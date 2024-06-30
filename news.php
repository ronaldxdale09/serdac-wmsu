<?php include('include/header.php');?>
<?php
// Enable error reporting for debugging



// Initialize variables
$articles = [];
$total_pages = 0;

// Pagination
$articles_per_page = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $articles_per_page;

// Get total number of articles
$total_query = "SELECT COUNT(*) as total FROM articles WHERE is_draft = 0";
$total_result = mysqli_query($con, $total_query);

if ($total_result) {
    $total_row = mysqli_fetch_assoc($total_result);
    $total_articles = $total_row['total'];
    $total_pages = ceil($total_articles / $articles_per_page);
} else {
    echo "Error executing total query: " . mysqli_error($con);
}

// Get articles for current page
$query = "SELECT * FROM articles WHERE is_draft = 0 ORDER BY published_at DESC LIMIT $start_from, $articles_per_page";
$result = mysqli_query($con, $query);

if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $articles[] = $row;
    }
} else {
    echo "Error executing article query: " . mysqli_error($con);
}
?>

<body>


    <!-- Sub Header -->
    <?php include('include/navbar.php');?>

    <!-- ***** Header Area End ***** -->
    <link rel="stylesheet" type="text/css" href="css/article.css">

    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- <h6>NEWS AND ARTICLES</h6> -->
                    <h2>NEWS AND ARTICLES</h2>
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
                            <div class="row" id="article-container">
                                <?php if (!empty($articles)): ?>
                                <?php foreach ($articles as $article): ?>
                                <div class="col-md-4 article-item <?= htmlspecialchars($article['type']); ?>">
                                    <div class="article-card">
                                        <div class="article-image"
                                            style="background-image: url('admin/images/article/<?= $article['image_path']; ?>');">
                                            <span class="article-status bg-primary">
                                                <?= htmlspecialchars($article['type']); ?>
                                            </span>
                                        </div>
                                        <div class="article-body">
                                            <div class="article-title">
                                                <?= htmlspecialchars($article['title']); ?>
                                            </div>
                                            <div class="article-meta">
                                                <span class="article-author">By
                                                    <?= htmlspecialchars($article['author']); ?></span>
                                                <span class="article-date">
                                                    <?= date('F j, Y \a\t g:i A', strtotime($article['published_at'])); ?>
                                                </span>
                                            </div>
                                            <div class="article-summary">
                                                <?= substr(htmlspecialchars(strip_tags($article['content'])), 0, 100) . '...'; ?>
                                            </div>
                                        </div>
                                        <div class="article-footer">
                                            <div class="article-buttons">
                                                <a href="article.php?id=<?= $article['article_id']; ?>"
                                                    class="btn btn-primary btn-sm read-more">
                                                    Read More
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <p>No articles found.</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if ($total_pages > 0): ?>
                        <div class="col-lg-12">
                            <div class="pagination">
                                <ul>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li <?= $i == $page ? 'class="active"' : '' ?>>
                                        <a href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                        </div>
                        <?php endif; ?>
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize Isotope
        var $grid = $('#article-container').isotope({
            itemSelector: '.article-item',
            layoutMode: 'fitRows'
        });

        // Filter items on button click
        $('.filters ul').on('click', 'li', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });

            // Toggle active class
            $('.filters ul li').removeClass('active');
            $(this).addClass('active');
        });
    });
    </script>
</body>


</body>

</html>