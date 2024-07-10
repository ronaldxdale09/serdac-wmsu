<?php
include('db.php');

function json_output($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    json_output(["success" => false, "message" => "Method Not Allowed"]);
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    json_output(["success" => false, "message" => "Email and password are required"]);
}

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['password'];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_output(["success" => false, "message" => "Invalid email format"]);
}

try {
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        json_output(["success" => false, "message" => "Invalid email or password"]);
    }

    $user = $result->fetch_assoc();

    if ($user['isActive'] == 0) {
        json_output(["success" => false, "message" => "Please activate your account first"]);
    }

    if (!password_verify($password, $user['password'])) {
        json_output(["success" => false, "message" => "Invalid email or password"]);
    }

    // Check for existing session and its last activity time
    $current_time = time();
    $session_timeout = 60 * 60; // 1 hour in seconds

    if (!empty($user['session_token']) && !empty($user['last_activity'])) {
        $last_activity = strtotime($user['last_activity']);
        if (($current_time - $last_activity) < $session_timeout) {
            json_output([
                "success" => false, 
                "message" => "This account is already logged in on another device. Please try again later."
            ]);
        }
    }

    // Generate new session token and update last activity
    $session_token = bin2hex(random_bytes(32));
    $last_activity = date('Y-m-d H:i:s', $current_time);

    $update_stmt = $con->prepare("UPDATE users SET session_token = ?, last_activity = ? WHERE user_id = ?");
    $update_stmt->bind_param("ssi", $session_token, $last_activity, $user['user_id']);
    $update_stmt->execute();
    $update_stmt->close();

    $_SESSION["fname"] = $user['fname'];
    $_SESSION["email"] = $email;
    $_SESSION["userId_code"] = $user['user_id'];
    $_SESSION["accessType"] = $user['accessType'];
    $_SESSION["adminAccess"] = $user['adminAccess'];
    $_SESSION["isLogin"] = 1;
    $_SESSION["session_token"] = $session_token;
    $_SESSION["last_activity"] = $current_time;

    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

    // Check if there's a stored redirect URL in the session
    $redirect = isset($_SESSION['redirect_after_login']) 
        ? $_SESSION['redirect_after_login'] 
        : ($user['accessType'] == 'Administrator' ? "admin/index.php" : "profile.php");

    // Clear the stored redirect URL
    unset($_SESSION['redirect_after_login']);

    json_output(["success" => true, "redirect" => $redirect]);

} catch (Exception $e) {
    error_log("Login error: " . $e->getMessage());
    json_output(["success" => false, "message" => "An error occurred. Please try again later."]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($con)) {
        $con->close();
    }
}
?>