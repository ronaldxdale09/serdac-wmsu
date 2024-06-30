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
    $author = $record['author'];
    $type = $record['type'];

  }

}

?>

<style>
.share ul {
    list-style: none;
    padding: 0;
    display: flex;
    gap: 10px;
}

.share ul li a {
    display: inline-flex;
    align-items: center;
    padding: 5px 10px;
    background-color: #f0f0f0;
    border-radius: 5px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s ease;
}

.share ul li a:hover {
    background-color: #e0e0e0;
}

.share ul li a i {
    margin-right: 5px;
}
</style>

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
                < class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="meeting-single-item">
                                <div class="thumb">
                                    <div class="price">
                                        <span><?php echo htmlspecialchars($type); ?></span>
                                    </div>
                                    <div class="date">
                                        <h6><?= date("M", strtotime($published_at)); ?>
                                            <span><?= date("d", strtotime($published_at)); ?></span>
                                        </h6>
                                    </div>
                                    <a href="article-details.php?id=<?= $id; ?>">
                                        <img src="admin/images/article/<?php echo htmlspecialchars($image_path); ?>"
                                            alt="<?php echo htmlspecialchars($title); ?>">
                                    </a>
                                </div>
                                <div class="down-content">
                                    <a href="article-details.php?id=<?= $id; ?>">
                                        <h4><?php echo htmlspecialchars($title); ?></h4>
                                    </a>
                                    <p><?php echo htmlspecialchars($subtitle); ?></p>
                                    <div class="description">
                                        <?php echo $content; ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="share">
                                                <h5>Share:</h5>
                                                <?php
                                                // Debugging: Output the current URL
                                                $current_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                                   
                                                $encoded_url = urlencode($current_url);
                                                $encoded_title = urlencode($title);
                                              
                                                ?>
                                                <ul>
                                                    <li>
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encoded_url; ?>"
                                                            target="_blank" rel="noopener noreferrer" class="facebook">
                                                            <i class="fab fa-facebook-f"></i> Facebook
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://twitter.com/intent/tweet?url=<?php echo $encoded_url; ?>&text=<?php echo $encoded_title; ?>"
                                                            target="_blank" rel="noopener noreferrer" class="twitter">
                                                            <i class="fab fa-twitter"></i> Twitter
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $encoded_url; ?>&title=<?php echo $encoded_title; ?>"
                                                            target="_blank" rel="noopener noreferrer" class="linkedin">
                                                            <i class="fab fa-linkedin-in"></i> LinkedIn
                                                        </a>
                                                    </li>
                                                </ul>
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
            <br> <br>
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