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
    $('.btnEdit').on('click', function() {
        var request = $(this).data('request');


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
            $('#service-specific').load(serviceTypeUrl, function(response, status, xhr) {
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



                document.querySelectorAll('button').forEach(function(button) {
                    if (button.innerHTML.includes('Cancel Request') ||
                        button.innerHTML.includes('Assign Schedule')) {
                        button.style.display = 'inline-block'; // Show the buttons
                    }
                });
                // Show the modal
                var modal = new bootstrap.Modal(document.getElementById(
                    'serviceRequestDetailsModal'));
                modal.show();
            },
            error: function() {
                console.log('Error fetching details.');
            }
        });




    });





    $(document).ready(function() {
        var serviceRequestModal = new bootstrap.Modal(document.getElementById(
            'serviceRequestDetailsModal'));
        var scheduleModal = new bootstrap.Modal(document.getElementById('scheduleModal'));

        document.getElementById('assign-sched').addEventListener('click', function() {
            console.log("Hiding service request modal and showing schedule modal.");
            serviceRequestModal.hide();
            scheduleModal.show();
        });

        document.getElementById('confirm-schedule').addEventListener('click', function() {
            var selectedDateTime = document.getElementById('schedule-date').value;
            console.log("Selected DateTime: " + selectedDateTime);

            if (selectedDateTime) {
                var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById('p_sched_date').value = selectedDateTime;
                document.querySelector('.selected_schedule').innerHTML =
                    '<h5>Selected Schedule</h5><p>' + formattedDateTime + '</p>';

                var submitBtn = document.getElementById('submit-request');
                submitBtn.removeAttribute('hidden');
                console.log("Submit button should now be visible.");

                scheduleModal.hide();
            } else {
                alert('Please select a date and time.');
            }
        });
    });



    $(document).ready(function() {
        var table = $('#service_request_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdfHtml5', 'print']
        });
    });


});
</script>