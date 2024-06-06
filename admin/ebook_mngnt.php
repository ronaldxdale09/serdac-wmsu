<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->


        <div class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">Manage E-Book</strong>
                            <button type="button" class="btn btn-primary btm-sm" data-toggle="modal"
                                data-target="#addEbookModal">
                                <i class="fa fa-plus"></i> Add Ebook
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="inventory-table">
                                <hr>
                                <table class="table table-bordered table-hover table-striped" id='ebook_record'>
                                    <thead>
                                        <tr>

                                            <th scope="col">Cover Page</th>
                                            <th scope="col">#</th>
                                            <th scope="col">Book Title</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Year Published</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $results = mysqli_query($con, "SELECT book_id, book_title, author, year_published, cover_page 
                                        FROM repo_ebooks");
                                        while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td>
                                                <?php if ($row['cover_page']) { ?>
                                                <img src="images/ebook_cover/<?php echo htmlspecialchars($row['cover_page']); ?>"
                                                    alt="Cover Page" style="width: 50px; height: 50px;">
                                                <?php } else { ?>
                                                No Image
                                                <?php } ?>
                                            </td>
                                            <td><?php echo $row['book_id']; ?></td>
                                            <td><?php echo htmlspecialchars($row['book_title']); ?></td>
                                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                                            <td><?php echo htmlspecialchars($row['year_published']); ?></td>

                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary btnEdit"
                                                    data-id='<?php echo $row['book_id']; ?>'>
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btnDelete"
                                                    data-id='<?php echo $row['book_id']; ?>'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- .animated -->
        </div>

    </div>
</body>
<style>
.modal-header {
    background-color: #343a40;
    color: #fff;
    border-bottom: none;
    padding: 20px;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: bold;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: none;
    padding: 20px;
}

.form-control {
    border-radius: 0.25rem;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    border-radius: 0.25rem;
    transition: background-color 0.3s;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    border-radius: 0.25rem;
}

.form-control-file {
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 5px;
}
</style>
<!-- Add Ebook Modal -->
<div class="modal fade" id="addEbookModal" tabindex="-1" role="dialog" aria-labelledby="addEbookModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="function/repo.ebook.action.php" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title" id="addEbookModalLabel">Add Ebook</h6>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bookTitle">Book Title</label>
                        <input type="text" class="form-control" id="bookTitle" name="book_title" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="yearPublished">Year Published</label>
                            <input type="number" class="form-control" id="yearPublished" name="year_published" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="coverPage">Cover Page</label>
                        <input type="file" class="form-control-file" id="coverPage" name="cover_page">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="new_ebook" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include('include/footer.php');?>




<script>
$('.btnDelete').on('click', function() {

    var $tr = $(this).closest('tr');
    var data = $tr.children("td").map(function() {
        return $.trim($(this).text()); // Trimming the text content of each 'td'
    }).get();


    $('#deleteUserId').val(data[0]);

    // Show the Delete User modal
    var modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
    modal.show();
});
</script>

</html>