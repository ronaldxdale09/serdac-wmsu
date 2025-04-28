<?php
include('../../function/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['projectID'])) {
    $projectID = intval($_POST['projectID']);

    $stmt = $con->prepare('DELETE FROM repo_projects WHERE ProjectID = ?');
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($con->error)]);
        exit();
    }

    $stmt->bind_param('i', $projectID);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Project deleted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Delete failed: ' . htmlspecialchars($stmt->error)]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
