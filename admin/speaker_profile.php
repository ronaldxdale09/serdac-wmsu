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
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Speaker Profile Management</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li class="active">Accounts</li>
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
                            <strong class="card-title">Speaker List</strong>
                        </div>
                        <div class="card-body">
                            <div class="inventory-table">
                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="modal"
                                    data-target="#createSpeakerModal">
                                    <i class="fa fa-user"> <span> NEW SPEAKER </span> </i>
                                </button>
                                <hr>
                                <table class="table table-bordered table-hover table-striped" id='speaker_profile'>
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Address</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Contact #</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                 $results = mysqli_query($con, "SELECT * from speaker_profile"); ?>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td><?php echo $row['speaker_id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['address']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['contact']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary btnEdit">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm  btn-danger btnDelete"><i
                                                        class="fa fa-trash"></i></button>
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
        </div><!-- .content -->


    </div>


</body>



<?php include('modal/speaker_profile.modal.php');?>

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