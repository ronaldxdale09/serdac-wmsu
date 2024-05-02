<?php
include('../../function/db.php');

header('Content-Type: application/json');



// Query to get the count of each type of service request
$query = "SELECT service_type, COUNT(*) as count FROM service_request GROUP BY service_type";
$result = $con->query($query);

$data = array();
foreach ($result as $row) {
    $data[] = $row;
}

// Free result set and close conection
$result->free_result();
$con->close();

echo json_encode($data);
?>
