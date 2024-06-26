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
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Client List</h1>
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
                            <strong class="card-title">Registered Clients</strong>
                        </div>
                        <div class="card-body">
                            <div class="inventory-table">
                                <hr>
                                <table class="table table-bordered table-hover table-striped" id='client_record'>
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Contact #</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
            $results = mysqli_query($con, "SELECT user_id, fname, midname, lname, contact_no, email FROM users WHERE accessType ='Client'");
            while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td><?php echo $row['user_id']; ?></td>
                                            <td><?php echo $row['fname'] . ' ' . $row['midname'] . ' ' . $row['lname']; ?>
                                            </td>
                                            <td><?php echo $row['contact_no']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary btnEdit"
                                                    data-access='<?php echo json_encode($row['user_id']); ?>'>
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btnDelete"
                                                    data-id='<?php echo $row['user_id']; ?>'>
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
        </div><!-- .content -->


    </div>


</body>



<?php include('modal/account.modal.php');?>

<?php include('include/footer.php');?>
<?php include('include/datatables.php');?>


<script>
$(document).ready(function() {
    var table = $('#client_record').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});
</script>


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