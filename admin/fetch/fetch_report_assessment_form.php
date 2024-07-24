<?php
include('../../function/db.php');

if (isset($_GET['formId'])) {
    $formId = intval($_GET['formId']);

    // Fetch form details
    $formQuery = "SELECT * FROM asmt_forms WHERE form_id = $formId";
    $formResult = $con->query($formQuery);
    $formDetails = $formResult->fetch_assoc();

    // Fetch questions
    $questionsQuery = "SELECT * FROM asmt_questions WHERE form_id = $formId";
    $questionsResult = $con->query($questionsQuery);
    $questions = [];
    while ($question = $questionsResult->fetch_assoc()) {
        $questions[] = $question;
    }

    // Fetch response statistics
    $responseQuery = "SELECT COUNT(DISTINCT user_id) as total_responses,
                      AVG(CASE WHEN ar.response_text = aq.correct_answer THEN 1 ELSE 0 END) as avg_score
                      FROM asmt_responses ar
                      JOIN asmt_questions aq ON ar.question_id = aq.question_id
                      WHERE ar.form_id = $formId";
    $responseResult = $con->query($responseQuery);
    $responseStats = $responseResult->fetch_assoc();

    // Prepare the output
    echo "<h4>" . htmlspecialchars($formDetails['title']) . "</h4>";
    echo "<p><strong>Description:</strong> " . htmlspecialchars($formDetails['description']) . "</p>";
    echo "<p><strong>Form Type:</strong> " . htmlspecialchars($formDetails['form_type']) . "</p>";
    echo "<p><strong>Date Range:</strong> " . htmlspecialchars($formDetails['start_date']) . " to " . htmlspecialchars($formDetails['end_date']) . "</p>";
    echo "<p><strong>Quota:</strong> " . htmlspecialchars($formDetails['quota']) . "</p>";
    echo "<p><strong>Total Responses:</strong> " . htmlspecialchars($responseStats['total_responses']) . "</p>";

    if ($formDetails['is_quiz']) {
        echo "<p><strong>Average Score:</strong> " . number_format($responseStats['avg_score'] * 100, 2) . "%</p>";
    }

    echo "<h5>Questions:</h5>";
    echo "<ul>";
    foreach ($questions as $question) {
        echo "<li>";
        echo "<strong>Question:</strong> " . htmlspecialchars($question['question_text']) . "<br>";
        echo "<strong>Type:</strong> " . htmlspecialchars($question['question_type']) . "<br>";
        if ($question['options']) {
            echo "<strong>Options:</strong> " . htmlspecialchars($question['options']) . "<br>";
        }
        if ($formDetails['is_quiz'] && $question['correct_answer']) {
            echo "<strong>Correct Answer:</strong> " . htmlspecialchars($question['correct_answer']) . "<br>";
        }
        echo "</li>";
    }
    echo "</ul>";

    // Fetch and display response distribution for multiple choice questions
    foreach ($questions as $question) {
        if ($question['question_type'] != 'paragraph') {
            $distributionQuery = "SELECT response_text, COUNT(*) as count
                                  FROM asmt_responses
                                  WHERE form_id = $formId AND question_id = {$question['question_id']}
                                  GROUP BY response_text";
            $distributionResult = $con->query($distributionQuery);
            
            echo "<h6>Response Distribution for: " . htmlspecialchars($question['question_text']) . "</h6>";
            echo "<ul>";
            while ($distribution = $distributionResult->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($distribution['response_text']) . ": " . $distribution['count'] . "</li>";
            }
            echo "</ul>";
        }
    }

} else {
    echo "No form ID provided.";
}

$con->close();
?>