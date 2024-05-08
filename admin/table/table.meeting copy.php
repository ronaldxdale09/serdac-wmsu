<?php
include('../../function/db.php');

$request_id = $_POST['request_id'];

// Fetch initial meeting records
$query = "SELECT * FROM sr_meeting WHERE request_id = $request_id";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

// Fetch meeting types from the database
$typeQuery = "SELECT mtype_id, meeting_type FROM d_meeting_type";
$typeResult = mysqli_query($con, $typeQuery);
if (!$typeResult) {
    die('Failed to retrieve meeting types: ' . mysqli_error($con));
}

$meetingTypes = [];
while ($typeRow = mysqli_fetch_assoc($typeResult)) {
    $meetingTypes[$typeRow['mtype_id']] = $typeRow['meeting_type'];
}

$modeOptions = [
    'face2face' => 'Face-to-Face',
    'online' => 'Online'
];

// Prepare the select HTML for meeting types
$selectHTML = '<select class="form-control" name="meeting_type[]">';
foreach ($meetingTypes as $key => $type) {
    $selectHTML .= "<option value=\"$key\">$type</option>";
}
$selectHTML .= '</select>';

// Prepare the select HTML for mode options
$modeSelectHTML = '<select class="form-control" name="mode[]">';
foreach ($modeOptions as $value => $text) {
    $modeSelectHTML .= "<option value=\"$value\">$text</option>";
}
$modeSelectHTML .= '</select>';

$output = '
<table class="table table-hover table-bordered" id="meetingTable">
    <thead class="table-primary">
        <tr>
            <th>Meeting Type</th>
            <th>Date and Time</th>
            <th>Mode</th>
            <th>Remarks</th>
            <th></th>
        </tr>
    </thead>
    <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $dateValue = date('Y-m-d\TH:i', strtotime($row['date_time']));
    $selectedTypeHTML = str_replace('value="' . $row['meeting_type'] . '"', 'value="' . $row['meeting_type'] . '" selected', $selectHTML);
    $selectedModeHTML = str_replace('value="' . $row['mode'] . '"', 'value="' . $row['mode'] . '" selected', $modeSelectHTML);

    $output .= '
        <tr>
            <td>' . $selectedTypeHTML . '</td>
            <td><input type="datetime-local" class="form-control" name="date_time[]" value="' . $dateValue . '"></td>
            <td>' . $selectedModeHTML . '</td>
            <td><textarea class="form-control" name="remarks[]">' . htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8') . '</textarea></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button></td>
        </tr>';
}

$output .= '</tbody></table>
<button type="button" class="btn btn-primary" id="addMeeting">Add New Meeting</button>';

echo $output;
?>

<script>
$(document).ready(function() {
    var selectHTML = '<?php echo $selectHTML; ?>'; // Meeting type select
    var modeSelectHTML = '<?php echo $modeSelectHTML; ?>'; // Mode select

    $('#addMeeting').click(function() {
        var newRow = $('<tr>').append(
            $('<td>').html(selectHTML),
            $('<td>').html('<input type="datetime-local" class="form-control" name="date_time[]">'),
            $('<td>').html(modeSelectHTML),
            $('<td>').html('<textarea class="form-control" name="remarks[]"></textarea>'),
            $('<td>').html(
                '<td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button></td>')
        );
        $('#meetingTable tbody').append(newRow);
    });

    $(document).on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
    });
});
</script>
