<?php
include('../../function/db.php');

header('Content-Type: application/json');

// Retrieve the year from the GET request; default to the current year if not provided
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Updated query to get the count of each type of service request per month, filtered by the selected year
$query = "SELECT service_type, MONTH(request_date) AS month, COUNT(*) AS count FROM service_request WHERE YEAR(request_date) = ? GROUP BY service_type, MONTH(request_date)";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $year);  // Bind the year as an integer parameter
$stmt->execute();
$result = $stmt->get_result();

$data = array();
while ($row = $result->fetch_assoc()) {
    if (!isset($data[$row['service_type']])) {
        $data[$row['service_type']] = array_fill(1, 12, 0);  // Fill months from 1 to 12 with zero
    }
    $data[$row['service_type']][intval($row['month'])] = $row['count'];
}

// Free result set and close the connection
$stmt->close();
$con->close();

echo json_encode($data);
?>
