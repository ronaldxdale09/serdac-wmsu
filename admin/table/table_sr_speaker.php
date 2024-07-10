<?php
include('../../function/db.php');

$request_id = $_POST['request_id'];

// Fetch initial speaker records
$query = "SELECT * FROM sr_speaker WHERE request_id = $request_id";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

// Prepare the select HTML for speakers
$speakerQuery = "SELECT speaker_id, name FROM speaker_profile"; // Assuming you have a table `speakers` with speaker details
$speakerResult = mysqli_query($con, $speakerQuery);
$speakerOptions = [];
while ($speaker = mysqli_fetch_assoc($speakerResult)) {
    $speakerOptions[$speaker['speaker_id']] = $speaker['name'];
}

$selectHTML = '<select class="form-control speaker-select" name="speaker_id[]">';
foreach ($speakerOptions as $id => $name) {
    $selectHTML .= "<option value=\"$id\">$name</option>";
}
$selectHTML .= '</select>';

$output = '
<table class="table " id="speakerTable">
    <thead class="table-dark">
        <tr>
            <th>Speaker</th>
            <th>Topic</th>
            <th></th>
        </tr>
    </thead>
    <tbody>';

while ($row = mysqli_fetch_assoc($result)) {
    $selectedSpeakerHTML = str_replace('value="' . $row['speaker_id'] . '"', 'value="' . $row['speaker_id'] . '" selected', $selectHTML);

    $output .= '
        <tr>
            <td>' . $selectedSpeakerHTML . '</td>
            <td><input type="text" class="form-control" style="border: 1px solid #00235e;" name="topic[]" value="' . htmlspecialchars($row['topic'], ENT_QUOTES, 'UTF-8') . '"></td>
            <td><button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button></td>
        </tr>';
}

$output .= '</tbody></table>
<a href="speaker_profile.php" type="button" class="btn btn-dark" target="_blank">
  <i class="fas fa-user-cog"></i> Manage Speaker
</a>
<button type="button" class="btn btn-primary" id="addSpeaker">
  <i class="fas fa-user-plus"></i> Add Speaker
</button>';

echo $output;
?>

<script>
$(document).ready(function() {

    var selectHTML = '<?php echo $selectHTML; ?>'; // Speaker select HTML

    $('#addSpeaker').click(function() {
        var newRow = $('<tr>').append(
            $('<td>').html(selectHTML),
            $('<td>').html(
                '<input type="text" style="border: 1px solid #00235e;" class="form-control" name="topic[]">'
                ),
            $('<td>').html(
                '<button type="button" class="btn btn-sm btn-danger remove-item"><i class="fa fa-trash"></i></button>'
                )
        );
        $('#speakerTable tbody').append(newRow);
    });

    $(document).on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
    });
});
</script>