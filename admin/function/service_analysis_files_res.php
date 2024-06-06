<?php
include('../../function/db.php');

// Check if the form's submit button is clicked
if (isset($_POST['confirm'])) {
    $request_id = $_POST['req_id']; // Assuming you're correctly passing the request ID

    // Handle file uploads
    if (!empty($_FILES['files']['name'][0])) {
        $remarksArray = $_POST['remarks_file'];

        foreach ($_FILES['files']['name'] as $key => $filename) {
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];

            $uploadDirectory = '../../files/uploads/'; 
            $uploadPath = $uploadDirectory . basename($filename);

            // Get and validate remarks (trimmed and with default value)
            $remarks = isset($remarksArray[$key]) ? trim($remarksArray[$key]) : '';
            if (empty($remarks)) {
                $remarks = 'No remarks provided';
            }

            $type = 'Result';

            // Check for file upload errors
            if ($fileError === UPLOAD_ERR_OK) {
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $date_uploaded = date('Y-m-d');

                    $query = "INSERT INTO sr_dataanalysis_files (request_id, filename, size, remarks, date_uploaded, type) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $query);

                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, 'isssss', $request_id, $filename, $fileSize, $remarks, $date_uploaded, $type);

                        if (mysqli_stmt_execute($stmt)) {
                            echo "File '$filename' successfully uploaded and recorded with remarks: '$remarks'.<br>";
                        } else {
                            echo "Error inserting file data: " . mysqli_stmt_error($stmt) . "<br>";
                        }

                        mysqli_stmt_close($stmt); // Close the statement
                    } else {
                        echo "Error preparing statement: " . mysqli_error($con) . "<br>";
                    }
                } else {
                    echo "Error moving uploaded file: $filename<br>";
                }
            } else {
                echo "Error uploading file: $filename with error code $fileError<br>";
            }
        }
    } else {
        echo "No files provided.<br>";
    }

    // Redirect after processing
    header("Location: ../request_record.php?tab=3"); 
    exit();
}
?>