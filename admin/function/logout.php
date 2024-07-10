<?php
    include('../../function/db.php');

    
    // Clear the session token in the database
    if (isset($_SESSION["userId_code"])) {
        $user_id = $_SESSION["userId_code"];
        $stmt = $con->prepare("UPDATE users SET session_token = NULL WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    }
    
    // Clear all session variables
    $_SESSION = array();
    
    // If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Close the database connection
    $con->close();
    
    // Redirect to the home page
    header('Location: ../../index.php');
    exit(); // Ensure no further code is executed after redirection
    ?>