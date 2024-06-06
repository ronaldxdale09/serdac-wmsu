<?php 

include('../../function/db.php');

if (isset($_POST['new_ebook'])) {
    // Retrieve ebook data from POST request
    $book_title = mysqli_real_escape_string($con, $_POST['book_title']);
    $author = mysqli_real_escape_string($con, $_POST['author']);
    $year_published = mysqli_real_escape_string($con, $_POST['year_published']);
    $cover_page = $_FILES['cover_page']['name'];
    $target_dir = "../images/ebook_cover/"; // Directory where the cover page will be uploaded
    $target_file = $target_dir . basename($cover_page);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file is an actual image or fake image
    $check = getimagesize($_FILES['cover_page']['tmp_name']);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['cover_page']['size'] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES['cover_page']['tmp_name'], $target_file)) {
            // Insert query for the ebooks table
            $query = "INSERT INTO repo_ebooks (book_title, author, year_published, cover_page) 
                      VALUES ('$book_title', '$author', '$year_published', '$cover_page')";

            // Execute the query
            if (mysqli_query($con, $query)) {
                header("Location: ../ebook_mngnt.php"); // Change redirect location if needed
                exit();
            } else {
                echo "ERROR: Could not execute the query. " . mysqli_error($con);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    exit();
}


?>