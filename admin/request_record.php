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
/* Premium Dashboard Statistics Styling */
.stats-container {
    margin-bottom: 1.5rem;
    padding: 0.25rem;
}

.stat-card {
    background: #FFFFFF;
    border-radius: 8px;
    padding: 1rem;
    height: 175px; /* Fixed height for all cards */
    border: none;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    transition: all 0.2s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(to right, rgba(255,255,255,0.1), rgba(255,255,255,0.3));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
}

.stat-card:hover::before {
    opacity: 1;
}

.stat-header {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.5rem;
}

.stat-icon {
    font-size: 1.2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem;
    border-radius: 8px;
    background: rgba(var(--icon-color), 0.08);
    margin-right: 0.75rem;
}

.stat-card:nth-child(1) .stat-icon {
    --icon-color: 13, 110, 253;
    color: rgb(var(--icon-color));
}

.stat-card:nth-child(2) .stat-icon {
    --icon-color: 25, 135, 84;
    color: rgb(var(--icon-color));
}

.stat-card:nth-child(3) .stat-icon {
    --icon-color: 255, 193, 7;
    color: rgb(var(--icon-color));
}

.stat-card:nth-child(4) .stat-icon {
    --icon-color: 220, 53, 69;
    color: rgb(var(--icon-color));
}

.stat-title {
    color: #6c757d;
    font-size: 0.7rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin: 0;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0.25rem 0;
    font-family: 'Inter', sans-serif;
    line-height: 1.2;
}

.stat-trend {
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
    margin-bottom: 0.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(0,0,0,0.04);
}

.trend-up {
    color: #198754;
}

.trend-down {
    color: #dc3545;
}

.stat-details {
    font-size: 0.7rem;
    color: #6c757d;
    flex-grow: 1;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(0,0,0,0.2) transparent;
}

.stat-details::-webkit-scrollbar {
    width: 4px;
}

.stat-details::-webkit-scrollbar-track {
    background: transparent;
}

.stat-details::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 4px;
}

.stat-details ul {
    margin: 0;
    padding: 0;
    list-style: none;
}

.stat-details li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.2rem 0;
    border-bottom: 1px dashed rgba(0,0,0,0.03);
}

.stat-details li:last-child {
    border-bottom: none;
}

/* Priority Colors */
.priority-critical {
    color: #dc3545;
    display: flex;
    align-items: center;
}

.priority-high {
    color: #ffc107;
    display: flex;
    align-items: center;
}

.priority-medium {
    color: #0dcaf0;
    display: flex;
    align-items: center;
}

.priority-critical::before,
.priority-high::before,
.priority-medium::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    margin-right: 6px;
}

.priority-critical::before {
    background-color: #dc3545;
}

.priority-high::before {
    background-color: #ffc107;
}

.priority-medium::before {
    background-color: #0dcaf0;
}

/* Revenue and Client Info */
.info-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.2rem 0;
}

.info-label {
    color: #6c757d;
    font-size: 0.7rem;
}

