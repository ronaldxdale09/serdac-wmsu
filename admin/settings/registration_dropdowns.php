<?php
// Function to get table data
function getTableData($table) {
    global $con;
    $data = array();
    $result = $con->query("SELECT * FROM $table ORDER BY id");
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// Get data for each table
$education_levels = getTableData('r_education_levels');
$genders = getTableData('r_genders');
$occupations = getTableData('r_occupations');
?>

<div class="container mt-5">
    <div class="row">
        <?php 
        $tables = [
            ['name' => 'r_education_levels', 'title' => 'Education Levels', 'data' => $education_levels, 'column' => 'education_level'],
            ['name' => 'r_genders', 'title' => 'Genders', 'data' => $genders, 'column' => 'gender'],
            ['name' => 'r_occupations', 'title' => 'Occupations', 'data' => $occupations, 'column' => 'occupation']
        ];
        
        foreach ($tables as $table): 
        ?>
        <div class="col-md-4">
            <h4><?php echo $table['title']; ?></h4>
            <form class="registration-add-form" data-table="<?php echo $table['name']; ?>">
                <div class="input-group">
                    <input type="text" class="form-control registration-add-input"
                        placeholder="Add new <?php echo strtolower($table['title']); ?>" required>
                    <div class="input-group-append">
                        <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i> Add</button>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo substr($table['title'], 0, -1); ?></th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($table['data'] as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td>
                                <span class="registration-editable" data-table="<?php echo $table['name']; ?>"
                                    data-id="<?php echo $item['id']; ?>" data-column="<?php echo $table['column']; ?>">
                                    <?php echo htmlspecialchars($item[$table['column']]); ?>
                                </span>
                            </td>
                            <td>
                                <div class="registration-action-buttons">
                                    <button class="btn btn-sm btn-primary registration-edit-btn">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger registration-delete-btn"
                                        data-table="<?php echo $table['name']; ?>" data-id="<?php echo $item['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script>$(document).ready(function() {
    // Edit functionality
    $('.registration-edit-btn').on('click', function() {
        var $span = $(this).closest('tr').find('.registration-editable');
        var currentValue = $span.text().trim();
        var input = $('<input>').attr({
            type: 'text',
            class: 'form-control form-control-sm registration-edit-input',
            value: currentValue
        });

        $span.hide().after(input);
        input.focus();

        input.on('blur', function() {
            var newValue = $(this).val();
            if (newValue !== currentValue) {
                updateRegistrationValue($span.data('table'), $span.data('id'), newValue, $span, $span.data('column'));
            } else {
                $span.show();
                $(this).remove();
            }
        });
    });

    // Delete functionality
    $('.registration-delete-btn').on('click', function() {
        var $btn = $(this);
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'function/crud_registration.php',
                    method: 'POST',
                    data: {
                        action: 'delete',
                        table: $btn.data('table'),
                        id: $btn.data('id')
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $btn.closest('tr').remove();
                            Swal.fire(
                                'Deleted!',
                                'The item has been deleted.',
                                'success'
                            );
                        } else {
                            Swal.fire(
                                'Error!',
                                'Error deleting item: ' + response.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Error communicating with the server.',
                            'error'
                        );
                    }
                });
            }
        });
    });

    // Add functionality
    $('.registration-add-form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $input = $form.find('.registration-add-input');
        var newValue = $input.val();

        $.ajax({
            url: 'function/crud_registration.php',
            method: 'POST',
            data: {
                action: 'add',
                table: $form.data('table'),
                value: newValue
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: 'New item has been added.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Error adding item: ' + response.message,
                        'error'
                    );
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'Error communicating with the server.',
                    'error'
                );
            }
        });
    });

    function updateRegistrationValue(table, id, newValue, $span, column) {
        $.ajax({
            url: 'function/crud_registration.php',
            method: 'POST',
            data: {
                action: 'update',
                table: table,
                id: id,
                value: newValue,
                column: column
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $span.text(newValue).show();
                    $span.next('.registration-edit-input').remove();
                    Swal.fire({
                        title: 'Updated!',
                        text: 'The item has been updated.',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire(
                        'Error!',
                        'Error updating value: ' + response.message,
                        'error'
                    );
                    $span.show();
                    $span.next('.registration-edit-input').remove();
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'Error communicating with the server.',
                    'error'
                );
                $span.show();
                $span.next('.registration-edit-input').remove();
            }
        });
    }
});
</script>