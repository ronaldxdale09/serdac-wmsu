<?php
include('../../function/db.php');

// Function to sanitize input
function sanitize_input($data) {
    global $con;
    return $con->real_escape_string(htmlspecialchars(strip_tags(trim($data))));
}

// Function to validate email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to set notification
function set_notification($status, $title, $message) {
    $_SESSION['notification'] = [
        'status' => $status,
        'title' => $title,
        'message' => $message
    ];
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    set_notification('error', 'Error', 'Invalid request method');
    exit;
}

// Determine the operation (update or delete)
$operation = $_POST['operation'] ?? '';

switch ($operation) {
    case 'update':
        // Validate and sanitize input
        $userId = filter_var($_POST['user_id'] ?? '', FILTER_VALIDATE_INT);
        $name = sanitize_input($_POST['name'] ?? '');
        $contact = sanitize_input($_POST['contact_no'] ?? '');
        $email = sanitize_input($_POST['email'] ?? '');
        $gender = sanitize_input($_POST['gender'] ?? '');
        $occupation = sanitize_input($_POST['occupation'] ?? '');
        $education = sanitize_input($_POST['education_level'] ?? '');

        // Validate inputs
        if (!$userId || empty($name) || !validate_email($email)) {
            set_notification('error', 'Error', 'Invalid input data');
            exit;
        }

        // Split the name into parts
        $nameParts = explode(' ', $name);
        $fname = $nameParts[0];
        $lname = end($nameParts);
        $midname = count($nameParts) > 2 ? implode(' ', array_slice($nameParts, 1, -1)) : '';

        $stmt = $con->prepare("UPDATE users SET fname = ?, midname = ?, lname = ?, contact_no = ?, email = ?, gender = ?, occupation = ?, education_level = ? WHERE user_id = ?");
        $stmt->bind_param("ssssssssi", $fname, $midname, $lname, $contact, $email, $gender, $occupation, $education, $userId);

        if ($stmt->execute()) {
            set_notification('success', 'Updated!', 'The client has been updated successfully.');
        } else {
            set_notification('error', 'Error', 'Failed to update client: ' . $con->error);
        }

        $stmt->close();
        break;

    case 'delete':
        $userId = filter_var($_POST['user_id'] ?? '', FILTER_VALIDATE_INT);

        if (!$userId) {
            set_notification('error', 'Error', 'Invalid user ID');
            exit;
        }

        $stmt = $con->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            set_notification('success', 'Deleted!', 'The client has been deleted successfully.');
        } else {
            set_notification('error', 'Error', 'Failed to delete client: ' . $con->error);
        }

        $stmt->close();
        break;

    default:
        set_notification('error', 'Error', 'Invalid operation');
        break;
}

$con->close();
echo json_encode(['status' => 'success']);
?>