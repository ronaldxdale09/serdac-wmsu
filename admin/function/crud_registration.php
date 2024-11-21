<?php
include('../../function/db.php');

// Function to sanitize input
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Function to log messages with context
function logMessage($message, $context = []) {
    $log = date('[Y-m-d H:i:s] ') . $message;
    if (!empty($context)) {
        $log .= ' | Context: ' . json_encode($context);
    }
    error_log($log . "\n", 3, 'crud_error.log');
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
            logMessage("Invalid table accessed", ['table' => $table]);
            exit(json_encode(['status' => 'error', 'message' => 'Invalid table']));
    }

    try {
        switch ($action) {
            case 'add':
                if (!isset($_POST['value']) || trim($_POST['value']) === '') {
                    throw new Exception("Value cannot be empty");
                }
                
                $value = sanitize_input($_POST['value']);
                
                // Check for duplicates
                $check_stmt = $con->prepare("SELECT id FROM `$table` WHERE `$column` = ?");
                if (!$check_stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                
                $check_stmt->bind_param("s", $value);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                
                if ($check_result->num_rows > 0) {
                    $check_stmt->close();
                    throw new Exception("This value already exists. Please enter a unique value.");
                }
                $check_stmt->close();

                // Insert new record
                $stmt = $con->prepare("INSERT INTO `$table` (`$column`) VALUES (?)");
                if (!$stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                $stmt->bind_param("s", $value);
                break;

            case 'update':
                if (!isset($_POST['id']) || !isset($_POST['value'])) {
                    throw new Exception("Missing required parameters");
                }

                $id = intval($_POST['id']);
                $value = sanitize_input($_POST['value']);

                if (trim($value) === '') {
                    throw new Exception("Value cannot be empty");
                }

                // Check for duplicates excluding current record
                $check_stmt = $con->prepare("SELECT id FROM `$table` WHERE `$column` = ? AND id != ?");
                if (!$check_stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                
                $check_stmt->bind_param("si", $value, $id);
                $check_stmt->execute();
                $check_result = $check_stmt->get_result();
                
                if ($check_result->num_rows > 0) {
                    $check_stmt->close();
                    throw new Exception("This value already exists. Please enter a unique value.");
                }
                $check_stmt->close();

                // Update record
                $stmt = $con->prepare("UPDATE `$table` SET `$column` = ? WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                $stmt->bind_param("si", $value, $id);
                break;

            case 'delete':
                if (!isset($_POST['id'])) {
                    throw new Exception("ID is required for deletion");
                }

                $id = intval($_POST['id']);

                // Verify record exists before deletion
                $check_stmt = $con->prepare("SELECT id FROM `$table` WHERE id = ?");
                if (!$check_stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                
                $check_stmt->bind_param("i", $id);
                $check_stmt->execute();
                
                if ($check_stmt->get_result()->num_rows === 0) {
                    $check_stmt->close();
                    throw new Exception("Record not found");
                }
                $check_stmt->close();

                // Delete record
                $stmt = $con->prepare("DELETE FROM `$table` WHERE id = ?");
                if (!$stmt) {
                    throw new Exception("Database error: " . $con->error);
                }
                $stmt->bind_param("i", $id);
                break;

            default:
                throw new Exception("Invalid action specified");
        }

        // Execute the prepared statement
        if (!$stmt->execute()) {
            throw new Exception("Database error: " . $stmt->error);
        }

        $affected_rows = $stmt->affected_rows;
        $stmt->close();

        echo json_encode([
            'status' => 'success',
            'affected_rows' => $affected_rows
        ]);

    } catch (Exception $e) {
        logMessage("Error occurred", [
            'action' => $action,
            'table' => $table,
            'error' => $e->getMessage()
        ]);
        
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }

    if (isset($con) && $con instanceof mysqli) {
        $con->close();
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No action specified']);
}
?>