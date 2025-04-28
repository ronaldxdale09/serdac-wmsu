<!DOCTYPE html>
<html lang="en">
<?php 
include('function/db.php'); // Path to your database connection

// function checkSession($timeout = 3600) {
//     session_start();

//     // Check if user is not logged in or session is expired
//     if (!isset($_SESSION['isLogin']) || 
//         !isset($_SESSION['userId_code']) || 
//         !isset($_SESSION['last_activity']) || 
//         (time() - $_SESSION['last_activity'] > $timeout)) {
        
//         // Destroy session and redirect to login page
//         session_destroy();
//         header("Location: login.php");
//         exit();
//     }

//     // Update last activity time
//     $_SESSION['last_activity'] = time();
// }

        // Fetch the web details
        $query = "SELECT * FROM web_details LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $webDetails = mysqli_fetch_assoc($result);
        } else {
            // If no data found, initialize with empty strings
            $webDetails = [
                'about_us' => '',
                'mission' => '',
                'vision' => '',
                'goals' => '',
                'banner_image' => '' ,
                'org_email' => '',
                'org_contact' => ''
            ];
        }

        
?>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Ronald Dale">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">

    <title>SERDAC-WMSU</title>
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">


    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/homepage.css?v=1.0.0"> <!-- Versioning for cache-busting -->
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
    <link rel="stylesheet" href="css/modal.css">

</head>