<style>
.table-btn {
    margin-right: 4px;
    white-space: nowrap;
}

.table-btn:last-child {
    margin-right: 0;
}

.card-equal-height {
    height: auto;
}

.card-body {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card-equal-height .card-title {
    font-size: 1.25rem;
}

.status-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.status-item i {
    font-size: 1.5rem;
}

.badge-pill {
    font-size: 1rem;
    margin-top: 5px;
}

.row.justify-content-center {
    justify-content: center;
}

.card-equal-height .card-title {
    font-size: 1.5rem;
    margin-bottom: 1rem;
    color: #343a40;
}

.card-equal-height .badge {
    font-size: 1rem;
    padding: 0.5rem 1rem;
}

.table-hover tbody tr:hover {
    background-color: #f1f1f1;
}

.btn {
    border-radius: 0.25rem;
    transition: background-color 0.3s, box-shadow 0.3s;
}

.btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

.btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

.btn-dark {
    background-color: #343a40;
    border-color: #343a40;
}

.btn:hover {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}
.modal.show .modal-dialog {
    transform: none;
}
</style>
<div class="container">
    <div class="row mb-4 justify-content-center">
        <div class="col-md-10">
            <div class="card text-dark bg-light mb-3 card-equal-height">
                <div class="card-body">
                    <div class="row text-center justify-content-center">
                        <div class="col-md-2">
                            <div class="status-item">
                                <i class="fa fa-hourglass-start text-dark"></i>
                                <div>Pending</div>
                                <span class="badge  text-dark" id="status-pending">0</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="status-item">
                                <i class="fa fa-check text-dark"></i>
                                <div>Approved</div>
                                <span class="badge text-dark " id="status-approved">0</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="status-item">
                                <i class="fa fa-spinner text-dark"></i>
                                <div>In Progress</div>
                                <span class="badge  text-dark" id="status-in-progress">0</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="status-item">
                                <i class="fa fa-times text-dark"></i>
                                <div>Cancelled</div>
                                <span class="badge  text-dark" id="status-cancelled">0</span>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="status-item">
                                <i class="fa fa-check-circle text-dark"></i>
                                <div>Completed</div>
                                <span class="badge text-dark" id="status-completed">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <a class="btn btn-maroon text-white border-0 btn-sm me-2" href="request.php">
            <i class="fas fa-chart-line"></i> <span>REQUEST SERVICE</span>
        </a>
        <button class="btn btn-maroon text-white border-0 btn-sm" id="notificationBtn">
            <i class="fas fa-bell"></i> <span>NOTIFICATIONS</span>
        </button>
    </div> <br>
    <div class="row mb-3">
        <!-- Date Range Filter -->
        <div class="col-md-3 mb-3">
            <label for="filterDateFrom">From Date:</label>
            <input type="date" id="filterDateFrom" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label for="filterDateTo">To Date:</label>
            <input type="date" id="filterDateTo" class="form-control">
        </div>

        <!-- Service Type Filter -->
        <div class="col-md-3 mb-3">
            <label for="filterServiceType">Service Type:</label>
            <select id="filterServiceType" class="form-control">
                <option value="">All</option>
                <option value="data-analysis">Data Analysis</option>
                <option value="capability-training">Capability Training</option>
                <option value="technical-assistance">Technical Assistance</option>
            </select>
        </div>

        <!-- Status Filter -->
        <div class="col-md-3 mb-3">
            <label for="filterStatus">Status:</label>
            <select id="filterStatus" class="form-control">
                <option value="">All</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="In Progress">In Progress</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Completed">Completed</option>
            </select>
        </div>
    </div>

    <div class="table-responsive custom-table-container">
        <table class="table table-hover" id='client_req_table'>
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Date Requested</th>
                    <th scope="col">Service</th>
                    <th scope="col">Office</th>
                    <th scope="col">Purpose</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // Initialize counters
                    $total_requests = 0;
                    $status_pending = 0;
                    $status_approved = 0;
                    $status_in_progress = 0;
                    $status_cancelled = 0;
                    $status_completed = 0;
                    $service_data_analysis = 0;
                    $service_capability_training = 0;
                    $service_technical_assistance = 0;

                    // Fetch data from the service_request table
                    $results = mysqli_query($con, "SELECT sr.*, u.fname, u.lname, u.midname, 
                    (SELECT COUNT(*) FROM sr_meeting WHERE sr_meeting.request_id = sr.request_id) AS meeting_count
                    FROM service_request AS sr
                    LEFT JOIN users AS u ON u.user_id = sr.user_id
                    WHERE u.user_id = $id");

                    if(mysqli_num_rows($results) > 0){
                        while ($row = mysqli_fetch_array($results)) { 
                            $total_requests++;
                            switch ($row['status']) {
                                case "Pending":
                                    $status_pending++;
                                    break;
                                case "Approved":
                                    $status_approved++;
                                    break;
                                case "In Progress":
                                    $status_in_progress++;
                                    break;
                                case "Cancelled":
                                    $status_cancelled++;
                                    break;
                                case "Completed":
                                    $status_completed++;
                                    break;
                            }

                            switch ($row['service_type']) {
                                case "data-analysis":
                                    $service_data_analysis++;
                                    break;
                                case "capability-training":
                                    $service_capability_training++;
                                    break;
                                case "technical-assistance":
                                    $service_technical_assistance++;
                                    break;
                            }

                            $status_color = '';
                            switch ($row['status']) {
                                case "Pending":
                                    $status_color = 'badge-primary';
                                    break;
                                case "Approved":
                                    $status_color = 'badge-warning';
                                    break;
                                case "In Progress":
                                    $status_color = 'badge-dark';
                                    break;
                                case "Cancelled":
                                    $status_color = 'badge-danger';
                                    break;
                                case "Completed":
                                    $status_color = 'badge-success';
                                    break;
                            }

                            $type_color = '';
                            if ($row['service_type'] === "data-analysis") {
                                $type_color = 'badge-success';
                            } elseif ($row['service_type'] === "capability-training") {
                                $type_color = 'badge-primary';
                            } elseif ($row['service_type'] === "technical-assistance") {
                                $type_color = 'badge-dark';
                            }
                            ?>
                <tr>
                    <td><?php echo $row['request_id']; ?></td>
                    <td>
                        <?php echo date('M j, Y', strtotime($row['request_date'])); ?>
                    </td>
                    <td>
                        <?php echo $row['service_type']; ?>
                    </td>
                    <td><?php echo $row['office_agency']; ?></td>
                    <td><?php echo $row['selected_purposes']; ?></td>
                    <td><span class="badge <?php echo $status_color; ?>">
                            <?php echo $row['status']; ?>
                        </span>
                    </td>
                    <td>
                        <div class="button-grid">
                            <!-- View button -->
                            <button type="button" class="btn btn-sm btn-primary btnView"
                                data-request='<?php echo json_encode($row); ?>'>
                                <i class="fas fa-book"></i>
                            </button>
                            <?php if ($row['status'] !== "Pending" && $row['status'] !== "Cancelled") { ?>
                            <button type="button" class="btn btn-sm btn-secondary btnMeeting"
                                data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip"
                                title="Progress Meeting">
                                <i class="fas fa-calendar"></i> Meetings <span
                                    class="badge badge-light"><?php echo $row['meeting_count']; ?></span>
                            </button>
                            <?php } ?>
                            <!-- Conditionally displayed Requirements button for 'data-analysis' services in 'In Progress' status -->
                            <?php if ($row['service_type'] === "data-analysis" && ($row['status'] === "In Progress" || $row['status'] === "Completed" )) { ?>
                            <button type="button" class="btn btn-sm btn-dark btnRequirement"
                                data-request='<?php echo json_encode($row); ?>'>
                                <i class="fas fa-tasks"></i> Docu
                            </button>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                <?php
                        }
                    } else {
                        echo '<tr><td colspan="6">No record found</td></tr>';
                    }
                    ?>
            </tbody>
        </table>
    </div>
 




</div>
<script>

    
$(document).ready(function() {
    $('.btnRequirement').on('click', function() {
        var request = $(this).data('request');

        $('#r_req_id').val(request.request_id);

        $('#r_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
            'N/A');
        $('#r_service-type').val(request.service_type || 'N/A');
        // Show or hide the button based on the request status
        if (request.status.toLowerCase() === 'completed') {
            $('#btnUploadDoc').hide();
            $('.file-uploader').hide();

        } else {
            $('#btnUploadDoc').show();
            $('.file-uploader').show();

        }
        request_id = request.request_id;

        function fetch_files() {

            $.ajax({
                url: "table_fetch/anaylsis_files_fetch.php",
                method: "POST",
                data: {
                    request_id: request_id,

                },
                success: function(data) {
                    $('#upload_document_list').html(data);

                }
            });
        }
        fetch_files();

        function fetch_result() {
            $.ajax({
                url: "table_fetch/anaylsis_files_fetch_result.php",
                method: "POST",
                data: {
                    request_id: request_id,

                },
                success: function(data) {
                    $('#upload_document_result').html(data);

                }
            });
        }
        fetch_result();
        var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
        modal.show();
    });
});


$(document).ready(function() {


    $(document).ready(function() {
        var notificationModal = new bootstrap.Modal(document.getElementById('notificationModal'), {
            backdrop: 'static', // Prevent closing on outside click
            keyboard: false // Prevent closing with Esc key
        });

        $('#notificationBtn').on('click', function() {
            // Show loading indicator
            $('#notificationTableContainer').html(
                '<p class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading notifications...</p>'
                );

            // Show the modal immediately
            notificationModal.show();

            // Fetch notifications after a short delay
            setTimeout(function() {
                fetchNotifications();
            }, 300); // 300ms delay
        });

        function fetchNotifications() {
            $.ajax({
                url: "function/get_notifications.php",
                method: "GET",
                cache: false,
                success: function(data) {
                    $('#notificationTableContainer').html(data);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching notifications:", error);
                    $('#notificationTableContainer').html(
                        '<p class="text-center text-danger">Error loading notifications. Please try again.</p>'
                        );
                }
            });
        }
    });


    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var dateFrom = $('#filterDateFrom').val();
            var dateTo = $('#filterDateTo').val();
            var serviceType = $('#filterServiceType').val();
            var status = $('#filterStatus').val();

            var rowDate = new Date(data[0]); // Date is now in the first column
            var rowServiceType = data[2]; // Service type is now in the third column
            var rowStatus = data[5]; // Status is now in the sixth column

            var dateCheck = (!dateFrom || !dateTo || (rowDate >= new Date(dateFrom) && rowDate <= new Date(
                dateTo)));

            if (
                dateCheck &&
                (serviceType === "" || rowServiceType.includes(serviceType)) &&
                (status === "" || rowStatus.includes(status))
            ) {
                return true;
            }
            return false;
        }
    );

    var table = $('#client_req_table').DataTable({
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        columnDefs: [{
                width: '100px',
                targets: 0
            }, // Date column
            {
                width: '60px',
                targets: 1
            }, // ID column
            {
                width: 'auto',
                targets: '_all'
            },
            {
                orderable: false,
                targets: 6
            } // Disable sorting for the actions column
        ],
        order: [
            [0, 'desc']
        ] // Sort by date in descending order
    });

    $('#filterDateFrom, #filterDateTo, #filterServiceType, #filterStatus').change(function() {
        table.draw();
    });

    $(window).on('resize', function() {
        table.columns.adjust().draw();
    });
});


// Update the statistical cards with PHP variables
document.getElementById('status-pending').innerText = <?php echo $status_pending; ?>;
document.getElementById('status-approved').innerText = <?php echo $status_approved; ?>;
document.getElementById('status-in-progress').innerText = <?php echo $status_in_progress; ?>;
document.getElementById('status-cancelled').innerText = <?php echo $status_cancelled; ?>;
document.getElementById('status-completed').innerText = <?php echo $status_completed; ?>;

$('.btnMeeting').on('click', function() {
    var request = $(this).data('request');

    $('#m_req_id').val(request.request_id);

    $('#m_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname : 'N/A');
    $('#m_service-type').val(request.service_type || 'N/A');
    $('#m_office-agency').val(request.office_agency || 'N/A');
    $('#m_agency-classification').val(request.agency_classification || 'N/A');
    $('#m_client-type').val(request.client_type || 'N/A');

    $('#m_from_date').val(request.sched_from_date || 'N/A');
    $('#m_to_date').val(request.sched_to_date || 'N/A');

    $('#m_purpose').val(request.selected_purposes || 'N/A');

    request_id = request.request_id;

    function fetch_meeting() {
        $.ajax({
            url: "table_fetch/table.meeting.php",
            method: "POST",
            data: {
                request_id: request_id,
            },
            success: function(data) {
                $('#meeting_table_modal').html(data);
            }
        });
    }
    fetch_meeting();

    var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
    modal.show();
});
</script>