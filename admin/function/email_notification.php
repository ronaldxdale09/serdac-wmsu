<?php
    require 'PHPMailer/PHPMailerAutoload.php';


    function dataAnalysisDocument($recipientEmail) {
        try {
            $mail = new PHPMailer(true);
    
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Port = 587;
            $mail->Username = 'no-reply@serdac-wmsu.online'; // SMTP username
            $mail->Password = 'Serdac@2024'; // SMTP password
    
            // Recipient
            if (!PHPMailer::validateAddress($recipientEmail)) {
                throw new Exception("Invalid email address");
            }
    
            $mail->setFrom('no-reply@serdac-wmsu.online', 'SERDAC-WMSU');
            $mail->addAddress($recipientEmail);
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'SERDAC-WMSU | Request Confirmation and Next Steps';
            $emailContent = "
            <html>
            <head>
                <style>
                    body { font-family: 'Arial', sans-serif; color: #333; }
                    .content-wrapper { width: 100%; max-width: 600px; margin: auto; padding: 20px; box-sizing: border-box; }
                    .button, .submit-button {
                        background-color: #0d6efd; /* Bootstrap primary color */
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
                        background-color: #0b5ed7; /* A slightly darker shade for hover effect */
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
                <p><a href='http://serdac-wmsu.online/profile.php' class='submit-button'>Submit Document</a></p>
                <p class='footer'>Do not reply to this email; it was sent from an unmonitored email address.<br>
                For inquiries, please contact our Technical Support at <a href='http://www.serdac-wmsu.online/support'>www.serdac-wmsu.online/support</a>.</p>
            </div>
        
            </body>
            </html>";
        
            $mail->Body = $emailContent;
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            // Handle exceptions or log errors
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }
    

?>