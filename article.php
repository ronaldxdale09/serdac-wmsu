<?php include('include/header.php');
if (isset($_GET['id'])) {

  $id = $_GET['id'];
  $id = preg_replace('~\D~', '', $id);

  
  $sql = "SELECT * FROM articles WHERE article_id = $id";
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $record = $result->fetch_assoc();

    $title = $record['title'];
    $subtitle = $record['subtitle'];
    $image_path = $record['image_path'];
    $content = $record['content'];
    $published_at = $record['published_at'];
    $published_by = $record['published_by'];
    $type = $record['type'];

  }

}

?>


<body>

    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->

    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6><?php echo $subtitle; ?></h6>
                    <h2><?php echo $title; ?></h2>
                </div>
            </div>
        </div>
    </section>

    <section class="meetings-page" id="meetings">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="meeting-single-item">
                                <div class="thumb">
                                    <div class="price">
                                        <span><?php echo $type; ?></span>
                                    </div>
                                    <div class="date">
                                        <h6><?= date("M", strtotime($published_at)); ?>
                                            <span><?= date("d", strtotime($published_at)); ?></span>
                                        </h6>
                                    </div>
                                    <a href="article-details.php?id=<?= $id; ?>"><img
                                            src="admin/images/article/<?php echo $image_path; ?>" alt=""></a>
                                </div>
                                <div class="down-content">
                                    <a href="meeting-details.html">
                                        <h4><?php echo $title; ?></h4>
                                    </a>
                                    <p><?php echo $subtitle; ?></p>
                                    <p class="description">
                                  
                                      <?php echo $content; ?>
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="hours">
                                                <h5>Hours</h5>
                                                <p>Monday - Friday: 07:00 AM - 13:00 PM<br>Saturday- Sunday: 09:00 AM -
                                                    15:00 PM</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="location">
                                                <h5>Location</h5>
                                                <p>Western Mindanao State University,
                                                    <br>Contact Details
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="book now">
                                                <h5>Contact Us</h5>
                                                <p>123456-</p>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="share">
                                                <h5>Share:</h5>
                                                <ul>
                                                    <li><a href="#">Facebook</a>,</li>
                                                    <li><a href="#">Twitter</a>,</li>
                                                    <li><a href="#">Linkedin</a>,</li>
                                                    <li><a href="#">Behance</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="main-button-red">
                                <a href="index.php">Back To Homepage</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="assets/js/custom.js"></script>
    <script>
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


</body>

</html>