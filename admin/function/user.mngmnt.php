<?php
include('../../function/db.php');


// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['email'])) {
    try {
        // Retrieve user data from POST request
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $midname = mysqli_real_escape_string($con, $_POST['midname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userType = mysqli_real_escape_string($con, $_POST['userType']);

        // Serialize or JSON-encode the userAccess array
        $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

        // Check if email already exists
        $checkEmail = "SELECT * FROM users WHERE email = ?";
        $checkStmt = $con->prepare($checkEmail);
        if (!$checkStmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        $checkStmt->bind_param("s", $email);
        if (!$checkStmt->execute()) {
            throw new Exception("Execute failed: " . $checkStmt->error);
        }
        $result = $checkStmt->get_result();

        if ($result->num_rows > 0) {
            // Email already exists
            $response = array(
                "status" => "error",
                "message" => "Email already exists. Please use a different email address."
            );
        } else {
            // If email doesn't exist, proceed with insertion
            $query = "INSERT INTO users (fname, midname, lname, email, contact_no, password, accessType, adminAccess, isActive) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";

            $stmt = $con->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $con->error);
            }
            $stmt->bind_param("ssssssss", $fname, $midname, $lname, $email, $contact_no, $password, $userType, $userAccess);

            if ($stmt->execute()) {
                $response = array(
                    "status" => "success",
                    "message" => "User created successfully!"
                );
            } else {
                throw new Exception("Execute failed: " . $stmt->error);
            }
            $stmt->close();
        }
    } catch (Exception $e) {
        // Log the error
        error_log("Error in user creation: " . $e->getMessage());
        $response = array(
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        );
    }

    // Ensure proper JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Function to update an existing user
if (isset($_POST['user_id'])) {
    try {
        // Retrieve user data and user_id from POST request
        $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $midname = mysqli_real_escape_string($con, $_POST['midname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
        $userType = mysqli_real_escape_string($con, $_POST['userType']);
        $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

      

        // Check if a new password is provided
        $newPassword = !empty($_POST['newPassword']) ? $_POST['newPassword'] : null;
        $confirmPassword = !empty($_POST['confirmPassword']) ? $_POST['confirmPassword'] : null;

        // Create the SQL update query
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

        // If a new password is provided and confirmed, add it to the query
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

        // Prepare the statement
        $stmt = $con->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $con->error);
        }
        $stmt->bind_param($types, ...$params);

        // Execute the query
        if ($stmt->execute()) {
            $response = array(
                "status" => "success",
                "message" => "User updated successfully!"
            );
        } else {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        // Log the error
        error_log("Error in user update: " . $e->getMessage());
        $response = array(
            "status" => "error",
            "message" => "An error occurred: " . $e->getMessage()
        );
    }

    // Ensure proper JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}


// Function to delete a user (if needed)
if (isset($_POST['delete'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    
    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        header("Location: ../account_mngmt.php");
    } else {
        echo "ERROR: Could not execute query. " . $stmt->error;
    }
    $stmt->close();
    exit();
}

// Delete User
if (isset($_POST['delete'])) {
// Retrieve user_id from POST request
$user_id = mysqli_real_escape_string($con, $_POST['user_id']);

// Delete query
$query = "DELETE FROM users WHERE user_id = '$user_id'";

// Execute the query
if (mysqli_query($con, $query)) {
header("Location: ../account_mngmt.php"); // Redirect location after deleting
} else {
echo "ERROR: Could not execute $query. " . mysqli_error($con);
}
exit();
}


?>