<?php include('include/header.php');



$tab = '';
if (isset($_GET['tab'])) {
    $tab = filter_var($_GET['tab']);
}





?>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel='stylesheet' href='css/tab-style.css'>
<link rel='stylesheet' href='css/request.css'>

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
                    <div class="col-sm-8">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li class="active">Request Record</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="inventory-table">
                    <div class="wrapper" id="myTab">
                        <input type="radio" name="slider" id="home" <?php if ($tab == '') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>
                        <input type="radio" name="slider" id="blog" <?php if ($tab == '2') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>
                        <input type="radio" name="slider" id="drying" <?php if ($tab == '3') {
                                                                                    echo 'checked';
                                                                                } else {
                                                                                    echo '';
                                                                                } ?>>
                        <input type="radio" name="slider" id="code" <?php if ($tab == '4') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>
                        <input type="radio" name="slider" id="help" <?php if ($tab == '5') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>

                        <nav>
                            <!-- Pending Approval -->
                            <label for="home" class="home">
                                <i class="fas fa-hourglass-half"></i> Pending
                                <span class="badge bg-danger text-light"> <?php echo '1' ?> </span>
                            </label>

                            <!-- Scheduled -->
                            <label for="blog" class="blog">
                                <i class="fas fa-calendar-alt"></i> Scheduled
                                <span class="badge bg-danger text-light"> <?php echo '1' ?> </span>
                            </label>

                            <!-- Completed -->
                            <label for="drying" class="drying">
                                <i class="fas fa-check-circle"></i> Completed
                                <span class="badge bg-danger text-light"> <?php echo '1' ?> </span>
                            </label>

                            <!-- Cancelled (Assuming you need this) -->
                            <label for="code" class="code">
                                <i class="fas fa-times-circle"></i> Cancelled
                                <span class="badge bg-danger text-light"><?php echo '1' ?> </span>
                            </label>

                            <!-- Archived -->
                            <label for="help" class="help">
                                <i class="fas fa-archive"></i> Archived
                                <span class="badge bg-danger text-light"> <?php echo '1' ?> </span>
                            </label>


                            <div class="slider"></div>
                        </nav>
                        <section>
                            <div class="content content-1">

                                <div class="title">PENDING REQUEST </div>
                                <hr>
                                <?php include('request_tab/req.pending.php'); ?>

                            </div>
                            <div class="content content-2">

                                <div class="title">SCHEDULED </div>
                                <hr>
                                <?php include('request_tab/req.approved.php'); ?>

                            </div>
                            <div class="content content-3">
                                <div class="title">COMPLETED</div>
                            </div>
                            <div class="content content-4">
                                <div class="title">CANCELLED</div>
                            </div>
                            <div class="content content-5">
                                <div class="title">ARCHIVED</div>
                        </section>
                    </div>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>
    <?php include('modal/approved.modal.php');?>

    <?php include('modal/request.modal.php');?>


</body>

</html>

<script>
$(document).ready(function() {
    // $('.btnEdit').on('click', function() {
    //     var request = $(this).data('request');


    //     $('#user-id').val(request.fname);

    //     var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
    //     modal.show();

    // });


    // // Handling click event for Delete button
    // $('.btnDelete').on('click', function() {

    //     var $tr = $(this).closest('tr');
    //     var data = $tr.children("td").map(function() {
    //         return $.trim($(this).text()); // Trimming the text content of each 'td'
    //     }).get();


    //     $('#deleteUserId').val(data[0]);

    //     // Show the Delete User modal
    //     $('#deleteUserModal').modal('show');
    // });
});
</script>