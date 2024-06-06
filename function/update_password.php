<?php
include 'db.php'; 

if (isset($_SESSION['userId_code'])) {
    $id = $_SESSION['userId_code'];
    $id = preg_replace('~\D~', '', $id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        // Fetch the current password hash from the database
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($hashed_password_from_db);
        $stmt->fetch();
        $stmt->close();

        // Verify the current password
        if (!password_verify($current_password, $hashed_password_from_db)) {
            http_response_code(400);
            echo 'Current password is incorrect.';
            exit;
        }

        // Check if the new passwords match
        if ($new_password != $confirm_password) {
            http_response_code(400);
            echo 'New passwords do not match.';
            exit;
        }

        // Hash the new password
        $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the password in the database
        $sql = "UPDATE users SET password = ? WHERE user_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('si', $hashed_new_password, $id);

        if ($stmt->execute()) {
            echo 'Password updated successfully.';
        } else {
            http_response_code(500);
            echo 'Failed to update password.';
        }
    }
} else {
    http_response_code(403);
    echo 'You are not authorized to perform this action.';
}
?>
