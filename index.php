<?php include('include/header.php');?>

<body>
    <!-- Sub Header -->
    <?php include('include/navbar.php');?>

    <!-- ***** Header Area End ***** -->

    <!-- ***** Main Banner Area Start ***** -->
    <?php 
    // Assuming $con is your database connection
    $articles = [];
    // Select only the five latest articles
    $query = "SELECT * FROM articles WHERE is_draft = 0 ORDER BY published_at DESC LIMIT 5";
    $result = mysqli_query($con, $query);

    if ($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $articles[] = $row;
        }
    }



        // Don't forget to free the result
        ?>
    <link rel="stylesheet" href="css/carousel.css">

    <section class="section main-banner" id="top" data-section="section1">
        <div id="newsCarousel" class="carousel-container">
            <div class="carousel-slide active">
                <img src="assets/images/<?php echo htmlspecialchars($webDetails['banner_image']); ?>"
                    alt="Banner Image" />
                <div class="video-overlay">
                    <div class="caption">
                        <h6>Socio-Economic Research and Data Analytics Center</h6>
                        <h2>WELCOME TO SERDAC-WMSU</h2>
                        <p>The general objective of the project is to enhance socio-economic research in Luzon, the
                            Visayas, and Mindanao through the establishment of satellite centers, as well as to
                            continuously provide assistance to other research sectors.</p>
                    </div>
                </div>
            </div>

            <?php foreach ($articles as $index => $article): ?>
            <div class="carousel-slide">
                <img src="admin/images/article/<?= htmlspecialchars($article['image_path']); ?>"
                    alt="<?= htmlspecialchars($article['title']); ?>" />
                <div class="video-overlay">
                    <div class="caption">
                        <h6><span class="badge bg-light text-dark"><?= htmlspecialchars($article['type']); ?></span>
                        </h6>
                        <h2>
                            <a href="article.php?id=<?= $article['article_id'] ?>" target="_blank" class="article-link">
                                <?= htmlspecialchars($article['title']); ?>
                            </a>
                        </h2>
                        <p><?= htmlspecialchars($article['subtitle']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <span class="carousel-control carousel-control-prev" onclick="moveSlide(-1)">&#10094;</span>
        <span class="carousel-control carousel-control-next" onclick="moveSlide(1)">&#10095;</span>
    </section>

    <section class="services">
        <div class="bg-light py-2 service-11">
            <div class="container">
                <div class="section-title">
                    <h2>What We Offer</h2>
                    <p>At SERDAC WMSU, we’re dedicated to advancing socio-economic research and data analytics. Our
                        offerings are focused on providing top-tier research tools, in-depth data analysis, and dynamic
                        capacity-building programs. Whether you’re delving into socio-economic studies or seeking
                        data-driven insights, our services are designed to elevate your research and inform impactful
                        decision-making.</p>
                </div>

                <!-- Row  -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-4 wrap-service11-box">
                        <div class="card card-shadow border-0 mb-4">
                            <div class="p-4">
                                <div class="icon-space">
                                    <div class="icon-round text-center d-inline-block ">
                                        <img src="assets/images/analysis.png" alt="">
                                    </div>
                                </div>
                                <h6 class="font-weight-medium">Training and Consultancy</h6>
                                <p class="mt-3">The center provides trainings and workshops to initiate research
                                    capability building
                                    activities</p>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-4 wrap-service11-box">
                        <div class="card card-shadow border-0 mb-4">
                            <div class="p-4">
                                <div class="icon-space">
                                    <div class="icon-round text-center d-inline-block ">
                                        <img src="assets/images/predictive-chart.png" alt="">
                                    </div>
                                </div>
                                <h6 class="font-weight-medium">Data Analytics</h6>
                                <p class="mt-3">The center offers in-depth data analytics services, providing
                                    socio-economic and
                                    statistical analysis to support robust research outcomes.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-4 wrap-service11-box">
                        <div class="card card-shadow border-0 mb-4">
                            <div class="p-4">
                                <div class="icon-space">
                                    <div class="icon-round text-center d-inline-block ">
                                        <img src="assets/images/online-library.png" alt="">
                                    </div>
                                </div>
                                <h6 class="font-weight-medium">Publications</h6>
                                <p class="mt-3">Selected books and journals on socio-economics, econometrics,
                                    statistics, and related
                                    subjects are available.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <a class="btn btn-maroon text-white border-0 btn-md" href="request.php"><span>REQUEST
                                SERVICE</span></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <br>
    <div class="section-container">

        <div class="container">
            <div class="section-title">
                <h2>Building a Stronger Research Network</h2>
                <p><?php echo htmlspecialchars($webDetails['about_us']); ?></p>
            </div>

            <div class="about-content">
                <div class="about-section">
                    <span class="icon">🎯</span> <!-- Replace with actual icons or images -->
                    <h2>Mission</h2>
                    <p><?php echo htmlspecialchars($webDetails['mission']); ?></p>
                </div>

                <div class="about-section">
                    <span class="icon">💡</span> <!-- Replace with actual icons or images -->
                    <h2>Vision</h2>
                    <p><?php echo htmlspecialchars($webDetails['vision']); ?></p>
                </div>

                <div class="about-section">
                    <span class="icon">🏆</span> <!-- Replace with actual icons or images -->
                    <h2>Goals</h2>
                    <p><?php echo htmlspecialchars($webDetails['goals']); ?></p>
                </div>
            </div>

        </div>
    </div>



    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Contact</h2>
                <p>If you have any inquiries or wish to discuss how we can cater our services to your specific needs,
                    don't hesitate to reach out to us. Our team at AetherIO is dedicated to providing comprehensive tech
                    solutions and we value open, direct
                    communication with our clients. We're here to navigate the complexities of the digital world with
                    you.</p>

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
                            <p><?php echo htmlspecialchars($webDetails['org_email']); ?></p>
                        </div>

                        <div class="phone">
                            <i class="fas fa-phone"></i>
                            <h4>Call:</h4>
                            <p><?php echo htmlspecialchars($webDetails['org_contact']); ?></p>
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
        $(document).ready(function() {
            $('#contactForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var url = form.attr('action');

                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if (data.status === 'success') {
                            $('.sent-message').text(data.message).show();
                            $('.error-message').hide();
                        } else {
                            $('.error-message').text(data.message).show();
                            $('.sent-message').hide();
                        }
                        form[0].reset();
                    },
                    error: function() {
                        $('.error-message').text(
                                'An unexpected error occurred. Please try again later.')
                            .show();
                        $('.sent-message').hide();
                    }
                });
            });
        });
        </script>

    </section>
    <?php include('include/footer.php')?>


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
    <script src="assets/js/custom.js"></script>

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


    <script>
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('.carousel-slide');

    function showSlide(index) {
        if (index >= slides.length) currentSlideIndex = 0;
        else if (index < 0) currentSlideIndex = slides.length - 1;
        else currentSlideIndex = index;

        slides.forEach(slide => {
            slide.classList.remove('active');
            slide.style.display = 'none';
        });

        slides[currentSlideIndex].style.display = 'block';
        setTimeout(() => slides[currentSlideIndex].classList.add('active'), 10);
    }

    function moveSlide(step) {
        showSlide(currentSlideIndex + step);
    }

    function autoMoveSlide() {
        moveSlide(1);
    }

    showSlide(currentSlideIndex);
    setInterval(autoMoveSlide, 5000);




    //according to loftblog tut
    $('.nav li:first').addClass('active');

    var showSection = function showSection(section, isAnimate) {
        var
            direction = section.replace(/#/, ''),
            reqSection = $('.section').filter('[data-section="' + direction + '"]'),
            reqSectionPos = reqSection.offset().top - 0;

        if (isAnimate) {
            $('body, html').animate({
                    scrollTop: reqSectionPos
                },
                800);
        } else {
            $('body, html').scrollTop(reqSectionPos);
        }

    };

    var checkSection = function checkSection() {
        $('.section').each(function() {
            var
                $this = $(this),
                topEdge = $this.offset().top - 80,
                bottomEdge = topEdge + $this.height(),
                wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
                var
                    currentId = $this.data('section'),
                    reqLink = $('a').filter('[href*=\\#' + currentId + ']');
                reqLink.closest('li').addClass('active').
                siblings().removeClass('active');
            }
        });
    };

    $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function(e) {
        e.preventDefault();
        showSection($(this).attr('href'), true);
    });

    $(window).scroll(function() {
        checkSection();
    });
    </script>
</body>

</html>