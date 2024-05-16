<?php
include('db.php');

// Check if the form's submit button is clicked
if (isset($_POST['confirm'])) {
    $request_id = $_POST['req_id'];  // Assuming you're correctly passing the request ID
    $user_id = $_SESSION["userId_code"]; // Retrieve the user ID from the session

    // Handle file uploads
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $key => $filename) {
            $filename = $_FILES['files']['name'][$key];
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            // Define the directory where the files will be uploaded
            $uploadDirectory = '../files/uploads/'; // Make sure this directory exists and is writable
            $uploadPath = $uploadDirectory . basename($filename);

            // Check for errors
            if ($fileError === 0) {
                // Move the file from the temporary location to the upload directory
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    // Prepare SQL statement to insert file info into the database
                    $date_uploaded = date('Y-m-d'); // Get the current date

                    $query = "INSERT INTO sr_dataanalysis_files (request_id, filename, size, remarks, date_uploaded) VALUES (?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $query);
                    $remarks = 'Uploaded'; // Customize this field based on your needs
                    
                    // Bind parameters and execute the statement
                    mysqli_stmt_bind_param($stmt, 'issis', $request_id, $filename, $fileSize, $remarks, $date_uploaded);
                    $result = mysqli_stmt_execute($stmt);

                    if (!$result) {
                        echo "Error inserting file data: " . mysqli_error($con);
                    } else {
                        echo "File successfully uploaded and recorded.";

                        // Log the activity
                        $activity_type = 'file_upload';
                        $activity_description = "User uploaded file: $filename for request ID $request_id";
                        log_activity($con, $user_id, $activity_type, $activity_description);
                    }
                } else {
                    echo "Error uploading file: $filename";
                }
            } else {
                echo "Error uploading file: $filename with error code $fileError";
            }
        }
    } else {
        echo "No files provided.";
    }

    // Redirect or handle the response appropriately
    header("Location: ../profile.php");  // Adjust as necessary
    exit();
}

?>