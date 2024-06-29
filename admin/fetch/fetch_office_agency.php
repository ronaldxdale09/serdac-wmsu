<?php
// get_office_agencies.php
header('Content-Type: application/json');

include('../../function/db.php');

if ($con->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $con->connect_error]));
}

$query = "SELECT DISTINCT office_agency FROM service_request ORDER BY office_agency ASC";
$result = $con->query($query);

if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $con->error]));
}

$agencies = [];
while ($row = $result->fetch_assoc()) {
    $agencies[] = $row['office_agency'];
}

echo json_encode($agencies);

$con->close();