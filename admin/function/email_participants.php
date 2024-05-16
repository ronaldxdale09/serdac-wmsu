<?php
require 'PHPMailer/PHPMailerAutoload.php';

function sendEmail($emails, $subject, $body) {
    $mail = new PHPMailer(true);
    try {
        //Server settings
         $mail->isSMTP();
         $mail->Host = 'smtp.hostinger.com';
         $mail->SMTPAuth = true;
         $mail->Port = 587;
         $mail->Username = 'no-reply@serdac-wmsu.online'; // SMTP username
         $mail->Password = 'Serdac@2024'; // SMTP password

                          

        //Recipients
        $mail->setFrom('no-reply@serdac-wmsu.online', 'SERDAC-WMSU');
        
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
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $emails = $_POST['emails'];
    $subject = $_POST['subject'];
    $body = $_POST['body'];
    sendEmail($emails, $subject, $body);
}
?>