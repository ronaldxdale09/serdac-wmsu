<?php
include('../../function/db.php');

// Check if the form's submit button is clicked
if (isset($_POST['confirm'])) {
    $request_id = $_POST['req_id']; // Assuming you're correctly passing the request ID

    // Handle file uploads
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $key => $filename) {
            $filename = $_FILES['files']['name'][$key];
            $fileTmpName = $_FILES['files']['tmp_name'][$key];
            $fileSize = $_FILES['files']['size'][$key];
            $fileError = $_FILES['files']['error'][$key];
            $remarks = $_POST['remarks'][$key + 1] ?? 'No remark provided'; // Adjusted to align with your remarks array
            $type = 'Result';
            $uploadDirectory = '../../files/uploads/'; // Ensure this directory exists and is writable
            $uploadPath = $uploadDirectory . basename($filename);

            // Echo file name and remarks for debugging
            echo "Processing file: $filename with remarks: $remarks<br>";

            // Check for errors
            if ($fileError === 0) {
                if (move_uploaded_file($fileTmpName, $uploadPath)) {
                    $date_uploaded = date('Y-m-d'); // Get the current date
                    $query = "INSERT INTO sr_dataanalysis_files (request_id, filename, size, remarks, date_uploaded, type) 
                              VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($con, $query);
                    mysqli_stmt_bind_param($stmt, 'isssss', $request_id, $filename, $fileSize, $remarks, $date_uploaded, $type);
                    $result = mysqli_stmt_execute($stmt);

                    if (!$result) {
                        echo "Error inserting file data: " . mysqli_error($con) . "<br>";
                    } else {
                        echo "File successfully uploaded and recorded.<br>";
                    }
                } else {
                    echo "Error uploading file: $filename<br>";
                }
            } else {
                echo "Error uploading file: $filename with error code $fileError<br>";
            }
        }
    } else {
        echo "No files provided.<br>";
    }

    // Redirect or handle the response appropriately
    // header("Location: ../request_record.php?tab=3");  // Adjust as necessary
    exit();
}
?>
