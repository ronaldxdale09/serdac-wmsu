<?php

function getStatCardValue($query) {
    global $conn; // Use your actual connection variable here
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return "Error: " . mysqli_error($conn);
    }
}

// Queries for Data Analysis
$totalDataAnalysisQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'data-analysis'";
$activeDataAnalysisQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'data-analysis' AND status IN ('In Progress', 'Approved', 'Pending')";
$totalDataAnalysis = getStatCardValue($totalDataAnalysisQuery);
$activeDataAnalysis = getStatCardValue($activeDataAnalysisQuery);

// Queries for Technical Assistance
$totalTechnicalAssistanceQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'technical-assistance'";
$activeTechnicalAssistanceQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'technical-assistance' AND status IN ('In Progress', 'Approved', 'Pending')";
$totalTechnicalAssistance = getStatCardValue($totalTechnicalAssistanceQuery);
$activeTechnicalAssistance = getStatCardValue($activeTechnicalAssistanceQuery);

// Queries for Capability Training
$totalCapabilityTrainingQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'capability-training'";
$activeCapabilityTrainingQuery = "SELECT COUNT(*) AS count FROM service_request WHERE service_type = 'capability-training' AND status IN ('In Progress', 'Approved', 'Pending')";
$totalCapabilityTraining = getStatCardValue($totalCapabilityTrainingQuery);
$activeCapabilityTraining = getStatCardValue($activeCapabilityTrainingQuery);

?>

<div class="row">
    <!-- Total Service Requests -->
    <div class="col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="stat-widget-five">
                        <div class="stat-icon dib flat-color-1">
                            <i class="pe-7s-graph"></i>
                        </div>
                        <div class="stat-content">
                            <div class="text-left dib">
                                <div class="stat-text">
                                    <span class="count"><?php echo $activeDataAnalysis; ?></span>/<span class="count"><?php echo $totalDataAnalysis; ?></span>
                                </div>
                                <div class="stat-heading">Data Analysis Requests</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Completed Service Requests -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-2">
                        <i class="pe-7s-check"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS completed_requests FROM service_request WHERE status = 'Completed'"); ?></span>
                            </div>
                            <div class="stat-heading">Completed Requests</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-3">
                        <i class="pe-7s-users"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS active_users FROM users WHERE isActive = 1"); ?></span>
                            </div>
                            <div class="stat-heading">Active Users</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Service Requests -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-4">
                        <i class="pe-7s-clock"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS recent_requests FROM service_request WHERE request_date >= CURDATE() - INTERVAL 1 MONTH"); ?></span>
                            </div>
                            <div class="stat-heading">Recent Requests</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Analysis Requests -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-5">
                        <i class="pe-7s-graph"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS data_analysis_requests FROM sr_dataanalysis"); ?></span>
                            </div>
                            <div class="stat-heading">Data Analysis Requests</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Meetings -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-6">
                        <i class="pe-7s-date"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS upcoming_meetings FROM sr_meeting WHERE date_time > NOW()"); ?></span>
                            </div>
                            <div class="stat-heading">Upcoming Meetings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Requests by Type -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-7">
                        <i class="pe-7s-display2"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS type_requests FROM service_request GROUP BY service_type ORDER BY COUNT(*) DESC LIMIT 1"); ?></span>
                            </div>
                            <div class="stat-heading">Most Common Request Type</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants in Training -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="stat-widget-five">
                    <div class="stat-icon dib flat-color-4">
                        <i class="pe-7s-graph3"></i>
                    </div>
                    <div class="stat-content">
                        <div class="text-left dib">
                            <div class="stat-text"><span
                                    class="count"><?php echo getStatCardValue("SELECT COUNT(*) AS monthly_registrations FROM users WHERE MONTH(registration_date) = MONTH(CURRENT_DATE()) AND YEAR(registration_date) = YEAR(CURRENT_DATE())"); ?></span>
                            </div>
                            <div class="stat-heading">Monthly Registrations</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>