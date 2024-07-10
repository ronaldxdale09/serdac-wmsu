<?php 

include('../../function/db.php');

if (isset($_POST['new'])) {
    // Retrieve speaker data from POST request
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $specialization = mysqli_real_escape_string($con, $_POST['specialization']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);

    // Insert query for the speaker_profile table
    $query = "INSERT INTO speaker_profile (name, occupation, specialization, address, email, contact) 
              VALUES ('$name', '$occupation', '$specialization', '$address', '$email', '$contact')";

    // Execute the query
    if (mysqli_query($con, $query)) {
        header("Location: ../speaker_profile.php"); // Change redirect location if needed
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}

if (isset($_POST['update'])) {
    // Retrieve speaker data from POST request
    $speaker_id = mysqli_real_escape_string($con, $_POST['speaker_id']);
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $specialization = mysqli_real_escape_string($con, $_POST['specialization']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);

    // Update query for the speaker_profile table
    $query = "UPDATE speaker_profile SET 
              name='$name', occupation='$occupation', specialization='$specialization', 
              address='$address', email='$email', contact='$contact' 
              WHERE speaker_id='$speaker_id'";

    // Execute the query
    if (mysqli_query($con, $query)) {
        header("Location: ../speaker_profile.php"); // Change redirect location if needed
        exit();
    } else {
        echo "ERROR: Could not execute the query. " . mysqli_error($con);
    }
    exit();
}


if (isset($_POST['delete'])) {
    // Retrieve speaker ID from POST request
    $speaker_id = mysqli_real_escape_string($con, $_POST['speaker_id']);

    // Delete query for the speaker_profile table
    $query = "DELETE FROM speaker_profile WHERE speaker_id='$speaker_id'";

    // Execute the query
    if (mysqli_query($con, $query)) {
        header("Location: ../speaker_profile.php"); // Change redirect location if needed
        exit();
    } else {
        echo "ERROR: Could not execute the delete query. " . mysqli_error($con);
    }
    exit();
}
?>