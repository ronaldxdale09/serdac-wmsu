<?php
include('../../function/db.php');

try {
    $sql = "SELECT el.log_id, el.request_id, el.recipients, el.subject, el.sent_at, sr.service_type
            FROM email_log el
            JOIN service_request sr ON el.request_id = sr.request_id
            ORDER BY el.sent_at DESC";

    $result = $con->query($sql);

    if ($result === false) {
        throw new Exception("Query failed: " . $con->error);
    }

    $logs = [];
    while ($row = $result->fetch_assoc()) {
        $logs[] = $row;
    }

    echo json_encode(['logs' => $logs]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['error' => 'An error occurred while fetching email logs.']);
} finally {
    if (isset($con)) {
        $con->close();
    }
}
?>