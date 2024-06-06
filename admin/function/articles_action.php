<?php
include('../../function/db.php');

// Function to handle new article submission
function handleNewArticleSubmission($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extracting form data
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $subtitle = isset($_POST['subtitle']) ? mysqli_real_escape_string($con, $_POST['subtitle']) : '';
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $publishedBy = 'username';
        $isDraft = isset($_POST['draft']) ? 1 : 0; // Updated to store 1 or 0 based on the checkbox
        $type = isset($_POST['type']) ? mysqli_real_escape_string($con, $_POST['type']) : ''; // Escape the 'type' as well

        // Handling file upload
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Define your image upload path, e.g., 'uploads/'
            $uploadDir = '../images/article/';
            $imageName = basename($_FILES['image']['name']);
            $imagePath = $uploadDir . $imageName;
            // Move the file to the upload directory
            move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
        }

        // SQL query to insert article data
        $query = "INSERT INTO articles (title, subtitle, content, published_at, author, is_draft, type, image_path) 
        VALUES ('$title', '$subtitle', '$content', NOW(), '$publishedBy', '$isDraft', '$type', '$imageName')";
        
        // Execute the query
        if (!mysqli_query($con, $query)) {
            echo "ERROR: Could not execute query: $query. " . mysqli_error($con);
            exit;
        } else {
            echo 'success';
        }
    }
}

handleNewArticleSubmission($con);
?>
