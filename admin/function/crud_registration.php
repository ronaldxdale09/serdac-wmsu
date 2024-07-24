<?php
include('../../function/db.php');

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to log messages
function logMessage($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . "\n", 3, 'crud_error.log');
}

// Handling the AJAX request
if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $table = $_POST['table'];

    // Determine the column name based on the table
    switch ($table) {
        case 'r_education_levels':
            $column = 'education_level';
            break;
        case 'r_genders':
            $column = 'gender';
            break;
        case 'r_occupations':
            $column = 'occupation';
            break;
        default:
            logMessage("Invalid table: $table");
            exit(json_encode(['status' => 'error', 'message' => 'Invalid table']));
    }

    try {
        switch ($action) {
            case 'add':
                $value = sanitize_input($_POST['value']);
                // Check if the value already exists
                $check_stmt = $con->prepare("SELECT id FROM $table WHERE $column = ?");
                $check_stmt->bind_param("s", $value);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                if ($check_result->num_rows > 0) {
                    throw new Exception("This value already exists. Please enter a unique value.");
                }
                $stmt = $con->prepare("INSERT INTO $table ($column) VALUES (?)");
                $stmt->bind_param("s", $value);
                break;

            case 'update':
                $id = intval($_POST['id']);
                $value = sanitize_input($_POST['value']);
                // Check if the new value already exists (excluding the current record)
                $check_stmt = $con->prepare("SELECT id FROM $table WHERE $column = ? AND id != ?");
                $check_stmt->bind_param("si", $value, $id);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                if ($check_result->num_rows > 0) {
                    throw new Exception("This value already exists. Please enter a unique value.");
                }
                $stmt = $con->prepare("UPDATE $table SET $column = ? WHERE id = ?");
                $stmt->bind_param("si", $value, $id);
                break;

            case 'delete':
                $id = intval($_POST['id']);
                $stmt = $con->prepare("DELETE FROM $table WHERE id = ?");
                $stmt->bind_param("i", $id);
                break;

            default:
                logMessage("Invalid action: $action");
                exit(json_encode(['status' => 'error', 'message' => 'Invalid action']));
        }

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            throw new Exception($con->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        logMessage("Error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $con->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
}
?>