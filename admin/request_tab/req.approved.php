<style>
.btnView,
.btnParticiapnts,
.btnMeeting,
.btnSpeaker {
    margin-right: 5px;
}
</style>
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
    <table class="table table-hover" id='service_sched_table'>
        <thead>
            <tr>
                <th scope="col">Req. ID</th>
                <th scope="col">Status</th>

                <th scope="col">Meeting Scheduled</th>
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
                                                    switch ($row['status']) {
                                                        case "Pending":
                                                            $status_color = 'badge-warning';
                                                            break;
                                                        case "Approved":
                                                            $status_color = 'badge-primary';
                                                            break;
                                                        case "Rejected":
                                                            $status_color = 'badge-danger';
                                                            break;
                                                    }
                                                ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td class="nowrap"><?php echo date('M j, Y, h:i A', strtotime($row['scheduled_date'])); ?></td>

                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['office_agency']; ?></td>

                <td><?php echo $row['admin_remarks']; ?></td>

                                <td style="display: flex; align-items: center; justify-content: center;">

                    <button type="button" class="btn btn-sm btn-primary  btnView"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-book"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary  btnMeeting"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-calendar"></i>
                    </button>

                    <?php if ($row['service_type'] == 'capability-training'): ?>
                    <button type="button" class="btn btn-sm btn-dark btnSpeaker"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-users"></i>
                    </button>
                    <?php endif; ?>



                    <button type="button" class="btn btn-sm btn-success btnComplete"
                        data-req='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-check"></i>
                    </button>


                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include('modal/service_meeting.php');?>
<?php include('modal/service_speaker.php');?>

<script>
$(document).ready(function() {
    var table = $('#service_sched_table').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});


$(document).ready(function() {
    $('.btnParticiapnts').on('click', function() {
        var req = $(this).data('req');

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


    $('.btnComplete').on('click', function() {
        var req = $(this).data('req');

        $('#d_req_id').val(req.request_id || 'N/A');



        var modal = new bootstrap.Modal(document.getElementById('markCompleteModal'));
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


        // Clear previous service type content
        $('#service-specific').empty();

        // Load service-specific content based on service type
        var serviceTypeUrl = '';
        if (request.service_type === 'data-analysis') {
            serviceTypeUrl = 'modal/md.data_analysis.php';
        } else if (request.service_type === 'technical-assistance') {
            serviceTypeUrl = 'modal/md.tech_assist.php';
        } else if (request.service_type === 'technical-assistance') {
            serviceTypeUrl = '';
        }


        // Append the service-specific form to the div
        if (serviceTypeUrl) {
            $('#d_service-specific').load(serviceTypeUrl, function(response, status, xhr) {
                if (status === "error") {
                    console.log("Error loading the page: " + xhr.status + " " + xhr.statusText);
                }
            });
        }




        serviceType = request.service_type;
        $.ajax({
            url: 'fetch/fetch.data_analysis.php', // Server-side script to return data
            type: 'POST',
            data: {
                service_type: serviceType,
                request_id: request.request_id
            },
            success: function(response) {
                // Assume response is JSON
                // Parse and populate more specific fields if necessary
                if (serviceType === 'data-analysis') {
                    var details = JSON.parse(response);
                    $('#anaylsis-type').val(details.analysis_type);
                    $('#research-overview').val(details.overview);
                    $('#general-objective').val(details.g_objective);
                    $('#specific-objective').val(details.s_objective);

                    console.log(details)

                }


            },
            error: function() {
                console.log('Error fetching details.');
            }
        });




        var modal = new bootstrap.Modal(document.getElementById('reqserviceDetails'));
        modal.show();

    });



    $('.btnMeeting').on('click', function() {
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
        // $('#d_additional_details').val(request.additional_purpose_details || 'N/A');

        // $('#d_remarks').val(request.admin_remarks || 'N/A');


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
                    //makeReadOnly(); // Call this function here

                }
            });
        }
        fetch_meeting();



        var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
        modal.show();

    });



    $(document).on('click', '#btnSaveMeetingForm', function(e) {
        // Prevent the default form submission
        e.preventDefault();




        // Set the form action to the desired URL
        $('#meeting_form').attr('action', 'function/service_action.meeting.php');

        // Submit the form asynchronously using AJAX
        $.ajax({
            type: "POST",
            url: $('#meeting_form').attr('action'),
            data: $('#meeting_form').serialize(),
            success: function(response) {
                if (response.trim() === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Meeting Record Saved!',
                    });


                    var selectElement = document.getElementById('patient_name');
                    $(selectElement).chosen('destroy');


                    // Set all inputs to readonly
                    $('#meeting_form input').prop('readonly', true);
                    $('#meeting_form textarea').prop('readonly', true);
                    $('#meeting_form select').prop('disabled',
                        true); //use 'disabled' for select elements
                    // Disable all buttons inside the form
                    // Temporarily hide the buttons

                    // $('#confirmPrenatalModal').modal('hide');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response,
                    });
                }
            },
            error: function(xhr, status, error) {
                // Handle the error response
                // Display SweetAlert error popup
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Form submission failed!',
                });
            }
        });
    });

});



$('.btnSpeaker').on('click', function() {
    var request = $(this).data('request');

    $('#sp_req_id').val(request.request_id);

    $('#sp_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
        'N/A');
    $('#sp_service-type').val(request.service_type || 'N/A');
    $('#sp_office-agency').val(request.office_agency || 'N/A');
    $('#sp_agency-classification').val(request.agency_classification || 'N/A');
    $('#sp_client-type').val(request.client_type || 'N/A');

    $('#sp_frosp_date').val(request.sched_frosp_date || 'N/A');
    $('#sp_to_date').val(request.sched_to_date || 'N/A');

    $('#sp_purpose').val(request.selected_purposes || 'N/A');
    // $('#d_additional_details').val(request.additional_purpose_details || 'N/A');

    // $('#d_remarks').val(request.admin_remarks || 'N/A');


    request_id = request.request_id;

    function fetch_speaker() {

        $.ajax({
            url: "table/table_sr_speaker.php",
            method: "POST",
            data: {
                request_id: request_id,

            },
            success: function(data) {
                $('#speaker_list_table').html(data);
                //makeReadOnly(); // Call this function here

            }
        });
    }
    fetch_speaker();
 


    var modal = new bootstrap.Modal(document.getElementById('serviceSpeakerModal'));
    modal.show();

});
</script>