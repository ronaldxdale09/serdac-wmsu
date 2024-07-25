<?php
include "db.php";
if (isset($_SESSION['userId_code']) && !empty($_SESSION['userId_code'])) {
    $userId = $_SESSION['userId_code'];
    
    $query = "SELECT * FROM client_notifications WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Date</th><th>Message</th></tr></thead>";
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . date('M j, Y H:i', strtotime($row['created_at'])) . "</td>";
            echo "<td>" . htmlspecialchars($row['message']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p class='text-center'>No notifications found.</p>";
    }
} else {
    echo "<p class='text-center text-danger'>User not logged in.</p>";
}
?>