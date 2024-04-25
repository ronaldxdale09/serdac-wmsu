<?php 

include('../../function/db.php');

if (isset($_POST['new'])) {
    // Retrieve speaker data from POST request
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);

    // Insert query for the speaker_profile table
    $query = "INSERT INTO speaker_profile (name, address, email, contact) 
              VALUES ('$name', '$address', '$email', '$contact')";

    // Execute the query
    if (mysqli_query($con, $query)) {
        header("Location: ../speaker_profile.php"); // Change redirect location if needed
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}

?>