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
    $image_path = 'admin/images/article/' . $record['image_path'];
    $image_caption = $record['image_caption'] ?? '';
    $content = $record['content'];
    $published_at = $record['published_at'];
    $author = $record['author'];
    $type = $record['type'];
  }
}
?>

<link rel="stylesheet" type="text/css" href="css/article.css">
<link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@400;700&family=Helvetica+Neue:wght@300;400;700&display=swap" rel="stylesheet">

<body>
    <?php include('include/navbar.php');?>
    
    <main class="main-content">
        <article class="article-container">
            <header class="article-header">
                <h1 class="article-title"><?php echo htmlspecialchars($title); ?></h1>
                <?php if(!empty($subtitle)): ?>
                    <h2 class="article-subtitle"><?php echo htmlspecialchars($subtitle); ?></h2>
                <?php endif; ?>
                
                <div class="article-meta">
                    <span>By <?php echo htmlspecialchars($author); ?></span>
                    <span><?php echo date('F j, Y', strtotime($published_at)); ?></span>
                    <?php if(!empty($type)): ?>
                        <span class="article-type"><?php echo htmlspecialchars($type); ?></span>
                    <?php endif; ?>
                </div>
            </header>

            <?php if(isset($image_path) && file_exists($image_path)): ?>
                <div class="image-container">
                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($title); ?>" class="article-header-image">
                    <?php if(!empty($image_caption)): ?>
                        <p class="image-caption"><?php echo htmlspecialchars($image_caption); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <div class="article-content">
                <?php echo $content; ?>
            </div>

            <div class="share">
                <h5>Share This Article</h5>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>" target="_blank" rel="noopener noreferrer" class="facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&text=<?php echo urlencode($title); ?>" target="_blank" rel="noopener noreferrer" class="twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&title=<?php echo urlencode($title); ?>" target="_blank" rel="noopener noreferrer" class="linkedin">
                            <i class="fab fa-linkedin-in"></i> LinkedIn
                        </a>
                    </li>
                </ul>
            </div>

            <hr class="article-divider">

            <div class="back-to-home">
                <a href="index.php" class="button">← Back to Homepage</a>
            </div>
        </article>
    </main>

    <?php include('include/footer.php'); ?>
</body>

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
</html>