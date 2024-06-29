<div class="table-responsive">
    <?php
                    // Fetch data from the service_request table
                $results = mysqli_query($con, "SELECT 
                sr.*, 
                u.fname, u.lname, u.email, 
                (SELECT COUNT(*) FROM sr_meeting sm WHERE sm.request_id = sr.request_id) AS meeting_count 
                FROM service_request sr
                LEFT JOIN users u ON u.user_id = sr.user_id
                WHERE sr.status = 'In Progress' ");
                ?>
    <table class="table table-hover" id='service_prog_table' style="width: 100% !important;">
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
                            <i class="fas fa-calendar"></i> Meetings <span
                                class="badge badge-light"><?php echo $row['meeting_count']; ?></span>
                        </button>

                        <?php if ($row['service_type'] == 'data-analysis'): ?>
                        <button type="button" class="btn btn-sm btn-warning text-dark btnRequirement"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Requirements">
                            <i class="fas fa-tasks"></i> Documents
                        </button>
                        <?php endif; ?>

                        <?php if ($row['service_type'] == 'capability-training'): ?>
                        <button type="button" class="btn btn-sm btn-dark btnProgSpeaker"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Speaker">
                            <i class="fas fa-users"></i> Speakers
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btnProgParticiapnts"
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
    var table = $('#service_prog_table').DataTable({
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        columnDefs: [{
                width: '60px',
                targets: 0
            }, // Assuming ID is the first column
            {
                width: 'auto',
                targets: '_all'
            }
        ]
    });

    $(window).on('resize', function() {
        table.columns.adjust().draw();
    });
});

$('.btnCompleteService').on('click', function() {
    var req = $(this).data('req');

    $('#c_req_id').val(req.request_id || 'N/A');

    var modal = new bootstrap.Modal(document.getElementById('completeRequestModal'));
    modal.show();

    enableModalElements('completeRequestModal');


});



$('.btnProgMeeting').on('click', function() {
    var request = $(this).data('request');

    populateMeetingModal(request);
    fetchMeetingDetails(request.request_id);

    var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
    modal.show();

    enableModalElements('serviceMeetingModal');

});




$('.btnProgView').on('click', function() {
    var request = $(this).data('request');

    populateViewModal(request);
    loadServiceSpecificContent(request.service_type);
    fetchDataAnalysisDetails(request.service_type, request.request_id);

    var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
    modal.show();
    enableModalElements('serviceRequestDetailsModal');

});



$('.btnProgSpeaker').on('click', function() {
    var request = $(this).data('request');

    populateSpeakerModal(request);
    fetchSpeakerDetails(request.request_id);
    fetchTrainingDetails(request.service_type, request.request_id);

    var modal = new bootstrap.Modal(document.getElementById('serviceSpeakerModal'));
    enableModalElements('serviceSpeakerModal');

    modal.show();

});


$('.btnProgParticiapnts').on('click', function() {
    var request = $(this).data('request');

    populateParticipantsModal(request);
    fetchParticipantsDetails(request);

    var modal = new bootstrap.Modal(document.getElementById('participantsModal'));
    modal.show();
    enableModalElements('participantsModal');
});

$('.btnRequirement').on('click', function() {
    var request = $(this).data('request');

    populateRequirementModal(request);
    fetchRequirementFiles(request.request_id);

    var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
    modal.show();
    enableModalElements('anaylsisReqModal');

});



function populateRequirementModal(request) {
    $('#r_req_id').val(request.request_id);
    $('#r_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname : 'N/A');
    $('#r_email').val(request.email);

    $('#r_service-type').val(request.service_type || 'N/A');
    $('#r_office-agency').val(request.office_agency || 'N/A');
    $('#r_agency-classification').val(request.agency_classification || 'N/A');
    $('#r_client-type').val(request.client_type || 'N/A');
    $('#r_fror_date').val(request.sched_fror_date || 'N/A');
    $('#r_to_date').val(request.sched_to_date || 'N/A');
    $('#r_purpose').val(request.selected_purposes || 'N/A');
}

function fetchRequirementFiles(request_id) {
    $.ajax({
        url: "table/anaylsis_files_fetch.php",
        method: "POST",
        data: {
            request_id: request_id
        },
        success: function(data) {
            $('#upload_document_list').html(data);
        }
    });

    $.ajax({
        url: "table/anaylsis_files_fetch_res.php",
        method: "POST",
        data: {
            request_id: request_id
        },
        success: function(data) {
            $('#upload_document_result').html(data);
        }
    });
}

// Function to populate participants modal
// Function to populate participants modal
function populateParticipantsModal(request) {
    $('#participants_client').val(request.fname && request.lname ? request.fname + ' ' + request.lname : 'N/A');
    $('#p_service-type').val(request.service_type || 'N/A');
    $('#p_office-agency').val(request.office_agency || 'N/A');
    $('#p_agency-classification').val(request.agency_classification || 'N/A');
    $('#p_client-type').val(request.client_type || 'N/A');
    $('#s_invcode').val(request.inviteCode || 'N/A');
    $('#s_req_id').val(request.request_id);
    $('#inviteCode').text(request.inviteCode || 'N/A');
    $('#s_quota').val(request.participants_quota);

    var allowParticipants = request.allowParticipants;

    console.log("allowParticipants value:", allowParticipants); // Debugging aid

    // Set the initial state of the toggle button
    if (allowParticipants == 1) {
        $('#allow-participants-toggle').removeClass('btn-secondary').addClass('btn-success');
        $('#allow-participants-toggle').html('<i class="fa fa-toggle-on"></i> Allow Participants');
    } else {
        $('#allow-participants-toggle').removeClass('btn-success').addClass('btn-secondary');
        $('#allow-participants-toggle').html('<i class="fa fa-toggle-off"></i> Allow Participants');
    }



}

function fetchParticipantsDetails(request) {
    $.ajax({
        url: 'fetch/fetch.training.php',
        type: 'POST',
        data: {
            service_type: request.service_type,
            request_id: request.request_id
        },
        success: function(response) {
            var details = JSON.parse(response);
            $('#p_service_title').val(details.title || '');
            $('#p_serviceVenue').val(details.venue || '');
            $('#p_fromDate').val(formatDate(details.s_from || ''));
            $('#p_toDate').val(formatDate(details.s_to || ''));
        },
        error: function() {
            console.log('Error fetching details.');
        }
    });

    $.ajax({
        url: "table/service_participants.php",
        method: "POST",
        data: {
            request_id: request.request_id
        },
        success: function(data) {
            $('#particiapnts_list_table').html(data);
        }
    });
}
</script>