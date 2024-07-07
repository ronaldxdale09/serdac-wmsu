<?php
include('../../function/db.php');

// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Function to create a new user
function createUser($con) {
    try {
        // Retrieve user data from POST request
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $midname = mysqli_real_escape_string($con, $_POST['midname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userType = mysqli_real_escape_string($con, $_POST['userType']);
        $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email = ?";
        $checkStmt = $con->prepare($checkEmail);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            return array(
                "status" => "error",
                "message" => "Email already exists. Please use a different email address."
            );
        } else {
            // If email doesn't exist, proceed with insertion
            $query = "INSERT INTO users (fname, midname, lname, email, contact_no, password, accessType, adminAccess, isActive) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";

            $stmt = $con->prepare($query);
            $stmt->bind_param("ssssssss", $fname, $midname, $lname, $email, $contact_no, $password, $userType, $userAccess);

            if ($stmt->execute()) {
                return array(
                    "status" => "success",
                    "message" => "User created successfully!"
                );
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }
    } catch (Exception $e) {
        error_log("Error in user creation: " . $e->getMessage());
        return array(
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        );
    }
}

// Function to update an existing user
function updateUser($con) {
    try {
        $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $midname = mysqli_real_escape_string($con, $_POST['midname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
        $userType = mysqli_real_escape_string($con, $_POST['userType']);
        $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

        $newPassword = !empty($_POST['newPassword']) ? $_POST['newPassword'] : null;
        $confirmPassword = !empty($_POST['confirmPassword']) ? $_POST['confirmPassword'] : null;

        $query = "UPDATE users SET 
                    fname = ?, 
                    midname = ?, 
                    lname = ?, 
                    email = ?, 
                    contact_no = ?, 
                    accessType = ?, 
                    adminAccess = ?";

        $params = [$fname, $midname, $lname, $email, $contact_no, $userType, $userAccess];
        $types = "sssssss";

        if ($newPassword && $newPassword === $confirmPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $query .= ", password = ?";
            $params[] = $hashedPassword;
            $types .= "s";
        } elseif ($newPassword !== $confirmPassword) {
            throw new Exception("New password and confirmation do not match.");
        }

        $query .= " WHERE user_id = ?";
        $params[] = $user_id;
        $types .= "i";

        $stmt = $con->prepare($query);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            return array(
                "status" => "success",
                "message" => "User updated successfully!"
            );
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
    } catch (Exception $e) {
        error_log("Error in user update: " . $e->getMessage());
        return array(
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        );
    }
}

// Function to delete a user
function deleteUser($con) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $current_user_id = $_SESSION["userId_code"];

    if ($user_id == $current_user_id) {
        return array(
            "status" => "error",
            "message" => "You cannot delete your own account."
        );
    } else {
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $user_id);
        
        if ($stmt->execute()) {
            return array(
                "status" => "success",
                "message" => "User deleted successfully."
            );
        } else {
            return array(
                "status" => "error",
                "message" => "Error deleting user: " . $stmt->error
            );
        }
    }
}

// Main logic to handle different actions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    if (isset($_POST['email']) && !isset($_POST['user_id'])) {
        // Create new user
        $response = createUser($con);
    } elseif (isset($_POST['user_id']) && !isset($_POST['delete'])) {
        // Update existing user
        $response = updateUser($con);
    } elseif (isset($_POST['delete'])) {
        // Delete user
        $response = deleteUser($con);
    } else {
        $response = array(
            "status" => "error",
            "message" => "Invalid request."
        );
    }

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    header("Location: ../account_mngmt.php"); // Change redirect location if needed

    exit();
}
?>