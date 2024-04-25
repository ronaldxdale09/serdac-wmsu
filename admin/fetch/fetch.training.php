<?php
include('../../function/db.php');

$service_type = $_POST['service_type'];
$request_id = $_POST['request_id'];

// Example for Data Analysis
if ($service_type == 'capability-training') {
    $query = "SELECT * FROM sr_training WHERE request_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    echo json_encode($data);
}
?>