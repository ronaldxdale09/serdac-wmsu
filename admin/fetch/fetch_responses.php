<?php
include('../../function/db.php');

if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);
    $is_quiz = intval($_GET['is_quiz']);

    $query = "SELECT ar.response_id, u.user_id, u.fname, u.email, ar.response_date,
              COUNT(DISTINCT aq.question_id) as total_questions,
              SUM(CASE WHEN ar.response_text = aq.correct_answer THEN 1 ELSE 0 END) as correct_answers
              FROM asmt_responses ar 
              JOIN users u ON ar.user_id = u.user_id 
              JOIN asmt_questions aq ON ar.form_id = aq.form_id
              WHERE ar.form_id = ? 
              GROUP BY u.user_id, ar.response_date";
              
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<table id="responsesTable" class="table table-striped table-bordered">';
        echo '<thead><tr><th>User</th><th>Email</th><th>Date</th>';
        if ($is_quiz) {
            echo '<th>Score</th>';
        }
        echo '<th>Action</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['response_date']) . '</td>';
            if ($is_quiz) {
                $score = $row['correct_answers'] . '/' . $row['total_questions'];
                echo '<td>' . $score . '</td>';
            }
            echo '<td><button type="button" class="btn btn-sm btn-primary btnViewResponseSummary" data-user-id="' . $row['user_id'] . '" data-form-id="' . $form_id . '" data-is-quiz="' . $is_quiz . '">View Summary</button></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p class="text-center">No responses found for this form.</p>';
    }
    
    $stmt->close();
} else {
    echo '<p class="text-center">Invalid form ID.</p>';
}

$con->close();
?>