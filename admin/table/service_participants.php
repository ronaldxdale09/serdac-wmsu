<?php
    include('../../function/db.php');

$request_id = $_POST['request_id'];  // Ensure you're sending the log_id or appropriate criteria from the front-end.

// Query to get the bank transaction logs from the database
$query = "SELECT *,service_participant.registration_date as join_date FROM service_participant
LEFT JOIN users on users.user_id = service_participant.user_id
 WHERE request_id = '$request_id'";
$result = mysqli_query($con, $query);
// Initialize the total participants count
$totalParticipants = 0;

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}
$output = '
<hr>
<h4> Participants </h4> <br>

<!-- Total Participants Card -->
<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Total Participants</h5>
        <p class="card-text" id="total-participants">Loading...</p>
    </div>
</div>

<!-- Button to toggle the collapse -->
<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#participantsCollapse" aria-expanded="false" aria-controls="participantsCollapse">
    Show/Hide Participants
</button>

<!-- Collapsible table -->
<div class="collapse" id="participantsCollapse">
    <div class="card card-body mt-3">
        <table class="table table-hover table-bordered table-striped" id="bank_trans_log_table">
            <thead class="table-dark">
            <tr style="font-weight: normal;">
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Joined Date</th>
            </tr>
            </thead>
            <tbody>';

$i = 1;
// Fetch the data from the database and output each row
while ($row = mysqli_fetch_assoc($result)) {
    $fullname = $row['fname'].' '.$row['midname'].' '.$row['lname'];
    $registrationDate = $row['join_date'];

    // Default value in case of invalid date
    $formattedDate = 'N/A';
    // Increment the total participants count
    $totalParticipants++;
    if ($registrationDate) {
        // Use DateTime::createFromFormat to handle the date
        $date = DateTime::createFromFormat('Y-m-d', $registrationDate);
        if ($date && $date->format('Y-m-d') === $registrationDate) {
            $formattedDate = $date->format('M j, Y');
        }
    }

    // Append row data to output
    $output .= '
    <tr>
        <td>' . $i++ . '</td>
        <td>' . $fullname . '</td>
        <td>' . $row['email'] . '</td>
        <td class="nowrap">' . $formattedDate . '</td>
    </tr>';
}

$output .= '
            </tbody>
        </table>
    </div>
</div>

<script>
// Set the total participants count
document.getElementById("total-participants").textContent = "' . $totalParticipants . '";
</script>

';

echo $output;
?>


<script>
var table_logs = $('#bank_trans_log_table').DataTable({
    "pageLength": 25,

    dom: '<"top"<"left-col"B><"center-col"f>>rti<"bottom"p><"clear">',

    order: [
        [0, 'desc']
    ],
    buttons: [{
            extend: 'excelHtml5',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            }
        },
        {
            extend: 'pdfHtml5',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
            }
        },
        {
            extend: 'print',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7]
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