
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
    <table class="table table-hover" id='service_sched_table'>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">Client</th>

                <th scope="col">Service Type</th>
                <th scope="col">Agency</th>

                <th scope="col">Remarks</th>


                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($results)) { 
                // Status color coding (optional)
            $status_color = '';
            $type_color = '';
            switch ($row['status']) {
                case "In Progress":
                    $status_color = 'badge-dark';
                    break;
            }

            $type_color = '';
            if ($row['service_type'] === "data-analysis") {
                $type_color = 'badge-success';
            } elseif ($row['service_type'] === "capability-training") {
                $type_color = 'badge-primary';
            } elseif ($row['service_type'] === "technical-assistance") {
                $type_color = 'badge-dark';
            }
                    ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td class='nowrap'><?php echo $row['fname'].' '.$row['lname'].' '; ?></td>


                <td><span class="badge <?php echo $type_color; ?>">
                        <?php echo $row['service_type']; ?>
                    </span></td>
                <td><?php echo $row['office_agency']; ?></td>


                <td><?php echo $row['inprogress_remarks']; ?></td>

                <td>
                    <div class="button-grid">
                        <button type="button" class="btn btn-sm btn-primary btnProgView" data-toggle="tooltip"
                            data-placement="top" title="View Request" data-request='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-book"></i> Details
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary btnProgMeeting"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip"
                            title="Progress Meeting">
                            <i class="fas fa-calendar"></i> Meetings
                        </button>

                        <?php if ($row['service_type'] == 'data-analysis'): ?>
                        <button type="button" class="btn btn-sm btn-warning text-dark btnRequirement"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Requirements">
                            <i class="fas fa-tasks"></i> Documents
                        </button>
                        <?php endif; ?>

                        <?php if ($row['service_type'] == 'capability-training'): ?>
                        <button type="button" class="btn btn-sm btn-dark btnSpeaker"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Speaker">
                            <i class="fas fa-users"></i> Speakers
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btnParticiapnts"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Participants">
                            <i class="fas fa-user-friends"></i> Participants
                        </button>



                        <?php endif; ?>

                        <button type="button" class="btn btn-sm btn-success btnCompleteService"
                            data-req='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-check"></i> Complete
                        </button>
                    </div>


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


$('.btnCompleteService').on('click', function() {
        var req = $(this).data('req');

        $('#c_req_id').val(req.request_id || 'N/A');

        var modal = new bootstrap.Modal(document.getElementById('completeRequestModal'));
        modal.show();

    });



$('.btnProgMeeting').on('click', function() {
    var request = $(this).data('request');

    $('#m_req_id').val(request.request_id);

    $('#m_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
        'N/A');
    $('#m_service-type').val(request.service_type || 'N/A');
    $('#m_office-agency').val(request.office_agency || 'N/A');
    $('#m_agency-classification').val(request.agency_classification || 'N/A');
    $('#m_client-type').val(request.client_type || 'N/A');

    $('#m_from_date').val(request.sched_from_date || 'N/A');
    $('#m_to_date').val(request.sched_to_date || 'N/A');

    $('#m_purpose').val(request.selected_purposes || 'N/A');


    request_id = request.request_id;

    function fetch_meeting() {

        $.ajax({
            url: "table/table.meeting.php",
            method: "POST",
            data: {
                request_id: request_id,

            },
            success: function(data) {
                $('#meeting_table_modal').html(data);

            }
        });
    }
    fetch_meeting();



    var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
    modal.show();

});

$('.btnParticiapnts').on('click', function() {
    var req = $(this).data('request');

    var request = req.request_id;
    var invite = req.inviteCode;


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

$('.btnRequirement').on('click', function() {
    var request = $(this).data('request');

    $('#r_req_id').val(request.request_id);

    $('#r_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
        'N/A');
    $('#r_service-type').val(request.service_type || 'N/A');
    $('#r_office-agency').val(request.office_agency || 'N/A');
    $('#r_agency-classification').val(request.agency_classification || 'N/A');
    $('#r_client-type').val(request.client_type || 'N/A');

    $('#r_fror_date').val(request.sched_fror_date || 'N/A');
    $('#r_to_date').val(request.sched_to_date || 'N/A');

    $('#r_purpose').val(request.selected_purposes || 'N/A');


    notificationStatus = request.notificationStatus;

    request_id = request.request_id;

    function fetch_files() {

        $.ajax({
            url: "table/anaylsis_files_fetch.php",
            method: "POST",
            data: {
                request_id: request_id,

            },
            success: function(data) {
                $('#upload_document_list').html(data);

            }
        });
    }
    fetch_files();



    var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
    modal.show();

});


$(document).ready(function() {
    $('.btnProgPart').on('click', function() {
        var req = $(this).data('req');

        var request = req.request_id;
        var invite = req.inviteCode;


        document.querySelector('.d_selected_schedule').style.display = 'none';


        $('#participants_client').val(req.fname && req.lname ? req.fname + ' ' + req.lname :
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



    $('.btnProgView').on('click', function() {
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

        $('#d_remarks').val(request.scheduled_remarks || 'N/A');


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