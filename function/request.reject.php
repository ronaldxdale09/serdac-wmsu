<?php 
include('db.php');

if (isset($_POST['reject'])) {
    $request_id = $_POST['req_id'];
    $user_id = $_SESSION["userId_code"]; // Retrieve the user ID from the session

    $query = "UPDATE service_request SET status='Cancelled', cancelled_date=NOW() WHERE request_id = '$request_id'";

    // Executing the query
    $results = mysqli_query($con, $query);

    if ($results) {
        // Log the activity
        $activity_type = 'reject_request';
        $activity_description = "User rejected request with ID $request_id";
        log_activity($con, $user_id, $activity_type, $activity_description);

        // Redirect after logging the activity
        header("Location: ../profile.php");  // Change this to your desired location
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}

   
?>