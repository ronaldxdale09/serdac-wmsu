<?php 

include('../../function/db.php');


$sql = "SELECT request_id, service_type, scheduled_date FROM service_request";
$result = $con->query($sql);

$events = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $e = array();
        $e['id'] = $row['request_id'];
        $e['title'] = $row['service_type'];
        $e['start'] = $row['scheduled_date'];

        // Assign background color based on service type
        switch($row['service_type']) {
            case "ServiceType1":
                $e['backgroundColor'] = "#ff0000"; // red
                break;
            case "ServiceType2":
                $e['backgroundColor'] = "#00ff00"; // green
                break;
            // Add more cases for different service types
            default:
                $e['backgroundColor'] = "#0000ff"; // blue
        }

        // Merge the event array into the return array
        array_push($events, $e);
    }
} else {
    echo "0 results";
}
$con->close();

// Return JSON encoded events
echo json_encode($events);
?>