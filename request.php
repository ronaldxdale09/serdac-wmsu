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

                                                        <button id="next2"
                                                            class="btn  btn-sm btn-primary  next">NEXT<span
                                                                class="fa fa-long-arrow-right"></span></button>

                                                        <button class="btn btn-sm btn-secondary prev"><span
                                                                class="fa fa-long-arrow-left"></span>PREVIOUS</button>


                                                    </div>
                                                </fieldset>



                                                <fieldset>
                                                    <div class="form-card">
                                                        <h5 class="sub-heading mb-4">Request Information</h5>

                                                        <div id="selected-service-card"
                                                            class="selected-service text-center"></div>
                                                        <hr>

                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label
                                                                        class="form-control-label required">Office/Agency:
                                                                    </label>
                                                                    <input type="text" id="agency" name="office_agency"
                                                                        placeholder="" class="form-control"
                                                                        onblur="validate2(1)">
                                                                </div>

                                                            </div>
                                                            <div class="col">
                                                                <div class="form-group">
                                                                    <label class="form-control-label required"
                                                                        class="form-control-label">Agency
                                                                        Classification:</label>
                                                                    <select name="agency_classification"
                                                                        class="form-control">
                                                                        <option value="" selected disabled>Select...
                                                                        </option>

                                                                        <option value="Public Agency">Public Agency
                                                                        </option>
                                                                        <option value="Private Agency">Private Agency
                                                                        </option>
                                                                        <option value="Goverment Organization">Goverment
                                                                            Organization</option>

                                                                        <option value="Non-Goverment Organization">
                                                                            Non-Goverment Organization</option>
                                                                        <option value="University">University</option>
                                                                        <option value="Others">Others</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label class="form-control-label required">Type of
                                                                        Client
                                                                        :</label>
                                                                    <select name="client_type" class="form-control">
                                                                        <option value="" selected disabled>Select...
                                                                        </option>
                                                                        <option value="Researcher">Researcher</option>
                                                                        <option value="Goverment Employee">Goverment
                                                                            Employee</option>
                                                                        <option value="Student">Student</option>
                                                                        <option value="Faculty">Faculty</option>
                                                                        <option value="University">University</option>
                                                                        <option value="Development Worker">Development
                                                                            Worker</option>
                                                                        <option value="Policy Maker">Policy Maker
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                      
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="purpose-select" class="required">Purpose of
                                                                Request</label>
                                                            <select id="purpose-select" name="purpose_options[]"
                                                                class="form-control" multiple>
                                                                <option value="Research">Research</option>
                                                                <option value="Data Analysis">Data Analysis</option>
                                                                <option value="Policy Development">Policy Development
                                                                </option>
                                                                <option value="Educational">Educational</option>
                                                                <option value="Technical Support">Technical Support
                                                                </option>
                                                                <!-- Add more options as needed -->
                                                            </select>
                                                            <small class="form-text text-muted">Hold down the Ctrl
                                                                (windows) or Command (Mac) button to select multiple
                                                                options.</small>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="purpose" class="required">Additional
                                                                Details</label>
                                                            <textarea id="purpose" name="additional_purpose_details"
                                                                rows="4" class="form-control"
                                                                placeholder="Please describe the purpose of your request in detail if needed"></textarea>
                                                        </div>


                                                        <button id="next3"
                                                            class="btn  btn-sm btn-success  submit">Submit<span
                                                                class="fa fa-long-arrow-right"></span></button>

                                                        <button class="btn btn-sm btn-secondary prev"><span
                                                                class="fa fa-long-arrow-left"></span>PREVIOUS</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        var serviceCards = document.querySelectorAll('.radio-group .radio');

        serviceCards.forEach(function(card) {
            card.addEventListener('click', function() {
                // Clone the entire card
                var clonedCard = this.cloneNode(true);
                // Get the placeholder element
                var selectedServiceCard = document.getElementById('selected-service-card');
                // Clear previous selections
                selectedServiceCard.innerHTML = '';
                // Append the cloned card to the placeholder element
                selectedServiceCard.appendChild(clonedCard);

                // Extract the service type
                var serviceType = this.getAttribute('data-option');
                // Find or create the input element
                var selectedServiceInput = document.getElementById('selected-service');

                // Set the value of the input to the service type
                selectedServiceInput.value = serviceType;
            });
        });
    });
    </script>


    <script>
    function validateFields(fields, val) {
        let allValid = true;
        fields.forEach((fieldId, index) => {
            if (val >= index + 1 || val == 0) {
                let field = document.getElementById(fieldId);
                if (field.value == "") {
                    field.style.borderColor = "red";
                    allValid = false;
                } else {
                    field.style.borderColor = "green";
                }
            }
        });
        return allValid;
    }

    function validate1(val) {
        return validateFields(["fname", "lname", "email", "mob"], val);
    }

    function validate2(val) {
        return validateFields(["cname", "zip", "state", "city"], val);
    }

    $(document).ready(function() {

        function isServiceSelected() {
            var selectedServiceInput = document.getElementById('selected-service');
            return selectedServiceInput && selectedServiceInput.value !== '';
        }



        function toggleFieldset($btn) {
            let current_fs = $btn.parent().parent();
            let target_fs = $btn.hasClass('next') ? current_fs.next() : current_fs.prev();

            current_fs.removeClass("show");
            target_fs.addClass("show");

            updateProgressBar($btn.hasClass('next'), target_fs);

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            target_fs.css({
                'display': 'block'
            });
        }


        function updateProgressBar(isNext, target_fs) {
            let index = $("fieldset").index(target_fs);
            if (isNext) {
                $("#progressbar li").eq(index).addClass("active");
            } else {
                $("#progressbar li").eq(index + 1).removeClass("active");
            }
        }
        $(".next").click(function(event) {
            event.preventDefault();
            let current_fs = $(this).parent().parent();

            // Check if currently on 'Select Service' fieldset
            if (current_fs.find('.radio-group').length > 0) {
                // Validate service selection only in this fieldset
                if (!isServiceSelected()) {
                    Swal.fire({ // Using SweetAlert for better user experience
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Please select a service before proceeding.'
                    });
                    return false; // Prevents moving to the next step
                }
            }

            toggleFieldset($(this));
        });


        $(".prev").click(function(event) {
            event.preventDefault();
            toggleFieldset($(this));
        });

        $(".submit").click(function(event) {
            event.preventDefault();

            // Flag to check if all required fields are filled
            let allFieldsValid = true;

            // Iterate through each required field and check if it's empty
            $('.form-card').find('.required').each(function() {
                let input = $(this).closest('.form-group').find('input, select, textarea');

                // Check if the input field is empty
                if (!input.val()) {
                    allFieldsValid = false;
                    // Highlight the empty field
                    input.css('border-color', 'red');
                } else {
                    // Reset the border color if the field is not empty
                    input.css('border-color', '');
                }
            });

            // If any required field is empty, show an alert and stop the function
            if (!allFieldsValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please fill out all required fields.'
                });
                return; // Stop the function if validation fails
            }

            // Proceed with the AJAX call if all fields are valid
            $('#reqForm').attr('action', 'function/request.action.php');

            $.ajax({
                type: "POST",
                url: $('#reqForm').attr('action'),
                data: $('#reqForm').serialize(),
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
                        text: 'Form submission failed!'
                    });
                }
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
        });



        $('.radio-group .radio').click(function() {
            $('.radio-group .radio').removeClass('selected');
            $(this).addClass('selected');
        });
    });
    </script>

</body>


</body>

</html>