<?php
    include('../../function/db.php');

$request_id = $_POST['request_id'];  // Ensure you're sending the log_id or appropriate criteria from the front-end.

// Query to get the bank transaction logs from the database
$query = "SELECT * FROM service_participant
LEFT JOIN users on users.user_id = service_participant.user_id
 WHERE request_id = '$request_id'";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$output = '

<hr>
<h4> Participants </h4> <br>
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
    $formattedDate = date('M j, Y', ($row['registration_date']));
    
    // Append row data to output
    $output .= '
    <tr>
        <td >' . $i++ . '</td>
        <td>' . $fullname . '</td>
        <td>' . $row['email'] . '</td>

        <td class="nowrap">' . $formattedDate . '</td>

    </tr>
';
}

$output .= '
    </tbody>
</table>';

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