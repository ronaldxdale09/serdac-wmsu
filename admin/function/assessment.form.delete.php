<?php
include('../../function/db.php');

if (isset($_POST['form_id'])) {
    $form_id = intval($_POST['form_id']);

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Delete associated records first (adjust table names as needed)
        mysqli_query($con, "DELETE FROM asmt_responses WHERE form_id = $form_id");
        mysqli_query($con, "DELETE FROM asmt_questions WHERE form_id = $form_id");
        
        // Then delete the form itself
        $result = mysqli_query($con, "DELETE FROM asmt_forms WHERE form_id = $form_id");

        if ($result) {
            mysqli_commit($con);
            echo json_encode(['success' => true]);
        } else {
            throw new Exception("Error deleting form");
        }
    } catch (Exception $e) {
        mysqli_rollback($con);
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No form ID provided']);
}
?>