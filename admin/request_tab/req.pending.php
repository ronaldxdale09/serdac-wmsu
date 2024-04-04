<div class="row">

    <!-- Check Status Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterStatus"> Service Type:</label>
        <select id="filterStatus" class="form-control">
            <option value="">All</option>
            <option value="Shipped Out">Capability Training</option>
            <option value="Sold">Data Analysis</option>
            <option value="In Progress">In Progress</option>

        </select>
    </div>


    <!-- Month Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterMonth">Month:</label>
        <select id="filterMonth" class="form-control">
            <option value="">All</option>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                echo '<option value="' . $i . '">' . date("F", mktime(0, 0, 0, $i, 10)) . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label for="filterYear">Year:</label>
        <select id="filterYear" class="form-control">
            <option value="">All</option>
            <?php
            $currentYear = date("Y");
            $startYear = 2022;
            for ($i = $startYear; $i <= $currentYear; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        </select>
    </div>

</div>

<div class="table-responsive custom-table-container">
    <?php
                            // Fetch data from the service_request table
                            $results = mysqli_query($con, "SELECT * FROM service_request
                            LEFT JOIN users ON users.user_id = service_request.user_id
                            WHERE service_request.status = 'Pending' ");
                            ?>
    <table class="table table-hover" id='service_request_table'>
        <thead>
            <tr>
                <th scope="col">Request ID</th>
                <th scope="col">Service Type</th>
                <th scope="col">Office / Agency</th>
                <th scope="col">Purpose</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($results)) { 
                                                    // Status color coding (optional)
                                                    $status_color = '';
                                                    switch ($row['status']) {
                                                        case "Pending":
                                                            $status_color = 'badge-warning';
                                                            break;
                                                        case "Approved":
                                                            $status_color = 'badge-success';
                                                            break;
                                                        case "Rejected":
                                                            $status_color = 'badge-danger';
                                                            break;
                                                    }
                                                ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['office_agency']; ?></td>
                <td><?php echo $row['purpose']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>
                <td>

                    <button type="button" class="btn btn-sm btn-primary mb-1 btnEdit"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-book"></i>
                    </button>

                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



<script>
$(document).ready(function() {
    $('.btnEdit').on('click', function() {
        var request = $(this).data('request');


        $('#p_user_id').val(request.user_id);
        $('#p_req_id').val(request.request_id);

        $('#p_user-name').val(request.fname + ' ' + request.lname);
        $('#service-type').val(request.service_type);
        $('#office-agency').val(request.office_agency);
        $('#agency-classification').val(request.agency_classification);
        $('#client-type').val(request.client_type);
        $('#purpose').val(request.purpose);



        var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
        modal.show();

    });


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

<script>
document.addEventListener('DOMContentLoaded', function() {
    var serviceRequestModal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
    var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

    document.getElementById('confirm-service-request').addEventListener('click', function() {
        serviceRequestModal.hide();
        scheduleModal.show();
    });

    document.getElementById('confirm-schedule').addEventListener('click', function() {
        var selectedDate = document.getElementById('schedule-date').value;

        if (selectedDate) {
            var formattedDate = new Date(selectedDate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            document.getElementById('p_sched_date').value = selectedDate;

            document.querySelector('.selected_schedule').innerHTML = '<h5>Selected Schedule</h5><p>' +
                formattedDate + '</p>';

            // Unhide the confirm service request button
            var submitBtn = document.getElementById('submit-request');
            submitBtn.removeAttribute('hidden');

            scheduleModal.hide();
        } else {
            alert('Please select a date.');
        }
    });
});
</script>