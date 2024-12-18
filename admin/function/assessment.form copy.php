<?php
include('../../function/db.php');

// Check connection
if (!$con) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . mysqli_error($con)]));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $quota = mysqli_real_escape_string($con, $_POST['quota']);
    $response_limit = mysqli_real_escape_string($con, $_POST['response_limit']);
    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    $is_update = isset($_POST['is_update']) ? intval($_POST['is_update']) : 0;
    $form_type = mysqli_real_escape_string($con, $_POST['form_type']);
    $request_id = mysqli_real_escape_string($con, $_POST['request_id']);

    // Validate title and description
    if (empty($title) || empty($description)) {
        echo json_encode(['status' => 'error', 'message' => 'Title and description are required.']);
        mysqli_close($con);
        exit;
    }

    if ($is_update && $form_id > 0) {
        // Update form
        $formQuery = "UPDATE asmt_forms SET request_id='$request_id', form_type='$form_type', title='$title', 
        description='$description', start_date='$start_date', end_date='$end_date', quota='$quota', response_limit='$response_limit' WHERE form_id=$form_id";
        $formResult = mysqli_query($con, $formQuery);

        if ($formResult) {
            $errors = [];

            // Fetch existing questions to determine which ones to update and which to delete
            $existingQuestionsQuery = "SELECT * FROM asmt_questions WHERE form_id=$form_id";
            $existingQuestionsResult = mysqli_query($con, $existingQuestionsQuery);
            $existingQuestions = [];
            while ($row = mysqli_fetch_assoc($existingQuestionsResult)) {
                $existingQuestions[] = $row;
            }

            // Update or delete questions
            foreach ($existingQuestions as $index => $existingQuestion) {
                if (isset($_POST['questions']['text'][$index])) {
                    // Update question
                    $question_text = mysqli_real_escape_string($con, $_POST['questions']['text'][$index]);
                    $question_type = mysqli_real_escape_string($con, $_POST['questions']['type'][$index]);
                    $is_required = isset($_POST['questions']['required'][$index]) ? 1 : 0;

                    $options_text = NULL;
                    if (($question_type === 'multiple_choice_single' || $question_type === 'multiple_choice_multiple') 
                        && isset($_POST['questions']['option_text'][$index]) && is_array($_POST['questions']['option_text'][$index])) {
                        $options = array_map(function($item) use ($con) {
                            return mysqli_real_escape_string($con, trim($item));
                        }, $_POST['questions']['option_text'][$index]);

                        $options_text = implode(',', $options);
                        // Check if options string exceeds 255 characters
                        if (strlen($options_text) > 255) {
                            $errors[] = "Options string too long for question at index $index";
                            continue; // Skip this question and continue with the next
                        }
                    }

                    $question_id = $existingQuestion['question_id'];
                    $updateQuestionQuery = "UPDATE asmt_questions SET question_text='$question_text', question_type='$question_type', options='$options_text', is_required='$is_required' WHERE question_id=$question_id";
                    $updateQuestionResult = mysqli_query($con, $updateQuestionQuery);

                    if (!$updateQuestionResult) {
                        $errors[] = "Error updating question at index $index: " . mysqli_error($con);
                    }
                } else {
                    // Delete question
                    $question_id = $existingQuestion['question_id'];
                    $deleteQuestionQuery = "DELETE FROM asmt_questions WHERE question_id=$question_id";
                    $deleteQuestionResult = mysqli_query($con, $deleteQuestionQuery);

                    if (!$deleteQuestionResult) {
                        $errors[] = "Error deleting question at index $index: " . mysqli_error($con);
                    }
                }
            }

            // Insert new questions that were added
            for ($index = count($existingQuestions); $index < count($_POST['questions']['text']); $index++) {
                $question_text = mysqli_real_escape_string($con, $_POST['questions']['text'][$index]);
                $question_type = mysqli_real_escape_string($con, $_POST['questions']['type'][$index]);
                $is_required = isset($_POST['questions']['required'][$index]) ? 1 : 0;

                $options_text = NULL;
                if (($question_type === 'multiple_choice_single' || $question_type === 'multiple_choice_multiple') 
                    && isset($_POST['questions']['option_text'][$index]) && is_array($_POST['questions']['option_text'][$index])) {
                    $options = array_map(function($item) use ($con) {
                        return mysqli_real_escape_string($con, trim($item));
                    }, $_POST['questions']['option_text'][$index]);

                    $options_text = implode(',', $options);
                    // Check if options string exceeds 255 characters
                    if (strlen($options_text) > 255) {
                        $errors[] = "Options string too long for question at index $index";
                        continue; // Skip this question and continue with the next
                    }
                }

                $questionQuery = "INSERT INTO asmt_questions (form_id, question_text, question_type, options, is_required) 
                                  VALUES ('$form_id', '$question_text', '$question_type', '$options_text', '$is_required')";
                $questionResult = mysqli_query($con, $questionQuery);

                if (!$questionResult) {
                    $errors[] = "Error saving new question at index $index: " . mysqli_error($con);
                }
            }

            if (empty($errors)) {
                echo json_encode(['status' => 'success', 'message' => 'Form updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Some questions could not be updated.', 'errors' => $errors]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error updating form: ' . mysqli_error($con)]);
        }
    } else {
        // Insert new form
        $formQuery = "INSERT INTO asmt_forms (title, description, form_type, request_id, start_date, end_date, quota, response_limit) 
                      VALUES ('$title', '$description', '$form_type', '$request_id', '$start_date', '$end_date', '$quota', '$response_limit')";
        $formResult = mysqli_query($con, $formQuery);

        if ($formResult) {
            $form_id = mysqli_insert_id($con);
            $errors = [];

            // Insert each question into asmt_questions table
            foreach ($_POST['questions']['text'] as $index => $text) {
                $question_text = mysqli_real_escape_string($con, $text);
                $question_type = mysqli_real_escape_string($con, $_POST['questions']['type'][$index]);
                $is_required = isset($_POST['questions']['required'][$index]) ? 1 : 0;

                $options_text = NULL;
                if (($question_type === 'multiple_choice_single' || $question_type === 'multiple_choice_multiple') 
                    && isset($_POST['questions']['option_text'][$index]) && is_array($_POST['questions']['option_text'][$index])) {
                    $options = array_map(function($item) use ($con) {
                        return mysqli_real_escape_string($con, trim($item));
                    }, $_POST['questions']['option_text'][$index]);

                    $options_text = implode(',', $options);
                    // Check if options string exceeds 255 characters
                    if (strlen($options_text) > 255) {
                        $errors[] = "Options string too long for question at index $index";
                        continue; // Skip this question and continue with the next
                    }
                }

                $questionQuery = "INSERT INTO asmt_questions (form_id, question_text, question_type, options, is_required) 
                                  VALUES ('$form_id', '$question_text', '$question_type', '$options_text', '$is_required')";
                $questionResult = mysqli_query($con, $questionQuery);

                if (!$questionResult) {
                    $errors[] = "Error saving question at index $index: " . mysqli_error($con);
                }
            }

            if (empty($errors)) {
                echo json_encode(['status' => 'success', 'message' => 'Form saved successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Some questions could not be saved.', 'errors' => $errors]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error saving form: ' . mysqli_error($con)]);
        }
    }
}

// Close the connection
mysqli_close($con);
?>
