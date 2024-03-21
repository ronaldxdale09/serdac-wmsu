<?php
include('db.php');
require 'PHPMailer/PHPMailerAutoload.php';

$user_id = $_POST['user_id']; // Assuming the name of the input field for service type
$email = $_POST['email']; // Assuming the name of the input field for service type

$service_type = $_POST['service_type']; // Assuming the name of the input field for service type
$office_agency = $_POST['office_agency'];
$agency_classification = $_POST['agency_classification'];
$client_type = $_POST['client_type'];
$purpose = $_POST['purpose'];


// Prepare SQL query to insert service request into the database
$query = "INSERT INTO `service_request` (user_id,service_type, office_agency, agency_classification, client_type, purpose) VALUES (?,?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $query);

// Bind parameters and execute
mysqli_stmt_bind_param($stmt, "ssssss", $user_id,$service_type, $office_agency, $agency_classification, $client_type, $purpose);

if (mysqli_stmt_execute($stmt)) {
    echo "Service request submitted successfully";
    sendServiceRequestSummaryEmail($email, $service_type, $office_agency, $agency_classification, $client_type, $purpose);

} else {
    // Handle errors
    echo "Error: " . mysqli_error($con);
}





function     sendServiceRequestSummaryEmail($recipientEmail, $serviceType, $officeAgency, $agencyClassification, $clientType, $purpose){
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
        $mail->Subject = 'Service Request Received - Thank You';
        $emailContent = "
        <html>
        <head>
            <style>
                // ... (your existing style definitions)
            </style>
        </head>
        <body>
            <div class='content-wrapper'>
                <h2>Your Service Request at SERDAC-WMSU</h2>
                <p>Hello,</p>
                <p>Thank you for submitting your service request. Here is a summary of your request details:</p>
                <ul>
                    <li><strong>Service Type:</strong> {$serviceType}</li>
                    <li><strong>Office/Agency:</strong> {$officeAgency}</li>
                    <li><strong>Agency Classification:</strong> {$agencyClassification}</li>
                    <li><strong>Client Type:</strong> {$clientType}</li>
                    <li><strong>Purpose of Request:</strong> {$purpose}</li>
                </ul>
                <p>We are currently processing your request and will send you an update soon. Please feel free to contact us if you have any further questions or need assistance.</p>
                <p class='footer'>This is an automated message. Please do not reply to this email.<br>
                For inquiries or assistance, visit <a href='http://www.serdac-wmsu.online/support'>www.serdac-wmsu.online/support</a>.</p>
            </div>
        </body>
        </html>";

        $mail->Body = $emailContent;

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}