.info-value {
    font-weight: 500;
    color: #2c3e50;
    font-size: 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stat-card {
        height: 160px;
        padding: 0.75rem;
    }
    
    .stat-value {
        font-size: 1.25rem;
    }
    
    .stat-icon {
        font-size: 1rem;
        padding: 0.4rem;
    }
}

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
                <!-- Statistics Dashboard -->
                <div class="stats-container">
                    <div class="row g-3">
                        <!-- Response Time Card -->
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <div class="stat-title">Response Time</div>
                                        <div class="stat-value" id="avgResponseTime">--</div>
                                    </div>
                                </div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span id="responseTimeTrend">--</span>
                                </div>
                                <div class="stat-details" id="responseTimeDetails"></div>
                            </div>
                        </div>

                        <!-- Success Rate Card -->
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div>
                                        <div class="stat-title">Success Rate</div>
                                        <div class="stat-value" id="completionRate">--</div>
                                    </div>
                                </div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span id="completionRateTrend">--</span>
                                </div>
                                <div class="stat-details" id="completionRateDetails"></div>
                            </div>
                        </div>

                        <!-- Monthly Overview Card -->
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                    <div>
                                        <div class="stat-title">Monthly Overview</div>
                                        <div class="stat-value" id="monthlyRequests">--</div>
                                    </div>
                                </div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-up"></i>
                                    <span id="monthlyRequestsTrend">--</span>
                                </div>
                                <div class="stat-details">
                                    <div class="info-item">
                                        <span class="info-label">Revenue</span>
                                        <span class="info-value" id="monthlyRevenue">₱--</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Clients</span>
                                        <span class="info-value" id="uniqueClients">--</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card -->
                        <div class="col-md-3">
                            <div class="stat-card">
                                <div class="stat-header">
                                    <div class="stat-icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                    <div>
                                        <div class="stat-title">Pending Requests</div>
                                        <div class="stat-value" id="overdueRequests">--</div>
                                    </div>
                                </div>
                                <div class="stat-trend">
                                    <i class="fas fa-arrow-down"></i>
                                    <span id="overdueRequestsTrend">--</span>
                                </div>
                                <div class="stat-details" id="overduePriority"></div>
                            </div>
                        </div>
                    </div>
                </div>

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
    // Existing email logs code
    $('#viewEmailLogsBtn').click(function() {
        loadEmailLogs();
    });

    // New Statistics Functions
    function loadStatistics() {
        $.ajax({
            url: 'fetch/fetch_request_statistics.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    updateStatistics(response.data);
                } else {
                    console.error("Failed to load statistics:", response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching statistics:", error);
            }
        });
    }

    function updateStatistics(data) {
        // Response Time Card
        $('#avgResponseTime').text(data.avgResponseTime.overall + ' hrs');
        $('#responseTimeTrend').text(data.trends['average response time'] + '% from last month');
        
        let responseTimeHtml = '<ul>';
        for (const [type, time] of Object.entries(data.avgResponseTime.by_type)) {
            responseTimeHtml += `<li><span>${type}</span><span>${time} hrs</span></li>`;
        }
        responseTimeHtml += '</ul>';
        $('#responseTimeDetails').html(responseTimeHtml);

        // Completion Rate Card
        $('#completionRate').text(data.completionRate.overall + '%');
        $('#completionRateTrend').text(data.trends['completion rate'] + '% from last month');
        
        let completionHtml = '<ul>';
        completionHtml += `<li><span>Pending</span><span>${data.completionRate.status_breakdown.pending}</span></li>`;
        completionHtml += `<li><span>In Progress</span><span>${data.completionRate.status_breakdown.in_progress}</span></li>`;
        completionHtml += `<li><span>Completed</span><span>${data.completionRate.status_breakdown.completed}</span></li>`;
        completionHtml += `<li><span>Cancelled</span><span>${data.completionRate.status_breakdown.cancelled}</span></li>`;
        completionHtml += '</ul>';
        $('#completionRateDetails').html(completionHtml);

        // Monthly Overview Card
        $('#monthlyRequests').text(data.monthlyRequests.total);
        $('#monthlyRequestsTrend').text(data.trends['total requests this month'] + '% from last month');
        $('#monthlyRevenue').text('₱' + data.monthlyRequests.total_revenue.toLocaleString());
        $('#uniqueClients').text(data.monthlyRequests.unique_clients);

        // Overdue Requests Card
        $('#overdueRequests').text(data.overdueRequests.total);
        
        let overdueHtml = '<ul>';
        overdueHtml += `<li><span class="priority-critical">Critical</span><span>${data.overdueRequests.by_priority.critical}</span></li>`;
        overdueHtml += `<li><span class="priority-high">High</span><span>${data.overdueRequests.by_priority.high}</span></li>`;
        overdueHtml += `<li><span class="priority-medium">Medium</span><span>${data.overdueRequests.by_priority.medium}</span></li>`;
        overdueHtml += '</ul>';
        $('#overduePriority').html(overdueHtml);

        // Update trend indicators
        updateTrendIndicators(data.trends);
    }

    function updateTrendIndicators(trends) {
        $('.stat-trend').each(function() {
            const $trend = $(this);
            const $icon = $trend.find('i');
            const type = $trend.closest('.stat-card').find('.stat-title').text().toLowerCase();
            const trendValue = trends[type] || 0;

            if (trendValue > 0) {
                $trend.removeClass('trend-down').addClass('trend-up');
                $icon.removeClass('fa-arrow-down').addClass('fa-arrow-up');
            } else {
                $trend.removeClass('trend-up').addClass('trend-down');
                $icon.removeClass('fa-arrow-up').addClass('fa-arrow-down');
            }
        });
    }

    // Auto-refresh statistics every 5 minutes
    function initializeStatisticsRefresh() {
        loadStatistics(); // Initial load
        setInterval(loadStatistics, 300000); // Refresh every 5 minutes
    }

    // Initialize statistics on page load
    initializeStatisticsRefresh();

    // Existing email logs functions
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