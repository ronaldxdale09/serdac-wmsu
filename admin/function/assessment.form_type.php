<?php
include('../../function/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['action'] === 'read') {
    $sql = "SELECT * FROM asmt_form_type";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['formType_id']}</td>
                    <td>{$row['form_type']}</td>
                    <td>
                        <button class='btn btn-sm btn-primary edit-form-type' data-id='{$row['formType_id']}' data-form-type='{$row['form_type']}'>Edit</button>
                        <button class='btn btn-sm btn-danger delete-form-type' data-id='{$row['formType_id']}'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No form types found</td></tr>";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $formType = $_POST['formType'];

    if ($action === 'create') {
        $sql = "INSERT INTO asmt_form_type (form_type) VALUES (?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $formType);
        $stmt->execute();
        echo "Form type created successfully";
    } elseif ($action === 'update') {
        $formTypeId = $_POST['formTypeId'];
        $sql = "UPDATE asmt_form_type SET form_type = ? WHERE formType_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("si", $formType, $formTypeId);
        $stmt->execute();
        echo "Form type updated successfully";
    } elseif ($action === 'delete') {
        $formTypeId = $_POST['formTypeId'];
        $sql = "DELETE FROM asmt_form_type WHERE formType_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $formTypeId);
        $stmt->execute();
        echo "Form type deleted successfully";
    }
}

$con->close();
?>