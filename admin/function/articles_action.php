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
        $isDraft = isset($_POST['draft']); 
        $type = isset($_POST['type']); 

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
      
        $query = "INSERT INTO articles (title,type, subtitle, image_path, content, published_at, published_by, is_draft) VALUES ('$title','$type', '$subtitle', '$imageName', '$content', NOW(), '$publishedBy', '$isDraft')";

        echo 'success';

        // Execute the query
        if (!mysqli_query($con, $query)) {
            echo "ERROR: Could not execute query: $query. " . mysqli_error($con);
            exit;
        }
    }
}

// Assuming you have a database connection instance in $con
handleNewArticleSubmission($con);
?>
