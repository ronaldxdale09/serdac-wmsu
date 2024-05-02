<?php 
    include('../../function/db.php');
    include('email_notification.php');
    

    if (isset($_POST['confirm'])) {

        $request_id = $_POST['req_id'];
        $sched_date = $_POST['sched_date'];
        $remarks = $_POST['remarks'];


        
        $inviteCode = substr(str_shuffle(md5(microtime())), 0, 6);
        
        // Creating the SQL query

        $query = "UPDATE service_request SET scheduled_remarks='$remarks',status='Approved',inviteCode='$inviteCode', scheduled_date='$sched_date'
        WHERE request_id   = '$request_id'";
  
        // Executing the query
        $results = mysqli_query($con, $query);
    
        if ($results) {

            // Insert new meeting 
            $insertSql = "INSERT INTO sr_meeting (request_id, meeting_type, date_time,mode) 
            VALUES ('$request_id', 'Initial Meeting',NOW(),'face2face')";
            // Executing the query
            $results = mysqli_query($con, $insertSql);
    
            

            header("Location: ../request_record.php?tab=2");  // Change this to your desired location
            exit();
        } else {
            echo "ERROR: Could not be able to execute the query. " . mysqli_error($con);
        }
        exit();
    }

    if (isset($_POST['progress'])) {
        $request_id = $_POST['request_id'];
        $remarks = $_POST['remarks'];

        
        // Start transaction
        mysqli_begin_transaction($con);
    
        try {
            // Fetch the user email and service_type
            $fetchQuery = "SELECT users.email, service_request.service_type 
                           FROM service_request 
                           JOIN users ON service_request.user_id = users.user_id 
                           WHERE service_request.request_id = '$request_id'";
            $fetchResult = mysqli_query($con, $fetchQuery);
            if ($fetchResult && mysqli_num_rows($fetchResult) > 0) {
                $data = mysqli_fetch_assoc($fetchResult);
                $recipientEmail = $data['email'];
                $serviceType = $data['service_type'];
    
                // Update the service_request status
                $updateQuery = "UPDATE service_request SET status='In Progress',inprogress_remarks='$remarks', ongoing_date=NOW() 
                                WHERE request_id = '$request_id'";
                $updateResult = mysqli_query($con, $updateQuery);
    
                if ($updateResult) {

                    if ($serviceType == 'data-analysis') {
                        dataAnalysisDocument($recipientEmail);
                    }
    
                    mysqli_commit($con);
                    header("Location: ../request_record.php?tab=3");  // Change this to your desired location
                    exit();
                } else {
                    throw new Exception("ERROR: Could not be able to execute the update query. " . mysqli_error($con));
                }
            } else {
                throw new Exception("No data found for the provided request ID.");
            }
        } catch (Exception $e) {
            mysqli_rollback($con);
            echo $e->getMessage();
        }
    }


    if (isset($_POST['complete'])) {

        $request_id = $_POST['request_id'];
        $remarks = $_POST['remarks'];

          // Update the service_request status
          $updateQuery = "UPDATE service_request SET status='Completed',completed_remarks='$remarks', ongoing_date=NOW() 
          WHERE request_id = '$request_id'";
        $updateResult = mysqli_query($con, $updateQuery);
            
        if ($updateResult) {

        

        
           // header("Location: ../request_record.php?tab=5");  // Change this to your desired location
            exit();
        } else {
            echo "ERROR: Could not be able to execute the query. " . mysqli_error($con);
        }
        exit();
    }
    

   
?>