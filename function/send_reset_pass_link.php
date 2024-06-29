<?php
include('db.php');
require 'PHPMailer/PHPMailerAutoload.php';

$email = mysqli_real_escape_string($con, $_POST['email']);

// Check if the email is registered
$stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "No account found with that email."]);
} else {
    $user = $result->fetch_assoc();
    $resetToken = bin2hex(random_bytes(16));
    $resetTokenExpiry = date('Y-m-d H:i:s', strtotime('+30 minutes'));

    // Save the reset token and expiry in the database
    $stmt = $con->prepare("UPDATE users SET resetToken = ?, resetTokenExpiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $resetToken, $resetTokenExpiry, $email);
    $stmt->execute();

    // Send the reset email
    $resetLink = 'https://serdac-wmsu.online/lset_password.php?token=' . $resetToken;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'no-reply@serdac-wmsu.online'; // SMTP username
        $mail->Password = 'Serdac@2024'; // SMTP password

        $mail->setFrom('no-reply@serdac-wmsu.online', 'SERDAC-WMSU');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mailContent = "<p>Click the link below to reset your password:</p><p><a href='{$resetLink}'>Reset Password</a></p>";
        $mail->Body = $mailContent;

        $mail->send();
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Mailer Error: {$mail->ErrorInfo}"]);
    }
}

$stmt->close();
$con->close();
?>
