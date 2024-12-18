<?php include('include/header.php')?>

<link rel="stylesheet" href="css/article.list.css">
<link rel="stylesheet" href="css/article.modal.css">

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
                                    <li class="active">Articles</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
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
        <!-- Complete HTML -->
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="dashboard-card">
                        <div class="dashboard-card-header">
                            <div class="header-content">
                                <h2 class="dashboard-title">List of Articles</h2>
                                <a href="new_article.php" class="btn-new-article">
                                    <i class="fas fa-plus"></i>
                                    <span>New Article</span>
                                </a>
                            </div>
                        </div>

                        <div class="filters-bar">
                            <div class="search-box">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text" id="searchArticles" placeholder="Search articles...">
                            </div>
                            <div class="filters-group">
                                <select id="typeFilter" class="filter-select">
                                    <option value="">All Types</option>
                                    <option value="Announcement">Announcement</option>
                                    <option value="Meeting">Meeting</option>
                                    <option value="Article">Article</option>
                                    <option value="Event">Event</option>
                                    <option value="News">News</option>
                                </select>
                                <select id="statusFilter" class="filter-select">
                                    <option value="">All Status</option>
                                    <option value="published">Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                                <select id="authorFilter" class="filter-select">
                                    <option value="">All Authors</option>
                                    <?php
                            $authors = array_unique(array_column($articles, 'author'));
                            foreach($authors as $author):
                            ?>
                                    <option value="<?= htmlspecialchars($author) ?>"><?= htmlspecialchars($author) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="dashboard-card-body">
                            <div class="article-grid" id="articlesContainer">
                                <?php foreach ($articles as $article): ?>
                                <div class="article-card" data-type="<?= htmlspecialchars($article['type']) ?>"
                                    data-status="<?= $article['is_draft'] ? 'draft' : 'published' ?>"
                                    data-author="<?= htmlspecialchars($article['author']) ?>"
                                    data-title="<?= htmlspecialchars($article['title']) ?>">
                                    <div class="card-media"
                                        style="background-image: url('images/article/<?= $article['image_path']; ?>')">
                                        <div class="media-overlay"></div>
                                        <div class="card-badges">
                                            <span
                                                class="badge badge-type"><?= htmlspecialchars($article['type']); ?></span>
                                            <span
                                                class="badge <?= $article['is_draft'] ? 'badge-draft' : 'badge-published' ?>">
                                                <?= $article['is_draft'] ? 'Draft' : 'Published' ?>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="card-content">
                                        <h3 class="card-title"><?= htmlspecialchars($article['title']); ?></h3>
                                        <div class="card-meta">
                                            <span class="meta-date">
                                                <i class="far fa-calendar-alt"></i>
                                                <?= date('M d, Y', strtotime($article['published_at'])); ?>
                                            </span>
                                            <span class="meta-author">
                                                <i class="far fa-user"></i>
                                                <?= htmlspecialchars($article['author']); ?>
                                            </span>
                                        </div>
                                        <p class="card-excerpt">
                                            <?= substr(strip_tags($article['content']), 0, 120) . '...'; ?>
                                        </p>

                                        <div class="card-actions">
                                            <a href="../article.php?id=<?= $article['article_id']; ?>"
                                                class="action-btn btn-view" target="_blank">
                                                <i class="fas fa-eye"></i>
                                                <span>View</span>
                                            </a>
                                            <button class="action-btn btn-edit btnEdit"
                                                data-article='<?= htmlspecialchars(json_encode($article), ENT_QUOTES, 'UTF-8'); ?>'>
                                                <i class="fas fa-edit"></i>
                                                <span>Edit</span>
                                            </button>
                                            <button class="action-btn btn-delete btnDelete"
                                                data-article-id="<?= $article['article_id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Delete</span>
                                            </button>
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
        <!-- Footer -->
        <?php include('modal/article.modal.php');?>

    </div>
    <?php include('include/footer.php');?>




    <script>
    tinymce.init({
        selector: '#edit_content',
        plugins: 'lists wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat',
        menubar: false,
        statusbar: false,
        height: 300,
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    });

    // Filter functionality
    function filterArticles() {
        const searchTerm = $('#searchArticles').val().toLowerCase();
        const typeFilter = $('#typeFilter').val();
        const statusFilter = $('#statusFilter').val();
        const authorFilter = $('#authorFilter').val();

        $('.article-card').each(function() {
            const $card = $(this);
            const title = $card.data('title').toLowerCase();
            const type = $card.data('type');
            const status = $card.data('status');
            const author = $card.data('author');

            const matchesSearch = title.includes(searchTerm);
            const matchesType = !typeFilter || type === typeFilter;
            const matchesStatus = !statusFilter || status === statusFilter;
            const matchesAuthor = !authorFilter || author === authorFilter;

            if (matchesSearch && matchesType && matchesStatus && matchesAuthor) {
                $card.removeClass('hidden').fadeIn();
            } else {
                $card.addClass('hidden').fadeOut();
            }
        });
    }

    // Event listeners for filters
    $('#searchArticles').on('input', filterArticles);
    $('#typeFilter, #statusFilter, #authorFilter').on('change', filterArticles);




    $('.btnEdit').on('click', function() {
        try {
            // Get and parse article data
            const article = $(this).data('article');

            // Decode HTML content
            const decodedContent = $('<div/>').html(article.content).text();

            // Populate the modal fields
            $('#edit_article_id').val(article.article_id);
            $('#edit_title').val(article.title);
            $('#edit_author').val(article.author);
            $('#edit_subtitle').val(article.subtitle);
            $('#edit_type').val(article.type);

            // Handle image preview
            if (article.image_path) {
                $('#edit_image_preview')
                    .attr('src', 'images/article/' + article.image_path)
                    .on('error', function() {
                        $(this).attr('src',
                        'assets/img/placeholder.jpg'); // Update with your placeholder path
                    });
                $('#file-chosen').text(article.image_path);
            } else {
                $('#edit_image_preview').attr('src', '').hide();
                $('#file-chosen').text('No file chosen');
            }

            // Initialize or update TinyMCE content
            if (tinymce.get('edit_content')) {
                tinymce.get('edit_content').setContent(decodedContent);
            } else {
                // Initialize TinyMCE if it doesn't exist
                tinymce.init({
                    selector: '#edit_content',
                    plugins: 'lists wordcount code',
                    toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat | code',
                    menubar: false,
                    statusbar: false,
                    height: 300,
                    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
                    entity_encoding: 'raw',
                    setup: function(editor) {
                        editor.on('init', function() {
                            editor.setContent(decodedContent);
                        });
                    }
                });
            }

            // Reset validation states
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            // Show modal
            const editModal = new bootstrap.Modal(document.getElementById('editArticleModal'));
            editModal.show();

            // Focus first input
            $('#editArticleModal').on('shown.bs.modal', function() {
                $('#edit_title').focus();
            });

        } catch (error) {
            console.error('Error in edit handler:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load article data. Please try again.'
            });
        }
    });

    // Handle image input change in edit modal
    $('#edit_image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#edit_image_preview')
                    .attr('src', e.target.result)
                    .show();
            };
            reader.readAsDataURL(file);
            $('#file-chosen').text(file.name);
        } else {
            $('#edit_image_preview').attr('src', '').hide();
            $('#file-chosen').text('No file chosen');
        }
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