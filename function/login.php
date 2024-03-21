<?php
include('db.php');

$email = mysqli_real_escape_string($con, $_POST['email']);
$password = mysqli_real_escape_string($con, $_POST['password']);

// Use prepared statements to avoid SQL injection
$stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Invalid email or password!"]);
} else {
    $user = $result->fetch_assoc();

    // Use password_verify to check the hashed password
    if (!password_verify($password, $user['password'])) {
        echo json_encode(["success" => false, "message" => "Invalid email or password!"]);
    } else {
        $accessType = $user['accessType'];
        $_SESSION["fname"] = $user['fname'];
        $_SESSION["email"] = $email;
        $_SESSION["userId_code"] =  $user['user_id'];

        // Token generation and storage can be enabled here

        if ($accessType == 'Administrator') {
            echo json_encode(["success" => true, "redirect" => "admin/index.php"]);
        } elseif ($accessType == 'Client') {
            echo json_encode(["success" => true, "redirect" => "user/index.php"]);
        } 
    }
}

$stmt->close();
mysqli_close($con);
?>
