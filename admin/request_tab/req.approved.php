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
                            WHERE service_request.status = 'Approved' ");
                            ?>
    <table class="table table-hover" id='service_request_table'>
        <thead>
            <tr>
                <th scope="col">Request ID</th>

                <th scope="col">Schedule</th>
                <th scope="col">Service Type</th>
                <th scope="col">Office / Agency</th>
                <th scope="col">Status</th>
                <th scope="col">Participants</th>

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
                <td class="nowrap"><?php echo date('M j, Y', strtotime($row['scheduled_date'])); ?></td>

                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['office_agency']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td><?php echo $row['participants']; ?></td>

                <td>

                    <button type="button" class="btn btn-sm btn-primary mb-1 btnEdit"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-book"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark mb-1 btnParticiapnts"
                        data-req='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-user"></i>
                    </button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<script>
$(document).ready(function() {
    $('.btnParticiapnts').on('click', function() {
        var req = $(this).data('req');

        var request = req.request_id;
        var invite = req.inviteCode;

        console.log(invite);
        $('#inviteCode').text(invite);

        function fetch_participants() {
            $.ajax({
                url: "table/service_participants.php",
                method: "POST",
                data: {
                    request_id: request
                },
                success: function(data) {
                    $('#particiapnts_list_table').html(data);

                }
            });
        }
        fetch_participants();





        var modal = new bootstrap.Modal(document.getElementById('participantsModal'));
        modal.show();

    });





});
</script>