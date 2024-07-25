<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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
                        <div class="card-header">
                            <strong class="card-title"> Settings</strong>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile"
                                        role="tab">CMS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="security-tab" data-toggle="tab" href="#security"
                                        role="tab">Registration Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="notifications-tab" data-toggle="tab" href="#notifications"
                                        role="tab">Service Request</a>
                                </li>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" id="appearance-tab" data-toggle="tab" href="#appearance"
                                        role="tab">Appearance</a>
                                </li> -->
                            </ul>
                            <div class="tab-content mt-3" id="settingsTabContent">
                                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                                  <?php include('settings/content_update.php'); ?>
                                </div>
                                <div class="tab-pane fade" id="security" role="tabpanel">
                                <?php include('settings/registration_dropdowns.php'); ?>

                                </div>
                                <div class="tab-pane fade" id="notifications" role="tabpanel">
                                    <h3>Service Request Dropdown</h3>
                                    <?php include('settings/request_dropdown.php'); ?>
                                </div>
                                <div class="tab-pane fade" id="appearance" role="tabpanel">
                                    <h3>Appearance Settings</h3>
                                    <form>
                                        <div class="form-group">
                                            <label for="theme">Theme</label>
                                            <select class="form-control" id="theme">
                                                <option>Light</option>
                                                <option>Dark</option>
                                                <option>System Default</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="fontSize">Font Size</label>
                                            <select class="form-control" id="fontSize">
                                                <option>Small</option>
                                                <option>Medium</option>
                                                <option>Large</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Appearance</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#settingsTabs a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
    </script>
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