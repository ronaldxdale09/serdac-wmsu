<?php
include('../../function/db.php');

$bank_id = $_POST['bank_id'];  // Ensure you're sending the log_id or appropriate criteria from the front-end.

// Query to get the bank transaction logs from the database
$query = "SELECT * FROM bank_trans_logs WHERE bank_id = '$bank_id'";
$result = mysqli_query($con, $query);

// Check if the query was successful
if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$output = '
<br>
<hr>
<div id="filter-container" class="container mb-3">
    <div class="row">
        <!-- Date Range Filters -->
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="form-group">
                <label for="min-date">Start Date:</label>
                <input type="date" id="min-date" name="min-date" class="form-control">
            </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="form-group">
                <label for="max-date">End Date:</label>
                <input type="date" id="max-date" name="max-date" class="form-control">
            </div>
        </div>

        <!-- Source Filter -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="form-group">
                <label for="source-filter">Source:</label>
                <select id="source-filter" name="source-filter" class="form-control">
                    <option value="" selected>All</option>
                    <option value="Bank Withdrawal">Bank Withdrawal</option>
                    <option value="Check cleared">Check cleared</option>
                    <option value="Bank Deposit">Bank Deposit</option>
                </select>
            </div>
        </div>

        <!-- Apply Filters Button -->
        
    </div>
    <div class="col-12 col-sm-6 col-lg-2 d-flex align-items-end">
            <button id="apply-filters" class="btn btn-primary w-100 mt-2 mt-lg-0">Apply Filter</button>
        </div>
</div>



<!-- Your existing table here -->

<hr>
<h4> Bank Transaction Logs </h4>
<table class="table table-hover table-bordered table-striped" id="bank_trans_log_table">
    <thead class="table-dark">
    <tr style="font-weight: normal;">
        <th scope="col">Log ID</th>
        <th scope="col">Date</th>
        <th scope="col">Previous Balance</th>
        <th scope="col">New Balance</th>
        <th scope="col">Change</th>
        <th scope="col">Source</th>
    </tr>
    </thead>
    <tbody>';

// Fetch the data from the database and output each row
while ($row = mysqli_fetch_assoc($result)) {

    // Append row data to output
    $output .= '
    <tr>
        <td >' . $row["log_id"] . '</td>
        <td class="nowrap">' .  date('M j, Y', strtotime($row['date'])) . '</td>
        <td>₱' . number_format($row["prev_balance"], 2) . '</td>
        <td>₱' . number_format($row["new_balance"], 2) . '</td>
        <td>₱' . number_format($row["new_balance"] - $row["prev_balance"], 2) . '</td>
        <td>' . $row["source"] . '</td>
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

// Custom filtering function for date range
$.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            var min = $('#min-date').val() ? new Date($('#min-date').val()) : null;
            var max = $('#max-date').val() ? new Date($('#max-date').val()) : null;
            var date = new Date(data[1]); // Adjust this index to match the date column in your table

            if ((min == null && max == null) ||
                (min == null && date <= max) ||
                (min <= date && max == null) ||
                (min <= date && date <= max)) {
                return true;
            }
            return false;
        }
    );

// Event listener for filtering
$('#apply-filters').click(function() {
    var sourceFilter = $('#source-filter').val();

    // Apply the source filter
    table_logs.column(5).search(sourceFilter).draw(); // Adjust the index as per your source column

    // Apply the date range filter
    $.fn.dataTable.ext.search.draw();
});
</script>