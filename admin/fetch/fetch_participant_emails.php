<?php
include('../../function/db.php');

$request_id = $_POST['request_id'];

// Query to get the emails of the participants from the database
$query = "SELECT email FROM service_participant
LEFT JOIN users ON users.user_id = service_participant.user_id
WHERE request_id = '$request_id'";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die(json_encode(['error' => 'Query Failed: ' . mysqli_error($con)]));
}

$emails = [];
while ($row = mysqli_fetch_assoc($result)) {
    $emails[] = $row['email'];
}

echo json_encode(['emails' => $emails]);
?>
