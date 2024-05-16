<?php
include('../../function/db.php');

if (isset($_GET['form_id'])) {
    $form_id = intval($_GET['form_id']);

    $query = "SELECT ar.response_id, u.user_id, u.fname, u.email, ar.response_date 
              FROM asmt_responses ar 
              JOIN users u ON ar.user_id = u.user_id 
              WHERE ar.form_id = ? 
              GROUP BY u.user_id, ar.response_date";
              
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $form_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo '<table class="table table-hover">';
        echo '<thead><tr><th>User</th><th>Email</th><th>Date</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
            echo '<td>' . htmlspecialchars($row['response_date']) . '</td>';
            echo '<td><button type="button" class="btn btn-sm btn-primary btnViewResponseSummary" data-user-id="' . $row['user_id'] . '" data-form-id="' . $form_id . '">View Summary</button></td>';
            echo '</tr>';
        }
        echo '</tbody></table>';
    } else {
        echo '<p>No responses found for this form.</p>';
    }
    
    $stmt->close();
} else {
    echo '<p>Invalid form ID.</p>';
}

$con->close();
?>
