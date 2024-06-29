<style>
#service_sched_table {
    width: 100%;
}
</style>

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
                <th scope="col">ID</th>
                <th scope="col">Status</th>

                <th scope="col">Service Type</th>
                <th scope="col">Client</th>

                <th scope="col">Agency</th>
                <th scope="col">Purpose</th>
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

            $type_color = '';
            if ($row['service_type'] === "data-analysis") {
                $type_color = 'badge-success';
            } elseif ($row['service_type'] === "capability-training") {
                $type_color = 'badge-primary';
            } elseif ($row['service_type'] === "technical-assistance") {
                $type_color = 'badge-dark';
            }
            $client = $row['fname'].' '.$row['lname'];


                                                ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td><span class="badge <?php echo $type_color; ?>">
                        <?php echo $row['service_type']; ?>
                    </span>
                </td>
                <td><?php echo $client ?></td>

                <td><?php echo $row['office_agency']; ?></td>
                <td><?php echo $row['selected_purposes']; ?></td>
                <td>
                    <div class="button-grid">

                        <button type="button" class="btn btn-sm btn-primary mb-1 btnEdit"
                            data-request='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-book"></i> Details
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
    // Cancel Request Button Click Handler
    $('.btnCancelRequest').on('click', function() {
        var request = $('#p_req_id').val();
        $('#cancelRequestId').val(request);
    });

    // Function to handle the Edit button click
    $('.btnEdit').on('click', function() {
        var request = $(this).data('request');

        // Populate form fields with request data
        $('#p_user_id').val(request.user_id);
        $('#p_req_id').val(request.request_id);
        $('#p_user-name').val(request.fname + ' ' + request.lname);
        $('#service-type').val(request.service_type);
        $('#office-agency').val(request.office_agency);
        $('#agency-classification').val(request.agency_classification);
        $('#client-type').val(request.client_type);
        $('#from_date').val(request.sched_from_date);
        $('#to_date').val(request.sched_to_date);
        $('#purpose').val(request.selected_purposes);
        $('#additional_details').val(request.additional_purpose_details);

        // Clear previous service type content
        $('#service-specific').empty();

        // Determine the service-specific URL
        var serviceTypeUrl = '';
        if (request.service_type === 'data-analysis') {
            serviceTypeUrl = 'modal/md.data_analysis.php';
        } else if (request.service_type === 'technical-assistance') {
            serviceTypeUrl = 'modal/md.tech_assist.php';
        }

        // Load service-specific content if URL is defined
        if (serviceTypeUrl) {
            $('#service-specific').load(serviceTypeUrl, function(response, status, xhr) {
                if (status === "error") {
                    console.error("Error loading the page: " + xhr.status + " " + xhr
                        .statusText);
                }
            });
        }

        // Fetch additional details for data analysis
        if (request.service_type === 'data-analysis') {
            $.ajax({
                url: 'fetch/fetch.data_analysis.php',
                type: 'POST',
                data: {
                    service_type: request.service_type,
                    request_id: request.request_id
                },
                success: function(response) {
                    var details = JSON.parse(response);
                    $('#anaylsis-type').val(details.analysis_type);
                    $('#research-overview').val(details.overview);
                    $('#general-objective').val(details.g_objective);
                    $('#specific-objective').val(details.s_objective);

                    console.log(details);

                    // Show relevant buttons
                    $('button').each(function() {
                        if ($(this).text().includes('Cancel Request') || $(this)
                            .text().includes('Assign Schedule')) {
                            $(this).show();
                        }
                    });

                },
                error: function() {
                    console.error('Error fetching details.');
                }
            });
        }
        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById(
            'serviceRequestDetailsModal'));
        modal.show();
    });

    // Handle the modal toggle for scheduling
    var serviceRequestModal = new bootstrap.Modal(document.getElementById('serviceRequestDetailsModal'));
    var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

    $('#assign-sched').on('click', function() {
        console.log("Hiding service request modal and showing schedule modal.");
        serviceRequestModal.hide();
        scheduleModal.show();
    });

    $('#confirm-schedule').on('click', function() {
        var selectedDateTime = $('#schedule-date').val();
        console.log("Selected DateTime: " + selectedDateTime);

        if (selectedDateTime) {
            var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            $('#p_sched_date').val(selectedDateTime);
            $('.selected_schedule').html('<h5>Selected Schedule</h5><p>' + formattedDateTime + '</p>');

            $('#submit-request').removeAttr('hidden');
            console.log("Submit button should now be visible.");

            scheduleModal.hide();
        } else {
            alert('Please select a date and time.');
        }
    });

    // Initialize DataTable with buttons
    $('#service_request_table').DataTable({
        "scrollX": true,
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5', 'print']
    });
});
</script>