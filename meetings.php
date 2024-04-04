<?php include('include/header.php');?>

<body>
    <style>
    .article-card {
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #666;
        width: 350px;
        margin-bottom: 20px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: space-between
            /* Organizes content vertically */
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        /* Adjusted to space-between */
        align-items: stretch;
    }


    .col-md-4 {
        display: flex;
        flex: 0 0 auto;
        /* Override flex-grow to prevent stretching */
        width: 350px;
        /* Fixed width; can be adjusted as necessary */
        margin: 10px;
        /* Keep or adjust the margin as necessary */
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .article-image {
        width: 100%;
        position: relative;

        height: 150px;
        /* Reduced height */
        background-size: cover;
        background-position: center;
    }

    .article-body {
        flex-grow: 1;
        /* Makes the article body expand to fill available space */

        background-color: aliceblue;
        padding: 12px;
        /* Reduced padding */
    }

    .article-title {
        font-size: 16px;
        /* Adjusted font size */
        font-weight: bold;
    }

    .article-date {
        font-size: 13px;
        /* Adjusted font size */
        color: #666;
        margin-bottom: 8px;
    }

    .article-summary {
        font-size: 13px;
        /* Adjusted font size */
        margin-bottom: 10px;
    }

    .article-buttons .btn {
        margin-right: 5px;
        padding: 5px 10px;
        /* Reduced padding */
        font-size: 13px;
        /* Adjusted font size */
    }

    .article-status {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    .article-footer {
        background-color: #ededed;
        margin-top: auto;
        /* Pushes the footer to the bottom */
        padding: 10px;
        /* Match the padding of the body if necessary */
    }

    .article-buttons {
        text-align: center;
        /* Aligns the buttons to the right */
    }

    .article-status.published {
        background-color: #28a745;
        /* Green for published articles */
    }

    .article-status.draft {
        background-color: #ffc107;
        /* Yellow for draft articles */
    }

    @media (max-width: 768px) {
        .row {
            grid-template-columns: repeat(2, 1fr);
            /* 2 columns for smaller screens */
        }
    }

    @media (max-width: 576px) {
        .row {
            grid-template-columns: 1fr;
            /* 1 column for extra small screens */
        }
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

                        <div class="col-lg-12">
                            <div class="row">



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
                                <div class="row">
                                    <?php foreach ($articles as $article): ?>
                                    <div class="col-md-4">
                                        <div class="article-card">
                                            <div class="article-image"
                                                style="background-image: url('admin/images/article/<?= $article['image_path']; ?>');">
                                                <span class="article-status bg-primary ">
                                                    <?= htmlspecialchars($article['type']); ?>

                                                </span>
                                            </div>
                                            <div class="article-body">
                                                <div class="article-title">
                                                    <?= htmlspecialchars($article['title']); ?>
                                                </div>
                                                <div class="article-date">Published on:
                                                    <?= $article['published_at']; ?>
                                                </div>
                                                <div class="article-summary">
                                                <?= substr(htmlspecialchars(strip_tags($article['content'])), 0, 100) . '...'; ?>
                                                </div>
                                            </div>
                                            <div class="article-footer">
                                                <div class="article-buttons">
                                                    <a href="article.php?id=<?= $article['article_id']; ?>"
                                                        target="_blank" class="btn btn-dark btn-sm">
                                                        <i class="fas fa-eye"> VIEW</i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php endforeach; ?>
                                </div>


                            </div><!-- .animated -->
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
        <br> <Br>

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