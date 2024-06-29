<?php
// report_data.php
header('Content-Type: application/json');

include('../../function/db.php');


// Get filter values
$service_type = $_GET['service_type'] ?? '';
$status = $_GET['status'] ?? '';
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';
$client_type = $_GET['client_type'] ?? '';
$office_agency = $_GET['office_agency'] ?? '';
$agency_classification = $_GET['agency_classification'] ?? '';

// Build the query
$query = "SELECT * FROM service_request WHERE 1=1";

if ($service_type) {
    $query .= " AND service_type = '$service_type'";
}

if ($status) {
    $query .= " AND status = '$status'";
}

if ($start_date && $end_date) {
    $query .= " AND request_date BETWEEN '$start_date' AND '$end_date'";
}

if ($client_type) {
    $query .= " AND client_type = '$client_type'";
}

if ($office_agency) {
    $query .= " AND office_agency LIKE '%$office_agency%'";
}

if ($agency_classification) {
    $query .= " AND agency_classification = '$agency_classification'";
}

$result = $con->query($query);

if (!$result) {
    die(json_encode(['error' => 'Query failed: ' . $con->error]));
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$con->close();