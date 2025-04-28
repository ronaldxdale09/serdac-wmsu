<?php
include('db.php');
require 'PHPMailer/PHPMailerAutoload.php';

// Retrieve values from the registration form
$fname = $_POST['fname'];
$midname = $_POST['midname'];
$lname = $_POST['lname'];
$contact_no = $_POST['contact_no'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$occupation = $_POST['occupation'];
$education_level = $_POST['education_level'];
$accessType = 'Client'; 
$sex = $_POST['sex'];

$gender = $_POST['gender'];
$zipcode = '';
$region = $_POST['region'];
$province = $_POST['province'];
$city = $_POST['city'];
$barangay = $_POST['barangay'];
$userType = 'Client'; 
$isActive = 0; 
$activationCode = substr(str_shuffle(md5(microtime())), 0, 12);

$current_date_dmy = date('d-m-Y');

// Check if email is already registered
$emailCheckQuery = "SELECT email FROM users WHERE email = ?";
$emailCheckStmt = mysqli_prepare($con, $emailCheckQuery);
mysqli_stmt_bind_param($emailCheckStmt, "s", $email);
mysqli_stmt_execute($emailCheckStmt);
mysqli_stmt_store_result($emailCheckStmt);

if (mysqli_stmt_num_rows($emailCheckStmt) > 0) {
    $response['status'] = 'error';
    $response['message'] = 'Email is already registered.';
} else {
    // Prepare insert query
    $query = "INSERT INTO users (sex, activationCode, fname, midname, lname, contact_no, email, password, occupation, education_level, accessType, gender, zipcode, region, province, city, barangay, userType, isActive,registration_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssss", $sex, $activationCode, $fname, $midname, $lname, $contact_no, $email, $password, $occupation, $education_level, $accessType, $gender, $zipcode, $region, $province, $city, $barangay, $userType, $isActive,$current_date_dmy);

    ob_start();

    if (mysqli_stmt_execute($stmt)) {
        $response['status'] = 'success';
        // Send activation email
        $activationLink = 'https://satserdac-wmsu.com/login.php?code='.$activationCode;
        $userEmail = $email;
        // Suppress any output from sendActivationEmail
        $emailResult = @sendActivationEmail($userEmail, $activationLink);
        if (!$emailResult) {
            error_log('Activation email failed for: ' . $userEmail);
            $response['email_warning'] = 'Activation email could not be sent, but your account was created.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . mysqli_error($con);
    }

    // --- Clean output buffer and only return JSON ---
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode($response);
}

function sendActivationEmail($recipientEmail, $activationLink) {
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
        $mail->Subject = 'Complete Your Registration';
        $emailContent = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    color: #333;
                    background-color: #f8f9fa;
                    margin: 0;
                    padding: 0;
                }
                .content-wrapper {
                    width: 100%;
                    max-width: 600px;
                    margin: auto;
                    padding: 20px;
                    background-color: #fff;
                    border-radius: 8px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                h2 {
                    color: #0d6efd;
                }
                p {
                    font-size: 16px;
                    line-height: 1.5;
                }
                .button {
                    background-color: #0d6efd;
                    color: white;
                    padding: 10px 20px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    transition: background-color 0.3s;
                    margin-top: 20px;
                }
                .button:hover {
                    background-color: #0b5ed7;
                }
                .footer {
                    font-size: 0.8em;
                    color: #666;
                    margin-top: 20px;
                    text-align: center;
                }
                .footer a {
                    color: #0d6efd;
                    text-decoration: none;
                }
                .footer a:hover {
                    text-decoration: underline;
                }
            </style>
        </head>
        <body>
            <div class='content-wrapper'>
                <h2>Activate Your Account</h2>
                <p>Hi,</p>
                <p>Thank you for registering with SERDAC-WMSU. To complete your registration, please click the button below within the next hour:</p>
                <p style='text-align: center;'><a href='{$activationLink}' class='button'>Activate Account</a></p>
                <p>If the button above does not work, copy and paste the following link into your web browser:</p>
                <p><a href='{$activationLink}'>{$activationLink}</a></p>
                <div class='footer'>
                    <p>Do not reply to this email; it was sent from an unmonitored email address.<br>
                    For inquiries, please contact our Technical Support at <a href='http://www.serdac-wmsu.online/support'>www.serdac-wmsu.online/support</a>.</p>
                </div>
            </div>
        </body>
        </html>";

        $mail->Body = $emailContent;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Activation email error: {$mail->ErrorInfo}");
        return false;
    }
}
?>