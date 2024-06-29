<?php
// report.php
header('Content-Type: application/json');
include('../../function/db.php');


$reportType = $_GET['reportType'] ?? '';
$year = $_GET['year'] ?? date('Y');
$filterType = $_GET['filterType'] ?? '';
$filterValue = $_GET['filterValue'] ?? '';

$query = "SELECT 
            CASE 
                WHEN '{$reportType}' = 'monthly' THEN DATE_FORMAT(request_date, '%Y-%m')
                WHEN '{$reportType}' = 'quarterly' THEN CONCAT(YEAR(request_date), '-Q', QUARTER(request_date))
                ELSE YEAR(request_date)
            END AS period,
            COUNT(*) as total_requests,
            SUM(CASE WHEN status = 'Completed' THEN 1 ELSE 0 END) as completed_requests,
            SUM(CASE WHEN status = 'In Progress' THEN 1 ELSE 0 END) as in_progress_requests,
            SUM(CASE WHEN status = 'Cancelled' THEN 1 ELSE 0 END) as cancelled_requests,
            AVG(DATEDIFF(IFNULL(completed_date, CURDATE()), request_date)) as avg_completion_time,
            COUNT(DISTINCT user_id) as unique_users,
            SUM(CASE WHEN service_type = 'capability-training' THEN 1 ELSE 0 END) as training_requests,
            SUM(CASE WHEN service_type = 'data-analysis' THEN 1 ELSE 0 END) as analysis_requests,
            SUM(CASE WHEN service_type = 'tech-assistance' THEN 1 ELSE 0 END) as assistance_requests,
            AVG(participants) as avg_participants
          FROM service_request
          WHERE YEAR(request_date) = ?";

if ($filterType && $filterValue) {
    switch ($filterType) {
        case 'activity':
            $query .= " AND service_type = ?";
            break;
        case 'participants':
            $query .= " AND client_type = ?";
            break;
        case 'status':
            $query .= " AND status = ?";
            break;
    }
}

$query .= " GROUP BY period ORDER BY period";

$stmt = $con->prepare($query);

if ($filterType && $filterValue) {
    $stmt->bind_param("is", $year, $filterValue);
} else {
    $stmt->bind_param("i", $year);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);

$stmt->close();
$con->close();
?>