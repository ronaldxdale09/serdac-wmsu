<?php
session_start(); 
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'serdac_db';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


function log_activity($con, $user_id, $activity_type, $activity_description) {
    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO user_activity_log (user_id, activity_type, activity_description) VALUES (?, ?, ?)";

    // Initialize a statement
    $stmt = $con->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("iss", $user_id, $activity_type, $activity_description);

    // Execute the statement
    if ($stmt->execute() === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    // Close the statement
    $stmt->close();
}
?>