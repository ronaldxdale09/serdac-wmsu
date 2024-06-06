<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<style>
.article-card {
    border: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #666;
    margin-bottom: 20px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 350px;
    /* Fixed height for all cards */
    width: 90%;
    /* Ensure all cards have the same width */
}

.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.article-image {
    width: 100%;
    height: 150px;
    /* Fixed height for images */
    background-size: cover;
    background-position: center;
    position: relative;
}

.article-body {
    padding: 12px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.article-title {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 8px;
    /* Add some space below the title */
}

.article-date {
    font-size: 13px;
    color: #666;
    margin-bottom: 8px;
}

.article-summary {
    font-size: 13px;
    margin-bottom: 10px;
    flex-grow: 1;
    /* Allow summary to grow and fill the space */
    overflow: hidden;
    /* Hide overflow text */
}

.article-buttons {
    display: flex;
    gap: 5px;
    /* Small gap between buttons */
}

.article-buttons .btn {
    padding: 2px 6px;
    /* Smaller padding */
    font-size: 12px;
    /* Smaller font size */
    border-radius: 4px;
    /* Adjusted border radius */
    display: flex;
    align-items: center;
    justify-content: center;
    text-transform: uppercase;
    font-weight: bold;
}

.article-buttons .btn i {
    margin-right: 3px;
}


.article-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

.article-image {
    width: 100%;
    height: 150px; /* Fixed height for images */
    background-size: cover;
    background-position: center;
    position: relative;
}

.article-status,
.article-type {
    position: absolute;
    top: 10px;
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 14px;
    color: #fff;
}

.article-status {
    right: 10px;
    background-color: rgba(0, 0, 0, 0.7);
}

.article-status.published {
    background-color: #28a745;
}

.article-status.draft {
    background-color: #ffc107;
}

.article-type {
    left: 10px;
    background-color: rgba(0, 0, 0, 0.7);
}

/* Reduce gutter space between columns */
.row>[class*='col-'] {
    padding-right: 5px;
    padding-left: 5px;
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">List of Articles</strong>
                            <a href="create_article.php" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> New Article
                            </a>
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
                                <div class="col-md-4 d-flex align-items-stretch">
                                    <div class="article-card">
                                        <div class="article-image"
                                            style="background-image: url('images/article/<?= $article['image_path']; ?>');">
                                            <span
                                                class="article-status <?= $article['is_draft'] ? 'draft' : 'published' ?>">
                                                <?= $article['is_draft'] ? 'Draft' : 'Published' ?>
                                            </span>
                                            <span class="article-type">
                                                <?= htmlspecialchars($article['type']); ?>
                                            </span>
                                        </div>
                                        <div class="article-body">
                                            <div>
                                                <div class="article-title"><?= htmlspecialchars($article['title']); ?>
                                                </div>
                                                <div class="article-date">Published on: <?= $article['published_at']; ?>
                                                </div>
                                                <div class="article-summary">
                                                    <?= substr(strip_tags($article['content']), 0, 100) . '...'; ?>
                                                </div>
                                            </div>
                                            <div class="article-buttons">
                                                <a href="../article.php?id=<?= $article['article_id']; ?>"
                                                    target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button class="btn btn-warning btn-sm btnEdit"
                                                    data-article='<?= json_encode($article); ?>'>
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm btnDelete"
                                                    data-article-id="<?= $article['article_id']; ?>">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>
    <?php include('modal/article.modal.php');?>




    <script>
    CKEDITOR.replace('edit_content');

    $('.btnEdit').on('click', function() {
        var article = $(this).data('article');

        $('#edit_article_id').val(article.article_id);
        $('#edit_title').val(article.title);
        $('#edit_author').val(article.author);
        $('#edit_subtitle').val(article.subtitle);
        $('#edit_image_preview').attr('src', 'images/article/' + article.image_path);

        CKEDITOR.instances['edit_content'].setData(article.content);

        var modal = new bootstrap.Modal(document.getElementById('editArticleModal'));
        modal.show();
    });
    $('#edit_image').on('change', function() {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#edit_image_preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    });


    $('.btnDelete').on('click', function() {
        var articleId = $(this).data('article-id');
        $('#delete_article_id').val(articleId);

        var modal = new bootstrap.Modal(document.getElementById('deleteArticleModal'));
        modal.show();
    });
    </script>
</body>

</html>