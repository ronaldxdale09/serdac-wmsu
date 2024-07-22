<?php 
include('../../function/db.php');


// Handle AJAX requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $table = $_POST['table'];
    $column = ($table == 'r_education_levels') ? 'education_level' : (($table == 'r_genders') ? 'gender' : 'occupation');
    
    switch ($action) {
        case 'update':
            $id = $_POST['id'];
            $value = $_POST['value'];
            $stmt = $con->prepare("UPDATE $table SET $column = ? WHERE id = ?");
            $stmt->bind_param("si", $value, $id);
            break;
        case 'add':
            $value = $_POST['value'];
            $stmt = $con->prepare("INSERT INTO $table ($column) VALUES (?)");
            $stmt->bind_param("s", $value);
            break;
        case 'delete':
            $id = $_POST['id'];
            $stmt = $con->prepare("DELETE FROM $table WHERE id = ?");
            $stmt->bind_param("i", $id);
            break;
    }
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $con->error]);
    }
    exit;
}

?>