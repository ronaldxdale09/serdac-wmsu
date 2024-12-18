<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">
<link rel="stylesheet" href="css/acc_manage.css">

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
                                <h1>Accounts</h1>
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
                                <div class="table-responsive custom-table-container">

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
                    $current_user_id = $_SESSION["userId_code"]; // Assuming you store the logged-in user's ID in session
                    ?>
                                        <tbody>
                                            <?php while ($row = mysqli_fetch_array($results)) { 
                            $adminAccessArray = json_decode($row['adminAccess'], true);
                            $adminAccessFormatted = implode(', ', $adminAccessArray);
                            $is_current_user = ($row['user_id'] == $current_user_id);
                        ?>
                                            <tr <?php echo $is_current_user ? 'class="table-primary"' : ''; ?>>
                                                <td>
                                                    <?php echo $row['user_id']; ?>
                                                    <?php if ($is_current_user) echo ' <span class="badge badge-success">Current User</span>'; ?>
                                                </td>
                                                <td><?php echo $row['fname'].' '.$row['midname'].' '.$row['lname']; ?>
                                                </td>
                                                <td><?php echo $row['contact_no']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td>
                                                    <?php foreach ($adminAccessArray as $access) { ?>
                                                    <span
                                                        class="badge badge-info"><?php echo htmlspecialchars($access); ?></span>
                                                    <?php } ?>
                                                </td>
                                                <td><?php echo $row['accessType']; ?></td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton<?php echo $row['user_id']; ?>"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu"
                                                            aria-labelledby="dropdownMenuButton<?php echo $row['user_id']; ?>">
                                                            <a class="dropdown-item btnEdit" href="#"
                                                                data-user='<?php echo json_encode($row); ?>'>
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php if (!$is_current_user) : ?>
                                                            <a class="dropdown-item btnDelete" href="#">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </a>
                                                            <a class="dropdown-item btnToggleActive" href="#"
                                                                data-user-id="<?php echo $row['user_id']; ?>"
                                                                data-is-active="<?php echo $row['isActive']; ?>">
                                                                <i
                                                                    class="fa <?php echo $row['isActive'] ? 'fa-ban' : 'fa-check'; ?>"></i>
                                                                <?php echo $row['isActive'] ? 'Deactivate' : 'Activate'; ?>
                                                            </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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

<script>
$(document).ready(function() {
    var table = $('#acc_record').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });

    $('.btnToggleActive').on('click', function() {
        var userId = $(this).data('user-id');
        var isActive = $(this).data('is-active');
        var newStatus = isActive ? 0 : 1;
        var $button = $(this);

        $.ajax({
            url: 'function/user.mngmnt.php',
            type: 'POST',
            data: {
                action: 'toggleActive',
                user_id: userId,
                new_status: newStatus
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Update button appearance
                            $button.data('is-active', newStatus);
                            if (newStatus) {
                                $button.removeClass('btn-success').addClass(
                                    'btn-warning');
                                $button.html(
                                    '<i class="fa fa-ban"></i> Deactivate');
                                $button.closest('tr').find('.badge').removeClass(
                                        'badge-danger').addClass('badge-success')
                                    .text('Active');
                            } else {
                                $button.removeClass('btn-warning').addClass(
                                    'btn-success');
                                $button.html(
                                    '<i class="fa fa-check"></i> Activate');
                                $button.closest('tr').find('.badge').removeClass(
                                        'badge-success').addClass('badge-danger')
                                    .text('Inactive');
                            }
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An unexpected error occurred. Please try again.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });


    $('#newUserForm').on('submit', function(e) {
    e.preventDefault();

    // Password validation
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    if (password !== confirmPassword) {
        Swal.fire({
            icon: 'error',
            title: 'Password Mismatch',
            text: 'The passwords you entered do not match. Please try again.',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Form submission
    $.ajax({
        type: 'POST',
        url: 'function/user.mngmnt.php',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload(); // Changed this line to reload the page
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message,
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An unexpected error occurred. Please try again. Error details: ' + error,
                confirmButtonText: 'OK'
            });
        }
    });
});

    $('.btnEdit').on('click', function() {
        var user = $(this).data('user');
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

    $('.btnDelete').on('click', function() {
        if (!$(this).prop('disabled')) {
            var $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function() {
                return $.trim($(this).text());
            }).get();

            $('#deleteUserId').val(data[0]);

            var modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
            modal.show();
        }
    });
});
</script>

</html>