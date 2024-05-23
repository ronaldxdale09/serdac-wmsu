<?php
include('../../function/db.php');

$service_type = isset($_GET['service_type']) ? $_GET['service_type'] : '';

if ($service_type) {
    $query = "SELECT service_request.*, users.fname, users.lname FROM service_request
              LEFT JOIN users ON users.user_id = service_request.user_id
              WHERE service_request.service_type = '$service_type'
              ORDER BY request_date DESC LIMIT 20";
} else {
    $query = "SELECT service_request.*, users.fname, users.lname FROM service_request
              LEFT JOIN users ON users.user_id = service_request.user_id
              ORDER BY request_date DESC LIMIT 10";
}

$results = mysqli_query($con, $query);

if (!$results) {
    echo json_encode(["error" => mysqli_error($con)]);
    exit;
}

$data = [];

while ($row = mysqli_fetch_assoc($results)) {
    $data[] = $row;
}

echo json_encode($data);
?>