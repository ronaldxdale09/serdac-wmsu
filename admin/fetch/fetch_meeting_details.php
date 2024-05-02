<?php
include('../../function/db.php');

$meet_id = $_GET['meet_id'];

$sql = "SELECT sr_meeting.*, service_request.service_type
        FROM sr_meeting
        JOIN service_request ON sr_meeting.request_id = service_request.request_id
        WHERE sr_meeting.meet_id = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $meet_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data);

$con->close();
?>
