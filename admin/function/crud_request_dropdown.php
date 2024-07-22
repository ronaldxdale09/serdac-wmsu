<?php 
include('../../function/db.php');


// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Handling the AJAX request
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $table = $_POST['table'];
    
    // Determine the column name based on the table
    switch ($table) {
        case 'r_agency_classification':
            $column = 'classification';
            break;
        case 'r_client_type':
            $column = 'type';
            break;
        case 'r_purpose_of_request':
            $column = 'purpose';
            break;
        default:
            exit(json_encode(['status' => 'error', 'message' => 'Invalid table']));
    }

    switch ($action) {
        case 'add':
            $value = sanitize_input($_POST['value']);
            $stmt = $con->prepare("INSERT INTO $table ($column) VALUES (?)");
            $stmt->bind_param("s", $value);
            break;

        case 'update':
            $id = intval($_POST['id']);
            $value = sanitize_input($_POST['value']);
            $stmt = $con->prepare("UPDATE $table SET $column = ? WHERE id = ?");
            $stmt->bind_param("si", $value, $id);
            break;

        case 'delete':
            $id = intval($_POST['id']);
            $stmt = $con->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->bind_param("i", $id);
            break;

        default:
            exit(json_encode(['status' => 'error', 'message' => 'Invalid action']));
    }

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $con->error]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
}

?>