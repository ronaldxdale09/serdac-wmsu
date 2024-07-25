<?php
include "db.php";

if (isset($_SESSION['userId_code']) && !empty($_SESSION['userId_code'])) {
    $userId = $_SESSION['userId_code'];
    $notificationId = $_POST['notification_id'];
    
    $query = "UPDATE client_notifications SET is_read = 1 WHERE notification_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $notificationId, $userId);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($con)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'User not logged in']);
}
?>