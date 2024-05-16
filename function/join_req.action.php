<?php
include('db.php');
require 'PHPMailer/PHPMailerAutoload.php';

// Fetch POST data
$user_id = $_POST['user_id'];
$req_id = $_POST['req_id'];
$current_date = date("Y-m-d");

// Prepare SQL query to insert service participant into the database
$query = "INSERT INTO service_participant (user_id, request_id, registration_date) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($con, $query);

// Bind parameters and execute
mysqli_stmt_bind_param($stmt, "iis", $user_id, $req_id, $current_date);

if (mysqli_stmt_execute($stmt)) {
    // Log the activity
    $activity_type = 'service_participation';
    $activity_description = "User participated in service request with ID $req_id";
    // log_activity($con, $user_id, $activity_type, $activity_description);

    // Optionally, send a service request summary email
    $serviceQuery = $con->prepare("SELECT service_type, office_agency, agency_classification, client_type, selected_purposes FROM service_request WHERE request_id = ?");
    $serviceQuery->bind_param("i", $req_id);
    $serviceQuery->execute();
    $serviceResult = $serviceQuery->get_result();
    $service = $serviceResult->fetch_assoc();

    $email = getUserEmail($con, $user_id); // Function to fetch user email

    if ($email) {
        sendServiceRequestSummaryEmail(
            $email,
            $service['service_type'],
            $service['office_agency'],
            $service['agency_classification'],
            $service['client_type'],
            $service['selected_purposes']
        );
    }

    echo "success";
} else {
    echo "Error: " . mysqli_error($con);
}

// Fetch user email
function getUserEmail($con, $user_id) {
    $query = "SELECT email FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    return $user['email'] ?? null;
}

// Send service request summary email
function sendServiceRequestSummaryEmail($recipientEmail, $serviceType, $officeAgency, $agencyClassification, $clientType, $purpose) {
    try {
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.hostinger.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'no-reply@serdac-wmsu.online';
        $mail->Password = 'Serdac@2024';

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
                .content-wrapper { font-family: Arial, sans-serif; padding: 20px; }
                .footer { font-size: 0.9em; color: #777; }
            </style>
        </head>
        <body>
            <div class='content-wrapper'>
                <h2>Thank You for Joining the Training at SERDAC-WMSU</h2>
                <p>Hello,</p>
                <p>Thank you for joining our training session. Here is a summary of your registration details:</p>
                <ul>
                    <li><strong>Service Type:</strong> {$serviceType}</li>
                    <li><strong>Office/Agency:</strong> {$officeAgency}</li>
                    <li><strong>Agency Classification:</strong> {$agencyClassification}</li>
                    <li><strong>Client Type:</strong> {$clientType}</li>
                    <li><strong>Purpose of Request:</strong> {$purpose}</li>
                </ul>
                <p>Please expect an invitation email from us soon with further details about the training. We look forward to your participation.</p>
                <p>If you have any questions or need assistance, please feel free to contact us.</p>
                <p class='footer'>This is an automated message. Please do not reply to this email.<br>
                For inquiries or assistance, visit <a href='http://www.serdac-wmsu.online/contact_us.php'>www.serdac-wmsu.online/support</a>.</p>
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
?>
