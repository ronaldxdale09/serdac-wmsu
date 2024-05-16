<?php

function getStatCardValue($query) {
    global $con; // Use your actual connection variable here
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    } else {
        return "Error: " . mysqli_error($con);
    }
}

// Queries for total
$sqlT = "SELECT COUNT(*) AS count FROM service_request ";
$sqlA = "SELECT COUNT(*) AS count FROM service_request WHERE status IN ('In Progress', 'Approved', 'Pending')";
$totalReq = getStatCardValue($sqlT);
$totalAct = getStatCardValue($sqlA);

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

// SQL FOR NO CLIENTS
$sql = "SELECT COUNT(*) AS count FROM users";
$totalClients = getStatCardValue($sql);

// SQL FOR NO CLIENTS
$sql = "SELECT COUNT(*) AS count FROM users WHERE isActive = 1";
$totalActiveClients = getStatCardValue($sql);

// MEETING
$sql = "SELECT COUNT(*) AS count FROM sr_meeting";
$totalMeetings  = getStatCardValue($sql);

$sql = "SELECT COUNT(*) AS count FROM sr_meeting WHERE date_time > NOW()";
$upcomingMeetings  = getStatCardValue($sql);

?>
<link rel="stylesheet" href="css/statistic-card.css">

<div class="row">
    <!-- Total Service Requests -->

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted"><b>Total Request </b></p>
                <h5> <b>Active : <?php echo number_format($totalAct, 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                        Total Request:
                        <?php echo number_format($totalReq, 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--secondary">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-list"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted"><b>Data Analysis </b></p>
                <h5> <b>Active : <?php echo number_format($activeDataAnalysis, 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                        Total Request:
                        <?php echo number_format($totalDataAnalysis, 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--primary">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>


    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted nowrap"><b>Capability Training </b></p>
                <h5> <b>Active : <?php echo number_format($activeCapabilityTraining, 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                        Total Request:
                        <?php echo number_format($totalCapabilityTraining, 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--dark">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted nowrap"><b>Technical Assistance </b></p>
                <h5><b>Active : <?php echo number_format($activeTechnicalAssistance, 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                        Total Request:
                        <?php echo number_format($totalTechnicalAssistance, 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--success">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-tools"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted nowrap"><b>No. of Clients </b></p>
                <h5><b>Total Registered : <?php echo number_format($totalClients, 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                        Total Active:
                        <?php echo number_format($totalActiveClients, 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--success">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-tools"></i>
                </div>
            </div>
        </div>
    </div>


   

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted"><b>Meeting Statistics</b></p>
                <h5>Upcoming Meetings: <?php echo number_format($upcomingMeetings, 0); ?></h5>
                <div>
                    <span class="text-muted">
                    Total Meetings: <?php echo number_format($totalMeetings, 0); ?>
                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--primary">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-calendar-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted nowrap"><b>Projects </b></p>
                <h5><b>Total : <?php echo number_format('5', 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                         This Month:
                        <?php echo number_format('3', 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--success">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-tools"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-card__content">
                <p class="text-uppercase mb-1 text-muted nowrap"><b>Library Resource </b></p>
                <h5><b>Total : <?php echo number_format('105', 0); ?></b>
                </h5>
                <div>
                    <span class="text-muted">
                         This Month:
                        <?php echo number_format('203', 0); ?><br>

                    </span>
                </div>
            </div>
            <div class="stat-card__icon stat-card__icon--success">
                <div class="stat-card__icon-circle">
                    <i class="fa fa-tools"></i>
                </div>
            </div>
        </div>
    </div>

</div>