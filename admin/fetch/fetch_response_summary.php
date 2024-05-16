<?php
include('../../function/db.php');

if (isset($_GET['user_id']) && isset($_GET['form_id'])) {
    $user_id = intval($_GET['user_id']);
    $form_id = intval($_GET['form_id']);

    $query = "SELECT aq.question_text, ar.response_text, u.fname, u.email, ar.response_date 
              FROM asmt_responses ar 
              JOIN asmt_questions aq ON ar.question_id = aq.question_id 
              JOIN users u ON ar.user_id = u.user_id 
              WHERE ar.user_id = ? AND ar.form_id = ?";
              
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $user_id, $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<div class="text-center">';
        echo '<h2>Response Summary</h2>';
        echo '<p><strong>User:</strong> ' . htmlspecialchars($result->fetch_assoc()['fname']) . '</p>';
        echo '<p><strong>Email:</strong> ' . htmlspecialchars($result->fetch_assoc()['email']) . '</p>';
        echo '<p><strong>Date:</strong> ' . htmlspecialchars($result->fetch_assoc()['response_date']) . '</p>';
        echo '<table class="table table-hover">';
        echo '<thead><tr><th>Question</th><th>Response</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['question_text']) . '</td>';
            echo '<td>' . htmlspecialchars($row['response_text']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
        echo '</div>';
    } else {
        echo '<p>No details found for this response.</p>';
    }
    
    $stmt->close();
} else {
    echo '<p>Invalid response ID.</p>';
}

$con->close();
?>
