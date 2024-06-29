<?php
include('db.php');

$token = $_POST['token'];
$newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Ensure token is provided
if (empty($token)) {
    echo json_encode(["success" => false, "message" => "Token is missing. Please request again."]);
    exit();
}

// Validate the reset token and check if it is expired
$stmt = $con->prepare("SELECT * FROM users WHERE resetToken = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Invalid or expired token. Please request again."]);
} else {
    $user = $result->fetch_assoc();
    $accessType = $user['accessType'];

    // Update the user's password and clear the reset token
    $stmt = $con->prepare("UPDATE users SET password = ?, resetToken = NULL, resetTokenExpiry = NULL WHERE resetToken = ?");
    $stmt->bind_param("ss", $newPassword, $token);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            // Automatically log in the user
            $_SESSION["fname"] = $user['fname'];
            $_SESSION["email"] = $user['email'];
            $_SESSION["userId_code"] = $user['user_id'];
            $_SESSION["accessType"] = $user['accessType'];
            $_SESSION["adminAccess"] = $user['adminAccess'];
            $_SESSION["isLogin"] = 1;

            if ($accessType == 'Administrator') {
                echo json_encode(["success" => true, "redirect" => "admin/index.php"]);
            } elseif ($accessType == 'Client') {
                echo json_encode(["success" => true, "redirect" => "profile.php"]);
            } else {
                echo json_encode(["success" => false, "message" => "Unknown access type."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Failed to reset password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Database error: Unable to execute the update."]);
    }
}

$stmt->close();
$con->close();
?>
