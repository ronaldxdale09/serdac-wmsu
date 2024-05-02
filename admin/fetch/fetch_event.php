<?php
include('../../function/db.php');

// Query to select data from the sr_meeting table
$sql = "SELECT sr_meeting.meet_id, sr_meeting.request_id, sr_meeting.meeting_type, sr_meeting.date_time, sr_meeting.remarks, service_request.service_type
        FROM sr_meeting
        JOIN service_request ON sr_meeting.request_id = service_request.request_id";
$result = $con->query($sql);

$events = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $e = array();
        $e['id'] = $row['meet_id'];
        $e['title'] = $row['meeting_type'] . " - " . $row['service_type'];
        $e['start'] = $row['date_time'];
        $e['description'] = $row['remarks']; // Additional detail to display

        // Assign background color based on meeting type or service type
        switch($row['service_type']) {
            case "data-analysis":
                $e['backgroundColor'] = "#ff0000"; // Red for specific service type
                break;
            case "capability-training":
                $e['backgroundColor'] = "#00ff00"; // Green for another type
                break;
            case "technical-assistance":
                    $e['backgroundColor'] = "#0000ff"; // Green for another type
                    break;
            // Add more cases as needed for different service types

        }

        // // Optionally add more properties to events, such as urls, etc.
        // $e['url'] = "request_record.php";

        array_push($events, $e);
    }
} else {
    echo "0 results";
}
$con->close();

// Return JSON encoded events
header('Content-Type: application/json');
echo json_encode($events);
?>
