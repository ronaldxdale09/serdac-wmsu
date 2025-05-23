<?php 
include('../../function/db.php');

require 'PHPMailer/PHPMailerAutoload.php';

function sendMeetingNotification($recipientEmail, $meetingContent) {
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'no-reply@satserdac-wmsu.com'; // SMTP username
        $mail->Password = 'Serdacnotif@2025'; // SMTP password

        // Recipient
        if (!PHPMailer::validateAddress($recipientEmail)) {
            throw new Exception("Invalid email address");
        }

        $mail->setFrom('no-reply@satserdac-wmsu.com', 'SERDAC-WMSU');
        $mail->addAddress($recipientEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'SERDAC-WMSU | Upcoming Meeting Notification';
        $mail->Body = nl2br($meetingContent); // Convert newlines to <br> tags for HTML email

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}"); // Log error to server's error log
        return false;
    }
}

// Assuming this is in your email notification script file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipientEmail = $_POST['recipient_email'];
    $meetingContent = $_POST['meeting_content'];

    $result = sendMeetingNotification($recipientEmail, $meetingContent);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
}

?>