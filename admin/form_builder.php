<?php include('include/header.php');
if (isset($_GET["form_id"])) {
    $form_id =  $_GET['form_id'];
    $formQuery = "SELECT * FROM asmt_forms WHERE form_id = $form_id";
    $formResult = mysqli_query($con, $formQuery);
    $formIdExists = isset($_GET['form_id']) && !empty($_GET['form_id']);

    if ($formResult && mysqli_num_rows($formResult) > 0) {
        $formRecord = mysqli_fetch_assoc($formResult);
        $isQuiz = $formRecord['is_quiz'];
        echo "
        <script>
            $(document).ready(function() {
                $('input[name=title]').val('{$formRecord['title']}');
                $('textarea[name=description]').val('{$formRecord['description']}');
                $('select[name=form_type]').val('{$formRecord['form_type']}');
                $('select[name=request_id]').val('{$formRecord['request_id']}');
                $('input[name=start_date]').val('{$formRecord['start_date']}');
                $('input[name=end_date]').val('{$formRecord['end_date']}');
                $('input[name=quota]').val('{$formRecord['quota']}');
                $('input[name=response_limit]').val('{$formRecord['response_limit']}');
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.builder.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Form Builder</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="assessment.php">Assessment List</a></li>
                                    <li class="active">Form Builder</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="card">

                <div class="card-body">
                    <div class="container mt-4">
                        <div class="form-builder-container">
                            <form id="myForm">
                                <div class="form-section">
                                    <!-- New Settings Section -->
                                    <div class="settings-panel mb-4">
                                        <div class="settings-header" data-toggle="collapse"
                                            data-target="#formSettingsCollapse" aria-expanded="true">
                                            <h5> <i class="fas fa-cog"></i> Form Settings</h5>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                        <div id="formSettingsCollapse" class="collapse show">
                                            <div class="settings-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="startDate">Start Date</label>
                                                        <input type="date" id="startDate" name="start_date"
                                                            class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="endDate">End Date</label>
                                                        <input type="date" id="endDate" name="end_date"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="quota">Quota</label>
                                                        <input type="number" id="quota" name="quota"
                                                            class="form-control" placeholder="Enter Quota">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="responseLimit">Response Limit per
                                                            User</label>
                                                        <input type="number" id="responseLimit" name="response_limit"
                                                            class="form-control" placeholder="Enter Limit" value="1">
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="isQuiz"
                                                        name="is_quiz" value="1">
                                                    <label class="form-check-label" for="isQuiz">
                                                        This is a quiz form
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- End of New Settings Section -->

                                    <div class="form-group">
                                        <input type="text" name="title" class="form-control form-title"
                                            placeholder="Enter Title Here">
                                    </div>
                                    <div class="form-group">
                                        <textarea name="description" class="form-control" rows="2"
                                            placeholder="Enter Description Here"></textarea>
                                    </div>
                                    <div class="form-row row">
                                        <div class="form-group col-md-6">
                                            <label for="formType">Form Type</label>
                                            <select id="formType" name="form_type" class="form-control">
                                                <option value="" selected>Select Form Type</option>
                                                <?php
                                                            // Fetch form types from the asmt_form_type table
                                                            $sql = "SELECT * FROM asmt_form_type";
                                                            $result = $con->query($sql);
                                                            
                                                            if ($result->num_rows > 0) {
                                                                while($row = $result->fetch_assoc()) {
                                                                    echo "<option value='".htmlspecialchars($row["form_type"])."'>".htmlspecialchars($row["form_type"])."</option>";
                                                                }
                                                            } else {
                                                                echo "<option value='' disabled>No form types available</option>";
                                                            }
                                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="serviceType">Service Request ID</label>
                                            <select id="serviceType" name="request_id" class="form-control select2">
                                                <option value="" selected disabled>Select Service Type</option>
                                                <?php
                                            // Fetch service types from the service_request table
                                            $sql = "SELECT request_id, service_type, completed_date, ongoing_date FROM service_request";
                                            $result = $con->query($sql);

                                            if ($result->num_rows > 0) {
                                                while($row = $result->fetch_assoc()) {
                                                    $date = !empty($row["completed_date"]) ? $row["completed_date"] : $row["ongoing_date"];
                                                    $dateLabel = !empty($row["completed_date"]) ? "Completed" : "Ongoing";
                                                    echo "<option value='".$row["request_id"]."'>ID:".$row["request_id"]." - ".$row["service_type"]." - ".$dateLabel.": ".date('Y-m-d', strtotime($date))."</option>";
                                                }
                                            } else {
                                                echo "<option value='' disabled>No services available</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div id="question_list_container" class="form-builder-container">
                                    <!-- Questions will be loaded here -->
                                </div>
                                <input type="hidden" name="form_id"
                                    value="<?php echo isset($form_id) ? $form_id : 0; ?>">
                                <input type="hidden" name="is_update" id="is_update" value="0">
                            </form>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button class="btn btn-primary" type="button" id="add-item">+ Add Item</button>
                        <button class="btn btn-success" type="button" id="saveFormButton">Save Form</button>
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
    $(document).ready(function() {
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
        });
    });


    const FormManager = {
        saveForm: function(isUpdate) {
            $('#is_update').val(isUpdate ? 1 : 0);
            this.performSave();
        },

        performSave: function() {
            if (!this.validateForm()) {
                return;
            }

            var formData = $('#myForm').serialize();

            Swal.fire({
                title: 'Saving...',
                text: 'Please wait while we save your form.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: 'function/assessment.form.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    Swal.close();
                    var modal = new bootstrap.Modal(document.getElementById('saveModal'));
                    modal.hide();

                    if (response.status === 'success') {
                        Swal.fire('Saved!', response.message, 'success').then(() => {
                            window.location.href = 'assessment.php';
                        });
                    } else {
                        Swal.fire('Error!', response.message, 'error');
                        if (response.errors) {
                            console.error('Detailed Errors:', response.errors);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    console.error('AJAX Error:', status, error);
                    Swal.fire('Error!', 'Your form could not be saved. Please try again.', 'error');
                }
            });
        },

        validateForm: function() {
            var isValid = true;
            var errorMessages = [];

            // Check required fields
            $('input[name="title"], textarea[name="description"], #formType, #serviceType').each(function() {
                if ($(this).val() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                    errorMessages.push($(this).attr('name').replace('_', ' ') + ' is required');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Check start and end dates
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            if (!startDate || !endDate) {
                isValid = false;
                if (!startDate) $('#startDate').addClass('is-invalid');
                if (!endDate) $('#endDate').addClass('is-invalid');
                errorMessages.push('Please set both start and end dates');
            } else {
                $('#startDate, #endDate').removeClass('is-invalid');
                if (new Date(endDate) <= new Date(startDate)) {
                    isValid = false;
                    $('#endDate').addClass('is-invalid');
                    errorMessages.push('End date must be after start date');
                }
            }



            if (!isValid) {
                Swal.fire('Validation Error', errorMessages.join('<br>'), 'error');
            }

            return isValid;
        },


        fetchQuestions: function(form_id, isQuiz) {
            $.ajax({
                url: 'table/form.build.php',
                method: 'POST',
                data: {
                    form_id: form_id,
                    is_quiz: isQuiz
                },
                success: function(data) {
                    $('#question_list_container').html(data);
                    // Re-initialize event listeners or other functionalities if needed
                    if (isQuiz) {
                        $('.question-card').each(function() {
                            const type = $(this).find('.question-type').val();
                            QuestionCardManager.updateCorrectAnswerField($(this), type);
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching questions:', textStatus, errorThrown);
                }
            });
        },

        handleQuizChange: function(isChecked) {
            var formId = $('input[name="form_id"]').val();
            this.fetchQuestions(formId, isChecked);
        }


    };



    $(document).ready(function() {


        // Event listener for opening the save modal
        $('#saveFormButton').click(function(e) {
            e.preventDefault();
            if (FormManager.validateForm()) {
                var modal = new bootstrap.Modal(document.getElementById('saveModal'));
                modal.show();
            }
        });

        // Event listener for updating the form
        $('#updateFormButton').click(function(e) {
            e.preventDefault();
            FormManager.saveForm(true);
        });

        // Event listener for saving as a new form
        $('#saveAsNewFormButton').click(function(e) {
            e.preventDefault();
            FormManager.saveForm(false);
        });

        // Fetch questions on page load
        var formId = <?php echo isset($form_id) ? $form_id : 'null'; ?>;
        var isQuiz = <?php echo isset($isQuiz) ? $isQuiz : 'false'; ?>;
        FormManager.fetchQuestions(formId || 0, isQuiz);

        // Ensure the settings panel stays open on page load
        $('#formSettingsCollapse').addClass('show');

        // Toggle the chevron icon when the panel is opened or closed
        $('#formSettingsCollapse').on('show.bs.collapse', function() {
            $('.settings-header i.fas').removeClass('fa-chevron-down').addClass('fa-chevron-up');
        });

        $('#formSettingsCollapse').on('hide.bs.collapse', function() {
            $('.settings-header i.fas').removeClass('fa-chevron-up').addClass('fa-chevron-down');
        });

        // Event listener for the quiz checkbox
        $('#isQuiz').change(function() {
            var isChecked = $(this).is(':checked');
            FormManager.handleQuizChange(isChecked);
        });


    });
    </script>




</body>

</html>