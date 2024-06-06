<?php
include('../../function/db.php');
require 'PHPMailer/PHPMailerAutoload.php';
$user_id = $_SESSION["userId_code"]; 
$email = $_POST['email'];
$service_type = $_POST['service_type'];
$office_agency = $_POST['office_agency'];
$agency_classification = $_POST['agency_classification'];
$client_type = $_POST['client_type'];
$purpose_options = $_POST['purpose_options'];
$selected_purposes = implode(", ", $purpose_options);
$additional_purpose_details = $_POST['additional_purpose_details'];
$status = "In Progress";

// Insert into service_request table
$query = "INSERT INTO service_request (request_date, user_id, service_type, office_agency, agency_classification, client_type, selected_purposes, additional_purpose_details, status)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$request_date = date('Y-m-d H:i:s'); // Formats the date and time as Year-Month-Day Hours:Minutes:Seconds
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "sisssssss", $request_date, $user_id, $service_type, $office_agency, $agency_classification, $client_type, $selected_purposes, $additional_purpose_details, $status);

if (mysqli_stmt_execute($stmt)) {
    $last_id = mysqli_insert_id($con);

    // Log the activity
    $activity_type = 'service_request';
    $activity_description = "User submitted a new service request with ID $last_id and service type $service_type";
    //log_activity($con, $user_id, $activity_type, $activity_description);

    switch ($service_type) {
        case 'data-analysis':
            $analysis_type = $_POST['analysis_type'];
            $overview = $_POST['research_overview'];
            $g_objective = $_POST['general_objective'];
            $s_objective = $_POST['specific_objective'];

            // Insert into sr_dataanalysis table
            $query_da = "INSERT INTO sr_dataanalysis (request_id, analysis_type, overview, g_objective, s_objective) VALUES (?, ?, ?, ?, ?)";
            $stmt_da = mysqli_prepare($con, $query_da);
            mysqli_stmt_bind_param($stmt_da, "issss", $last_id, $analysis_type, $overview, $g_objective, $s_objective);
            mysqli_stmt_execute($stmt_da);
            break;

        case 'technical-assistance':
            $consultation_type = $_POST['consultation_type'];
            $remarks = '';

            // Insert into sr_tech_assistance table
            $query_ta = "INSERT INTO sr_tech_assistance (request_id, consultation_type, remarks) VALUES (?, ?, ?)";
            $stmt_ta = mysqli_prepare($con, $query_ta);
            mysqli_stmt_bind_param($stmt_ta, "iss", $last_id, $consultation_type, $remarks);
            mysqli_stmt_execute($stmt_ta);
            break;

        case 'capability-training':
            $s_from = '';
            $s_to = '';
            $title = '';
            $venue = '';
            $no_participants = '';
            
            // Insert into sr_training table
            $query_tr = "INSERT INTO sr_training (request_id, s_from, s_to, title, venue, no_participants) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt_tr = mysqli_prepare($con, $query_tr);
            mysqli_stmt_bind_param($stmt_tr, "issssi", $last_id, $s_from, $s_to, $title, $venue, $no_participants);
            mysqli_stmt_execute($stmt_tr);
            break;
    }
    echo 'success';
    header("Location: ../request_record.php?tab=3");  // Change this to your desired location
    // Optionally, send a service request summary email
    // sendServiceRequestSummaryEmail($email, $service_type, $office_agency, $agency_classification, $client_type, $selected_purposes);

} else {
    echo "Error: " . mysqli_error($con);
}




// function     sendServiceRequestSummaryEmail($recipientEmail, $serviceType, $officeAgency, $agencyClassification, $clientType, $purpose){
//     try {
//         $mail = new PHPMailer(true);

//         // Server settings
//         $mail->isSMTP();
//         $mail->Host = 'smtp.hostinger.com';
//         $mail->SMTPAuth = true;
//         $mail->Port = 587;
//         $mail->Username = 'no-reply@serdac-wmsu.online'; // SMTP username
//         $mail->Password = 'Serdac@2024'; // SMTP password

//         // Recipient
//         if (!PHPMailer::validateAddress($recipientEmail)) {
//             throw new Exception("Invalid email address");
//         }

//         $mail->setFrom('no-reply@serdac-wmsu.online', 'SERDAC-WMSU');
//         $mail->addAddress($recipientEmail);

//         // Content
//         $mail->isHTML(true);
//         $mail->Subject = 'Service Request Received - Thank You';
//         $emailContent = "
//         <html>
//         <head>
//         </head>
//         <body>
//             <div class='content-wrapper'>
//                 <h2>Your Service Request at SERDAC-WMSU</h2>
//                 <p>Hello,</p>
//                 <p>Thank you for submitting your service request. Here is a summary of your request details:</p>
//                 <ul>
//                     <li><strong>Service Type:</strong> {$serviceType}</li>
//                     <li><strong>Office/Agency:</strong> {$officeAgency}</li>
//                     <li><strong>Agency Classification:</strong> {$agencyClassification}</li>
//                     <li><strong>Client Type:</strong> {$clientType}</li>
//                     <li><strong>Purpose of Request:</strong> {$purpose}</li>
//                 </ul>
//                 <p>We are currently processing your request and will send you an update soon. Please feel free to contact us if you have any further questions or need assistance.</p>
//                 <p class='footer'>This is an automated message. Please do not reply to this email.<br>
//                 For inquiries or assistance, visit <a href='http://www.serdac-wmsu.online/support'>www.serdac-wmsu.online/support</a>.</p>
//             </div>
//         </body>
//         </html>";

//         $mail->Body = $emailContent;

//         $mail->send();
//         return true;
//     } catch (Exception $e) {
//         echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
//         return false;
//     }
// }