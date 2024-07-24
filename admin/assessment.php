<?php include('include/header.php')?>
<link rel="stylesheet" href="css/assmt.form.view.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<style>
.date-range {
    display: flex;
    flex-direction: column;
}

.start-date,
.end-date {
    white-space: nowrap;
}

.start-date::after {
    content: " to";
    font-style: italic;
    color: #888;
}
</style>

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">Assessment Form List</strong>
                            <div>
                                <a href="form_builder.php" class="btn btn-primary btn-sm" id="addNewFormBtn">
                                    <i class="fas fa-plus"></i> New Form
                                </a>
                                <button class="btn btn-primary btn-sm" id="manageFormTypesBtn">
                                    <i class="fas fa-cog"></i> Manage Form Types
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label for="formTypeFilter">Form Type:</label>
                                        <select id="formTypeFilter" class="form-control">
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="serviceTypeFilter">Training:</label>
                                        <select id="serviceTypeFilter" class="form-control">
                                            <option value="">All</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Date Range:</label>
                                        <div class="input-group">
                                            <input type="date" id="startDate" class="form-control">
                                            <div class="input-group-prepend input-group-append">
                                                <span class="input-group-text">to</span>
                                            </div>
                                            <input type="date" id="endDate" class="form-control">
                                            <div class="input-group-append">
                                                <button id="applyDateFilter" class="btn btn-primary">Apply</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    // Update the query to include both training title and service type
                                    $query = "SELECT af.*, sr.request_id, sr.service_type, srt.title as training_title 
                                            FROM asmt_forms af
                                            LEFT JOIN service_request sr ON af.request_id = sr.request_id
                                            LEFT JOIN sr_training srt ON sr.request_id = srt.request_id";
                                    $results = mysqli_query($con, $query);

                                    if (!$results) {
                                        die("Query failed: " . mysqli_error($con));
                                    }
                                    ?>

                                <table class="table table-hover" id="assessment_form_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Form ID</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Training</th>
                                            <th scope="col">Responses</th>
                                            <th scope="col">Dates</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
        while ($row = mysqli_fetch_array($results)) { 
            $form_id = $row['form_id'];
            $questionCountResult = mysqli_query($con, "SELECT COUNT(*) as question_count FROM asmt_questions WHERE form_id = $form_id");
            $questionCount = mysqli_fetch_assoc($questionCountResult)['question_count'];

            $responseCountResult = mysqli_query($con, "SELECT COUNT(DISTINCT user_id) as response_count FROM asmt_responses WHERE form_id = $form_id");
            $responseCount = mysqli_fetch_assoc($responseCountResult)['response_count'];

            $startDate = date('F j, Y', strtotime($row['start_date']));
            $endDate = date('F j, Y', strtotime($row['end_date'])); 
            
            $responsesWithQuota = $responseCount . '/' . $row['quota'];

            $displayTitle = !empty($row['training_title']) ? $row['training_title'] : $row['service_type'];

            // Determine status
            $currentDate = new DateTime();
            $formEndDate = new DateTime($row['end_date']);
            $status = ($currentDate > $formEndDate) ? 'Completed' : 'Ongoing';
            $statusClass = ($status === 'Completed') ? 'text-success' : 'text-primary';
        ?>
                                        <tr>
                                            <td><?php echo $row['form_id']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['form_type']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td><?php echo $displayTitle ?? 'N/A'; ?></td>
                                            <td><?php echo $responsesWithQuota; ?></td>
                                            <td>
                                                <div class="date-range">
                                                    <div class="start-date"><?php echo $startDate; ?></div>
                                                    <div class="end-date"><?php echo $endDate; ?></div>
                                                </div>
                                            </td>
                                            <td><span class="<?php echo $statusClass; ?>"><?php echo $status; ?></span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                        type="button"
                                                        id="dropdownMenuButton-<?php echo $row['form_id']; ?>"
                                                        data-toggle="dropdown" aria-expanded="false">
                                                        Actions
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton-<?php echo $row['form_id']; ?>">
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="../assmnt.form.php?form_id=<?php echo $row['form_id']; ?>"
                                                                target="_blank">
                                                                <i class="fas fa-eye"></i> View Form
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="form_builder.php?form_id=<?php echo $row['form_id']; ?>"
                                                                target="_blank">
                                                                <i class="fas fa-pen"></i> Edit Form
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btnViewResponses" href="#"
                                                                data-form-id="<?php echo $row['form_id']; ?>"
                                                                data-is-quiz="<?php echo $row['is_quiz']; ?>">
                                                                <i class="fas fa-list"></i> View Responses
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btnSendInvite" href="#"
                                                                data-form-id="<?php echo $row['form_id']; ?>"
                                                                data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                                                data-description="<?php echo htmlspecialchars($row['description']); ?>"
                                                                data-toggle="modal" data-bs-target="#emailModal">
                                                                <i class="fas fa-envelope"></i> Send Invite
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item btnDeleteForm" href="#"
                                                                data-form-id="<?php echo $row['form_id']; ?>"
                                                                data-title="<?php echo htmlspecialchars($row['title']); ?>">
                                                                <i class="fas fa-trash-alt"></i> Delete Form
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include('include/footer.php');?>


    <script>
    $(document).ready(function() {

        var table = $('#assessment_form_table').DataTable({
            "pageLength": 10,
            "columns": [{
                    "data": "form_id"
                },
                {
                    "data": "title"
                },
                {
                    "data": "form_type"
                },
                {
                    "data": "description"
                },
                {
                    "data": "training"
                },
                {
                    "data": "questions"
                },
                {
                    "data": "responses"
                },
                {
                    "data": "dates"
                },
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            initComplete: function() {
                this.api().columns([2, 4]).every(function(colIdx) {
                    var column = this;
                    var select = $('#' + (colIdx === 2 ? 'formTypeFilter' :
                            'serviceTypeFilter'))
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d +
                            '</option>');
                    });
                });
            }
        });

        $(document).on('click', '.btnDeleteForm', function(e) {
            e.preventDefault();
            var formId = $(this).data('form-id');
            var formTitle = $(this).data('title');

            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to delete the form "${formTitle}". This action cannot be undone.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send AJAX request to delete the form
                    $.ajax({
                        url: 'function/assessment.form.delete.php', // Create this PHP file to handle the deletion
                        method: 'POST',
                        data: {
                            form_id: formId
                        },
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The form has been deleted.',
                                    'success'
                                ).then(() => {
                                    // Reload the page or remove the row from the table
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the form.',
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'There was an error connecting to the server.',
                                'error'
                            );
                        }
                    });
                }
            });
        });



        // Date range filter
        $('#applyDateFilter').on('click', function() {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var date = new Date(data[7].split(" to ")[
                        0]); // Assuming the date is in the 8th column
                    var start = new Date(startDate);
                    var end = new Date(endDate);
                    return (isNaN(start) && isNaN(end)) ||
                        (isNaN(start) && date <= end) ||
                        (start <= date && isNaN(end)) ||
                        (start <= date && date <= end);
                }
            );

            table.draw();

            // Clear the custom filter after drawing
            $.fn.dataTable.ext.search.pop();
        });
    });
    </script>

    <?php include('modal/response.form.modal.php');?>
    <?php include('modal/assessment.invite.php');?>
    <?php include('modal/assessment.form_type.php');?>

    <script>
    $(document).ready(function() {
        var responsesTable = null;

        // View responses button
        $('.btnViewResponses').on('click', function() {
            var form_id = $(this).data('form-id');
            var is_quiz = $(this).data('is-quiz');

            $.ajax({
                url: 'fetch/fetch_responses.php',
                type: 'GET',
                data: {
                    form_id: form_id,
                    is_quiz: is_quiz
                },
                success: function(data) {
                    $('#responsesContent').html(data);

                    // Check if DataTable is already initialized
                    if ($.fn.DataTable.isDataTable('#responsesTable')) {
                        $('#responsesTable').DataTable().destroy();
                    }

                    // Initialize DataTable
                    responsesTable = $('#responsesTable').DataTable({
                        responsive: true,
                        order: [
                            [2, 'desc']
                        ]
                    });

                    var modal = new bootstrap.Modal(document.getElementById(
                        'responsesModal'));
                    modal.show();
                },
                error: function() {
                    Swal.fire('Error', 'Failed to fetch responses. Please try again.',
                        'error');
                }
            });
        });

        // View response summary button (inside the responses modal)
        $(document).on('click', '.btnViewResponseSummary', function() {
            var user_id = $(this).data('user-id');
            var form_id = $(this).data('form-id');
            var is_quiz = $(this).data('is-quiz');

            $.ajax({
                url: 'fetch/fetch_response_summary.php',
                type: 'GET',
                data: {
                    user_id: user_id,
                    form_id: form_id,
                    is_quiz: is_quiz
                },
                success: function(data) {
                    $('#responseSummaryContent').html(data);
                    var modal = new bootstrap.Modal(document.getElementById(
                        'responseSummaryModal'));
                    modal.show();
                },
                error: function() {
                    Swal.fire('Error',
                        'Failed to fetch response summary. Please try again.', 'error');
                }
            });
        });
    });



    $(document).ready(function() {
        // Send Invite button
        $('.btnSendInvite').on('click', function() {

            tinymce.init({
                selector: '#emailBody',
                plugins: 'lists wordcount',
                toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat',
                menubar: false,
                statusbar: false,
                height: 300,
                content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
            });


            var form_id = $(this).data('form-id');
            var title = $(this).data('title');
            var description = $(this).data('description');

            // Set up the modal with the relevant form details
            $('#formTitle').val(title);
            $('#formDescription').val(description);
            var inviteLink = 'http://serdac-wmsu.online/assmnt.form.php?form_id=' + form_id;
            $('#inviteLink').val(inviteLink);

            // Generate the message dynamically
            var message = `
            <p>Dear Participant,</p>
            <p>We are pleased to invite you to participate in our assessment titled <strong>${title}</strong>.</p>
            <p>${description}</p>
            <p>Please find the invitation link attached: <strong>${inviteLink}</strong>.</p>
            <p>We look forward to your participation.</p>
            <p>Best regards,<br>Assessment Team</p>
        `;
            $('#emailBody').val(message);

            // Fetch participant emails
            $.ajax({
                url: 'fetch/fetch_asmt_emails.php',
                type: 'POST',
                data: {
                    form_id: form_id
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.error) {
                        console.log(result.error);
                    } else {
                        var emails = result.emails.join(', ');
                        $('#emailList').val(emails);
                    }
                },
                error: function() {
                    console.log('Error fetching participant emails.');
                }
            });

            var modal = new bootstrap.Modal(document.getElementById('emailModal'));
            modal.show();
        });
    });

    $(document).ready(function() {
        $('#manageFormTypesBtn').click(function() {
            var modal = new bootstrap.Modal(document.getElementById('formTypeModal'));
            modal.show();
            loadFormTypes();
        });

        $('#addFormTypeBtn').click(function() {
            showFormTypeForm();
        });

        $('#cancelFormType').click(function(e) {
            e.preventDefault();
            hideFormTypeForm();
        });

        $('#formTypeForm').submit(function(e) {
            e.preventDefault();
            saveFormType();
        });

        function showFormTypeForm() {
            $('#addFormTypeBtn').hide();
            $('#formTypeForm').show();
        }

        function hideFormTypeForm() {
            $('#addFormTypeBtn').show();
            $('#formTypeForm').hide();
            $('#formTypeId').val('');
            $('#formType').val('');
        }

        function loadFormTypes() {
            $.ajax({
                url: 'function/assessment.form_type.php',
                type: 'GET',
                data: {
                    action: 'read'
                },
                success: function(response) {
                    $('#formTypeTableBody').html(response);
                }
            });
        }

        function saveFormType() {
            var formData = $('#formTypeForm').serialize();
            var action = $('#formTypeId').val() ? 'update' : 'create';

            $.ajax({
                url: 'function/assessment.form_type.php',
                type: 'POST',
                data: formData + '&action=' + action,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadFormTypes();
                    hideFormTypeForm();
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    });
                }
            });
        }

        $(document).on('click', '.edit-form-type', function() {
            var id = $(this).data('id');
            var formType = $(this).data('form-type');
            $('#formTypeId').val(id);
            $('#formType').val(formType);
            showFormTypeForm();
        });

        $(document).on('click', '.delete-form-type', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'function/assessment.form_type.php',
                        type: 'POST',
                        data: {
                            action: 'delete',
                            formTypeId: id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            loadFormTypes();
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                            });
                        }
                    });
                }
            });
        });
    });
    </script>


</body>

</html>