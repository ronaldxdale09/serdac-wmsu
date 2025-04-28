<?php
include('../../function/db.php');

require 'PHPMailer/PHPMailerAutoload.php';

function sendEmail($emails, $subject, $body, $request_id) {
    global $con; // Assuming you have a database connection

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'no-reply@satserdac-wmsu.com';
        $mail->Password = 'Serdacnotif@2025';

        //Recipients
        $mail->setFrom('no-reply@satserdac-wmsu.com', 'SERDAC-WMSU');
        
        foreach (explode(',', $emails) as $email) {
            if (PHPMailer::validateAddress(trim($email))) {
                $mail->addAddress(trim($email));    
            }
        }

        //Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        // Insert email log into database
        $stmt = $con->prepare("INSERT INTO email_log (request_id, recipients, subject, body) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $request_id, $emails, $subject, $body);
        $stmt->execute();

        echo 'Message has been sent and logged';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emails = $_POST['emails'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    $request_id = $_POST['request_id']; // Make sure to pass this from the AJAX call
    sendEmail($emails, $subject, $body, $request_id);
}
?>