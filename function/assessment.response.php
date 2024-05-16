<?php
include('db.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_id = 99; // Replace this with the actual form_id you are using
    $user_id = 1; // Replace this with the actual user_id from your session or context

    $answers = $_POST['answers'];
    $errors = [];

    foreach ($answers as $question_id => $response) {
        if (is_array($response)) {
            $response_text = implode(',', array_map(function($item) use ($con) {
                return mysqli_real_escape_string($con, trim($item));
            }, $response));
        } else {
            $response_text = mysqli_real_escape_string($con, trim($response));
        }

        $responseQuery = "INSERT INTO asmt_responses (form_id, question_id, user_id, response_text) 
                          VALUES ('$form_id', '$question_id', '$user_id', '$response_text')";
        $responseResult = mysqli_query($con, $responseQuery);

        if (!$responseResult) {
            $errors[] = "Error saving response for question ID $question_id: " . mysqli_error($con);
        }
    }

    if (empty($errors)) {
        echo json_encode(['status' => 'success', 'message' => 'Your answers have been submitted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Some responses could not be saved.', 'errors' => $errors]);
    }
}

// Close the connection
mysqli_close($con);
?>
