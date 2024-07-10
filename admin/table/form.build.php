<?php
include('../../function/db.php'); // Adjust this path to your database connection file

$form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
$isQuiz = isset($_POST['is_quiz']) ? filter_var($_POST['is_quiz'], FILTER_VALIDATE_BOOLEAN) : false;

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
        $correctAnswer = htmlspecialchars($row['correct_answer']);

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
                <span class="delete-question">&times;</span>
            </div>
            <div class="form-check required-checkbox">
                <input type="checkbox" name="questions[required][' . $questionIndex . ']" class="form-check-input" value="1" ' . ($isRequired ? 'checked' : '') . '>
                <label class="form-check-label">Required</label>
            </div>
            <div class="question-body">
                <div class="answers-container">';

        if ($questionType != 'paragraph') {
            $optionList = explode(',', $options);
            foreach ($optionList as $optionIndex => $option) {
                $output .= '
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="' . ($questionType == 'multiple_choice_single' ? 'radio' : 'checkbox') . '" name="questions[option][' . $questionIndex . '][]" value="' . $optionIndex . '">
                        </div>
                    </div>
                    <input type="text" name="questions[option_text][' . $questionIndex . '][]" class="form-control" value="' . htmlspecialchars($option) . '" placeholder="Option">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary add-option" type="button">+</button>
                        <button class="btn btn-outline-danger delete-option" type="button">-</button>
                    </div>
                </div>';
            }
        }

        $output .= '
                </div>';
        
        if ($isQuiz) {
            $output .= '
                <div class="form-group correct-answer-field">
                    <label>Correct Answer:</label>
                    ' . getCorrectAnswerInput($questionType, $questionIndex, $correctAnswer) . '
                </div>';
        }

        $output .= '
            </div>
        </div>';
        $questionIndex++;
    }

    $output .= '</div>'; // Close the form-builder container

    echo $output;
}

function getCorrectAnswerInput($type, $questionIndex, $correctAnswer) {
    switch($type) {
        case 'paragraph':
            return '<input type="text" name="questions[correct_answer][' . $questionIndex . ']" class="form-control" value="' . $correctAnswer . '">';
        case 'multiple_choice_single':
            return '<select name="questions[correct_answer][' . $questionIndex . ']" class="form-control">' .
                getOptionsForSelect($questionIndex, $correctAnswer) .
                '</select>';
        case 'multiple_choice_multiple':
            return getCheckboxesForMultipleAnswers($questionIndex, $correctAnswer);
    }
}

function getOptionsForSelect($questionIndex, $correctAnswer) {
    global $con, $form_id;
    $options = '';
    $query = "SELECT options FROM asmt_questions WHERE form_id = ? AND question_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $form_id, $questionIndex);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $optionList = explode(',', $row['options']);
        foreach ($optionList as $index => $option) {
            $selected = ($correctAnswer == $index) ? 'selected' : '';
            $options .= '<option value="' . $index . '" ' . $selected . '>' . htmlspecialchars($option) . '</option>';
        }
    }
    return $options;
}

function getCheckboxesForMultipleAnswers($questionIndex, $correctAnswers) {
    global $con, $form_id;
    $checkboxes = '';
    $query = "SELECT options FROM asmt_questions WHERE form_id = ? AND question_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $form_id, $questionIndex);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $optionList = explode(',', $row['options']);
        $correctAnswerList = explode(',', $correctAnswers);
        foreach ($optionList as $index => $option) {
            $checked = in_array($index, $correctAnswerList) ? 'checked' : '';
            $checkboxes .= '
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="questions[correct_answer][' . $questionIndex . '][]" value="' . $index . '" ' . $checked . '>
                    <label class="form-check-label">' . htmlspecialchars($option) . '</label>
                </div>';
        }
    }
    return $checkboxes;
}
?>

