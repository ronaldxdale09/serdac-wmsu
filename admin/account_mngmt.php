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
                                <h1>Schedules</h1>
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
                            <strong class="card-title">Account Management</strong>
                        </div>
                        <div class="card-body">
                            <div class="inventory-table">
                                <button type="button" class="btn btn-sm btn-dark text-white" data-toggle="modal"
                                    data-target="#createUserModal">
                                    <i class="fa fa-user"> </i> NEW ADMIN
                                </button>
                                <hr>
                                <table class="table table-bordered table-hover table-striped" id='acc_record'>
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Contact #</th>
                                            <th scope="col">Username</th>

                                            <th width="25%" scope="col">Access</th>
                                            <th>User Type</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <?php
                                        $results = mysqli_query($con, "SELECT * from users where accessType !='Client' ");
                                        ?>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($results)) { 
                                                $adminAccessArray = json_decode($row['adminAccess'], true);
                                                $adminAccessFormatted = implode(', ', $adminAccessArray); // Format the array as a comma-separated string
                                            ?>
                                        <tr>
                                            <td>
                                                <?php echo $row['user_id']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['fname'].' '.$row['midname'].' '.$row['lname']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['contact_no']; ?>
                                            </td>
                                            <td>
                                                <?php echo $row['email']; ?>
                                            </td>
                                            <td>
                                                <?php foreach ($adminAccessArray as $access) { ?>
                                                <span
                                                    class="badge badge-info"><?php echo htmlspecialchars($access); ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php echo $row['accessType']; ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-secondary btnEdit"
                                                    data-user='<?php echo json_encode($row); ?>'>
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btnDelete"><i
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



<?php include('modal/account.modal.php');?>

<?php include('include/footer.php');?>
<?php include('include/datatables.php');?>


<script>
$(document).ready(function() {
    var table = $('#acc_record').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});
</script>



<script>
$(document).ready(function() {
    $('.btnEdit').on('click', function() {
        var user = $(this).data('user');

        // Fill the form with user data
        $('#updateUserId').val(user.user_id);
        $('#updateFname').val(user.fname);
        $('#updateMidname').val(user.midname);
        $('#updateLname').val(user.lname);
        $('#updateEmail').val(user.email);
        $('#updateContactNo').val(user.contact_no);
        $('#updateUserType').val(user.userType);

        var userAccess = user.adminAccess ? JSON.parse(user.adminAccess) : [];
        $('#updateUserForm .form-check-input').each(function() {
            var checkbox = $(this);
            checkbox.prop('checked', userAccess.includes(checkbox.val()));
        });

        if (userAccess.includes('superadmin')) {
            $('#updateSuperadmin').prop('checked', true);
            $('#updateUserForm .form-check-input:not(#updateSuperadmin)').prop('disabled', true);
        } else {
            $('#updateSuperadmin').prop('checked', false);
            $('#updateUserForm .form-check-input:not(#updateSuperadmin)').prop('disabled', false);
        }

        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('updateUserModal'));
        modal.show();
    });

    $('#updateSuperadmin').on('change', function() {
        if (this.checked) {
            $('#updateUserForm .form-check-input:not(#updateSuperadmin)').prop('disabled', true);
        } else {
            $('#updateUserForm .form-check-input:not(#updateSuperadmin)').prop('disabled', false);
        }
    });
});


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