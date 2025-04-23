<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERDAC-WMSU - Service Join</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/service_join.css">
</head>
<body>
    <?php
    include('include/header.php');

    // Check if user is logged in
    if (!isset($_SESSION['userId_code'])) {
        $_SESSION['redirect_after_login'] = "service_join.php" . (isset($_GET['inv']) ? "?inv=" . $_GET['inv'] : "");
        header("Location: login.php");
        exit();
    }

    $id = preg_replace('~\D~', '', $_SESSION['userId_code']);
    $code = $_GET['inv'] ?? '';

    // Initialize variables
    $user = [];
    $service = [];
    $training = [];
    $speakers = [];
    $scheduleDate = "Not scheduled";
    $alreadyJoined = false;
    $allowParticipants = 1;
    $quotaMet = false;

    // Only proceed if invitation code is provided
    if (!empty($code)) {
        try {
            // Fetch service request information
            $serviceQuery = $con->prepare("SELECT * FROM service_request WHERE inviteCode = ?");
            $serviceQuery->bind_param("s", $code);
            $serviceQuery->execute();
            $serviceResult = $serviceQuery->get_result();
            
            if ($serviceResult->num_rows > 0) {
                $service = $serviceResult->fetch_assoc();
                $req_id = $service['request_id'];

                // Check if user has already joined this training
                $joinCheckQuery = $con->prepare("SELECT * FROM service_participant WHERE user_id = ? AND request_id = ?");
                $joinCheckQuery->bind_param("ii", $id, $req_id);
                $joinCheckQuery->execute();
                $alreadyJoined = $joinCheckQuery->get_result()->num_rows > 0;
                $joinCheckQuery->close();

                // Fetch training information
                $trainingQuery = $con->prepare("SELECT s_from, s_to, title, venue FROM sr_training WHERE request_id = ?");
                $trainingQuery->bind_param("i", $req_id);
                $trainingQuery->execute();
                $trainingResult = $trainingQuery->get_result();
                
                if ($trainingResult->num_rows > 0) {
                    $training = $trainingResult->fetch_assoc();
                    $formattedFromDate = new DateTime($training['s_from']);
                    $formattedToDate = new DateTime($training['s_to']);
                    $fromDate = $formattedFromDate->format('F j, Y');
                    $toDate = $formattedToDate->format('F j, Y');
                    $scheduleDate = ($fromDate == $toDate) ? $fromDate : $fromDate . ' - ' . $toDate;
                }
                $trainingQuery->close();

                // Fetch speakers and their topics
                $speakersQuery = $con->prepare("
                    SELECT sp.name, sr.topic, sp.profile_image 
                    FROM sr_speaker sr
                    LEFT JOIN speaker_profile sp ON sp.speaker_id = sr.speaker_id
                    WHERE sr.request_id = ?
                ");
                $speakersQuery->bind_param("i", $req_id);
                $speakersQuery->execute();
                $speakersResult = $speakersQuery->get_result();
                while ($row = $speakersResult->fetch_assoc()) {
                    $speakers[] = $row;
                }
                $speakersQuery->close();

                // Check if participants are allowed and if quota is met
                $allowParticipants = $service['allowParticipants'] ?? 1;
                $participants = $service['participants'] ?? 0;
                $participantsQuota = $service['participants_quota'] ?? null;
                $quotaMet = $participantsQuota !== null && $participants >= $participantsQuota;
            }
            $serviceQuery->close();

            // Fetch user information
            $userQuery = $con->prepare("SELECT * FROM users WHERE user_id = ?");
            $userQuery->bind_param("i", $id);
            $userQuery->execute();
            $userResult = $userQuery->get_result();
            if ($userResult->num_rows > 0) {
                $user = $userResult->fetch_assoc();
            }
            $userQuery->close();
        } catch (Exception $e) {
            error_log("Error in service_join.php: " . $e->getMessage());
        }
    }
    ?>

    <?php include('include/navbar.php'); ?>
    
    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form id="joinForm" action="function/join_req.action.php" method="post">
                        <div class="card">
                            <?php if ($alreadyJoined): ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-info-circle fa-4x text-warning mb-4"></i>
                                    <h3 class="mb-4">Already Joined</h3>
                                    <p class="message">You have already joined this training session. If you need any assistance, please contact the administrator.</p>
                                    <div class="main-button-red mt-4">
                                        <a href="index.php"><i class="fas fa-home me-2"></i>Return to Homepage</a>
                                    </div>
                                </div>
                            </div>
                            <?php elseif ($allowParticipants == 0): ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-clock fa-4x text-warning mb-4"></i>
                                    <h3 class="mb-4">Training Closed</h3>
                                    <p class="message">This training session is either closed or has already ended. For inquiries, please contact the administrator.</p>
                                    <div class="main-button-red mt-4">
                                        <a href="index.php"><i class="fas fa-home me-2"></i>Return to Homepage</a>
                                    </div>
                                </div>
                            </div>
                            <?php elseif ($quotaMet): ?>
                            <div class="card-body">
                                <div class="text-center">
                                    <i class="fas fa-users-slash fa-4x text-warning mb-4"></i>
                                    <h3 class="mb-4">Quota Reached</h3>
                                    <p class="message">The participant quota for this training session has been reached. Please contact the administrator for more information.</p>
                                    <div class="main-button-red mt-4">
                                        <a href="index.php"><i class="fas fa-home me-2"></i>Return to Homepage</a>
                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="card-body">
                                <?php if (empty($code)): ?>
                                <div class="invitation-card">
                                    <div class="info-alert">
                                        <i class="fas fa-info-circle"></i>
                                        <p>Please enter your invitation code to join this training session.</p>
                                    </div>
                                    <div class="form-group">
                                        <label for="invCode">Invitation Code</label>
                                        <input type="text" id="invCode" name="invCode" class="form-control" required placeholder="Enter your invitation code">
                                    </div>
                                    <div class="button-container text-center">
                                        <button type="button" id="checkInvCode" class="btn-verify">
                                            <i class="fas fa-arrow-right me-2"></i>Verify Code
                                        </button>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="form-card">
                                    <h4 class="sub-heading">Training Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-chalkboard-teacher me-2"></i>Title</label>
                                                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($training['title'] ?? 'N/A'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-map-marker-alt me-2"></i>Venue</label>
                                                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($training['venue'] ?? 'N/A'); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="schedule-date-label">
                                        <label><i class="fas fa-calendar-alt me-2"></i>Schedule</label>
                                        <div class="date-value">
                                            <?php 
                                            if (isset($training['s_from']) && isset($training['s_to'])) {
                                                $fromTime = new DateTime($training['s_from']);
                                                $toTime = new DateTime($training['s_to']);
                                                echo htmlspecialchars($fromTime->format('F j, Y g:i A')) . ' - ' . 
                                                     htmlspecialchars($toTime->format('g:i A'));
                                            } else {
                                                echo 'Schedule to be announced';
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <?php if (!empty($speakers)): ?>
                                    <h4 class="sub-heading mt-4">Speakers</h4>
                                    <div class="speakers-grid">
                                        <?php foreach ($speakers as $speaker): ?>
                                        <div class="speaker-card">
                                            <div class="speaker-image">
                                                <?php if (!empty($speaker['profile_image'])): ?>
                                                    <img src="admin/images/speakers/<?php echo htmlspecialchars($speaker['profile_image']); ?>" alt="<?php echo htmlspecialchars($speaker['name']); ?>">
                                                <?php else: ?>
                                                    <i class="fas fa-user-circle"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="speaker-info">
                                                <h5><?php echo htmlspecialchars($speaker['name']); ?></h5>
                                                <p class="speaker-topic"><?php echo htmlspecialchars($speaker['topic']); ?></p>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>

                                    <h4 class="sub-heading mt-4">Organization Details</h4>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-building me-2"></i>Office/Agency</label>
                                                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($service['office_agency'] ?? 'N/A'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><i class="fas fa-tag me-2"></i>Agency Classification</label>
                                                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($service['agency_classification'] ?? 'N/A'); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-card mt-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <i class="fas fa-users"></i>
                                                    <div class="stat-info">
                                                        <label>Current Participants</label>
                                                        <span class="stat-value"><?php echo htmlspecialchars($service['participants'] ?? '0'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="stat-item">
                                                    <i class="fas fa-user-plus"></i>
                                                    <div class="stat-info">
                                                        <label>Participant Quota</label>
                                                        <span class="stat-value"><?php echo htmlspecialchars($service['participants_quota'] ?? 'Unlimited'); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="sub-heading mt-4">Service Type</h4>
                                    <div class="row radio-group">
                                        <?php
                                        $serviceTypes = [
                                            'data-analysis' => ['icon' => 'assets/images/predictive-chart.png', 'title' => 'DATA ANALYSIS'],
                                            'capability-training' => ['icon' => 'assets/images/analysis.png', 'title' => 'CAPABILITY TRAINING'],
                                            'technical-assistance' => ['icon' => 'assets/images/technical-support.png', 'title' => 'TECHNICAL ASSISTANCE']
                                        ];

                                        foreach ($serviceTypes as $type => $details) {
                                            if (isset($service['service_type']) && $service['service_type'] == $type) {
                                                echo '<div class="col-md-4">';
                                                echo '<div class="card-block selected" data-type="' . $type . '">';
                                                echo '<div class="image-icon"><img src="' . $details['icon'] . '" alt="' . $details['title'] . '"></div>';
                                                echo '<p class="sub-desc">' . $details['title'] . '</p>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <input type="hidden" name="req_id" value="<?php echo htmlspecialchars($req_id ?? ''); ?>">
                                    
                                    <div class="button-container text-center mt-4">
                                        <button type="submit" class="btn-verify">
                                            <i class="fas fa-check-circle me-2"></i>Join Training
                                        </button>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include('include/footer.php'); ?>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
        // Handle invitation code verification
        $("#checkInvCode").click(function(event) {
            event.preventDefault();
            const invCode = $("#invCode").val().trim();
            
            if (!invCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Empty Code',
                    text: 'Please enter an invitation code.',
                });
                return;
            }

            Swal.fire({
                title: 'Verifying...',
                text: 'Please wait while we check your invitation code.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "POST",
                url: "function/check_inv_code.php",
                data: { invCode: invCode },
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Invitation code verified successfully.',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = `service_join.php?inv=${encodeURIComponent(invCode)}`;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Code',
                            text: 'The invitation code you entered is invalid or expired.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while verifying the code. Please try again.',
                    });
                }
            });
        });

        // Handle form submission
        $("#joinForm").on('submit', function(event) {
            event.preventDefault();
            const submitButton = $(this).find('button[type="submit"]');
            const originalText = submitButton.html();

            submitButton.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Processing...');

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Joined Successfully!',
                            text: 'You have successfully joined the training session.',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.href = 'profile.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to join the training session.'
                        });
                        submitButton.prop('disabled', false).html(originalText);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing your request.'
                    });
                    submitButton.prop('disabled', false).html(originalText);
                }
            });
        });

        // Add smooth animations for cards
        $('.card').each(function(index) {
            $(this).css('opacity', '0');
            $(this).css('transform', 'translateY(20px)');
            setTimeout(() => {
                $(this).css('transition', 'all 0.5s ease');
                $(this).css('opacity', '1');
                $(this).css('transform', 'translateY(0)');
            }, index * 100);
        });
    });
    </script>
</body>
</html>