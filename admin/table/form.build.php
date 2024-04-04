<?php
include('../../function/db.php'); // Adjust this path to your database connection file

// Modify the query to fetch questions for a specific form. 
// For example, fetch questions for form_id 1. Adjust this as needed.
$form_id = 1; // This should be dynamically set based on your application logic
$query = "SELECT * FROM asmt_questions WHERE form_id = 38";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$output = '<div class="form-builder-container">';

// Output each question from the database
$questionIndex = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $questionText = htmlspecialchars($row['question_text']);
    $questionType = $row['question_type'];
    $isRequired = $row['is_required'];
    $options = htmlspecialchars($row['options']); // Assuming options are stored as a comma-separated string

    $output .= '
    <div class="question-card" data-question-index="' . $questionIndex . '">
        <div class="question-header">
            <input type="text" name="questions[text][]"
                   class="form-control" value="' . $questionText . '"
                   placeholder="Write your question here">
            <select name="questions[type][]" class="form-control question-type">';

    // Populate the question type dropdown
    foreach (['paragraph', 'multiple_choice_single', 'multiple_choice_multiple'] as $type) {
        $selected = $questionType == $type ? 'selected' : '';
        $output .= '<option value="' . $type . '" ' . $selected . '>' . ucfirst(str_replace('_', ' ', $type)) . '</option>';
    }

    $output .= '
            </select>
            <span class="delete-question" onclick="deleteQuestionCard(this)">&times;</span>
        </div>
        <div class="form-check required-checkbox">
            <input type="checkbox" name="questions[required][]" class="form-check-input" value="1" ' . ($isRequired ? 'checked' : '') . '>
            <label class="form-check-label">Required</label>
        </div>
        <div class="question-body">
            <div class="answers-container">';
    
    // Generate options if the question type is multiple choice
    if ($questionType != 'paragraph') {
        $optionList = explode(',', $options);
        foreach ($optionList as $option) {
            $output .= '
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="' . ($questionType == 'multiple_choice_single' ? 'radio' : 'checkbox') . '">
                    </div>
                </div>
                <input type="text" name="questions[options][' . $questionIndex . '][]" class="form-control" value="' . $option . '" placeholder="Option">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="addOption(this, \'' . $questionType . '\')">+</button>
                    <button class="btn btn-outline-danger" type="button" onclick="removeOption(this)">-</button>
                </div>
            </div>';
        }
    }

    $output .= '
            </div>
        </div>
    </div>';
    $questionIndex++;
}

$output .= '</div>'; // Close the form-builder container

echo $output;
?>


<script>
$(document).ready(function () {
    // Event listener for the "Add Question" button
    $("#add-item").click(function() {
        addQuestionCard();
    });

    function addQuestionCard() {
        var newQuestionCard = createQuestionCard();
        $('.form-builder-container').append(newQuestionCard);
    }




    // Event listener for dynamically created "Delete Question" and "Delete Option" buttons
    $('.form-builder-container').on('click', '.delete-question, .delete-option', function() {
        $(this).closest('.question-card, .input-group').remove();
    });

    // Event listener for dynamically created "Add Option" buttons
    $('.form-builder-container').on('click', '.add-option', function() {
        var questionType = $(this).closest('.question-card').find('.question-type').val();
        var questionIndex = $(this).closest('.question-card').attr('data-question-index');
        var newOption = getOptionInput(questionType, questionIndex);
        $(this).closest('.answers-container').append(newOption);
    });

    // Event listener for question type change
    $('.form-builder-container').on('change', '.question-type', function() {
        updateAnswerFields($(this).closest('.question-card'), $(this).val());
    });

     function createQuestionCard() {
        var questionIndex = $('.form-builder-container .question-card').length;
        var questionCard = `
        <div class="question-card" data-question-index="${questionIndex}">
            <div class="question-header">
                <input type="text" name="questions[text][${questionIndex}]"
                    class="form-control" placeholder="Write your question here">
                <select name="questions[type][${questionIndex}]" class="form-control question-type">
                    <option value="paragraph">Paragraph</option>
                    <option value="multiple_choice_single">Multiple choice (single answer)</option>
                    <option value="multiple_choice_multiple">Multiple choice (multiple answers)</option>
                </select>
                <span class="delete-question">&times;</span>
            </div>
            <div class="form-check required-checkbox">
                <input type="checkbox" name="questions[required][${questionIndex}]" class="form-check-input" value="1">
                <label class="form-check-label">Required</label>
            </div>
            <div class="question-body">
                <div class="answers-container">
                    <!-- Options will be inserted here -->
                </div>
            </div>
        </div>`;
        return questionCard;
    }

    function updateAnswerFields(questionCard, type) {
        let container = questionCard.find('.answers-container');
        container.empty();
        if (type !== 'paragraph') {
            container.append(getOptionInput(type, questionCard.data('question-index')));
        }
    }

    function getOptionInput(type, questionIndex) {
        return `
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="${type === 'multiple_choice_single' ? 'radio' : 'checkbox'}" name="questions[options][${questionIndex}][]">
                    </div>
                </div>
                <input type="text" class="form-control" placeholder="Option">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-option" type="button">+</button>
                    <button class="btn btn-outline-danger delete-option" type="button">-</button>
                </div>
            </div>`;
    }
});
</script>
