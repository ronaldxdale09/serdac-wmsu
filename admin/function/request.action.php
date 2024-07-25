<?php 
include('../../function/db.php');
include('email_notification.php');
include('client_notification.php'); // Include the new function

// Function to sanitize input
function sanitize_input($input) {
    global $con;
    return mysqli_real_escape_string($con, trim($input));
}

if (isset($_POST['confirm'])) {
    $request_id = sanitize_input($_POST['req_id']);
    $sched_date = sanitize_input($_POST['sched_date']);
    $remarks = sanitize_input($_POST['remarks']);
    
    $inviteCode = substr(str_shuffle(md5(microtime())), 0, 12);
    
    // Use prepared statement to prevent SQL injection
    $query = "UPDATE service_request SET scheduled_remarks=?, status='Approved',
              inviteCode=?, scheduled_date=?, participants_quota=50, allowParticipants=1, participants=1
              WHERE request_id = ?";
    
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $remarks, $inviteCode, $sched_date, $request_id);
    $results = mysqli_stmt_execute($stmt);

    if ($results) {
        // Insert new meeting 
        $insertSql = "INSERT INTO sr_meeting (request_id, meeting_type, date_time, mode) 
                      VALUES (?, '1', ?, 'face2face')";
        $stmt = mysqli_prepare($con, $insertSql);
        mysqli_stmt_bind_param($stmt, "ss", $request_id, $sched_date);
        mysqli_stmt_execute($stmt);

           // Add notification
           $user_id = fetch_user_id_from_request($con, $request_id); // You need to implement this function
           $message = "Your service request (ID: $request_id) has been approved and scheduled for $sched_date.";
           insert_notification($con, $user_id, $request_id, 'request_approved', $message);

        header("Location: ../request_record.php?tab=2");
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
}

if (isset($_POST['progress'])) {
    $request_id = sanitize_input($_POST['request_id']);
    $remarks = sanitize_input($_POST['remarks']);
    
    mysqli_begin_transaction($con);
    
    try {
        $fetchQuery = "SELECT users.email, service_request.service_type 
                       FROM service_request 
                       JOIN users ON service_request.user_id = users.user_id 
                       WHERE service_request.request_id = ?";
        $stmt = mysqli_prepare($con, $fetchQuery);
        mysqli_stmt_bind_param($stmt, "s", $request_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            $recipientEmail = $data['email'];
            $serviceType = $data['service_type'];

            $updateQuery = "UPDATE service_request SET status='In Progress', inprogress_remarks=?, ongoing_date=NOW() 
                            WHERE request_id = ?";
            $stmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($stmt, "ss", $remarks, $request_id);
            $updateResult = mysqli_stmt_execute($stmt);

            if ($updateResult) {
                if ($serviceType == 'data-analysis') {
                    dataAnalysisDocument($recipientEmail);
                }
                $message = "Your service request (ID: $request_id) is now in progress.";
                insert_notification($con, $data['user_id'], $request_id, 'request_in_progress', $message);


                mysqli_commit($con);
                header("Location: ../request_record.php?tab=3");
                exit();
            } else {
                throw new Exception("ERROR: Could not execute the update query. " . mysqli_error($con));
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
    $request_id = sanitize_input($_POST['request_id']);
    $remarks = sanitize_input($_POST['remarks']);
    $payment_status = sanitize_input($_POST['payment_status']);
    $payment_amount = sanitize_input($_POST['payment_amount']);

    $updateQuery = "UPDATE service_request SET status='Completed', completed_remarks=?,
                    payment_status=?, payment_amount=?, completed_date=NOW()
                    WHERE request_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ssds", $remarks, $payment_status, $payment_amount, $request_id);
    $updateResult = mysqli_stmt_execute($stmt);
        
    if ($updateResult) {

        $user_id = fetch_user_id_from_request($con, $request_id);
        $message = "Your service request (ID: $request_id) has been completed.";
        insert_notification($con, $user_id, $request_id, 'request_completed', $message);


        header("Location: ../request_record.php?tab=5");
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
}

if (isset($_POST['cancel'])) {
    $request_id = sanitize_input($_POST['request_id']);
    $remarks = sanitize_input($_POST['remarks']);

    $updateQuery = "UPDATE service_request SET status='Cancelled', cancelled_remarks=?, cancelled_date=NOW() WHERE request_id = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ss", $remarks, $request_id);
    $updateResult = mysqli_stmt_execute($stmt);
        
    if ($updateResult) {

        $user_id = fetch_user_id_from_request($con, $request_id);
        $message = "Your service request (ID: $request_id) has been cancelled.";
        insert_notification($con, $user_id, $request_id, 'request_cancelled', $message);

        
        header("Location: ../request_record.php?tab=4");
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
}
?>