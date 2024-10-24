<?php
// update_web_details.php

include('../../function/db.php');

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $aboutUs = mysqli_real_escape_string($con, $_POST['about_us']);
    $mission = mysqli_real_escape_string($con, $_POST['mission']);
    $vision = mysqli_real_escape_string($con, $_POST['vision']);
    $goals = mysqli_real_escape_string($con, $_POST['goals']);

    $email = mysqli_real_escape_string($con, $_POST['email']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);


    // Handle file upload
    $bannerImage = '';
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] == 0) {
        $uploadDir = '../../assets/images/'; // Adjust this path as needed
        $fileName = basename($_FILES['banner_image']['name']);
        $targetFilePath = $uploadDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $targetFilePath)) {
                $bannerImage = $targetFilePath;
            } else {
                echo json_encode(['success' => false, 'message' => 'Sorry, there was an error uploading your file.']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.']);
            exit;
        }
    }

    // Update query
    $query = "UPDATE web_details SET 
              about_us = ?, 
              mission = ?, 
              vision = ?, 
              goals = ?,
              org_email = ?,
              org_contact = ?";
    $params = [$aboutUs, $mission, $vision, $goals,$email, $contact];
    $types = "ssssss";

    if ($bannerImage) {
        $query .= ", banner_image = ?";
        $params[] = $fileName;
        $types .= "s";
    }

    $query .= " WHERE details_id = 1"; // Assuming there's only one row, with ID 1

    $stmt = mysqli_prepare($con, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['success' => true, 'message' => 'Content updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating content: ' . mysqli_error($con)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

mysqli_close($con);
?>