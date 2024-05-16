<?php
include('../../function/db.php');

// Fetch notifications
$user_id = $_SESSION['user_id']; // Assuming you have user_id in session
$query = "SELECT * FROM user_activity_log WHERE  isView = 0 ORDER BY activity_timestamp DESC";
$result = mysqli_query($con, $query);

$notifications = [];
while ($row = mysqli_fetch_assoc($result)) {
    $notifications[] = $row;
}
// Mark notifications as viewed
$updateQuery = "UPDATE user_activity_log SET isView = 1 WHERE isView = 0";
mysqli_query($con, $updateQuery);


echo json_encode($notifications);
?>