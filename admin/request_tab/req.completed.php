<div class="row mb-3">
    <!-- Status Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterStatus">Status:</label>
        <select id="filterStatus" class="form-control">
            <option value="">All</option>
            <option value="Completed">Completed</option>
            <!-- Add other status options as needed -->
        </select>
    </div>

    <!-- Service Type Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterServiceType">Service Type:</label>
        <select id="filterServiceType" class="form-control">
            <option value="">All</option>
            <option value="data-analysis">Data Analysis</option>
            <option value="capability-training">Capability Training</option>
            <option value="technical-assistance">Technical Assistance</option>
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

    <!-- Year Filter -->
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
                            WHERE service_request.status = 'Completed' ");
                            ?>
    <table class="table table-hover" id='service_completed_table'>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">Client</th>

                <th scope="col">Service Type</th>
                <th scope="col">Agency</th>
                <th scope="col">Date Completed</th>

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
                case "Completed":
                    $status_color = 'badge-success';
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
                <td><?php echo $row['completed_date']; ?></td>


                <td><?php echo $row['inprogress_remarks']; ?></td>

                <td>
                    <div class="button-grid">
                        <button type="button" class="btn btn-sm btn-primary btnComView" data-toggle="tooltip"
                            data-placement="top" title="View Request" data-request='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-book"></i> Details
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary btnComMeeting"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip"
                            title="Progress Meeting">
                            <i class="fas fa-calendar"></i> Meetings
                        </button>

                        <?php if ($row['service_type'] == 'data-analysis'): ?>
                        <button type="button" class="btn btn-sm btn-warning text-dark btnComRequirement"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Requirements">
                            <i class="fas fa-tasks"></i> Documents
                        </button>
                        <?php endif; ?>

                        <?php if ($row['service_type'] == 'capability-training'): ?>
                        <button type="button" class="btn btn-sm btn-dark btnComSpeaker"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Speaker">
                            <i class="fas fa-users"></i> Speakers
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btnComParticiapnts"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Participants">
                            <i class="fas fa-user-friends"></i> Participants
                        </button>



                        <?php endif; ?>

                    </div>


                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</div>




<script>
$(document).ready(function() {

  



    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var status = $('#filterStatus').val();
            var serviceType = $('#filterServiceType').val();
            var month = parseInt($('#filterMonth').val(), 10);
            var year = parseInt($('#filterYear').val(), 10);

            var rowStatus = data[1]; // Assuming status is in the second column
            var rowServiceType = data[3]; // Assuming service type is in the fourth column
            var rowDate = new Date(data[5]);

            if (
                (status === "" || rowStatus.includes(status)) &&
                (serviceType === "" || rowServiceType.includes(serviceType)) &&
                (isNaN(month) || rowDate.getMonth() + 1 === month) &&
                (isNaN(year) || rowDate.getFullYear() === year)
            ) {
                return true;
            }
            return false;
        }
    );

    var table = $('#service_completed_table').DataTable({
        responsive: true,
        scrollX: false,
        autoWidth: false,
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: ['excelHtml5', 'pdfHtml5', 'print'],
        columnDefs: [{
                width: '60px',
                targets: 0
            }, // ID column
            {
                width: 'auto',
                targets: '_all'
            }
        ],
        order: [
            [0, 'desc']
        ] // Sort by ID in descending order
    });

    $('#filterStatus, #filterServiceType, #filterMonth, #filterYear').change(function() {
        table.draw();
    });

    $(window).on('resize', function() {
        table.columns.adjust().draw();
    });
});


function disableModalElements(modalId) {
    $('#' + modalId).find('input, select, textarea, button').not('[data-dismiss="modal"]').prop('disabled', true);
}
// Function to enable all buttons and inputs in a given modal
function enableModalElements(modalId) {
    $('#' + modalId).find('input, select, textarea, button').prop('disabled', false);
}




// Event handlers for the buttons
$('.btnComMeeting').on('click', function() {
    var request = $(this).data('request');

    populateMeetingModal(request);
    fetchMeetingDetails(request.request_id);


    var modal = new bootstrap.Modal(document.getElementById('serviceMeetingModal'));
    modal.show();

    disableModalElements('serviceMeetingModal');

});

$('.btnComView').on('click', function() {
    var request = $(this).data('request');

    populateViewModal(request);
    loadServiceSpecificContent(request.service_type);
    fetchDataAnalysisDetails(request.service_type, request.request_id);

    disableModalElements('serviceRequestDetailsModal');

    var modal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
    modal.show();
});

$('.btnComSpeaker').on('click', function() {
    var request = $(this).data('request');

    populateSpeakerModal(request);
    fetchSpeakerDetails(request.request_id);
    fetchTrainingDetails(request.service_type, request.request_id);

    disableModalElements('serviceSpeakerModal');

    var modal = new bootstrap.Modal(document.getElementById('serviceSpeakerModal'));
    modal.show();
});

$('.btnComParticiapnts').on('click', function() {
    var request = $(this).data('request');

    populateParticipantsModal(request);
    fetchParticipantsDetails(request);

    disableModalElements('participantsModal');

    var modal = new bootstrap.Modal(document.getElementById('participantsModal'));
    modal.show();
});

$('.btnComRequirement').on('click', function() {
    var request = $(this).data('request');

    populateRequirementModal(request);
    fetchRequirementFiles(request.request_id);

    disableModalElements('anaylsisReqModal');

    var modal = new bootstrap.Modal(document.getElementById('anaylsisReqModal'));
    modal.show();
});
</script>