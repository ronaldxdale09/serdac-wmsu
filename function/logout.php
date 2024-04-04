<?php
include "db.php";
session_start(); // Ensure the session is started

// Clear all session variables
session_unset();
session_destroy();

// Clear the authentication cookie


mysqli_close($con);

// Redirect to the home page
header('Location: ../index.php');
exit(); // Ensure no further code is executed after redirection
?>
