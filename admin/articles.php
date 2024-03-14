<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.article-card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #666;
    margin-bottom: 20px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
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

.article-status.published {
    background-color: #28a745;
    /* Green for published articles */
}

.article-status.draft {
    background-color: #ffc107;
    /* Yellow for draft articles */
}
</style>

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Data table</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">List of Articles</strong>
                        </div>
                        <div class="card-body">

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
                                            style="background-image: url('images/article/<?= $article['image_path']; ?>');">
                                            <span
                                                class="article-status <?= $article['is_draft'] ? 'draft' : 'published' ?>">
                                                <?= $article['is_draft'] ? 'Draft' : 'Published' ?>
                                            </span>
                                        </div>
                                        <div class="article-body">
                                            <div class="article-title"><?= htmlspecialchars($article['title']); ?></div>
                                            <div class="article-date">Published on: <?= $article['published_at']; ?>
                                            </div>
                                            <div class="article-summary">
                                                <?= substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?>
                                            </div>
                                            <div class="article-buttons">
                                                <a href="../article.php?id=<?= $article['article_id']; ?>"
                                                    target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                </a>


                                                <button class="btn btn-warning btn-sm"><i
                                                        class="fas fa-edit"></i></button>
                                                <button class="btn btn-danger btn-sm"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>


            </div><!-- .animated -->
        </div><!-- .content -->
        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>


</body>

</html>