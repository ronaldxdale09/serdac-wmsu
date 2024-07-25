<?php
function insert_notification($con, $user_id, $request_id, $notification_type, $message) {
    $query = "INSERT INTO client_notifications (user_id, request_id, notification_type, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "iiss", $user_id, $request_id, $notification_type, $message);
    
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Failed to insert notification: " . mysqli_error($con));
    }
    
    mysqli_stmt_close($stmt);
}

function fetch_user_id_from_request($con, $request_id) {
    $query = "SELECT user_id FROM service_request WHERE request_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $request_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['user_id'];
}


?>