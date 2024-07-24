<?php
include('../../function/db.php');

if (isset($_GET['user_id']) && isset($_GET['form_id'])) {
    $user_id = intval($_GET['user_id']);
    $form_id = intval($_GET['form_id']);
    $is_quiz = intval($_GET['is_quiz']);

    $query = "SELECT aq.question_text, ar.response_text, aq.correct_answer, u.fname, u.email, ar.response_date,
              af.title as form_title
              FROM asmt_responses ar 
              JOIN asmt_questions aq ON ar.question_id = aq.question_id 
              JOIN users u ON ar.user_id = u.user_id 
              JOIN asmt_forms af ON ar.form_id = af.form_id
              WHERE ar.user_id = ? AND ar.form_id = ?";
              
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $user_id, $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
        echo '<div class="container">';
        echo '<h2 class="text-center mb-4">' . htmlspecialchars($user_info['form_title']) . ' - Response Summary</h2>';
        echo '<div class="card mb-4">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Respondent Information</h5>';
        echo '<p><strong>Name:</strong> ' . htmlspecialchars($user_info['fname']) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars($user_info['email']) . '</p>';
        echo '<p><strong>Submission Date:</strong> ' . htmlspecialchars($user_info['response_date']) . '</p>';
        echo '</div></div>';

        if ($is_quiz) {
            $correct_count = 0;
            $total_questions = 0;
        }

        echo '<div class="table-responsive">';
        echo '<table class="table table-striped table-bordered">';
        echo '<thead><tr><th>Question</th><th>Response</th>';
        if ($is_quiz) {
            echo '<th>Correct Answer</th><th>Result</th>';
        }
        echo '</tr></thead>';
        echo '<tbody>';
        
        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['question_text']) . '</td>';
            echo '<td>' . htmlspecialchars($row['response_text']) . '</td>';
            if ($is_quiz) {
                echo '<td>' . htmlspecialchars($row['correct_answer']) . '</td>';
                $is_correct = $row['response_text'] == $row['correct_answer'];
                echo '<td>' . ($is_correct ? '<span class="text-success">Correct</span>' : '<span class="text-danger">Incorrect</span>') . '</td>';
                $correct_count += $is_correct ? 1 : 0;
                $total_questions++;
            }
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';

        if ($is_quiz) {
            $score_percentage = ($correct_count / $total_questions) * 100;
            echo '<div class="card mt-4">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Quiz Summary</h5>';
            echo '<p><strong>Score:</strong> ' . $correct_count . '/' . $total_questions . ' (' . number_format($score_percentage, 2) . '%)</p>';
            echo '</div></div>';
        }

        echo '</div>';
    } else {
        echo '<p class="text-center">No details found for this response.</p>';
    }
    
    $stmt->close();
} else {
    echo '<p class="text-center">Invalid response ID.</p>';
}

$con->close();
?>