<?php include('include/header.php');
if (isset($_GET["form_id"]) && !empty($_GET["form_id"])) {
    $form_id = $_GET['form_id'];
    // Use prepared statement to prevent SQL injection
    $formQuery = "SELECT * FROM asmt_forms WHERE form_id = ?";
    $stmt = mysqli_prepare($con, $formQuery);
    mysqli_stmt_bind_param($stmt, "i", $form_id);
    mysqli_stmt_execute($stmt);
    $formResult = mysqli_stmt_get_result($stmt);
    $formIdExists = true;

    if ($formResult && mysqli_num_rows($formResult) > 0) {
        $formRecord = mysqli_fetch_assoc($formResult);
        $isQuiz = $formRecord['is_quiz'];
        $request_id = $formRecord['request_id'];
        
        echo "
        <script>
            $(document).ready(function() {
                // Set form values
                $('input[name=title]').val(" . json_encode($formRecord['title']) . ");
                $('textarea[name=description]').val(" . json_encode($formRecord['description']) . ");
                $('select[name=form_type]').val(" . json_encode($formRecord['form_type']) . ");
                
                // Set service request with Select2
                $('select[name=request_id]').val(" . json_encode($request_id) . ").trigger('change');
                
                $('input[name=start_date]').val(" . json_encode($formRecord['start_date']) . ");
                $('input[name=end_date]').val(" . json_encode($formRecord['end_date']) . ");
                $('input[name=quota]').val(" . json_encode($formRecord['quota']) . ");
                $('input[name=response_limit]').val(" . json_encode($formRecord['response_limit']) . ");
                $('#isQuiz').prop('checked', " . ($isQuiz ? 'true' : 'false') . ");

                fetchQuestions($form_id, $isQuiz);
            });
        </script>
        ";
    }
} else {
    echo "
    <script>
        $(document).ready(function() {
            fetchQuestions(0, false);
        });
    </script>
    ";
}

// Fetch distinct service types from the service_request table
$query = "SELECT DISTINCT service_type FROM service_request";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$serviceOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $serviceOptions[] = $row['service_type'];
}

?>
<link rel="stylesheet" href="css/assmt.form.builder.css">


