<?php 
include('../../function/db.php');

// Check connection
if (!$con) {
    die('Could not connect: ' . mysqli_connect_error());
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Ensure request_id is set and sanitized
if (!isset($_POST['req_id'])) {
    die('Error: req_id is not set');
}
$request_id = mysqli_real_escape_string($con, $_POST['req_id']);

processMeetingRecords($con, $request_id);

function processMeetingRecords($con, $request_id) {
    // Fetch existing meeting records
    $fetchSql = "SELECT meet_id FROM sr_meeting WHERE request_id = ?";
    $stmt = mysqli_prepare($con, $fetchSql);
    mysqli_stmt_bind_param($stmt, "s", $request_id);
    mysqli_stmt_execute($stmt);
    $fetchResult = mysqli_stmt_get_result($stmt);
    
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

    // Prepare statements
    $updateStmt = mysqli_prepare($con, "UPDATE sr_meeting SET meeting_type = ?, date_time = ?, mode = ?, remarks = ? WHERE meet_id = ?");
    $insertStmt = mysqli_prepare($con, "INSERT INTO sr_meeting (request_id, meeting_type, date_time, mode, remarks) VALUES (?, ?, ?, ?, ?)");

    foreach ($date_times as $index => $date_time) {
        $meet_id = $meet_ids[$index] ?? null;
        $meeting_type = $meeting_types[$index] ?? null;
        $mode = $modes[$index] ?? '-';
        $remark = $remarks[$index] ?? '-';

        if ($meet_id && isset($existingMeetingData[$meet_id])) {
            // Update existing record
            mysqli_stmt_bind_param($updateStmt, "sssss", $meeting_type, $date_time, $mode, $remark, $meet_id);
            if (!mysqli_stmt_execute($updateStmt)) {
                die('Error updating meeting record: ' . mysqli_error($con));
            }
        } else {
            // Insert new record
            mysqli_stmt_bind_param($insertStmt, "sssss", $request_id, $meeting_type, $date_time, $mode, $remark);
            if (!mysqli_stmt_execute($insertStmt)) {
                die('Error inserting new meeting record: ' . mysqli_error($con));
            }
        }
    }

    // Close prepared statements
    mysqli_stmt_close($updateStmt);
    mysqli_stmt_close($insertStmt);

    // Remove any old records that weren't in the current submission
    $deleteStmt = mysqli_prepare($con, "DELETE FROM sr_meeting WHERE meet_id = ?");
    foreach ($existingMeetingData as $existingMeetId) {
        if (!in_array($existingMeetId, $meet_ids)) {
            mysqli_stmt_bind_param($deleteStmt, "s", $existingMeetId);
            if (!mysqli_stmt_execute($deleteStmt)) {
                echo 'Error deleting old meeting data: ' . mysqli_error($con) . "<br>";
            }
        }
    }
    mysqli_stmt_close($deleteStmt);

    echo 'success';
}
?>