<?php include('include/header.php');?>

<body>
<style>
/* Styles for the article image */
.article-image {
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 250px;
}

/* Styles for the article image if using img tags */
.article-image img {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

/* Styles for the meeting item, which is the card container */
.meeting-item {
    width: 100%; /* Full width within its column */
    height: auto; /* Height adjusts to content */
    display: flex;
    flex-direction: column; /* Stack elements vertically */
}

/* Styles for the content area of the card */
.meeting-item .down-content {
    height: 150px; /* Fixed height for content area */
    overflow: hidden; /* Hide overflow */
}

/* Styles for the title in the card */
.meeting-item .down-content h4 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Truncate long titles */
}

/* Styles for the paragraph in the card */
.meeting-item .down-content p {
    display: -webkit-box;
    -webkit-line-clamp: 3; /* Show max 3 lines of text */
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis; /* Truncate long texts */
}

</style>

    <!-- Sub Header -->
    <?php include('include/navbar.php');?>

    <!-- ***** Header Area End ***** -->

    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6>Here are our upcoming meetings</h6>
                    <h2>Upcoming Meetings</h2>
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
                            <div class="filters">
                                <ul>
                                    <li data-filter="*" class="active">All</li>
                                    <li data-filter=".Announcement">Announcement</li>
                                    <li data-filter=".Event">Event</li>
                                    <li data-filter=".Article">Article</li>

                                    <li data-filter=".Meeting">Meeting</li>
                                    <li data-filter=".News">News</li>

                                </ul>
                            </div>
                        </div>
                        <?php
                        $articles = [];
                        $query = "SELECT * FROM articles ORDER BY published_at DESC";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $articles[] = $row;
                            }
                        }
                        ?>

                        <div class="col-lg-12">
                            <div class="row grid">


                                <div class="row grid">
                                    <?php foreach ($articles as $article): ?>
                                    <div
                                        class="col-lg-2 templatemo-item-col all <?php echo htmlspecialchars($article['type']); ?>">
                                        <div class="meeting-item">
                                            <div class="thumb article-image">
                                                <div class="price">
                                                    <span><?php echo htmlspecialchars($article['type']); ?></span>
                                                </div>
                                                <a
                                                    href="article.php?id=<?= htmlspecialchars($article['article_id']); ?>">
                                                    <img src="admin/images/article/<?php echo htmlspecialchars($article['image_path']); ?>"
                                                        alt="">
                                                </a>
                                            </div>
                                            <div class="down-content">
                                                <div class="date">
                                                    <h6><?= date("M", strtotime($article['published_at'])); ?>
                                                        <span><?= date("d", strtotime($article['published_at'])); ?></span>
                                                    </h6>
                                                </div>
                                                <a
                                                    href="article.php?id=<?= htmlspecialchars($article['article_id']); ?>">
                                                    <h4><?= htmlspecialchars($article['title']); ?></h4>
                                                </a>
                                                <p><?= substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>


                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="pagination">
                                <ul>
                                    <li><a href="#">1</a></li>
                                    <li class="active"><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
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
    <script src="assets/js/isotope.js"></script>
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