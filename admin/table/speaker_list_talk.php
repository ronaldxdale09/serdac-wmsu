<?php
include('../../function/db.php');

$speaker_id = $_POST['speaker_id'];  // Ensure you're sending the speaker_id from the front-end.

// Query to get the service request details along with the speaker's participation details
// Query to get the service request details along with the speaker's participation details
$query = "
    SELECT 
        spk.name AS speaker_name,
        spk.email AS speaker_email,
        srq.service_type AS service_type,
        sr.topic AS service_topic,
        srq.scheduled_date AS service_date,
        srp.registration_date AS join_date
    FROM sr_speaker sr
    LEFT JOIN service_request srq ON sr.request_id = srq.request_id
    LEFT JOIN speaker_profile spk ON spk.speaker_id = sr.speaker_id
    LEFT JOIN service_participant srp ON srp.request_id = srq.request_id
    WHERE sr.speaker_id = '$speaker_id'
";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$output = '
<hr>
<div class="table-responsive custom-table-container">

<table class="table" style="width: 100% !important;" id="service_request_table">
    <thead class="table-dark">
    <tr style="font-weight: normal;">
        <th scope="col">#</th>
        <th scope="col">Full Name</th>
        <th scope="col">Service Type</th>
        <th scope="col">Topic</th>
        <th scope="col">Service Date</th>
    </tr>
    </thead>
    <tbody>';

$i = 1;
// Fetch the data from the database and output each row
while ($row = mysqli_fetch_assoc($result)) {
    $fullname = $row['speaker_name'];
    $registrationDate = $row['join_date'];
    $serviceDate = $row['service_date'];

    // Format dates
    $formattedJoinDate = $registrationDate ? DateTime::createFromFormat('Y-m-d', $registrationDate)->format('M j, Y') : 'N/A';
    $formattedServiceDate = $serviceDate ? DateTime::createFromFormat('Y-m-d H:i:s', $serviceDate)->format('M j, Y g:i A') : 'N/A';

    // Append row data to output
    $output .= '
    <tr>
        <td>' . $i++ . '</td>
        <td>' . $fullname . '</td>
        <td>' . $row['service_type'] . '</td>
        <td>' . $row['service_topic'] . '</td>
        <td>' . $formattedServiceDate . '</td>
    </tr>';
}

$output .= '
    </tbody>
</table> </div>';

echo $output;
?>

<script>
var table_logs = $('#service_request_table').DataTable({
    "pageLength": 25,
    dom: '<"top"<"left-col"B><"center-col"f>>rti<"bottom"p><"clear">',
    order: [
        [0, 'desc']
    ],
    buttons: [{
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6]
            }
        }
    ],
    lengthMenu: [
        [-1],
        ["All"]
    ],
    orderCellsTop: true,
    infoCallback: function(settings, start, end, max, total, pre) {
        return total + ' entries';
    }
});
</script>