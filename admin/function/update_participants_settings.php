<?php
include('../../function/db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request_id = $_POST['request_id'];
    $quota = $_POST['quota'];
    $allow_participants = $_POST['allow_participants'];

    $query = "UPDATE service_request SET participants_quota = ?, allowParticipants = ? WHERE request_id = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, 'iii', $quota, $allow_participants, $request_id);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($con)]);
    }

    mysqli_close($con);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>