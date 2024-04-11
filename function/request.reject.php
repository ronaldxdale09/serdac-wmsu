<?php 
include('db.php');

    if (isset($_POST['reject'])) {

        $request_id = $_POST['req_id'];

        $query = "UPDATE service_request SET status='Cancelled', cancelled_date=NOW()
        WHERE request_id   = '$request_id'";
  
        // Executing the query
        $results = mysqli_query($con, $query);
    
        if ($results) {
            header("Location: ../profile.php");  // Change this to your desired location
            exit();
        } else {
            echo "ERROR: Could not be able to execute the query. " . mysqli_error($con);
        }
        exit();
    }

   
?>