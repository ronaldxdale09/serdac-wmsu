<?php
include('../../function/db.php');


$formType = $_GET['formType'] ?? '';
$isQuiz = $_GET['isQuiz'] ?? '';
$dateRange = $_GET['dateRange'] ?? '';

$query = "SELECT af.*, 
          COUNT(DISTINCT ar.user_id) as responses,
          COUNT(DISTINCT aq.question_id) as question_count
          FROM asmt_forms af 
          LEFT JOIN asmt_responses ar ON af.form_id = ar.form_id 
          LEFT JOIN asmt_questions aq ON af.form_id = aq.form_id
          WHERE 1=1";

if ($formType) {
    $query .= " AND af.form_type = '" . $con->real_escape_string($formType) . "'";
}

if ($isQuiz !== '') {
    $query .= " AND af.is_quiz = " . intval($isQuiz);
}

if ($dateRange) {
    $dates = explode(' - ', $dateRange);
    $startDate = $con->real_escape_string($dates[0]);
    $endDate = $con->real_escape_string($dates[1]);
    $query .= " AND af.start_date >= '$startDate' AND af.end_date <= '$endDate'";
}

$query .= " GROUP BY af.form_id";

$result = $con->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);

$con->close();
?>