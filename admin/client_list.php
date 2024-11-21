<?php include('include/header.php')?>
<link rel="stylesheet" href="css/assmt.form.view.css">
<link rel="stylesheet" href="css/client_list.css">

<?php 
function getFilterOptions($table, $column) {
    global $con;
    $options = array();
    $query = "SELECT $column FROM $table ORDER BY $column";
    $result = $con->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $options[] = $row[$column];
        }
    }
    return $options;
}

// Fetch options
$education_levels = getFilterOptions('r_education_levels', 'education_level');
$genders = getFilterOptions('r_genders', 'gender');
$occupations = getFilterOptions('r_occupations', 'occupation');

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
        <?php 
            // Fetch client data
            $query = "SELECT user_id, CONCAT(fname, ' ', IFNULL(midname, ''), ' ', lname) AS full_name, 
                    contact_no, email, gender, occupation, education_level, registration_date 
                    FROM users WHERE accessType = 'Client'";
            $results = mysqli_query($con, $query); 
            ?>

        <div class="content">
            <div class="container-fluid mt-4">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h2 class="font-weight-bold text-primary">Registered Clients</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        <button class="btn btn-primary" onclick="exportToExcel()">
                            <i class="fas fa-download mr-2"></i>Export to Excel
                        </button>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="filters-container">
                            <div class="filters-row">
                                <div class="filter-group">
                                    <label class="filter-label">Gender</label>
                                    <select id="genderFilter" class="filter-select">
                                        <option value="">All Genders</option>
                                        <?php foreach($genders as $gender): ?>
                                        <option value="<?php echo htmlspecialchars($gender); ?>">
                                            <?php echo htmlspecialchars($gender); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Occupation</label>
                                    <select id="occupationFilter" class="filter-select">
                                        <option value="">All Occupations</option>
                                        <?php foreach($occupations as $occupation): ?>
                                        <option value="<?php echo htmlspecialchars($occupation); ?>">
                                            <?php echo htmlspecialchars($occupation); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Education Level</label>
                                    <select id="educationFilter" class="filter-select">
                                        <option value="">All Education Levels</option>
                                        <?php foreach($education_levels as $level): ?>
                                        <option value="<?php echo htmlspecialchars($level); ?>">
                                            <?php echo htmlspecialchars($level); ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="filter-group">
                                    <label class="filter-label">Registration Date</label>
                                    <input type="date" id="dateFilter" class="date-input">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover" id="clientTable">
                                <thead>
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
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary edit-btn"
                                                    data-id="<?php echo $row['user_id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger delete-btn"
                                                    data-id="<?php echo $row['user_id']; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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

</body>



<?php include('modal/clients_modal.php');?>

<?php include('include/footer.php');?>

<script>
$(document).ready(function() {
    // Initialize DataTable with advanced features
    var table = $('#clientTable').DataTable({
        dom: 'Bfrtip',
        buttons: ['excel', 'pdf', 'print'],
        order: [[0, 'desc']],
        pageLength: 25,
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search records..."
        },
        columnDefs: [{ orderable: false, targets: -1 }]
    });

    // Combined filter function
    function filterTable() {
        var filters = {
            gender: $('#genderFilter').val(),
            occupation: $('#occupationFilter').val(),
            education: $('#educationFilter').val(),
            date: $('#dateFilter').val()
        };

        $.fn.dataTable.ext.search.pop(); // Remove previous filter
        $.fn.dataTable.ext.search.push((settings, data) => {
            return (!filters.gender || data[4] === filters.gender) &&
                   (!filters.occupation || data[5] === filters.occupation) &&
                   (!filters.education || data[6] === filters.education) &&
                   (!filters.date || new Date(data[7]).toDateString() === new Date(filters.date).toDateString());
        });

        table.draw();
    }

    // Attach filter event
    $('.filter-select, #dateFilter').on('change', filterTable);

    // Edit button handler
    $('.edit-btn').on('click', function() {
        var userId = $(this).data('id');
        var row = $(this).closest('tr');

        $('#editUserId').val(userId);
        $('#editName').val(row.find('td:eq(1)').text().trim());
        $('#editContact').val(row.find('td:eq(2)').text().trim());
        $('#editEmail').val(row.find('td:eq(3)').text().trim());
        $('#editGender').val(row.find('td:eq(4)').text().trim());
        $('#editOccupation').val(row.find('td:eq(5)').text().trim());
        $('#editEducation').val(row.find('td:eq(6)').text().trim());

        new bootstrap.Modal(document.getElementById('editModal')).show();
    });

    // Save changes handler
    $('#saveChanges').on('click', function() {
        if (!$('#editForm')[0].checkValidity()) {
            $('#editForm')[0].reportValidity();
            return;
        }

        $.ajax({
            url: 'function/update_client_details.php',
            method: 'POST',
            data: $('#editForm').serialize() + '&operation=update',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Client details updated successfully',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error!', response.message || 'Update failed', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Failed to update client details', 'error');
            }
        });
    });

    // Delete button handler
    $('.delete-btn').on('click', function() {
        var userId = $(this).data('id');
        $('#deleteModal').data('userId', userId);
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });

    // Confirm delete handler
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
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Client has been deleted successfully',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error!', response.message || 'Deletion failed', 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'Failed to delete client', 'error');
            }
        });
    });
});

// Export to Excel function
function exportToExcel() {
    $('.buttons-excel').click();
}
</script>