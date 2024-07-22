<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">
<?php 


// Fetch client data
$query = "SELECT user_id, CONCAT(fname, ' ', IFNULL(midname, ''), ' ', lname) AS full_name, 
          contact_no, email, gender, occupation, education_level, registration_date 
          FROM users WHERE accessType = 'Client'";
$results = mysqli_query($con, $query);
?>

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
                                    <li class="active">Clients</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid mt-4">
                <h2>Registered Clients</h2> <br>

                <div class="filters row">
                    <div class="col-md-3">
                        <select id="genderFilter" class="form-control">
                            <option value="">All Genders</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="occupationFilter" class="form-control">
                            <option value="">All Occupations</option>
                            <option value="employed_ft">Employed (Full-time)</option>
                            <option value="employed_pt">Employed (Part-time)</option>
                            <option value="self_employed">Self-employed</option>
                            <option value="student">Student</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select id="educationFilter" class="form-control">
                            <option value="">All Education Levels</option>
                            <option value="elementary">Elementary</option>
                            <option value="high_school">High School</option>
                            <option value="college">College</option>
                            <option value="postgraduate">Postgraduate</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="dateFilter" class="form-control" placeholder="Registration Date">
                    </div>
                </div>
                <br>
                <table class="table table-bordered table-hover" id="clientTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact #</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>Occupation</th>
                            <th>Education</th>
                            <th>Registered</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($results)) { ?>
                        <tr>
                            <td><?php echo $row['user_id']; ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['gender']); ?></td>
                            <td><?php echo htmlspecialchars($row['occupation']); ?></td>
                            <td><?php echo htmlspecialchars($row['education_level']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['registration_date'])); ?></td>
                            <td>
                                <button class="btn btn-sm btn-primary edit-btn"
                                    data-id="<?php echo $row['user_id']; ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-btn"
                                    data-id="<?php echo $row['user_id']; ?>">
                                    <i class="fas fa-trash"></i>
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


</body>



<?php include('modal/clients_modal.php');?>

<?php include('include/footer.php');?>

<script>
$(document).ready(function() {
    var table = $('#clientTable').DataTable({
        "order": [
            [0, "desc"]
        ],
        "pageLength": 25
    });

    // Apply filters
    $('#genderFilter, #occupationFilter, #educationFilter').on('change', function() {
        table.draw();
    });

    $('#dateFilter').on('keyup', function() {
        table.draw();
    });

    $('.edit-btn').on('click', function() {
        var userId = $(this).data('id');
        var row = $(this).closest('tr');

        $('#editUserId').val(userId);
        $('#editName').val(row.find('td:eq(1)').text());
        $('#editContact').val(row.find('td:eq(2)').text());
        $('#editEmail').val(row.find('td:eq(3)').text());
        $('#editGender').val(row.find('td:eq(4)').text());
        $('#editOccupation').val(row.find('td:eq(5)').text());
        $('#editEducation').val(row.find('td:eq(6)').text());

        var editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
    });

    // Save changes button click
    $('#saveChanges').on('click', function() {
        $.ajax({
            url: 'function/update_client_details.php',
            method: 'POST',
            data: $('#editForm').serialize() + '&operation=update',
            dataType: 'json',
            success: function(response) {
                console.log('Update response:', response); // Debug log
                location.reload(); // Refresh the page immediately
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error); // Debug log
                location.reload(); // Refresh the page even on error
            }
        });
    });

    // Delete button click
    $('.delete-btn').on('click', function() {
        var userId = $(this).data('id');
        $('#deleteModal').data('userId', userId);
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    });

    // Confirm delete button click
    $('#confirmDelete').on('click', function() {
        var userId = $('#deleteModal').data('userId');
        $.ajax({
            url: 'function/update_client_details.php',
            method: 'POST',
            data: {
                operation: 'delete',
                user_id: userId
            },
            dataType: 'json',
            success: function(response) {
                console.log('Delete response:', response); // Debug log
                location.reload(); // Refresh the page immediately
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error); // Debug log
                location.reload(); // Refresh the page even on error
            }
        });
    });

    // Check for notification on page load
 
});
</script>

</html>