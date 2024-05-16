<?php 
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO contact_messages (name, email, mobile, subject, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($con->error)]);
        exit();
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("sssss", $name, $email, $mobile, $subject, $message);

    // Execute the statement
    if ($stmt->execute() === false) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . htmlspecialchars($stmt->error)]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Your message has been sent. Thank you!']);

        // Log the activity
        $activity_type = 'contact_form_submission';
        $activity_description = "Contact form submitted by $name";
        $user_id = 0; // Assuming 0 for anonymous user, adjust based on your application context
        log_activity($con, $user_id, $activity_type, $activity_description);
    }

    // Close the statement
    $stmt->close();
}
   
?>