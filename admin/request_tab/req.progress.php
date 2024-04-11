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
                            WHERE service_request.status = 'In Progress' ");
                            ?>
    <table class="table table-hover" id='service_progress'>
        <thead>
            <tr>
                <th scope="col">Req. ID</th>
                <th scope="col">Status</th>
                <th scope="col">Title</th>
                <th scope="col">Speaker</th>

                <th scope="col">Service Type</th>
                <th scope="col">Agency</th>
                <th scope="col">Participants</th>


                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($results)) { 
                                                    // Status color coding (optional)
                                                    $status_color = '';
                                                    switch ($row['status']) {
                                                  
                                                        case "In Progress":
                                                            $status_color = 'badge-success';
                                                            break;
                                                    }
                                                ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>
                    
                <td><?php echo $row['event_title']; ?></td>
                <td><?php echo $row['event_speaker']; ?></td>

                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['office_agency']; ?></td>


                <td><?php echo $row['participants']; ?></td>
                <td><?php echo $row['admin_remarks']; ?></td>

                <td style="display: flex; align-items: center; justify-content: center;">

                    <button type="button" class="btn btn-sm btn-primary mb-1 btnView"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-book"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark mb-1 btnProgPart"
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
    var table = $('#service_progress').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});



$(document).ready(function() {
    $('.btnProgPart').on('click', function() {
        var req = $(this).data('req');

        var request = req.request_id;
        var invite = req.inviteCode;


        document.querySelector('.d_selected_schedule').style.display = 'none';


        $('#p_user-name').val(req.fname && req.lname ? req.fname + ' ' + req.lname :
            'N/A');
        $('#p_service-type').val(req.service_type || 'N/A');
        $('#p_office-agency').val(req.office_agency || 'N/A');
        $('#p_agency-classification').val(req.agency_classification || 'N/A');
        $('#p_client-type').val(req.client_type || 'N/A');



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



    $('.btnView').on('click', function() {
        var request = $(this).data('request');

        $('#d_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
            'N/A');
        $('#d_service-type').val(request.service_type || 'N/A');
        $('#d_office-agency').val(request.office_agency || 'N/A');
        $('#d_agency-classification').val(request.agency_classification || 'N/A');
        $('#d_client-type').val(request.client_type || 'N/A');

        $('#d_from_date').val(request.sched_from_date || 'N/A');
        $('#d_to_date').val(request.sched_to_date || 'N/A');

        $('#d_purpose').val(request.selected_purposes || 'N/A');
        $('#d_additional_details').val(request.additional_purpose_details || 'N/A');

        $('#d_remarks').val(request.admin_remarks || 'N/A');


        var selectedDateTime = request.scheduled_date;

        if (selectedDateTime) {
            // Format the date and time
            var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });


            document.querySelector('.d_selected_schedule').innerHTML = '<h5>Selected Schedule</h5><p>' +
                formattedDateTime + '</p>';
        }


        var modal = new bootstrap.Modal(document.getElementById('reqserviceDetails'));
        modal.show();

    });




});
</script>