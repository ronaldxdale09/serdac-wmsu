<?php 

function log_balance_update($con,$bank, $prev_balance, $new_balance, $source) {

    $insert_log = "INSERT INTO bank_trans_logs (bank_id, date, prev_balance, new_balance, source)
                   VALUES ('$bank', NOW(), '$prev_balance', '$new_balance', '$source')";
    $log_results = mysqli_query($con, $insert_log);
  
    // Check for errors
    if (!$log_results) {
        echo "Error inserting log: " . mysqli_error($con);
        exit();
    }
  }

?>