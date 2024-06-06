<?php 

include('../../function/db.php');

// 1. Input Sanitization & Retrieval
if (isset($_POST['updateArticle'])) {
    $articleId = mysqli_real_escape_string($con, $_POST['article_id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $subtitle = isset($_POST['subtitle']) ? mysqli_real_escape_string($con, $_POST['subtitle']) : '';
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $author = mysqli_real_escape_string($con, $_POST['author']); // Assuming author is sent from the form
    $isDraft = isset($_POST['draft']) ? 1 : 0;
    $type = isset($_POST['type']) ? mysqli_real_escape_string($con, $_POST['type']) : '';
    $imagePath = '';

    // 2. Image Upload Handling (if applicable)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../images/article/';
        $imageName = basename($_FILES['image']['name']);
        $imagePath = $uploadDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    $updateFields = [];

    // Always update these fields
    $updateFields[] = "title='$title'";
    $updateFields[] = "subtitle='$subtitle'";
    $updateFields[] = "content='$content'";
    $updateFields[] = "author='$author'";
    $updateFields[] = "is_draft='$isDraft'";
    $updateFields[] = "type='$type'";

    // Only update image path if a new image was uploaded
    if (!empty($imagePath)) {
        $updateFields[] = "image_path='$imageName'";
    }

    $updateQuery = "UPDATE articles SET " . implode(', ', $updateFields) . " WHERE article_id = $articleId";

    // 4. Query Execution and Result Handling
    if (mysqli_query($con, $updateQuery)) {
        header("Location: ../articles.php"); // Change redirect location if needed
    } else {
        echo "ERROR: Could not update article. " . mysqli_error($con); 
    }
}

// Delete article function
if (isset($_POST['deleteArticle'])) {
    $articleId = mysqli_real_escape_string($con, $_POST['article_id']);

    // 1. Retrieve the current image path to delete the image file
    $query = "SELECT image_path FROM articles WHERE article_id = $articleId";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = '../images/article/' . $row['image_path'];

        // 2. Delete the article record from the database
        $deleteQuery = "DELETE FROM articles WHERE article_id = $articleId";
        if (mysqli_query($con, $deleteQuery)) {
            // 3. Delete the image file from the server
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            header("Location: ../articles.php"); // Change redirect location if needed
        } else {
            echo "ERROR: Could not delete article. " . mysqli_error($con);
        }
    } else {
        echo "ERROR: Could not find article. " . mysqli_error($con);
    }
}

?>