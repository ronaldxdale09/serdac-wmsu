<?php
include('db.php');
require 'PHPMailer/PHPMailerAutoload.php';

$user_id = $_POST['user_id'];
$email = $_POST['email'];

$service_type = $_POST['service_type'];
$office_agency = $_POST['office_agency'];
$agency_classification = $_POST['agency_classification'];
$client_type = $_POST['client_type'];

$purpose_options = $_POST['purpose_options'];
$selected_purposes = implode(", ", $purpose_options);

$additional_purpose_details = $_POST['additional_purpose_details'];
$status = "Pending";

$query = "INSERT INTO service_request (user_id, service_type, office_agency, agency_classification, client_type, selected_purposes, additional_purpose_details, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "isssssss", $user_id, $service_type, $office_agency, $agency_classification, $client_type, $selected_purposes, $additional_purpose_details, $status);

if (mysqli_stmt_execute($stmt)) {
    $last_id = mysqli_insert_id($con);
  //  echo "Service request created successfully.";

    switch ($service_type) {
        case 'data-analysis':
            $analysis_type = $_POST['analysis_type'];
            $overview = $_POST['research_overview'];
            $g_objective = $_POST['general_objective'];
            $s_objective = $_POST['specific_objective'];

            // Assume additional details for Data Analysis
            $query_da = "INSERT INTO sr_dataanalysis (request_id, analysis_type, overview, g_objective, s_objective) VALUES (?, ?, ?, ?, ?)";
            $stmt_da = mysqli_prepare($con, $query_da);
            mysqli_stmt_bind_param($stmt_da, "issss", $last_id, $analysis_type, $overview, $g_objective, $s_objective);
            mysqli_stmt_execute($stmt_da);
            break;
        
        case 'technical-assistance':
            $consultation_type = $_POST['consultation_type'];
            $remarks = $_POST['remarks'];

            // Insert into sr_tech_assistance table
            $query_ta = "INSERT INTO sr_tech_assistance (request_id, consultation_type, remarks) VALUES (?, ?, ?)";
            $stmt_ta = mysqli_prepare($con, $query_ta);
            mysqli_stmt_bind_param($stmt_ta, "iss", $last_id, $consultation_type, $remarks);
            mysqli_stmt_execute($stmt_ta);
            break;

        case 'capability-training':
            $s_from = $_POST['s_from'];
            $s_to = $_POST['s_to'];
            $title = $_POST['title'];
            $venue = $_POST['venue'];
            $no_participants = $_POST['no_participants'];
            $speaker_id = $_POST['speaker_id'];

            // Insert into sr_training table
            $query_tr = "INSERT INTO sr_training (request_id, s_from, s_to, title, venue, no_participants, speaker_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_tr = mysqli_prepare($con, $query_tr);
            mysqli_stmt_bind_param($stmt_tr, "issssis", $last_id, $s_from, $s_to, $title, $venue, $no_participants, $speaker_id);
            mysqli_stmt_execute($stmt_tr);
            break;
    }
    echo 'success';

  //  sendServiceRequestSummaryEmail($email, $service_type, $office_agency, $agency_classification, $client_type, $selected_purposes);

} else {
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