<?php include('include/header.php')?>
<style>
/* ... other styles ... */

#editor-container {
    height: 200px;
}

.custom-file {
    position: relative;
    display: inline-block;
}

#file-chosen {
    margin-left: 10px;
    font-family: Arial, sans-serif;
    color: #666;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

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
                                        <div class="col-2">
                                            <label for="type">Type:</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="Announcement">Announcement</option>
                                                <option value="Meeting">Meeting</option>
                                                <option value="Article">Article</option>
                                                <option value="Event">Event</option>
                                                <option value="News">News</option>
                                            </select>
                                        </div>

                                        <!-- Title Input Field - occupies 9 columns -->
                                        <div class="col-7">
                                            <label for="title" class="required">Title:</label>
                                            <input type="text" class="form-control " id="title" name="title" required>
                                        </div>
                                        <div class="col-3">
                                            <label for="title " class="required">Author:</label>
                                            <input type="text" class="form-control" id="author" name="author" required>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="subtitle" class="required">Subtitle:</label>
                                        <input type="text" class="form-control" id="subtitle" name="subtitle">
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="required">Image:</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="image"
                                                accept="image/*" hidden>
                                            <label class="btn btn-sm btn-secondary" for="image">Choose File</label>
                                            <span id="file-chosen">No file chosen</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content">Content:</label>
                                        <textarea class="form-control" id="content" name="content" rows="8"></textarea>
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
        <script>
        CKEDITOR.replace('content');
        </script>

    </div>
    <?php include('include/footer.php');?>
    <script>
    document.getElementById('image').addEventListener('change', function() {
        var fileName = document.getElementById('image').files[0].name;
        document.getElementById('file-chosen').textContent = fileName;
    });


    $(document).on('click', '#publishBtn', function(e) {
        e.preventDefault();

        var form = document.getElementById('articlePost');
        var formData = new FormData(form);
        // Update content from CKEditor before appending to formData
        formData.set('content', CKEDITOR.instances.content.getData());

        // Check if it's a draft or publish
        formData.append('isDraft', this.id === 'draft');

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
                        text: 'Article successful published!',
                    });

                    // Set all inputs to readonly
                    $('#articlePost input, #articlePost textarea, #articlePost select').prop(
                        'readonly', true);
                    $('#articlePost input[type="file"]').prop('disabled', true);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response,
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Form submission failed!',
                });
            }
        });
    });
    </script>




</body>

</html>