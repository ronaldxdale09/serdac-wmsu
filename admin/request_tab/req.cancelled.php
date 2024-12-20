<div class="table-responsive custom-table-container">
    <?php
                            // Fetch data from the service_request table
                            $results = mysqli_query($con, "SELECT * FROM service_request
                            LEFT JOIN users ON users.user_id = service_request.user_id
                            WHERE service_request.status = 'Cancelled' ");
                            ?>
    <table class="table table-hover" id='service_cancelled_table'>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">Client</th>

                <th scope="col">Date Cancelled</th>
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
                
                    case "Cancelled":
                        $status_color = 'badge-danger';
                        break;
                }  
                 $client = $row['fname'].' '.$row['lname'];

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
                <td><?php echo $client ?></td>

                <td class="nowrap"><?php echo date('M j, Y, h:i A', strtotime($row['cancelled_date'])); ?></td>

                <td><span class="badge <?php echo $type_color; ?>">
                        <?php echo $row['service_type']; ?>
                    </span>
                </td>
                <td><?php echo $row['office_agency']; ?></td>

                <td><?php echo $row['cancelled_remarks']; ?></td>

                <td>

                    <button type="button" class="btn btn-sm btn-primary mb-1 btnView"
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
    var table = $('#service_cancelled_table').DataTable({
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





// $('.btnView').on('click', function() {
//     var request = $(this).data('request');

//     $('#d_user-name').val(request.fname && request.lname ? request.fname + ' ' + request.lname :
//         'N/A');
//     $('#d_service-type').val(request.service_type || 'N/A');
//     $('#d_office-agency').val(request.office_agency || 'N/A');
//     $('#d_agency-classification').val(request.agency_classification || 'N/A');
//     $('#d_client-type').val(request.client_type || 'N/A');

//     $('#d_from_date').val(request.sched_from_date || 'N/A');
//     $('#d_to_date').val(request.sched_to_date || 'N/A');

//     $('#d_purpose').val(request.selected_purposes || 'N/A');
//     $('#d_additional_details').val(request.additional_purpose_details || 'N/A');

//     $('#d_remarks').val(request.scheduled_remarks || 'N/A');


//     var selectedDateTime = request.scheduled_date;

//     if (selectedDateTime) {
//         // Format the date and time
//         var formattedDateTime = new Date(selectedDateTime).toLocaleString('en-US', {
//             year: 'numeric',
//             month: 'long',
//             day: 'numeric',
//             hour: '2-digit',
//             minute: '2-digit'
//         });


//         document.querySelector('.d_selected_schedule').innerHTML = '<h5>Selected Schedule</h5><p>' +
//             formattedDateTime + '</p>';
//     }


//     var modal = new bootstrap.Modal(document.getElementById('reqserviceDetails'));
//     modal.show();

// });
</script>