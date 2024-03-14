<?php



include('db.php');

if (isset($_COOKIE['user_token'])) {
    $token = mysqli_real_escape_string($con, $_COOKIE['user_token']);

    // Verify the token and get user information
    $stmt = $con->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Set session variables
        $_SESSION["type"] = $user['user_type'];
        $_SESSION["full_name"] = $user['name'];
        $_SESSION["user"] = $user['username'];


        header('Location: user/dashboard.php');
    }

    $stmt->close();
}

mysqli_close($con);





?>