<script>
$(document).ready(function() {
   

    const QuestionCardManager = {
        addQuestionCard: function() {
            const newQuestionCard = this.createQuestionCard();
            $('#question_list_container').append(newQuestionCard);

            const questionCard = $('#question_list_container .question-card').last();
            const questionTypeSelect = questionCard.find('.question-type');
            questionTypeSelect.val('multiple_choice_single').change();

            // Add this line to ensure correct answer field is added for new questions in quiz mode
            if ($('#isQuiz').is(':checked')) {
                this.updateCorrectAnswerField(questionCard, 'multiple_choice_single');
            }
        },

        createQuestionCard: function() {
            const questionIndex = $('#question_list_container .question-card').length;
            return `
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
                            ${this.getOptionInput('multiple_choice_single', questionIndex)}
                        </div>
                        ${$('#isQuiz').is(':checked') ? this.getCorrectAnswerField('multiple_choice_single', questionIndex) : ''}
                    </div>
                </div>`;
        },


        getOptionInput: function(type, questionIndex) {
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
        },

        updateAnswerFields: function(questionCard, type) {
            const container = questionCard.find('.answers-container');
            container.empty();
            if (type !== 'paragraph') {
                container.append(this.getOptionInput(type, questionCard.data('question-index')));
            } else {
                container.append('<textarea class="form-control" rows="3" placeholder="Your answer"></textarea>');
            }
            
            if ($('#isQuiz').is(':checked')) {
                this.updateCorrectAnswerField(questionCard, type);
            }
        },

        updateCorrectAnswerField: function(questionCard, type) {
            let correctAnswerField = questionCard.find('.correct-answer-field');
            if (correctAnswerField.length === 0) {
                correctAnswerField = $('<div class="form-group correct-answer-field"><label>Correct Answer:</label></div>');
                questionCard.find('.question-body').append(correctAnswerField);
            }
            correctAnswerField.find('select, input[type="text"], .form-check').remove();
            correctAnswerField.append(this.getCorrectAnswerInput(type, questionCard.data('question-index')));
        },

        getCorrectAnswerInput: function(type, questionIndex) {
            switch(type) {
                case 'paragraph':
                    return `<input type="text" name="questions[correct_answer][${questionIndex}]" class="form-control">`;
                case 'multiple_choice_single':
                    return `<select name="questions[correct_answer][${questionIndex}]" class="form-control">
                        ${this.getOptionsForSelect(questionIndex)}
                    </select>`;
                case 'multiple_choice_multiple':
                    return this.getCheckboxesForMultipleAnswers(questionIndex);
            }
        },

        getOptionsForSelect: function(questionIndex) {
            let options = '';
            $(`[name="questions[option_text][${questionIndex}][]"]`).each(function(index) {
                options += `<option value="${index}">${$(this).val()}</option>`;
            });
            return options;
        },

        getCheckboxesForMultipleAnswers: function(questionIndex) {
            let checkboxes = '';
            $(`[name="questions[option_text][${questionIndex}][]"]`).each(function(index) {
                checkboxes += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="questions[correct_answer][${questionIndex}][]" value="${index}">
                        <label class="form-check-label">${$(this).val()}</label>
                    </div>`;
            });
            return checkboxes;
        }
    };

    // Event Listeners
    $("#add-item").click(function() {
        QuestionCardManager.addQuestionCard();
    });

    $('#question_list_container').on('click', '.delete-question', function() {
        $(this).closest('.question-card').remove();
    });

    $('#question_list_container').on('click', '.add-option', function() {
        const questionCard = $(this).closest('.question-card');
        const questionType = questionCard.find('.question-type').val();
        const questionIndex = questionCard.data('question-index');
        const newOption = QuestionCardManager.getOptionInput(questionType, questionIndex);
        $(this).closest('.input-group').after(newOption);
        
        if ($('#isQuiz').is(':checked')) {
            QuestionCardManager.updateCorrectAnswerField(questionCard, questionType);
        }
    });

    $('#question_list_container').on('click', '.delete-option', function() {
        const questionCard = $(this).closest('.question-card');
        $(this).closest('.input-group').remove();
        
        if ($('#isQuiz').is(':checked')) {
            const questionType = questionCard.find('.question-type').val();
            QuestionCardManager.updateCorrectAnswerField(questionCard, questionType);
        }
    });

    $('#question_list_container').on('input', '[name^="questions[option_text]"]', function() {
        const questionCard = $(this).closest('.question-card');
        if ($('#isQuiz').is(':checked')) {
            const questionType = questionCard.find('.question-type').val();
            QuestionCardManager.updateCorrectAnswerField(questionCard, questionType);
        }
    });

    $('#question_list_container').on('change', '.question-type', function() {
        QuestionCardManager.updateAnswerFields($(this).closest('.question-card'), $(this).val());
    });

    $('#isQuiz').change(function() {
        if(this.checked) {
            $('.question-card').each(function() {
                const type = $(this).find('.question-type').val();
                QuestionCardManager.updateCorrectAnswerField($(this), type);
            });
        } else {
            $('.correct-answer-field').remove();
        }
    });

    $('#saveFormButton').click(function(e) {
        e.preventDefault();
        var modal = new bootstrap.Modal(document.getElementById('saveModal'));
        modal.show();
    });

    $('#updateFormButton').click(function(e) {
        e.preventDefault();
        FormManager.saveForm(true);
    });

    $('#saveAsNewFormButton').click(function(e) {
        e.preventDefault();
        FormManager.saveForm(false);
    });

    // Initialize
    function initializeForm(isQuiz) {
        if(isQuiz) {
            $('#isQuiz').prop('checked', true).change();
        }
        $('.question-card').each(function() {
            const $card = $(this);
            const $typeSelect = $card.find('.question-type');
            if (isQuiz) {
                QuestionCardManager.updateCorrectAnswerField($card, $typeSelect.val());
            }
        });
    }

    // Call initializeForm with the isQuiz parameter passed from PHP
    initializeForm(<?php echo json_encode($isQuiz); ?>);
});
</script>