<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <?php include('include/navbar.php')?>

        <!-- Breadcrumbs -->
        <div class="breadcrumbs">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="assessment.php">Assessment List</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Form Builder</li>
                </ol>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="card">
                <div class="card-header">
                    <h1 class="form-title">Form Builder</h1>
                </div>

                <div class="card-body">
                    <form id="myForm" class="form-builder">
                        <!-- Settings Panel -->
                        <div class="settings-panel">
                            <div class="settings-header" data-bs-toggle="collapse"
                                data-bs-target="#formSettingsCollapse" aria-expanded="true">
                                <h5>
                                    <i class="fas fa-cog"></i>
                                    Form Settings
                                </h5>
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <div id="formSettingsCollapse" class="collapse show">
                                <div class="settings-body">
                                    <div class="row g-4">
                                        <!-- Date Settings -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="startDate">Start Date</label>
                                            <input type="date" id="startDate" name="start_date" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="endDate">End Date</label>
                                            <input type="date" id="endDate" name="end_date" class="form-control">
                                        </div>

                                        <!-- Quota Settings -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="quota">Response Quota</label>
                                            <input type="number" id="quota" name="quota" class="form-control"
                                                placeholder="Enter response quota">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="responseLimit">Response Limit per
                                                User</label>
                                            <input type="number" id="responseLimit" name="response_limit"
                                                class="form-control" value="1">
                                        </div>

                                        <!-- Quiz Toggle -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="isQuiz"
                                                    name="is_quiz" value="1">
                                                <label class="form-check-label" for="isQuiz">
                                                    Enable Quiz Mode
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Details -->
                        <div class="form-section">
                            <label class="form-label" for="title">Title: *</label>
                            <input type="text" name="title" class="form-control form-title"
                                placeholder="Enter Form Title">
                            <label class="form-label" for="title">Description: *</label>

                            <textarea name="description" class="form-control" rows="3"
                                placeholder="Enter Form Description"></textarea>

                            <div class="row g-4 mt-4">
                                <div class="col-md-3">
                                    <label class="form-label" for="formType">Form Type</label>
                                    <select id="formType" name="form_type" class="form-select">
                                        <option value="" selected disabled>Select Form Type</option>
                                        <?php
                                        $sql = "SELECT * FROM asmt_form_type";
                                        $result = $con->query($sql);
                                        
                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo "<option value='" . htmlspecialchars($row["form_type"]) . "'>" . 
                                                    htmlspecialchars($row["form_type"]) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <label class="form-label" for="serviceType">Service Request</label>
                                    <select id="serviceType" name="request_id" class="form-select select2">
                                        <option value="" selected disabled>Select Service Request</option>
                                        <?php
                                        // Complex query to get service requests with additional details
                                        $sql = "SELECT 
                                                sr.request_id,
                                                sr.service_type,
                                                sr.office_agency,
                                                sr.client_type,
                                                sr.completed_date,
                                                sr.ongoing_date,
                                                sr.participants,
                                                sr.participants_quota,
                                                CASE 
                                                    WHEN sr.service_type = 'data-analysis' THEN sda.analysis_type
                                                    WHEN sr.service_type = 'capability-training' THEN st.title
                                                    ELSE NULL 
                                                END as additional_info
                                            FROM service_request sr
                                            LEFT JOIN sr_dataanalysis sda ON sr.request_id = sda.request_id
                                            LEFT JOIN sr_training st ON sr.request_id = st.request_id
                                            WHERE sr.request_id NOT IN (
                                                SELECT DISTINCT request_id 
                                                FROM asmt_forms 
                                                WHERE form_type = COALESCE(?, form_type)
                                            )
                                            ORDER BY sr.request_date DESC";
                                        
                                        $stmt = mysqli_prepare($con, $sql);
                                        
                                        // If form_id exists, get the form type to exclude it from filtering
                                        $currentFormType = isset($_GET['form_id']) ? 
                                                        (mysqli_fetch_assoc(mysqli_query($con, 
                                                        "SELECT form_type FROM asmt_forms WHERE form_id = " . 
                                                        intval($_GET['form_id']))))['form_type'] : null;
                                        
                                        mysqli_stmt_bind_param($stmt, "s", $currentFormType);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        if ($result && mysqli_num_rows($result) > 0) {
                                            while($row = mysqli_fetch_assoc($result)) {
                                                $date = !empty($row["completed_date"]) ? $row["completed_date"] : $row["ongoing_date"];
                                                $dateLabel = !empty($row["completed_date"]) ? "Completed" : "Ongoing";
                                                
                                                // Format participants info
                                                $participantsInfo = "";
                                                if ($row["participants_quota"] > 0) {
                                                    $participantsInfo = " | Participants: " . $row["participants"] . 
                                                                    "/" . $row["participants_quota"];
                                                }
                                                
                                                // Format additional info based on service type
                                                $additionalInfo = "";
                                                if ($row["additional_info"]) {
                                                    $additionalInfo = " | " . $row["additional_info"];
                                                }
                                                
                                                // Build the option text
                                                $optionText = sprintf(
                                                    "ID:%d - %s - %s - %s%s%s - %s: %s",
                                                    $row["request_id"],
                                                    ucfirst(str_replace('-', ' ', $row["service_type"])),
                                                    $row["office_agency"],
                                                    $row["client_type"],
                                                    $additionalInfo,
                                                    $participantsInfo,
                                                    $dateLabel,
                                                    date('Y-m-d', strtotime($date))
                                                );
                                                
                                                echo "<option value='" . $row["request_id"] . "'>" . 
                                                    htmlspecialchars($optionText) . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Questions Container -->
                        <div id="question_list_container" class="questions-container mt-4">
                            <!-- Questions will be loaded here -->
                        </div>

                        <input type="hidden" name="form_id" value="<?php echo isset($form_id) ? $form_id : 0; ?>">
                        <input type="hidden" name="is_update" id="is_update" value="0">
                    </form>

                    <!-- Action Buttons -->
                    <div class="form-actions mt-4">
                        <button class="btn btn-primary" type="button" id="add-item">
                            <i class="fas fa-plus"></i>
                            Add Question
                        </button>
                        <button class="btn btn-success" type="button" id="saveFormButton">
                            <i class="fas fa-save"></i>
                            Save Form
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php
$formIdExists = isset($_GET['form_id']) && !empty($_GET['form_id']);
$modalTitle = $formIdExists ? "Save Form" : "Save New Form";
$modalBody = $formIdExists ? "Do you want to update this form or save it as a new form?" : "Do you want to save this as a new form?";
?>
    <!-- Modal for update or save as new -->
    <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveModalLabel"><?php echo $modalTitle; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><?php echo $modalBody; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <?php if ($formIdExists): ?>
                    <button type="button" class="btn btn-primary" id="updateFormButton">Update Form</button>
                    <?php endif; ?>
                    <button type="button" class="btn btn-success" id="saveAsNewFormButton">Save as New Form</button>
                </div>
            </div>
        </div>
    </div>



    <?php include('include/footer.php');?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    const FormManager = {
        // Configuration
        config: {
            minTitleLength: 3,
            maxTitleLength: 100,
            minDescriptionLength: 10,
            maxDescriptionLength: 500,
            minQuota: 1,
            maxQuota: 1000,
            minResponseLimit: 1,
            maxResponseLimit: 10
        },

        // Validation Rules
        validationRules: {
            title: function(value) {
                if (!value.trim()) return 'Title is required';
                if (value.length < FormManager.config.minTitleLength)
                    return `Title must be at least ${FormManager.config.minTitleLength} characters`;
                if (value.length > FormManager.config.maxTitleLength)
                    return `Title must not exceed ${FormManager.config.maxTitleLength} characters`;
                return null;
            },
            description: function(value) {
                if (!value.trim()) return 'Description is required';
                if (value.length < FormManager.config.minDescriptionLength)
                    return `Description must be at least ${FormManager.config.minDescriptionLength} characters`;
                if (value.length > FormManager.config.maxDescriptionLength)
                    return `Description must not exceed ${FormManager.config.maxDescriptionLength} characters`;
                return null;
            },
            dates: function(startDate, endDate) {
                if (!startDate) return 'Start date is required';
                if (!endDate) return 'End date is required';

                const start = new Date(startDate);
                const end = new Date(endDate);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (start < today) return 'Start date cannot be in the past';
                if (end <= start) return 'End date must be after start date';

                // Check if the date range is reasonable (e.g., not more than 2 years)
                const twoYearsFromNow = new Date();
                twoYearsFromNow.setFullYear(twoYearsFromNow.getFullYear() + 2);
                if (end > twoYearsFromNow) return 'End date cannot be more than 2 years in the future';

                return null;
            },
            quota: function(value) {
                if (!value) return 'Response quota is required';
                if (isNaN(value) || value < FormManager.config.minQuota)
                    return `Quota must be at least ${FormManager.config.minQuota}`;
                if (value > FormManager.config.maxQuota)
                    return `Quota cannot exceed ${FormManager.config.maxQuota}`;
                return null;
            },
            responseLimit: function(value) {
                if (!value) return 'Response limit is required';
                if (isNaN(value) || value < FormManager.config.minResponseLimit)
                    return `Response limit must be at least ${FormManager.config.minResponseLimit}`;
                if (value > FormManager.config.maxResponseLimit)
                    return `Response limit cannot exceed ${FormManager.config.maxResponseLimit}`;
                return null;
            },
            questions: function(container) {
                const questions = container.find('.question-card');
                if (questions.length === 0) return 'At least one question is required';

                let errors = [];
                questions.each(function(index) {
                    // Get the text input value and trim it
                    const questionTextInput = $(this).find('input[type="text"]').first();
                    const questionText = questionTextInput.val() ? questionTextInput.val().trim() : '';
                    const questionType = $(this).find('select[name^="questions[type]"]').val();
                    const options = $(this).find('.option-input');

                    if (!questionText) {
                        questionTextInput.addClass('is-invalid');
                        errors.push(`Question ${index + 1}: Question text is required`);
                    } else {
                        questionTextInput.removeClass('is-invalid');
                    }

                    if (!questionType) {
                        errors.push(`Question ${index + 1}: Question type must be selected`);
                    }

                    if (questionType === 'multiple_choice' || questionType === 'checkbox') {
                        if (options.length < 2) {
                            errors.push(`Question ${index + 1}: At least 2 options are required`);
                        }

                        options.each(function(optionIndex) {
                            if (!$(this).val()?.trim()) {
                                errors.push(
                                    `Question ${index + 1}, Option ${optionIndex + 1}: Option text is required`
                                );
                            }
                        });
                    }

                    if ($('#isQuiz').is(':checked')) {
                        const correctAnswer = $(this).find('.correct-answer').val();
                        if (!correctAnswer) {
                            errors.push(
                                `Question ${index + 1}: Correct answer must be specified in quiz mode`
                            );
                        }
                    }
                });

                return errors.length > 0 ? errors : null;
            }
        },

        validateForm: function() {
            let errors = [];
            const form = $('#myForm');

            // Validate basic fields
            const title = form.find('input[name="title"]').val();
            const description = form.find('textarea[name="description"]').val();
            const startDate = form.find('#startDate').val();
            const endDate = form.find('#endDate').val();
            const quota = form.find('#quota').val();
            const responseLimit = form.find('#responseLimit').val();
            const formType = form.find('#formType').val();
            const serviceType = form.find('#serviceType').val();

            // Check each field using validation rules
            const titleError = this.validationRules.title(title);
            const descriptionError = this.validationRules.description(description);
            const dateError = this.validationRules.dates(startDate, endDate);
            const quotaError = this.validationRules.quota(quota);
            const responseLimitError = this.validationRules.responseLimit(responseLimit);
            const questionErrors = this.validationRules.questions($('#question_list_container'));

            // Collect all errors
            [titleError, descriptionError, dateError, quotaError, responseLimitError].forEach(error => {
                if (error) errors.push(error);
            });

            if (!formType) errors.push('Form type must be selected');
            if (!serviceType) errors.push('Service type must be selected');

            if (questionErrors) {
                errors = errors.concat(questionErrors);
            }

            // Display errors if any
            if (errors.length > 0) {
                Swal.fire({
                    title: 'Validation Errors',
                    html: errors.join('<br>'),
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
            }

            return true;
        },

        saveForm: function(isUpdate) {
            $('#is_update').val(isUpdate ? 1 : 0);
            this.performSave();
        },

        performSave: function() {
            // Validate form first
            if (!this.validateForm()) {
                return;
            }

            // Serialize form data
            const formData = $('#myForm').serialize();

            // Make AJAX request
            $.ajax({
                url: 'function/assessment.form.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: (response) => {
                    // Close modal if it exists - Fixed Bootstrap Modal syntax
                    const saveModal = document.getElementById('saveModal');
                    if (saveModal) {
                        const modalInstance = new bootstrap.Modal(saveModal);
                        modalInstance.hide();
                    }

                    if (response.status === 'success') {
                        // Show success message and redirect
                        Swal.fire({
                            icon: 'success',
                            title: 'Form Saved!',
                            text: response.message,
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'assessment.php';
                            }
                        });
                    } else {
                        let errorMessage = response.message;
                        let errorDetails = '';

                        // If there are specific errors, format them for display
                        if (response.errors && response.errors.length > 0) {
                            errorDetails = response.errors.map(error => {
                                return typeof error === 'string' ? error : error.message ||
                                    error;
                            }).join('\n');
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage,
                            footer: errorDetails ?
                                '<div style="text-align: left; color: #dc3545;">Details:\n' +
                                errorDetails + '</div>' : '',
                            showConfirmButton: true,
                            confirmButtonText: 'OK',
                            allowOutsideClick: false
                        });

                        if (response.errors) {
                            console.error('Form Submission Errors:', response.errors);
                        }
                    }
                },
                error: (xhr, status, error) => {
                    console.error('AJAX Error:', {
                        xhr,
                        status,
                        error
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Failed to save the form. Please try again.',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    });
                }
            });
        },


        fetchQuestions: function(form_id, isQuiz) {
            $.ajax({
                url: 'table/form.build.questions.php',
                method: 'POST',
                data: {
                    form_id,
                    is_quiz: isQuiz
                },
                success: (data) => {
                    $('#question_list_container').html(data);
                    if (isQuiz) {
                        $('.question-card').each(function() {
                            const type = $(this).find('.question-type').val();
                            QuestionCardManager.updateCorrectAnswerField($(this), type);
                        });
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error('Error fetching questions:', textStatus, errorThrown);
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to load questions. Please refresh the page.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        },

        handleQuizChange: function(isChecked) {
            const formId = $('input[name="form_id"]').val();
            this.fetchQuestions(formId, isChecked);
        },

        initializeEventListeners: function() {
            // Save button click handler
            $('#saveFormButton').click((e) => {
                e.preventDefault();
                if (this.validateForm()) {
                    const modal = new bootstrap.Modal(document.getElementById('saveModal'));
                    modal.show();
                }
            });

            // Update form button click handler
            $('#updateFormButton').click((e) => {
                e.preventDefault();
                this.saveForm(true);
            });

            // Save as new form button click handler
            $('#saveAsNewFormButton').click((e) => {
                e.preventDefault();
                this.saveForm(false);
            });

            // Quiz mode toggle handler
            $('#isQuiz').change(function() {
                const isChecked = $(this).is(':checked');
                FormManager.handleQuizChange(isChecked);
            });

            // Settings panel collapse handlers
            $('#formSettingsCollapse').on('show.bs.collapse', function() {
                $('.settings-header i.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }).on('hide.bs.collapse', function() {
                $('.settings-header i.fas').removeClass('fa-chevron-up').addClass('fa-chevron-down');
            });

            // Input validation handlers
            $('input, textarea, select').on('input change', function() {
                $(this).removeClass('is-invalid');
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        FormManager.initializeEventListeners();

        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select Service Type",
            allowClear: true,
            width: '100%',
            minimumResultsForSearch: 0,
            language: {
                noResults: function() {
                    return "No matching results found";
                }
            }
        }).on('select2:open', function() {
            $(this).data('select2').$dropdown.css('z-index', 9999);
        });

        // Fetch initial questions
        const formId = $('input[name="form_id"]').val() || 0;
        const isQuiz = $('#isQuiz').is(':checked');
        FormManager.fetchQuestions(formId, isQuiz);
    });
    </script>

</body>

</html>