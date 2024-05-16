<?php
include('../../function/db.php');

$form_id = $_POST['form_id'];

// Query to get the emails of the participants from the database
$query = "SELECT email FROM service_participant
LEFT JOIN users ON users.user_id = service_participant.user_id
WHERE request_id IN (SELECT request_id FROM asmt_forms WHERE form_id = ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $form_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$emails = [];
while ($row = mysqli_fetch_assoc($result)) {
    $emails[] = $row['email'];
}

echo json_encode(['emails' => $emails]);
?>
