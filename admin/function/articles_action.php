<?php
include('../../function/db.php');

// Function to handle new article submission
function handleNewArticleSubmission($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Extracting form data
        $title = mysqli_real_escape_string($con, $_POST['title']);
        $subtitle = mysqli_real_escape_string($con, $_POST['subtitle']);
        $content = mysqli_real_escape_string($con, $_POST['content']);
        $author = mysqli_real_escape_string($con, $_POST['author']);
        $type = mysqli_real_escape_string($con, $_POST['type']);
        $isDraft = isset($_POST['isDraft']) && $_POST['isDraft'] === '1' ? 1 : 0;
        
        // Get the custom publication date or use current date if not provided
        $published_date = isset($_POST['published_date']) && !empty($_POST['published_date']) 
            ? mysqli_real_escape_string($con, $_POST['published_date']) 
            : date('Y-m-d');
        
        // Add time to the date to make it a datetime
        $published_datetime = $published_date . ' ' . date('H:i:s');

        // Handle image upload
        $imageName = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../images/article/';
            $imageName = time() . '_' . basename($_FILES['image']['name']); // Add timestamp to prevent duplicates
            $targetPath = $uploadDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                echo "Failed to upload image";
                return;
            }
        }

        // Prepare and execute query using prepared statements
        $query = "INSERT INTO articles (title, subtitle, content, published_at, author, is_draft, type, image_path) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($con, $query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssiss", 
                $title, 
                $subtitle, 
                $content, 
                $published_datetime,  // Use the custom datetime
                $author, 
                $isDraft, 
                $type, 
                $imageName
            );

            if (mysqli_stmt_execute($stmt)) {
                echo 'success';
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($con);
        }
    }
}
handleNewArticleSubmission($con);
?>
