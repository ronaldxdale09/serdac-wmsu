<?php
include "db.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invCode = $_POST['invCode'];
    
    // Check the invitation code against your database
    // This is a placeholder query, adjust according to your database structure
    $query = "SELECT * FROM service_request WHERE inviteCode = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $invCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Invitation code is valid
        echo "success";
    } else {
        // Invitation code is invalid
        echo "error";
    }
}
?>