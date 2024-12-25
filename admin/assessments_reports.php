<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assessment_report.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
.card {
    transition: all 0.3s;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Report</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li class="active">Assessment Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid mt-5">
                <h1 class="text-center mb-4">Assessment Report</h1>

                <!-- Filters -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label for="formTypeFilter" class="form-label">Form Type</label>
                                    <select id="formTypeFilter" class="form-control">
                                        <option value="">All Form Types</option>
                                        <!-- PHP code to populate form types -->
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="quizFilter" class="form-label">Form Category</label>
                                    <select id="quizFilter" class="form-control">
                                        <option value="">All Categories</option>
                                        <option value="1">Quiz</option>
                                        <option value="0">Non-Quiz</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="dateRange" class="form-label">Date Range</label>
                                    <input type="text" id="dateRange" class="form-control"
                                        placeholder="Select date range">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-4" id="summaryCards">
                    <!-- Summary cards will be inserted here -->
                </div>

                <!-- Detailed Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive custom-table-container">

                            <table id="assessmentTable" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Form ID</th>
                                        <th>Title</th>
                                        <th>Form Type</th>
                                        <th>Description</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Quota</th>
                                        <th>Responses</th>
                                        <th>Questions</th>
                                        <th>Is Quiz</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Table data will be dynamically inserted here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

     


        </div>


        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>
    <?php include('modal/report.modal.assessment.php');?>

    <script>
    $(document).ready(function() {
        var table = $('#assessmentTable').DataTable({
            ajax: {
                url: 'fetch/fetch_report_assessment.php',
                dataSrc: ''
            },
            columns: [{
                    data: 'form_id'
                },
                {
                    data: 'title'
                },
                {
                    data: 'form_type'
                },
                {
                    data: 'description'
                },
                {
                    data: 'start_date'
                },
                {
                    data: 'end_date'
                },
                {
                    data: 'quota'
                },
                {
                    data: 'responses'
                },
                {
                    data: 'question_count'
                },
                {
                    data: 'is_quiz',
                    render: function(data) {
                        return data == 1 ? 'Yes' : 'No';
                    }
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return '<button class="btn btn-sm btn-info view-details" data-id="' +
                            row.form_id + '">View Details</button>';
                    }
                }
            ],
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });

        $('#dateRange').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                cancelLabel: 'Clear',
                format: 'YYYY-MM-DD'
            }
        });

        $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format(
                'YYYY-MM-DD'));
        });

        $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        $('#filterForm').on('submit', function(e) {
            e.preventDefault();
            applyFilters();
        });

        function applyFilters() {
            var formType = $('#formTypeFilter').val();
            var isQuiz = $('#quizFilter').val();
            var dateRange = $('#dateRange').val();

            Swal.fire({
                title: 'Loading...',
                text: 'Fetching data',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: 'fetch/fetch_report_assessment.php',
                method: 'GET',
                data: {
                    formType: formType,
                    isQuiz: isQuiz,
                    dateRange: dateRange
                },
                dataType: 'json',
                success: function(data) {
                    table.clear().rows.add(data).draw();
                    updateSummary(data);
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Filters Applied',
                        text: 'The report has been updated.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: " + status + " - " + error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch data. Please try again.'
                    });
                }
            });
        }

        function updateSummary(data) {
            var totalForms = data.length;
            var totalResponses = data.reduce((sum, form) => sum + parseInt(form.responses || 0), 0);
            var avgResponses = totalForms > 0 ? (totalResponses / totalForms).toFixed(2) : 0;
            var totalQuestions = data.reduce((sum, form) => sum + parseInt(form.question_count || 0), 0);
            var quizForms = data.filter(form => form.is_quiz == 1).length;

            var summaryHtml = `
                <div class="col-md-2 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h6 class="card-title">Total Forms</h6>
                            <p class="card-text h4">${totalForms}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6 class="card-title">Total Responses</h6>
                            <p class="card-text h4">${totalResponses}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h6 class="card-title">Avg Responses</h6>
                            <p class="card-text h4">${avgResponses}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h6 class="card-title">Total Questions</h6>
                            <p class="card-text h4">${totalQuestions}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title">Quiz Forms</h6>
                            <p class="card-text h4">${quizForms}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body">
                            <h6 class="card-title">Non-Quiz Forms</h6>
                            <p class="card-text h4">${totalForms - quizForms}</p>
                        </div>
                    </div>
                </div>
            `;

            $('#summaryCards').html(summaryHtml);
        }


        // Initial data load and summary update
        applyFilters();
    });
    </script>

</body>

</html>