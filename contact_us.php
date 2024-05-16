<?php include('include/header.php');

?>
<link rel="stylesheet" href="css/profile.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

<body>
    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->
    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>CONTACT US</h2>
                    <h6>If you have any questions or concerns, please feel free to reach out to us.</h6>


                </div>
            </div>
        </div>
    </section>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">


            </div>

            <div class="row">

                <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                        <div class="address">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Location:</h4>
                            <p>Western Mindanao State University,
                                <br> Normal Road, Baliwasan,
                                , Zamboanga City 7000 Philippines
                            </p>
                        </div>

                        <div class="email">
                            <i class="fas fa-envelope"></i>
                            <h4>Email:</h4>
                            <p>wmsuserdac@wmsu.edu.ph</p>
                        </div>

                        <div class="phone">
                            <i class="fas fa-phone"></i>
                            <h4>Call:</h4>
                            <p>0917-109-8164</p>
                        </div>

                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3962.8919974525347!2d122.14191481477147!3d6.660305395184244!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMzknMzcuMSJOIDEyMsKwMDgnMzguOCJF!5e0!3m2!1sen!2sph!4v1690030559152!5m2!1sen!2sph"
                            frameborder="0" style="border:0; width: 100%; height: 290px;" allowfullscreen></iframe>
                    </div>


                </div>

                <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                    <form method="post" action="contact.php" role="form" id="contactForm" class="php-email-form">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="name">Your Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Mobile</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Message</label>
                            <textarea class="form-control" name="message" rows="10" required></textarea>
                        </div>
                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit" name="submit">Send Message</button></div>
                    </form>

                </div>

            </div>

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("contactForm").addEventListener("submit", function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this);

                fetch("function/send.contact_us.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.querySelector(".sent-message").style.display = "block";
                            document.querySelector(".error-message").style.display = "none";
                            document.getElementById("contactForm").reset(); // Reset the form
                        } else {
                            document.querySelector(".sent-message").style.display = "none";
                            document.querySelector(".error-message").style.display = "block";
                            document.querySelector(".error-message").innerHTML = data.message;
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        document.querySelector(".sent-message").style.display = "none";
                        document.querySelector(".error-message").style.display = "block";
                        document.querySelector(".error-message").innerHTML =
                            "There was an error submitting your message. Please try again.";
                    });
            });
        });
        </script>

    </section>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <br>


    <?php include('include/footer.php');?>


</body>

</html>