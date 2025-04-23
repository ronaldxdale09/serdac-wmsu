<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SERDAC-WMSU</title>
    <?php include('include/header.php');?>
    <link rel="stylesheet" href="css/about_us.css">
    <!-- Add Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/carousel.css">
    <style>
     
        .hero-section {
            margin-top: 0;
            padding-top: 0;
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<!-- Include the custom navbar CSS -->

<body>
    <!-- Sub Header -->
    <?php include('include/navbar.php');?>

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
    ?>

    <section class="hero-section" id="top" data-section="section1">
        <div id="newsCarousel" class="carousel-container">
            <div class="carousel-slide active">
                <img src="assets/images/<?php echo htmlspecialchars($webDetails['banner_image']); ?>"
                    alt="Banner Image" />
                <div class="hero-overlay">
                    <div class="hero-content">
                        <span class="hero-badge">Research Excellence</span>
                        <h1>Socio-Economic Research and Data Analytics Center</h1>
                        <p>Enhancing socio-economic research in Luzon, the Visayas, and Mindanao through data-driven insights and innovative research methodologies.</p>
                        <div class="hero-buttons">
                            <a href="request.php" class="btn btn-primary">Request Service</a>
                            <a href="about.php" class="btn btn-outline">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php foreach ($articles as $index => $article): ?>
            <div class="carousel-slide">
                <img src="admin/images/article/<?= htmlspecialchars($article['image_path']); ?>"
                    alt="<?= htmlspecialchars($article['title']); ?>" />
                <div class="hero-overlay">
                    <div class="hero-content">
                        <span class="hero-badge"><?= htmlspecialchars($article['type']); ?></span>
                        <h1>
                            <a href="article.php?id=<?= $article['article_id'] ?>" class="article-link">
                                <?= htmlspecialchars($article['title']); ?>
                            </a>
                        </h1>
                        <p><?= htmlspecialchars($article['subtitle']); ?></p>
                        <div class="hero-buttons">
                            <a href="article.php?id=<?= $article['article_id'] ?>" class="btn btn-primary">Read Article</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="carousel-controls">
            <span class="carousel-control carousel-control-prev" onclick="moveSlide(-1)">
                <i class="fas fa-chevron-left"></i>
            </span>
            <span class="carousel-control carousel-control-next" onclick="moveSlide(1)">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
    </section>

    <section class="services">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Our Services</span>
                <h2 class="section-title">What We Offer</h2>
                <div class="section-divider"></div>
                <p class="section-description">At SERDAC WMSU, we're dedicated to advancing socio-economic research and data analytics. Our
                    offerings are focused on providing top-tier research tools, in-depth data analysis, and dynamic
                    capacity-building programs.</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <img src="assets/images/analysis.png" alt="Training and Consultancy">
                    </div>
                    <h3>Training and Consultancy</h3>
                    <p>The center provides trainings and workshops to initiate research capability building activities</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <img src="assets/images/predictive-chart.png" alt="Data Analytics">
                    </div>
                    <h3>Data Analytics</h3>
                    <p>The center offers in-depth data analytics services, providing socio-economic and statistical analysis to support robust research outcomes.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <img src="assets/images/online-library.png" alt="Publications">
                    </div>
                    <h3>Publications</h3>
                    <p>Selected books and journals on socio-economics, econometrics, statistics, and related subjects are available.</p>
                </div>
            </div>
            
            <div class="cta-container">
                <a href="request.php" class="cta-button">
                    <div class="cta-content">
                        <span class="cta-icon"><i class="fas fa-handshake"></i></span>
                        <div class="cta-text">
                            <span class="cta-primary">Request Service</span>
                            <span class="cta-secondary">Get Started with SERDAC</span>
                        </div>
                    </div>
                    <span class="cta-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">About Us</span>
                <h2 class="section-title">Building a Stronger Research Network</h2>
                <div class="section-divider"></div>
                <p class="section-description"><?php echo htmlspecialchars($webDetails['about_us']); ?></p>
            </div>
            
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3>Mission</h3>
                    <p><?php echo htmlspecialchars($webDetails['mission']); ?></p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3>Vision</h3>
                    <p><?php echo htmlspecialchars($webDetails['vision']); ?></p>
                </div>

                <div class="value-card">
                    <div class="value-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <h3>Goals</h3>
                    <p><?php echo htmlspecialchars($webDetails['goals']); ?></p>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="contact-section">
        <div class="container">
            <div class="section-header">
                <span class="section-subtitle">Get in Touch</span>
                <h2 class="section-title">Contact Us</h2>
                <div class="section-divider"></div>
                <p class="section-description">If you have any inquiries or wish to discuss how we can cater our services to your specific needs,
                    don't hesitate to reach out to us. Our team is dedicated to providing comprehensive research solutions.</p>
            </div>

            <div class="contact-container">
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Location</h4>
                            <p>Western Mindanao State University,<br> Normal Road, Baliwasan,<br> Zamboanga City 7000 Philippines</p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>Email</h4>
                            <p><?php echo htmlspecialchars($webDetails['org_email']); ?></p>
                        </div>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h4>Phone</h4>
                            <p><?php echo htmlspecialchars($webDetails['org_contact']); ?></p>
                        </div>
                    </div>

                    <div class="map-container">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d20361.026531977903!2d122.04334815541998!3d6.913594200000012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x325041dd7a24816f%3A0x51af215fb64cc81a!2sWestern%20Mindanao%20State%20University!5e1!3m2!1sen!2sph!4v1734487486187!5m2!1sen!2sph"
                            frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>

                <div class="contact-form">
                    <form method="post" action="contact.php" role="form" id="contactForm" class="form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" name="subject" id="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" name="message" id="message" rows="5" required></textarea>
                        </div>
                        <div class="form-messages">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="form-submit">
                            <button type="submit" name="submit" class="submit-btn">Send Message</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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