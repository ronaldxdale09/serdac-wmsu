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
                <th scope="col">Req. ID</th>
                <th scope="col">Status</th>

                <th scope="col">Service Type</th>
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
                                                ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td><?php echo $row['service_type']; ?></td>
                <td><?php echo $row['office_agency']; ?></td>
                <td><?php echo $row['selected_purposes']; ?></td>
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

        // Basic data fill
        $('#p_user_id').val(request.user_id);
        $('#p_req_id').val(request.request_id);
        $('#p_user-name').val(request.fname + ' ' + request.lname);
        $('#service-type').val(request.service_type);
        $('#office-agency').val(request.office_agency);
        $('#agency-classification').val(request.agency_classification);
        $('#client-type').val(request.client_type);
        $('#purpose').val(request.selected_purposes);
        $('#additional_details').val(request.additional_purpose_details);

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

                    // Show the modal
                    var modal = new bootstrap.Modal(document.getElementById(
                        'dataAnalysisDetails'));
                    modal.show();
                }
            },
            error: function() {
                console.log('Error fetching details.');
            }
        });
        loadAndShowModal(serviceType, request.request_id)

    });

    function loadAndShowModal(serviceType, requestId) {

        console.log(serviceType)
        // Map service types to modal file paths and their corresponding IDs
        var modalInfo = {
            'data-analysis': {
                url: 'modal/modal.data_analysis.php',
                id: 'dataAnalysisDetails'
            },
            'technical-assistance': {
                url: 'modal/modal_technical.php',
                id: 'technicalAssistanceDetails'
            },
            'training': {
                url: 'modal/modal_training.php',
                id: 'trainingDetails'
            }
        };

        // Normalize the service type to match keys in the modalInfo object
        var serviceKey = serviceType.toLowerCase().replace(/\s+/g, '-');
        var modalDetails = modalInfo[serviceKey];

        if (modalDetails && modalDetails.url) {
            $.ajax({
                url: modalDetails.url,
                type: 'GET',
                data: {
                    request_id: requestId
                },
                success: function(html) {
                    // Append the fetched modal HTML to the body if not already loaded
                    if (!$('#' + modalDetails.id).length) {
                        $('body').append(html);
                    }

                    var modal = new bootstrap.Modal(document.getElementById(modalDetails.id));
                    modal.show();
                },
                error: function() {
                    console.error('Error loading the modal for', serviceType);
                }
            });
        } else {
            console.error('No modal URL found for the given service type:', serviceType);
        }
    }





    $(document).ready(function() {
        var table = $('#service_request_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdfHtml5', 'print']
        });
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
        var selectedDateTime = document.getElementById('schedule-date').value;

        if (selectedDateTime) {
            // Format the date and time
            var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });

            document.getElementById('p_sched_date').value = selectedDateTime;

            document.querySelector('.selected_schedule').innerHTML = '<h5>Selected Schedule</h5><p>' +
                formattedDateTime + '</p>';

            // Unhide the confirm service request button
            var submitBtn = document.getElementById('submit-request');
            submitBtn.removeAttribute('hidden');

            scheduleModal.hide();
        } else {
            alert('Please select a date and time.');
        }
    });
});
</script>