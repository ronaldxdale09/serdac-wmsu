<?php include('include/header.php')?>
<style>
/* ... other styles ... */
</style>



<link rel="stylesheet" href="css/new_article.css">

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
                                <h1>Article</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Article</a></li>
                                    <li class="active">New Article</li>
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
                            <strong class="card-title">Create New Article</strong>
                        </div>
                        <div class="card-body">

                            <div class="container">
                                <form action="#" method="post" id="articlePost" enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <!-- Type Dropdown - occupies 2 columns -->


                                        <!-- Title Input Field - occupies 9 columns -->
                                        <div class="col-6">
                                            <label for="title" class="required">Title:</label>
                                            <input type="text" class="form-control " id="title" name="title"
                                                placeholder="Enter Title">
                                        </div>
                                        <div class="col-3">
                                            <label for="type">Type:</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="Announcement">Announcement</option>
                                                <option value="Meeting">Meeting</option>
                                                <option value="Article">Article</option>
                                                <option value="Event">Event</option>
                                                <option value="News">News</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label for="title " class="required">Author:</label>
                                            <input type="text" class="form-control" id="author" name="author"
                                                value="<?php echo  $_SESSION["fullName"]; ?>" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="subtitle" class="required">Subtitle:</label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle"
                                            placeholder="Enter Subtitle">
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="required">Image:</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image"
                                                accept="image/*" hidden>
                                            <label class="btn btn-sm btn-secondary" for="image">Choose File</label>
                                            <span id="file-chosen">No file chosen</span>
                                        </div>
                                        <!-- Add this new div for image preview -->
                                        <div id="imagePreviewContainer" style="display: none; margin-top: 10px;">
                                            <img id="imagePreview" src="#" alt="Preview"
                                                style="max-width: 200px; max-height: 200px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content:</label>
                                        <textarea class="form-control" id="content" name="content" rows="8"></textarea>
                                        <!-- <div id="content" >
                                            <p>Hello World!</p>
                                            <p>Some initial <strong>bold</strong> text</p>
                                            <p><br /></p>
                                        </div> -->
                                    </div>
                                    <button type="button" id="publishBtn" class="btn btn-sm btn-success"><i
                                            class="fa fa-arrow-right"></i> Publish</button>
                                    <button type="button" id="draft" class="btn btn-sm btn-primary"><i
                                            class="fa fa-archive"></i> Draft</button>
                                </form>
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
    <script>
    $(document).ready(function() {
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            plugins: 'lists wordcount',
            toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat',
            menubar: false,
            statusbar: false,
            height: 300,
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
        });

        // Update file input label and show image preview when a file is selected
        $('#image').on('change', function() {
            var file = this.files[0];
            if (file) {
                // Update filename display
                $('#file-chosen').text(file.name);

                // Show image preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreviewContainer').fadeIn('fast');
                }
                reader.readAsDataURL(file);
            } else {
                // Reset everything if no file is selected
                $('#file-chosen').text('No file chosen');
                $('#imagePreviewContainer').hide();
                $('#imagePreview').attr('src', '#');
            }
        });

        // Function to validate form
        function validateForm() {
            var title = $('#title').val().trim();
            var author = $('#author').val().trim();
            var subtitle = $('#subtitle').val().trim();
            var image = $('#image')[0].files[0];
            var content = tinymce.get('content').getContent().trim();

            if (!title) {
                Swal.fire('Error', 'Please enter a title', 'info');
                return false;
            }
            if (!author) {
                Swal.fire('Error', 'Please enter an author', 'info');
                return false;
            }
            if (!subtitle) {
                Swal.fire('Error', 'Please enter a subtitle', 'info');
                return false;
            }
            if (!image) {
                Swal.fire('Error', 'Please select an image', 'info');
                return false;
            }
            if (!content) {
                Swal.fire('Error', 'Please enter some content', 'info');
                return false;
            }
            return true;
        }

        // Handle form submission
        $('#publishBtn, #draft').on('click', function(e) {
            e.preventDefault();

            if (!validateForm()) {
                return;
            }

            var form = $('#articlePost')[0];
            var formData = new FormData(form);
            var isDraft = this.id === 'draft';

            // Update content from TinyMCE
            formData.set('content', tinymce.get('content').getContent());
            formData.set('isDraft', isDraft ? '1' : '0'); // Explicitly set 1 or 0

            $.ajax({
                type: "POST",
                url: 'function/articles_action.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Article successfully ' + (isDraft ?
                                'saved as draft!' : 'published!'),
                            showConfirmButton: true,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'articles.php';
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission failed: ' + error
                    });
                }
            });
        });
    });
    </script>




</body>

</html>