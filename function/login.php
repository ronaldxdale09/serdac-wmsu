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
    echo json_encode(["success" => false, "message" => "Invalid Password!"]);

} else {
    $user = $result->fetch_assoc();
    if ($password !== $user['password']) {
        echo json_encode(["success" => false, "message" => "Invalid Password!"]);

    } else {
        $userType = $user['userType'];
        $_SESSION["type"] = $userType;
        $_SESSION["fname"] = $user['fname'];
        $_SESSION["email"] = $email;

       // Generate and store token
        // $token = generateUserToken($user['user_id'], $con); // Pass the user's ID and $con
        // setcookie("user_token", $token, time() + (86400 * 30), "/"); // Set the cookie




        if ($userType == 'Administrator') {
            echo json_encode(["success" => true, "redirect" => "admin/index.php"]);
            // echo 'success';
        } 
    }
}

$stmt->close();
mysqli_close($con);



// function generateUserToken($user_id, $con) {
//     $token = bin2hex(random_bytes(32)); // Generate a secure token

//     // Store the token in the database with the user ID (implement this according to your database schema)
//     $stmt = $con->prepare("UPDATE users SET token = ? WHERE user_id = ?");
//     $stmt->bind_param("si", $token, $user_id);
//     $stmt->execute();
//     $stmt->close();

//     return $token;
// }



?>

