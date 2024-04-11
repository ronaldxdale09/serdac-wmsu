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
    $query = "INSERT INTO users (fname, midname, lname, email, contact_no, password, accessType, adminAccess) 
              VALUES ('$fname', '$midname', '$lname', '$email', '$contact_no', '$password', '$userType', '$userAccess')";

    // Executing the query
    $results = mysqli_query($con, $query);

    if ($results) {
        header("Location: ../acc_mng.php");  // Change this to your desired location
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}


// Update User
if (isset($_POST['update'])) {
    // Retrieve user data and user_id from POST request
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $contact_no = mysqli_real_escape_string($con, $_POST['contact_no']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']); // Consider encrypting the password
    $userType = mysqli_real_escape_string($con, $_POST['userType']);
   // Serialize or JSON-encode the userAccess array
   $userAccess = isset($_POST['userAccess']) ? json_encode($_POST['userAccess']) : '';

   // Update query to include userAccess
   $query = "UPDATE users SET name = '$name', contact_no = '$contact_no', username = '$username', password = '$password', userType = '$userType', userAccess = '$userAccess' WHERE user_id = '$user_id'";


    // Execute the query
    if (mysqli_query($con, $query)) {
        header("Location: ../account_mngmt.php"); // Redirect location after updating
    } else {
        echo "ERROR: Could not execute $query. " . mysqli_error($con);
    }
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
