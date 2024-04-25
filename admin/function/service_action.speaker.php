<?php 
include('../../function/db.php');

// Check connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$request_id = mysqli_real_escape_string($con, $_POST['req_id']);

$title = mysqli_real_escape_string($con, $_POST['service_title']);
$venue = mysqli_real_escape_string($con, $_POST['venue']);
$from_date = mysqli_real_escape_string($con, $_POST['from_date']);
$to_date = mysqli_real_escape_string($con, $_POST['to_date']);



$updateSql = "UPDATE sr_training SET 
title = '$title',
s_from = '$from_date',
s_to = '$to_date',
venue = '$venue'
WHERE request_id = '$request_id'";

if (!mysqli_query($con, $updateSql)) {
    die('Error updating training record: ' . mysqli_error($con));
}


processSpeakerRecords($con, $request_id);

function processSpeakerRecords($con, $request_id) {
    // Fetch existing speaker records
    $fetchSql = "SELECT sr_spk_id FROM sr_speaker WHERE request_id = '" . $request_id . "'";
    $fetchResult = mysqli_query($con, $fetchSql);
    if (!$fetchResult) {
        die('Error fetching existing speaker records: ' . mysqli_error($con));
    }

    $existingSpeakerData = [];
    while ($row = mysqli_fetch_assoc($fetchResult)) {
        $existingSpeakerData[$row['sr_spk_id']] = $row['sr_spk_id'];
    }

    // Arrays from the form
    $speaker_ids = $_POST['speaker_id'] ?? [];
    $topics = $_POST['topic'] ?? [];

    foreach ($speaker_ids as $index => $speaker_id) {
        $topic = mysqli_real_escape_string($con, $topics[$index] ?? null);

        if (isset($existingSpeakerData[$speaker_id])) {
            // Update existing record
            $updateSql = "UPDATE sr_speaker SET 
                topic = '$topic'
                WHERE sr_spk_id = '$speaker_id' AND request_id = '$request_id'";

            if (!mysqli_query($con, $updateSql)) {
                die('Error updating speaker record: ' . mysqli_error($con));
            }
        } else {
            // Insert new record
            $insertSql = "INSERT INTO sr_speaker (speaker_id, request_id, topic) 
                    VALUES ('$speaker_id', '$request_id', '$topic')";

            if (!mysqli_query($con, $insertSql)) {
                die('Error inserting new speaker record: ' . mysqli_error($con));
            }
        }
    }

    // Remove any old records that weren't in the current submission
    foreach ($existingSpeakerData as $existingSpkId) {
        if (!in_array($existingSpkId, $speaker_ids)) {
            $deleteSql = "DELETE FROM sr_speaker WHERE sr_spk_id = '$existingSpkId'";
            if (!mysqli_query($con, $deleteSql)) {
                die('Error deleting old speaker data: ' . mysqli_error($con));
            }
        }
    }
    echo 'success';
}
?>