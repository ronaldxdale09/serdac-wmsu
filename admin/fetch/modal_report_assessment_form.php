<?php
include('../../function/db.php');
header('Content-Type: application/json');

if (isset($_GET['formId'])) {
    $formId = intval($_GET['formId']);
    $response = array();

    // Fetch form details with total responses
    $formQuery = "SELECT af.*, 
                  (SELECT COUNT(DISTINCT user_id) FROM asmt_responses WHERE form_id = af.form_id) as total_responses
                  FROM asmt_forms af 
                  WHERE af.form_id = ?";
    
    $stmt = $con->prepare($formQuery);
    $stmt->bind_param("i", $formId);
    $stmt->execute();
    $formResult = $stmt->get_result();
    $response['form'] = $formResult->fetch_assoc();

    // Calculate stats
    $response['stats'] = array(
        'total_responses' => $response['form']['total_responses'],
        'completion_rate' => ($response['form']['quota'] > 0) 
            ? (($response['form']['total_responses'] / $response['form']['quota']) * 100) 
            : 0
    );

    // Fetch questions with response distribution
    $questions = array();
    $questionQuery = "SELECT * FROM asmt_questions WHERE form_id = ?";
    $stmt = $con->prepare($questionQuery);
    $stmt->bind_param("i", $formId);
    $stmt->execute();
    $questionResult = $stmt->get_result();
    
    while ($question = $questionResult->fetch_assoc()) {
        // Get response distribution for this question
        $distributionQuery = "SELECT response_text, COUNT(*) as count 
                            FROM asmt_responses 
                            WHERE question_id = ? 
                            GROUP BY response_text";
        $stmt2 = $con->prepare($distributionQuery);
        $stmt2->bind_param("i", $question['question_id']);
        $stmt2->execute();
        $distributionResult = $stmt2->get_result();
        
        $distribution = array();
        while ($dist = $distributionResult->fetch_assoc()) {
            $distribution[] = $dist;
        }
        
        $question['response_distribution'] = $distribution;
        $questions[] = $question;
    }
    
    $response['questions'] = $questions;

    echo json_encode($response);
} else {
    echo json_encode(['error' => 'No form ID provided']);
}

$con->close();
?>