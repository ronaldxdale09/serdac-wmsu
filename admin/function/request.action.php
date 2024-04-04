<?php 
    include('../../function/db.php');


    if (isset($_POST['confirm'])) {

        $request_id = $_POST['req_id'];
        $sched_date = $_POST['sched_date'];

        $inviteCode = substr(str_shuffle(md5(microtime())), 0, 6);
        
        // Creating the SQL query

        $query = "UPDATE service_request SET status='Approved',inviteCode='$inviteCode', scheduled_date='$sched_date'
        WHERE request_id   = '$request_id'";
  
        // Executing the query
        $results = mysqli_query($con, $query);
    
        if ($results) {
            header("Location: ../request_record.php?tab=2");  // Change this to your desired location
            exit();
        } else {
            echo "ERROR: Could not be able to execute the query. " . mysqli_error($con);
        }
        exit();
    }

    if (isset($_POST['schedule'])) {
        $ship_id = $_POST['ship_id'] ?? '';


        $query = "UPDATE sales_cuplump_shipment SET status='In Progress'
          WHERE shipment_id  = '$ship_id'";
    
        // Executing the query
        $results = mysqli_query($con, $query);


        header("Location: ../cuplump_shipment.php?id=$ship_id");  // Change this to your desired location

    }
    

   
?>