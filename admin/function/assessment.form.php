<?php

include('../../function/db.php');


// Check connection
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);

            echo '<pre>';
        print_r($_POST['questions']);
        echo '</pre>';


    $formQuery = "INSERT INTO asmt_forms (title, description) VALUES ('$title', '$description')";
    $formResult = mysqli_query($con, $formQuery);

    if ($formResult) {
        $form_id = mysqli_insert_id($con);

        foreach ($_POST['questions']['text'] as $index => $text) {
            $question_text = mysqli_real_escape_string($con, $text);
            $question_type = mysqli_real_escape_string($con, $_POST['questions']['type'][$index]);
            $is_required = isset($_POST['questions']['required'][$index]) ? 1 : 0;

            $options_text = NULL;
            if (($question_type === 'multiple_choice_single' || $question_type === 'multiple_choice_multiple') 
                && isset($_POST['questions']['options'][$index]) && is_array($_POST['questions']['options'][$index])) {
                $options = array_map(function($item) use ($con) {
                    return mysqli_real_escape_string($con, trim($item));
                }, $_POST['questions']['options'][$index]);

                $options_text = implode(',', $options);
                // Check if options string exceeds 255 characters
                if (strlen($options_text) > 255) {
                    echo "Error: Options string too long for question at index $index";
                    return;
                }
            }

            $questionQuery = "INSERT INTO asmt_questions (form_id, question_text, question_type, options, is_required) 
                              VALUES ('$form_id', '$question_text', '$question_type', '$options_text', '$is_required')";
            $questionResult = mysqli_query($con, $questionQuery);

            if (!$questionResult) {
                echo "Error saving question: " . mysqli_error($con);
                return; // Exit the script in case of error
            }
        }

        echo "success";
    } else {
        echo "Error saving form: " . mysqli_error($con);
    }
}


// Close the connection
mysqli_close($con);

?>