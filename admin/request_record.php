<?php 

include('include/header.php');

$tab = '';
if (isset($_GET['tab'])) {
    $tab = filter_var($_GET['tab']);

}

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Pending'  ");
$res = mysqli_fetch_array($sql);
$pending_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Approved'  ");
$res = mysqli_fetch_array($sql);
$approved_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='In Progress'  ");
$res = mysqli_fetch_array($sql);
$progress_count = $res['Total'];


$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Cancelled'  ");
$res = mysqli_fetch_array($sql);
$cancel_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Completed'  ");
$res = mysqli_fetch_array($sql);
$completed_count = $res['Total'];

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<style>
/* ... other styles ... */

#editor-container {
    height: 200px;
}

.custom-file {
    position: relative;
    display: inline-block;
}

#file-chosen {
    margin-left: 10px;
    font-family: Arial, sans-serif;
    color: #666;
}


/* Basic styling for the modal backdrop */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    /* Semi-transparent background */
    z-index: 200;
    /* Lower than modal but higher than other content */
}

/* Styling for the modal itself */
.modal {
    position: fixed;
    z-index: 201;

    overflow: hidden;
    outline: none;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel='stylesheet' href='css/tab-style.css'>
<link rel='stylesheet' href='css/request.css'>
<link rel="stylesheet" href="css/assmt.form.view.css">

<body>

    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->

    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <?php include('include/navbar.php')?>


        <div class="content">
            <div class="container-fluid">
                <div class="inventory-table">
                    <div class="wrapper" id="myTab">
                        <!-- Radio inputs for tab control -->
                        <input type="radio" name="slider" id="home" <?php echo ($tab == '') ? 'checked' : ''; ?>>
                        <input type="radio" name="slider" id="blog" <?php echo ($tab == '2') ? 'checked' : ''; ?>>
                        <input type="radio" name="slider" id="drying" <?php echo ($tab == '3') ? 'checked' : ''; ?>>
                        <input type="radio" name="slider" id="code" <?php echo ($tab == '4') ? 'checked' : ''; ?>>
                        <input type="radio" name="slider" id="help" <?php echo ($tab == '5') ? 'checked' : ''; ?>>

                        <!-- Tab Navigation -->
                        <nav class="tab-navigation">
                            <label for="home" class="home tab-label">
                                <div class="tab-content">
                                    <i class="fas fa-hourglass-half"></i>
                                    <span class="tab-text">Pending</span>
                                    <span class="badge badge-pending"><?php echo $pending_count ?></span>
                                </div>
                            </label>

                            <label for="blog" class="blog tab-label">
                                <div class="tab-content">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span class="tab-text">Scheduled</span>
                                    <span class="badge badge-scheduled"><?php echo $approved_count ?></span>
                                </div>
                            </label>

                            <label for="drying" class="drying tab-label">
                                <div class="tab-content">
                                    <i class="fas fa-clock"></i>
                                    <span class="tab-text">In Progress</span>
                                    <span class="badge badge-progress"><?php echo $progress_count ?></span>
                                </div>
                            </label>

                            <label for="code" class="code tab-label">
                                <div class="tab-content">
                                    <i class="fas fa-times-circle"></i>
                                    <span class="tab-text">Cancelled</span>
                                    <span class="badge badge-cancelled"><?php echo $cancel_count ?></span>
                                </div>
                            </label>

                            <label for="help" class="help tab-label">
                                <div class="tab-content">
                                    <i class="fas fa-archive"></i>
                                    <span class="tab-text">Completed</span>
                                    <span class="badge badge-completed"><?php echo $completed_count ?></span>
                                </div>
                            </label>

                            <div class="slider"></div>
                        </nav>

                        <!-- Tab Content Sections -->
                        <section class="tab-sections">
                            <!-- Pending Section -->
                            <div class="content content-1">
                                <header class="section-header">
                                    <h2 class="section-title">Pending Service</h2>
                                </header>
                                <?php include('request_tab/req.pending.php'); ?>
                            </div>

                            <!-- Scheduled Section -->
                            <div class="content content-2">
                                <header class="section-header">
                                    <h2 class="section-title">Scheduled Request</h2>
                                </header>
                                <?php include('request_tab/req.approved.php'); ?>
                            </div>

                            <!-- In Progress Section -->
                            <div class="content content-3">
                                <header class="section-header">
                                    <h2 class="section-title">In Progress Request</h2>
                                    <div class="action-buttons">
                                        <button class="btn btn-primary new-service-btn" data-toggle="modal"
                                            data-target="#serviceRequestModal">
                                            <i class="fas fa-plus"></i>
                                            <span>New Service</span>
                                        </button>
                                        <button type="button" class="btn btn-secondary" id="viewEmailLogsBtn">
                                            <i class="fas fa-envelope-open-text"></i>
                                            <span>View Email Logs</span>
                                        </button>
                                    </div>
                                </header>
                                <?php include('request_tab/req.progress.php'); ?>
                            </div>

                            <!-- Cancelled Section -->
                            <div class="content content-4">
                                <header class="section-header">
                                    <h2 class="section-title">Cancelled Request</h2>
                                </header>
                                <?php include('request_tab/req.cancelled.php'); ?>
                            </div>

                            <!-- Completed Section -->
                            <div class="content content-5">
                                <header class="section-header">
                                    <h2 class="section-title">Completed</h2>
                                </header>
                                <?php include('request_tab/req.completed.php'); ?>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <!-- Footer -->

    </div>

</body>
<?php include('modal/pending.modal.php');?>
<?php include('modal/approved.modal.php');?>
<?php include('modal/progress.modal.php');?>
<?php include('modal/service_meeting.php');?>

<?php include('modal/service_participants.php');?>
<?php include('modal/service_speaker.php');?>
<?php include('modal/service_analysis.req.php');?>
<?php include('modal/new_service.php');?>

<?php include('include/footer.php');?>


<!-- Email Logs Modal -->
<div class="modal fade" id="emailLogsModal" tabindex="-1" aria-labelledby="emailLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="emailLogsModalLabel">Email Logs</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="emailLogsTable">
                        <thead>
                            <tr>
                                <th>Date Sent</th>
                                <th>Service Type</th>
                                <th>Recipients</th>
                                <th>Subject</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Email logs will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#viewEmailLogsBtn').click(function() {
        loadEmailLogs();
    });

    function loadEmailLogs() {
        $.ajax({
            url: 'fetch/fetch_email_logs.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.logs && Array.isArray(response.logs)) {
                    populateEmailLogsTable(response.logs);
                    var emailLogs = new bootstrap.Modal(document
                        .getElementById(
                            'emailLogsModal'));
                    emailLogs.show(); // Show the next modal
                } else {
                    console.error("Invalid response format:", response);
                    alert("Failed to load email logs. Invalid data received.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching email logs:", error);
                alert("Failed to load email logs. Please try again.");
            }
        });
    }

    function populateEmailLogsTable(logs) {
        const tbody = $('#emailLogsTable tbody');
        tbody.empty();

        if (logs.length === 0) {
            tbody.append('<tr><td colspan="4" class="text-center">No email logs found.</td></tr>');
        } else {
            logs.forEach(log => {
                const row = `<tr>
                   <td>${new Date(log.sent_at).toLocaleString()}</td>
                    <td>${log.service_type}</td>
                    <td>${log.recipients}</td>
                    <td>${log.subject}</td>
                </tr>`;
                tbody.append(row);
            });
        }
    }

    $(document).on('click', '.view-email', function() {
        const logId = $(this).data('log-id');
        // Implement logic to fetch and display full email content
        // This could open another modal or expand the row to show details
        alert('Viewing email log with ID: ' + logId);
    });
});
</script>

</html>