<?php include('include/header.php');


if (isset($_SESSION["userId_code"])) {

    $id = $_SESSION['userId_code'];
    $id = preg_replace('~\D~', '', $id);

    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
            echo "
            <script>
                $(document).ready(function() {

                    $('#fname').val('".$record['fname']. "');
                    $('#mname').val('".$record['midname']. "');
                    $('#lname').val('".$record['lname']. "');
                    $('#email').val('".$record['email']. "');
                    $('#contact').val('".$record['contact_no']. "');               
                });
            </script>
        ";
        }

   


    }
    else{
        header("Location: login.php");
        exit;
    }
?>
<style>
.form-check-label {
    margin-left: 8px;
    /* Adjust as needed for spacing */
    font-weight: normal;
}
</style>

<body>
    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->
    <link rel="stylesheet" href="assets/css/request.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <section class="meetings-page" id="meetings">

        <div class="container">
            <div class="row">

                <div class="col-lg-12">
                    <div class="container-fluid px-1 py-5 mx-auto">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card b-0">
                                    <h3 class="heading">Your Request Details</h3>
                                    <p class="desc">Please complete the form below<span class="yellow-text">

                                            <!-- 7891</span><br>to start protecting your business today!</p> -->

                                            <ul id="progressbar" class="text-center">
                                                <li class="active step0" id="step1"></li>
                                                <li class="step0" id="step2"></li>
                                                <li class="step0" id="step3"></li>
                                                <li class="step0" id="step4">

                                                </li>
                                            </ul>

                                            <form id="reqForm" action="" method="post">

                                                <fieldset class="show">
                                                    <div class="form-card">
                                                        <h5 class="sub-heading mb-4">Personal Details</h5>

                                                        <input type="text" name="user_id" value="<?php echo $id?>"
                                                            hidden>
                                                        <div class="form-group">
                                                            <label class="form-control-label">First Name:</label>
                                                            <input type="text" id="fname" placeholder=""
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-control-label">Mid Name:</label>
                                                            <input type="text" id="mname" placeholder=""
                                                                class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="form-control-label">Last Name:</label>
                                                            <input type="text" id="lname" placeholder=""
                                                                class="form-control" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-control-label">Email:</label>
                                                            <input type="text" id="email" name="email" placeholder=""
                                                                class="form-control" readonly>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-control-label">Contact:</label>
                                                            <input type="text" id="contact" name="mob" placeholder=""
                                                                class="form-control" readonly>
                                                        </div>


                                                        <button id="next1"
                                                            class="btn btn-sm btn-primary  next ">NEXT<span
                                                                class="fa fa-long-arrow-right"></span></button>

                                                    </div>
                                                </fieldset>



                                                <fieldset>
                                                    <div class="form-card">
                                                        <h5 class="sub-heading">Select Service</h5>
                                                        <input type="text" id="selected-service" name="service_type"
                                                            hidden>
                                                        <div class="row px-1 radio-group"
                                                            style="display: flex; justify-content: center;">
                                                            <div class="card-block text-center radio"
                                                                style="flex: 1; margin: 5px;"
                                                                data-option="data-analysis">
                                                                <div class="image-icon">
                                                                    <img class="icon icon1"
                                                                        src="assets/images/predictive-chart.png">
                                                                </div>
                                                                <p class="sub-desc">DATA ANALYSIS</p>
                                                            </div>
                                                            <div class="card-block text-center radio"
                                                                style="flex: 1; margin: 5px;"
                                                                data-option="capability-training">
                                                                <div class="image-icon">
                                                                    <img class="icon icon1"
                                                                        src="assets/images/analysis.png">
                                                                </div>
                                                                <p class="sub-desc">CAPABILITY TRAINING</p>
                                                            </div>
                                                            <div class="card-block text-center radio"
                                                                style="flex: 1; margin: 5px;"
                                                                data-option="technical-assistance">
                                                                <div class="image-icon">
                                                                    <img class="icon icon1 fit-image"
                                                                        src="https://i.imgur.com/ynKYPkk.png">
                                                                </div>
                                                                <p class="sub-desc">TECHNICAL ASSISTANCE</p>
                                                            </div>
                                                        </div>

                                                        <br>


                                                        <button class="btn btn-sm btn-secondary prev"><span
                                                                class="fa fa-long-arrow-left"></span>PREVIOUS</button>
                                                        <button id="next2"
                                                            class="btn  btn-sm btn-primary  next">NEXT<span
                                                                class="fa fa-long-arrow-right"></span></button>


                                                    </div>
                                                </fieldset>

                                                <!-- SERVICES FIELDSETS -->
                                                <fieldset>
                                                    <!-- <div id="selected-service-card"
                                                        class="selected-service text-center"></div> -->

                                                    <div id="service-content"> </div>


                                                    <button class="btn btn-sm btn-secondary prev"><span
                                                            class="fa fa-long-arrow-left"></span>PREVIOUS</button>
                                                    <button id="next3"
                                                        class="btn  btn-sm btn-success  submit">Submit<span
                                                            class="fa fa-long-arrow-right"></span></button>

                                                </fieldset>

                                                <!-- END SERVICE FIELDSETS -->
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
                                            </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
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

    <script>
    $(document).ready(function() {
        // Function to handle showing and hiding fieldsets
        function toggleFieldset(btn, direction) {
            let currentFieldset = btn.closest('fieldset');
            let targetFieldset = (direction === 'next') ? currentFieldset.next('fieldset') : currentFieldset
                .prev('fieldset');

            if (targetFieldset.length) {
                currentFieldset.removeClass("show").hide();
                targetFieldset.addClass("show").show();
                updateProgressBar(direction, targetFieldset);
            }
        }

        // Function to update the progress bar based on the fieldset being shown
        function updateProgressBar(direction, fieldset) {
            let index = $('fieldset').index(fieldset);
            $("#progressbar li").removeClass("active").slice(0, index + 1).addClass("active");
        }

        // Click handler for 'next' buttons
        $('.next').click(function(event) {
            event.preventDefault();
            let current_fs = $(this).closest('fieldset');

            // Validation for service selection
            if (current_fs.find('.radio-group').length > 0 && !isServiceSelected()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please select a service before proceeding.'
                });
                return; // Prevents moving to the next step
            }

            toggleFieldset($(this), 'next');
        });

        // Click handler for 'previous' buttons
        $('.prev').click(function(event) {
            event.preventDefault();
            toggleFieldset($(this), 'prev');
        });

        // Function to check if a service is selected
        function isServiceSelected() {
            return $('#selected-service').val() !== '';
        }

        $('.radio-group .radio').click(function() {
            var serviceType = $(this).data('option');
            fetchServiceContent(serviceType);

            // Set the value of the hidden input to the service type
            $('#selected-service').val(serviceType);

            // Visually indicate which service has been selected
            $('.radio-group .radio').removeClass('selected');
            $(this).addClass('selected');

            // Clone the entire card and display it in the placeholder
            var clonedCard = this.cloneNode(true); // Clone the clicked element
            var selectedServiceCard = document.getElementById('selected-service-card');
            selectedServiceCard.innerHTML = ''; // Clear previous selections
            selectedServiceCard.appendChild(clonedCard); // Append the cloned card
        });

        function fetchServiceContent(serviceType) {
            var url = '';
            switch (serviceType) {
                case 'data-analysis':
                    url = 'request/field.data_analysis.php';
                    break;
                case 'capability-training':
                    url = 'request/field.training.php';
                    break;
                case 'technical-assistance':
                    url = 'request/field.technical.php';
                    break;
                default:
                    $('#service-content').html('<p>Please select a service.</p>');
                    return;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#service-content').html(response);
                },
                error: function() {
                    $('#service-content').html('<p>Error loading the service content.</p>');
                }
            });
        }

        // Submit handling
        $('.submit').click(function(event) {
            event.preventDefault();
            if (validateAllFields()) {
                submitForm();
            }
        });

        function submitForm() {
            let formAction = $('#reqForm').attr('action', 'function/request.action.php').attr('action');
            // Now the formAction variable correctly holds the action URL

            $.ajax({
                type: "POST",
                url: formAction, // Use the action URL from the form
                data: $('#reqForm').serialize(), // Serialize form data for submission
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Request Completed!'
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission failed: ' + error
                    });
                }
            });
        }

        function submitForm() {
            let formAction = $('#reqForm').attr('action', 'function/request.action.php').attr('action');
            // Now the formAction variable correctly holds the action URL

            $.ajax({
                type: "POST",
                url: formAction, // Use the action URL from the form
                data: $('#reqForm').serialize(), // Serialize form data for submission
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Request Completed!'
                        });

                        // Move to the last fieldset
                        let last_fs = $("fieldset").last();
                        $("fieldset.show").removeClass("show").css({
                            'display': 'none',
                            'position': 'relative'
                        });
                        last_fs.addClass("show").css({
                            'display': 'block'
                        });
                        updateProgressBar(true, last_fs);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission failed: ' + error
                    });
                }
            });
        }


        function validateAllFields() {
            let allFieldsValid = true;

            $('.form-card').find('.required').each(function() {
                let input = $(this).closest('.form-group').find('input, select, textarea');

                if (!input.val()) {
                    input.css('border-color', 'red');
                    allFieldsValid = false;
                } else {
                    input.css('border-color', '');
                }
            });

            if (!allFieldsValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill out all required fields.'
                });
            }
            return allFieldsValid;
        }

    });
    </script>


</body>

</html>