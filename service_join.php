<?php
include('include/header.php');

if (!isset($_SESSION["userId_code"])) {
    header("Location: login.php");
    exit;
}

$id = preg_replace('~\D~', '', $_SESSION['userId_code']);
$code = preg_replace('~\D~', '', $_GET['inv']);

// Initialize variables
$user = [];
$service = [];
$training = [];
$scheduleDate = "Not scheduled";

// Fetch user information
$userQuery = $con->prepare("SELECT * FROM users WHERE user_id = ?");
$userQuery->bind_param("i", $id);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows > 0) {
    $user = $userResult->fetch_assoc();
}

// Fetch service request information
$serviceQuery = $con->prepare("SELECT * FROM service_request WHERE inviteCode = ?");
$serviceQuery->bind_param("i", $code);
$serviceQuery->execute();
$serviceResult = $serviceQuery->get_result();

if ($serviceResult->num_rows > 0) {
    $service = $serviceResult->fetch_assoc();
    $req_id = $service['request_id'];
    
    // Fetch training information
    $trainingQuery = $con->prepare("SELECT s_from, s_to FROM sr_training WHERE request_id = ?");
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
}

$fullName = trim(($user['fname'] ?? '') . ' ' . ($user['midname'] ?? '') . ' ' . ($user['lname'] ?? ''));
$requestDate = $service['request_date'] ?? 'N/A';
$status = $service['status'] ?? 'N/A';
$selectedPurposes = $service['selected_purposes'] ?? 'N/A';
$officeAgency = $service['office_agency'] ?? 'N/A';
$agencyClassification = $service['agency_classification'] ?? 'N/A';
$clientType = $service['client_type'] ?? 'N/A';
$email = $user['email'] ?? 'N/A';
$contactNo = $user['contact_no'] ?? 'N/A';
?>


<body>

    <link rel="stylesheet" href="assets/css/request.css">

    <?php include('include/navbar.php'); ?>
    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="row">
                <form id="joinForm" action="function/join_req.action.php" method="post">
                    <div class="col-lg-12">
                        <div class="container-fluid px-1 py-5 mx-auto">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card b-0">
                                        <fieldset class="show">
                                            <div class="form-card">
                                                <h5 class="sub-heading mb-4">REQUEST DETAILS</h5>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Request Date:</label>
                                                            <input type="text" class="form-control" readonly
                                                                value="<?php echo $service['request_date']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Status:</label>
                                                            <input type="text" class="form-control" readonly
                                                                value="<?php echo $service['status']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Selected Purposes:</label>
                                                            <input type="text" class="form-control" readonly
                                                                value="<?php echo $service['selected_purposes']; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <h5 class="sub-heading mb-4">SERVICE DETAILS</h5>
                                                <div class="row px-1 radio-group text-center">
                                                    <?php if ($service['service_type'] == 'data-analysis'): ?>
                                                    <div class="card-block flex-fill m-2" data-option="data-analysis">
                                                        <div class="image-icon">
                                                            <img class="icon icon1"
                                                                src="assets/images/predictive-chart.png">
                                                        </div>
                                                        <p class="sub-desc">DATA ANALYSIS</p>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if ($service['service_type'] == 'capability-training'): ?>
                                                    <div class="card-block flex-fill m-2"
                                                        data-option="capability-training">
                                                        <div class="image-icon">
                                                            <img class="icon icon1" src="assets/images/analysis.png">
                                                        </div>
                                                        <p class="sub-desc">CAPABILITY TRAINING</p>
                                                    </div>
                                                    <?php endif; ?>
                                                    <?php if ($service['service_type'] == 'technical-assistance'): ?>
                                                    <div class="card-block flex-fill m-2"
                                                        data-option="technical-assistance">
                                                        <div class="image-icon">
                                                            <img class="icon icon1 fit-image"
                                                                src="https://i.imgur.com/ynKYPkk.png">
                                                        </div>
                                                        <p class="sub-desc">TECHNICAL ASSISTANCE</p>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="schedule-date-label">
                                                    <label>Schedule Date:</label>
                                                    <div class="date-value">
                                                        <?php echo htmlspecialchars($scheduleDate); ?></div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Office/Agency:</label>
                                                            <input type="text" readonly id="agency" class="form-control"
                                                                value="<?php echo $service['office_agency']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Agency
                                                                Classification:</label>
                                                            <input type="text" id="agency_class" readonly
                                                                class="form-control"
                                                                value="<?php echo $service['agency_classification']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Type of Client:</label>
                                                            <input type="text" id="client_type" readonly
                                                                class="form-control"
                                                                value="<?php echo $service['client_type']; ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h5 class="sub-heading mb-4">Personal Details</h5>
                                                <input type="hidden" name="user_id" value="<?php echo $id ?>">
                                                <input type="hidden" name="req_id" value="<?php echo $req_id ?>">
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Name:</label>
                                                            <input type="text" id="fname" class="form-control" readonly
                                                                value="<?php echo $fullName; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Email:</label>
                                                            <input type="text" id="email" name="email"
                                                                class="form-control" readonly
                                                                value="<?php echo $user['email']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Contact:</label>
                                                            <input type="text" id="contact" name="mob"
                                                                class="form-control" readonly
                                                                value="<?php echo $user['contact_no']; ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="button-container text-center">
                                                    <button id="next3" class="btn btn-success submit">JOIN <span
                                                            class="fa fa-long-arrow-right"></span></button>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card text-center">
                                                <h5 class="sub-heading mb-4">Request Submitted Successfully!</h5>
                                                <p class="message">Your request for our services has been received. We
                                                    will review the details and get back to you shortly with the next
                                                    steps. Confirmation has been sent to your email address and contact
                                                    number. Thank you for trusting us with your needs.</p>
                                                <div class="check">
                                                    <img class="fit-image check-img" style="width:600px"
                                                        src="https://i.imgur.com/QH6Zd6Y.gif">
                                                </div>
                                                <br>
                                                <div class="main-button-red">
                                                    <a href="index.php">Return to User Portal</a>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php include('include/footer.php'); ?>
    </section>

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
    $(document).ready(function() {
        function toggleFieldset($btn) {
            let current_fs = $btn.parent().parent();
            let target_fs = $btn.hasClass('next') ? current_fs.next() : current_fs.prev();

            current_fs.removeClass("show");
            target_fs.addClass("show");

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            target_fs.css({
                'display': 'block'
            });
        }

        $(".next, .prev").click(function(event) {
            event.preventDefault();
            toggleFieldset($(this));
        });

        $(".submit").click(function(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Processing...',
                text: 'Please wait while your request is being processed.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: "POST",
                url: $('#joinForm').attr('action'),
                data: $('#joinForm').serialize(),
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Request Completed!',
                        }).then(() => {
                            let last_fs = $("fieldset").last();
                            $("fieldset.show").removeClass("show").css({
                                'display': 'none',
                                'position': 'relative'
                            });
                            last_fs.addClass("show").css({
                                'display': 'block'
                            });
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission failed!',
                    });
                }
            });
        });
    });
    </script>
</body>

</html>