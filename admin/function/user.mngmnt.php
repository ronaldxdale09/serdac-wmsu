<?php
include('../../function/db.php');

if (isset($_POST['new'])) {
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

    // Modify the SQL query to include additional fields
    $query = "INSERT INTO users (fname, midname, lname, email, contact_no,
     password, accessType, adminAccess,isActive) 
              VALUES ('$fname', '$midname', '$lname', '$email', '$contact_no',
               '$password', '$userType', '$userAccess', '1')";

    // Executing the query
    $results = mysqli_query($con, $query);

    if ($results) {
        header("Location: ../account_mngmt.php");  // Change this to your desired location
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}


    if (isset($_POST['update'])) {
        // Retrieve user data and user_id from POST request
        $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        $fname = mysqli_real_escape_string($con, $_POST['fname']);
        $midname = mysqli_real_escape_string($con, $_POST['midname']);
        $lname = mysqli_real_escape_string($con, $_POST['lname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
        $userType = mysqli_real_escape_string($con, $_POST['userType']);
        $password = !empty($_POST['password']) ? password_hash(mysqli_real_escape_string($con, $_POST['password']), PASSWORD_DEFAULT) : null;
        $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

        // Create the SQL update query
        $query = "UPDATE users SET 
                    fname = ?, 
                    midname = ?, 
                    lname = ?, 
                    email = ?, 
                    contact_no = ?, 
                    userType = ?, 
                    adminAccess = ?";
        if ($password) {
            $query .= ", password = ?";
        }
        $query .= " WHERE user_id = ?";

        // Prepare the statement
        $stmt = $con->prepare($query);

        if ($password) {
            $stmt->bind_param("ssssssssi", $fname, $midname, $lname, $email, $contact_no, $userType, $userAccess, $password, $user_id);
        } else {
            $stmt->bind_param("sssssssi", $fname, $midname, $lname, $email, $contact_no, $userType, $userAccess, $user_id);
        }

        // Execute the query
        if ($stmt->execute()) {
            header("Location: ../account_mngmt.php"); // Redirect location after updating
        } else {
            echo "ERROR: Could not execute query. " . mysqli_error($con);
        }
        $stmt->close();
        $con->close();
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