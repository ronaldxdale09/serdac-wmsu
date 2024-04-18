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
$activationCode = substr(str_shuffle(md5(microtime())), 0, 10);



// Check if email is already registered
$emailCheckQuery = "SELECT email FROM users WHERE email = ?";
$emailCheckStmt = mysqli_prepare($con, $emailCheckQuery);
mysqli_stmt_bind_param($emailCheckStmt, "s", $email);
mysqli_stmt_execute($emailCheckStmt);
mysqli_stmt_store_result($emailCheckStmt);

if (mysqli_stmt_num_rows($emailCheckStmt) > 0) {
    echo "Email is already registered.";
} else {
    // Prepare insert query
    $query = "INSERT INTO users (sex, activationCode, fname, midname, lname, contact_no, email, password, occupation, education_level, accessType, gender, zipcode, region, province, city, barangay, userType, isActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "sssssssssssssssssss", $sex, $activationCode, $fname, $midname, $lname, $contact_no, $email, $password, $occupation, $education_level, $accessType, $gender, $zipcode, $region, $province, $city, $barangay, $userType, $isActive);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
        // Send activation email
        $activationLink = 'https://localhost/serdac-wmsu/login.php?code='.$activationCode; // Replace with actual activation link
        $userEmail = $email;
        // sendActivationEmail($userEmail, $activationLink);
    } else {
        echo "Error: " . mysqli_error($con);
    }
}






function sendActivationEmail($recipientEmail, $activationLink) {
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
        $mail->Subject = 'Complete Your Registration';
        $emailContent = "
        <html>
        <head>
            <style>
                body { font-family: 'Arial', sans-serif; color: #333; }
                .content-wrapper { width: 100%; max-width: 600px; margin: auto; padding: 20px; box-sizing: border-box; }
                .button {
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
                .button:hover {
                    background-color: #0b5ed7; /* A slightly darker shade for hover effect */
                }
                .footer { font-size: 0.8em; color: #666; }
            </style>
        </head>
        <body>
            <div class='content-wrapper'>
                <h2>Activate Your Account</h2>
                <p>Hi,</p>
                <p>Thank you for registering. To complete your registration, please click the following button within an hour:</p>
                <p><a href='{$activationLink}' class='button'>Activate Account</a></p>
                <p class='footer'>Do not reply to this email; it was sent from an unmonitored email address.<br>
                For inquiries, please contact our Technical Support at <a href='http://www.serdac-wmsu.online/support'>www.yourdomain.com/support</a>.</p>
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