<?php 
    include('../../function/db.php');


    if (isset($_POST['confirm'])) {

        $request_id = $_POST['req_id'];
        $sched_date = $_POST['sched_date'];
        $remarks = $_POST['remarks'];


        
        $inviteCode = substr(str_shuffle(md5(microtime())), 0, 6);
        
        // Creating the SQL query

        $query = "UPDATE service_request SET admin_remarks='$remarks',status='Approved',inviteCode='$inviteCode', scheduled_date='$sched_date'
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

    if (isset($_POST['ongoing'])) {

        $request_id = $_POST['request_id'];
        $dateType = $_POST['date_type'];
        $fromDate = $_POST['from_date'];
        $toDate = isset($_POST['to_date']) ? $_POST['to_date'] : null;

        $service_title = $_POST['service_title'];

        $event_speaker = $_POST['speaker'];

    

        $query = "UPDATE service_request SET status='In Progress', ongoing_date=NOW(), sched_from_date='$fromDate',
        sched_to_date='$toDate' ,dateType='$dateType',event_title='$service_title',event_speaker='$event_speaker'
                WHERE request_id = '$request_id'";
    
    
        // Executing the query
        $results = mysqli_query($con, $query);
    
        if ($results) {
            header("Location: ../request_record.php?tab=3");  // Change this to your desired location
            exit();
        } else {
            echo "ERROR: Could not be able to execute the query. " . mysqli_error($con);
        }
        exit();
    }
    

   
?>