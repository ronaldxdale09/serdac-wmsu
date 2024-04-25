<?php include('include/header.php');



$tab = '';
if (isset($_GET['tab'])) {
    $tab = filter_var($_GET['tab']);




}

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Pending'  ");
$res = mysqli_fetch_array($sql);
$pending_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Approved'  ");
$res = mysqli_fetch_array($sql);
$approved_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='In Progress'  ");
$res = mysqli_fetch_array($sql);
$progress_count = $res['Total'];


$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Cancelled'  ");
$res = mysqli_fetch_array($sql);
$cancel_count = $res['Total'];

$sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE status='Completed'  ");
$res = mysqli_fetch_array($sql);
$completed_count = $res['Total'];

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
                                <span class="badge bg-danger text-light"> <?php echo $pending_count ?> </span>
                            </label>

                            <!-- Scheduled -->
                            <label for="blog" class="blog">
                                <i class="fas fa-calendar-alt"></i> Scheduled
                                <span class="badge bg-danger text-light"> <?php echo $approved_count ?> </span>
                            </label>

                            <!-- Completed -->
                            <label for="drying" class="drying">
                                <i class="fas fa-clock"></i> In Progress
                                <span class="badge bg-danger text-light"> <?php echo $progress_count ?> </span>
                            </label>

                            <!-- Cancelled (Assuming you need this) -->
                            <label for="code" class="code">
                                <i class="fas fa-times-circle"></i> Cancelled
                                <span class="badge bg-danger text-light"><?php echo $cancel_count ?> </span>
                            </label>

                            <!-- Archived -->
                            <label for="help" class="help">
                                <i class="fas fa-archive"></i> Completed
                                <span class="badge bg-danger text-light"> <?php echo $completed_count ?> </span>
                            </label>


                            <div class="slider"></div>
                        </nav>
                        <section>
                            <div class="content content-1">

                                <div class="title"
                                    style="text-align: center; font-size: 24px; font-weight: bold; color: maroon; padding: 15px 0; border-bottom: 3px solid maroon; margin-bottom: 20px; font-family: Arial, sans-serif;">
                                    Pending Service</div>

                                <?php include('request_tab/req.pending.php'); ?>

                            </div>
                            <div class="content content-2">

                                <div class="title"
                                    style="text-align: center; font-size: 24px; font-weight: bold; color: maroon; padding: 15px 0; border-bottom: 3px solid maroon; margin-bottom: 20px; font-family: Arial, sans-serif;">
                                    Scheduled Request</div>
                                <hr>
                                <?php include('request_tab/req.approved.php'); ?>

                            </div>
                            <div class="content content-3">
                                <div class="title"
                                    style="text-align: center; font-size: 24px; font-weight: bold; color: maroon; padding: 15px 0; border-bottom: 3px solid maroon; margin-bottom: 20px; font-family: Arial, sans-serif;">
                                    In Progress Request</div>
                                <hr>
                                <?php include('request_tab/req.progress.php'); ?>

                            </div>
                            <div class="content content-4">
                                <div class="title"
                                    style="text-align: center; font-size: 24px; font-weight: bold; color: maroon; padding: 15px 0; border-bottom: 3px solid maroon; margin-bottom: 20px; font-family: Arial, sans-serif;">
                                    Cancelled Request</div>
                                <?php include('request_tab/req.cancelled.php'); ?>

                            </div>
                            <div class="content content-5">
                                <div class="title"
                                    style="text-align: center; font-size: 24px; font-weight: bold; color: maroon; padding: 15px 0; border-bottom: 3px solid maroon; margin-bottom: 20px; font-family: Arial, sans-serif;">
                                    Completed</div>
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

    <?php include('include/datatables.php');?>

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