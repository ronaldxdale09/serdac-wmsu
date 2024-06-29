<?php
// user_report.php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../../function/db.php');

$response = ['error' => null, 'data' => null, 'debug' => []];

try {
    $reportType = $_GET['reportType'] ?? 'yearly';
    $year = $_GET['year'] ?? date('Y');
    $filterType = $_GET['filterType'] ?? '';
    $filterValue = $_GET['filterValue'] ?? '';

    $response['debug'][] = "Report Type: $reportType, Year: $year, Filter Type: $filterType, Filter Value: $filterValue";

    $query = "SELECT 
                CASE 
                    WHEN ? = 'monthly' THEN DATE_FORMAT(COALESCE(registration_date, NOW()), '%Y-%m')
                    WHEN ? = 'quarterly' THEN CONCAT(YEAR(COALESCE(registration_date, NOW())), '-Q', QUARTER(COALESCE(registration_date, NOW())))
                    ELSE YEAR(COALESCE(registration_date, NOW()))
                END AS period,
                COUNT(*) as total_users,
                SUM(CASE WHEN gender = 0 THEN 1 ELSE 0 END) as male_users,
                SUM(CASE WHEN gender = 1 THEN 1 ELSE 0 END) as female_users,
                SUM(CASE WHEN occupation = 'student' THEN 1 ELSE 0 END) as student_users,
                SUM(CASE WHEN occupation = 'employed_ft' THEN 1 ELSE 0 END) as employed_ft_users,
                SUM(CASE WHEN occupation = 'employed_pt' THEN 1 ELSE 0 END) as employed_pt_users,
                SUM(CASE WHEN education_level = 'elementary' THEN 1 ELSE 0 END) as elementary_edu,
                SUM(CASE WHEN education_level = 'high_school' THEN 1 ELSE 0 END) as high_school_edu,
                SUM(CASE WHEN education_level = 'college' THEN 1 ELSE 0 END) as college_edu,
                SUM(CASE WHEN education_level = 'post_graduate' THEN 1 ELSE 0 END) as post_graduate_edu
              FROM users
              WHERE (registration_date IS NULL OR YEAR(registration_date) = ? OR ? = 'all') 
                AND accessType = 'Client'";

    $params = [$reportType, $reportType, $year, $year];
    $types = "ssss";

    if ($filterType && $filterValue && $filterValue !== 'all') {
        $query .= " AND $filterType = ?";
        $params[] = $filterValue;
        $types .= "s";
    }

    $query .= " GROUP BY period ORDER BY period";

    $stmt = $con->prepare($query);

    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $con->error);
    }

    if (!$stmt->bind_param($types, ...$params)) {
        throw new Exception("Binding parameters failed: " . $stmt->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $response['data'] = $data;
    $response['debug'][] = "Query executed successfully. Row count: " . count($data);

} catch (Exception $e) {
    $response['error'] = $e->getMessage();
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if (isset($con)) {
        $con->close();
    }
}

echo json_encode($response);