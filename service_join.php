<?php include('include/header.php');


// if (isset($_SESSION["userId_code"]) && isset($_SESSION["code"])) {

if (isset($_SESSION["userId_code"])) {
    $id = preg_replace('~\D~', '', $_SESSION['userId_code']);
    $code = preg_replace('~\D~', '', $_GET['inv']);

    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        echo "
        <script>
            $(document).ready(function() {
                $('#fname').val('".$record['fname']."');
                $('#mname').val('".$record['midname']."');
                $('#lname').val('".$record['lname']."');
                $('#email').val('".$record['email']."');
                $('#contact').val('".$record['contact_no']."');               
            });
        </script>
        ";

        
    $sql = "SELECT * FROM service_request WHERE inviteCode = $code";
    $result = $con->query($sql);
    $service = $result->fetch_assoc();
    $req_id =  ($service['request_id']);

    $date = new DateTime($service['scheduled_date']);
    $formattedDate = $date->format('F j, Y'); // Format: March 30, 2024

    
    echo "
    <script>
        $(document).ready(function() {
            $('#agency').val('".$service['office_agency']."');
            $('#agency_class').val('".$service['agency_classification']."');
            $('#client_type').val('".$service['client_type']."');
        });
    </script>
    ";

    
    }
} else {
    header("Location: login.php");
    exit;
}

?>

<body>

    <link rel="stylesheet" href="assets/css/request.css">

    <?php include('include/navbar.php');?>
    <section class="meetings-page" id="meetings">

        <div class="container">
            <div class="row">

                <form id="joinForm" action="" method="post">
                    <div class="col-lg-12">
                        <div class="container-fluid px-1 py-5 mx-auto">
                            <div class="row d-flex justify-content-center">
                                <div class="col-xl-12 col-lg-12">
                                    <div class="card b-0">

                                        <fieldset class="show">
                                            <div class="form-card">
                                                <h5 class="sub-heading mb-4">SERVICE DETAILS</h5>

                                                <div class="row px-1 radio-group"
                                                    style="display: flex; justify-content: center;">
                                                    <?php if ($service['service_type'] == 'data-analysis'): ?>
                                                    <div class="card-block text-center " style="flex: 1; margin: 5px;"
                                                        data-option="data-analysis">
                                                        <div class="image-icon">
                                                            <img class="icon icon1"
                                                                src="assets/images/predictive-chart.png">
                                                        </div>
                                                        <p class="sub-desc">DATA ANALYSIS</p>
                                                    </div>
                                                    <?php endif; ?>

                                                    <?php if ($service['service_type'] == 'capability-training'): ?>
                                                    <div class="card-block text-center " style="flex: 1; margin: 5px;"
                                                        data-option="capability-training">
                                                        <div class="image-icon">
                                                            <img class="icon icon1" src="assets/images/analysis.png">
                                                        </div>
                                                        <p class="sub-desc">CAPABILITY TRAINING</p>
                                                    </div>
                                                    <?php endif; ?>

                                                    <?php if ($service['service_type'] == 'technical-assistance'): ?>
                                                    <div class="card-block text-center  " style="flex: 1; margin: 5px;"
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
                                                    <div class="date-value"><?php echo $formattedDate; ?></div>
                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Office/Agency:
                                                                *</label>
                                                            <input type="text" readonly id="agency"
                                                                class="form-control">
                                                        </div>

                                                    </div>
                                                    <div class="col">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Agency
                                                                Classification:*</label>
                                                            <input type="text" id="agency_class" readonly placeholder=""
                                                                class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Type of Client
                                                                :*</label>
                                                            <input type="text" id="client_type" readonly placeholder=""
                                                                class="form-control">
                                                        </div>
                                                    </div>

                                                </div>

                                                <h5 class="sub-heading mb-4">Personal Details</h5>
                                                <input type="text" name="user_id" value="<?php echo $id?>" hidden>
                                                <input type="text" name="req_id" value="<?php echo $req_id?>" hidden>

                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">First Name:</label>
                                                            <input type="text" id="fname" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Mid Name:</label>
                                                            <input type="text" id="mname" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Last Name:</label>
                                                            <input type="text" id="lname" class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Email:</label>
                                                            <input type="text" id="email" name="email"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-control-label">Contact:</label>
                                                            <input type="text" id="contact" name="mob"
                                                                class="form-control" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="button-container">
                                                    <button id="next3" class="btn btn-success submit">JOIN <span
                                                            class="fa fa-long-arrow-right"></span></button>
                                                </div>

                                            </div>

                                        </fieldset>
                                        <fieldset>
                                            <div class="form-card">
                                                <h5 class="sub-heading mb-4">Request Submitted Successfully!
                                                </h5>
                                                <p class="message">Your request for our services has been
                                                    received.
                                                    We will review the details and get back to you shortly with
                                                    the
                                                    next steps. Confirmation has been sent to your email address
                                                    and
                                                    contact number. Thank you for trusting us with your needs.
                                                </p>
                                                <div class="check">
                                                    <img class="fit-image check-img" style="width:600px"
                                                        src="https://i.imgur.com/QH6Zd6Y.gif">
                                                </div>
                                                <!-- https://i.imgur.com/4Y9xMCF.gif -->
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

        <?php include('include/footer.php');?>

    </section>


    <!-- Scripts -->
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>


</body>

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


        $('#joinForm').attr('action',
            'function/join_req.action.php'); // Corrected form ID
        // Show the loading overlay
        // $('#loadingOverlay').show();
        $.ajax({
            type: "POST",
            url: $('#joinForm').attr('action'), // Corrected form ID
            data: $('#joinForm').serialize(), // Corrected form ID
            success: function(response) {
                if (response.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Request Completed!',
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


        let last_fs = $("fieldset").last();
        $("fieldset.show").removeClass("show").css({
            'display': 'none',
            'position': 'relative'
        });
        last_fs.addClass("show").css({
            'display': 'block'
        });
    });


});
</script>

</html>