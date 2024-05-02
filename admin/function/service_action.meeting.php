<?php 
include('../../function/db.php');

// Check connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}


ini_set('display_errors', 1);
error_reporting(E_ALL);

$request_id = mysqli_real_escape_string($con, $_POST['req_id']);
processMeetingRecords($con, $request_id);


function processMeetingRecords($con, $request_id) {
    // Fetch existing meeting records
    $fetchSql = "SELECT meet_id FROM sr_meeting WHERE request_id = '" . mysqli_real_escape_string($con, $request_id) . "'";
    $fetchResult = mysqli_query($con, $fetchSql);
    if (!$fetchResult) {
        die('Error fetching existing meeting records: ' . mysqli_error($con));
    }

    $existingMeetingData = [];
    while ($row = mysqli_fetch_assoc($fetchResult)) {
        $existingMeetingData[$row['meet_id']] = $row['meet_id'];
    }

    // Arrays from the form
    $meet_ids = $_POST['meet_id'] ?? [];
    $meeting_types = $_POST['meeting_type'] ?? [];
    $date_times = $_POST['date_time'] ?? [];
    $modes = $_POST['mode'] ?? [];
    $remarks = $_POST['remarks'] ?? [];

    foreach ($date_times as $index => $date_time) {
        $meet_id = $meet_ids[$index] ?? null;
        $meeting_type = mysqli_real_escape_string($con, $meeting_types[$index] ?? null);
        $mode = mysqli_real_escape_string($con, $modes[$index] ?? '-');
        $remark = mysqli_real_escape_string($con, $remarks[$index] ?? '-');

        if ($meet_id && isset($existingMeetingData[$meet_id])) {
            // Update existing record
            $updateSql = "UPDATE sr_meeting SET 
                meeting_type = '$meeting_type',
                date_time = '$date_time',
                mode = '$mode',
                remarks = '$remark'
                WHERE meet_id = '$meet_id'";

            if (!mysqli_query($con, $updateSql)) {
                echo 'Error updating  meeting record';

                die('Error updating meeting record: ' . mysqli_error($con));
            }
        } else {
            // Insert new record
            $insertSql = "INSERT INTO sr_meeting (request_id, meeting_type, date_time, mode, remarks) 
                    VALUES ('$request_id', '$meeting_type', '$date_time', '$mode', '$remark')";

            if (!mysqli_query($con, $insertSql)) {
                echo 'Error inserting new meeting record';

                die('Error inserting new meeting record: ' . mysqli_error($con));
            }
        }
    }

    // Remove any old records that weren't in the current submission
    foreach ($existingMeetingData as $existingMeetId) {
        if (!in_array($existingMeetId, $meet_ids)) {
            $deleteSql = "DELETE FROM sr_meeting WHERE meet_id = '$existingMeetId'";
            if (!mysqli_query($con, $deleteSql)) {
                echo 'Error deleting old meeting data: ' . mysqli_error($con) . "<br>";
            }
        }
    }
    echo 'success';

}


?>