<?php
include 'db.php'; // Ensure this includes your database connection

if (isset($_SESSION['userId_code'])) {
    $id = $_SESSION['userId_code'];
    $id = preg_replace('~\D~', '', $id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $fname = $_POST['fname'];
        $midname = $_POST['midname'];
        $lname = $_POST['lname'];
        $contact_no = $_POST['contact_no'];
        $region = $_POST['region'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if ($password != $confirm_password) {
            http_response_code(400);
            echo 'Passwords do not match.';
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "UPDATE users SET 
                    fname = ?, 
                    midname = ?, 
                    lname = ?, 
                    contact_no = ?, 
                    region = ?, 
                    city = ?, 
                    province = ?, 
                    password = ? 
                WHERE user_id = ?";
                
        $stmt = $con->prepare($sql);
        $stmt->bind_param('ssssssssi', 
            $fname, 
            $midname, 
            $lname, 
            $contact_no, 
            $region, 
            $city, 
            $state, 
            $hashed_password, 
            $id
        );

        if ($stmt->execute()) {
            echo 'Profile updated successfully.';
        } else {
            http_response_code(500);
            echo 'Failed to update profile.';
        }
    }
} else {
    http_response_code(403);
    echo 'You are not authorized to perform this action.';
}
?>
