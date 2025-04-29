<?php
require 'PHPMailer/PHPMailerAutoload.php';

function loadEmailTemplate() {
    return "
    <html>
    <head>
        <style>
            body { font-family: 'Arial', sans-serif; color: #333; }
            .content-wrapper { width: 100%; max-width: 600px; margin: auto; padding: 20px; box-sizing: border-box; }
            .button, .submit-button {
                background-color: #0d6efd;
                color: white;
                padding: 10px 15px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                border: none;
                border-radius: 5px;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s;
            }
            .button:hover, .submit-button:hover {
                background-color: #0b5ed7;
            }
            .footer { font-size: 0.8em; color: #666; }
        </style>
    </head>
    <body>
        <div class='content-wrapper'>
             <h2>Confirmation of Your Request</h2>
            <p>Dear User,</p>
            <p>Your request has been successfully confirmed. To proceed to the next stage, you must submit all required documents and files necessary for your data analysis request.</p>
            <p>To submit your documents, please click on the following link:</p>
            <p><a href='http://satserdac-wmsu.com/profile.php' class='submit-button'>Submit Document</a></p>
            <p class='footer'>Do not reply to this email; it was sent from an unmonitored email address.<br>
            For inquiries, please contact our Technical Support at <a href='http://www.satserdac-wmsu.com/support'>www.satserdac-wmsu.com/support</a>.</p>
        </div>
    
    </body>
    </html>";
}

function dataAnalysisDocument($recipientEmail) {
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
        $mail->Subject = 'SERDAC-WMSU | Request Confirmation and Next Steps';
        $mail->Body = loadEmailTemplate();

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}"); // Log error to server's error log
        return false;
    }
}

?>