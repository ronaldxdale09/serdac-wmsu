<?php
include('../../function/db.php'); // Adjust this path to your database connection file

$form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
if ($form_id > 0) {
    $query = "SELECT * FROM asmt_questions WHERE form_id = $form_id";
    $result = mysqli_query($con, $query);

    if (!$result) {
        die('Query Failed: ' . mysqli_error($con));
    }

    $output = '<div class="form-builder-container" id="question_list_container">';

    $questionIndex = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $questionText = htmlspecialchars($row['question_text']);
        $questionType = $row['question_type'];
        $isRequired = $row['is_required'];
        $options = htmlspecialchars($row['options']);

        $output .= '
        <div class="question-card" data-question-index="' . $questionIndex . '">
            <div class="question-header">
                <input type="text" name="questions[text][' . $questionIndex . ']"
                       class="form-control" value="' . $questionText . '"
                       placeholder="Write your question here">
                <select name="questions[type][' . $questionIndex . ']" class="form-control question-type">';

        foreach (['paragraph', 'multiple_choice_single', 'multiple_choice_multiple'] as $type) {
            $selected = $questionType == $type ? 'selected' : '';
            $output .= '<option value="' . $type . '" ' . $selected . '>' . ucfirst(str_replace('_', ' ', $type)) . '</option>';
        }

        $output .= '
                </select>
                <span class="delete-question" onclick="deleteQuestionCard(this)">&times;</span>
            </div>
            <div class="form-check required-checkbox">
                <input type="checkbox" name="questions[required][' . $questionIndex . ']" class="form-check-input" value="1" ' . ($isRequired ? 'checked' : '') . '>
                <label class="form-check-label">Required</label>
            </div>
            <div class="question-body">
                <div class="answers-container">';

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
                    <input type="text" name="questions[option_text][' . $questionIndex . '][]" class="form-control" value="' . $option . '" placeholder="Option">
                    <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-option" type="button">+</button>
                    <button class="btn btn-outline-danger delete-option" type="button">-</button>
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
}
?>
<script>
$(document).ready(function() {
    // Event listener for the "Add Item" button
    $("#add-item").click(function() {
        addQuestionCard();
    });

    function addQuestionCard() {
        var newQuestionCard = createQuestionCard();
        $('#question_list_container').append(newQuestionCard);

        // Set default question type to "Multiple choice (single answer)" and update fields
        var questionCard = $('#question_list_container .question-card').last();
        var questionTypeSelect = questionCard.find('.question-type');
        questionTypeSelect.val('multiple_choice_single').change();
    }

    function createQuestionCard() {
        var questionIndex = $('#question_list_container .question-card').length;
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
                    ${getOptionInput('multiple_choice_single', questionIndex)}
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
        } else {
            container.append('<textarea class="form-control" rows="3" placeholder="Your answer"></textarea>');
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
                <input type="text" name="questions[option_text][${questionIndex}][]" class="form-control" placeholder="Option">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary add-option" type="button">+</button>
                    <button class="btn btn-outline-danger delete-option" type="button">-</button>
                </div>
            </div>`;
    }

    // Event listener for dynamically created "Delete Question" buttons
    $('#question_list_container').on('click', '.delete-question', function() {
        $(this).closest('.question-card').remove();
    });

    // Event listener for dynamically created "Add Option" buttons
    $('#question_list_container').on('click', '.add-option', function() {
        var questionType = $(this).closest('.question-card').find('.question-type').val();
        var questionIndex = $(this).closest('.question-card').attr('data-question-index');
        var newOption = getOptionInput(questionType, questionIndex);
        $(this).closest('.answers-container').append(newOption);
    });

    // Event listener for dynamically created "Delete Option" buttons
    $('#question_list_container').on('click', '.delete-option', function() {
        $(this).closest('.input-group').remove();
    });

    // Event listener for question type change
    $('#question_list_container').on('change', '.question-type', function() {
        updateAnswerFields($(this).closest('.question-card'), $(this).val());
    });

    var formId = <?php echo isset($form_id) ? $form_id : 'null'; ?>;

    $(document).on('click', '#saveFormButton', function(e) {
        e.preventDefault();
        var modal = new bootstrap.Modal(document.getElementById('saveModal'));
        modal.show();
    });

    $(document).on('click', '#updateFormButton', function(e) {
        e.preventDefault();
        $('#is_update').val(1);
        saveForm();
    });

    $(document).on('click', '#saveAsNewFormButton', function(e) {
        e.preventDefault();
        $('#is_update').val(0);
        saveForm();
    });

    function saveForm() {
        var formData = $('#myForm').serialize(); // Serialize form data
        $.ajax({
            url: 'function/assessment.form.php', // Replace with the path to your PHP script
            type: 'POST',
            data: formData,
            dataType: 'json', // Expect JSON response
            success: function(response) {
                var modal = new bootstrap.Modal(document.getElementById('saveModal'));
                modal.hide();
                if (response.status === 'success') {
                    Swal.fire('Saved!', response.message, 'success').then(() => {
                        // Optional: reload the page or redirect after saving
                        window.location.href = 'assessment.php';
                    });
                } else {
                    Swal.fire('Error!', response.message, 'error');
                    if (response.errors) {
                        console.error('Detailed Errors:', response.errors);
                    }
                }
            },
            error: function() {
                Swal.fire('Error!', 'Your form could not be saved. Please try again.', 'error');
            }
        });
    }

});
</script>