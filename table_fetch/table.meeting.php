<style>
.meeting-accordion .meeting-panel {
    border-bottom: 1px solid #ccc;
}

.meeting-accordion .meeting-header {
    background: #a3c0f0;
    
    /* Light gray background */
    border-top: 1px solid #ddd;
}

.meeting-accordion .meeting-toggle {
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    padding: 12px 15px;
    font-size: 1rem;
    font-weight: bold;
    color: #242424;
    transition: background-color 0.3s ease;
}

.meeting-accordion .meeting-toggle:hover,
.meeting-accordion .meeting-toggle:focus {
    background-color: #d2d2d2;
    /* Slight highlight on hover/focus */
    text-decoration: none;
    /* No underline */
    outline: none;
}

.meeting-accordion .collapse:not(.show) {
    display: none;
}

.meeting-accordion .meeting-body {
    padding: 15px;
    background: #fff;
    transition: padding 0.3s ease;
}

.form-control,
.form-control:focus {
    border-radius: 4px;
    border: 1px solid #ced4da;
    box-shadow: none;
}

textarea.form-control {
    height: 80px;
}

.btn-danger {
    margin-top: 10px;
}
</style>
<?php
include('../function/db.php');

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
$selectHTML = '<select class="form-control" name="meeting_type[]" disabled>';
foreach ($meetingTypes as $key => $type) {
    $selectHTML .= "<option value=\"$key\">$type</option>";
}
$selectHTML .= '</select>';

// Prepare the select HTML for mode options
$modeSelectHTML = '<select class="form-control" name="mode[]" disabled>';
foreach ($modeOptions as $value => $text) {
    $modeSelectHTML .= "<option value=\"$value\">$text</option>";
}
$modeSelectHTML .= '</select>';

// Start the output with a div container for the accordion
$output = '<div id="meetingAccordion" class="meeting-accordion">';

$index = 0;  // Initialize index for accordion collapse control
while ($row = mysqli_fetch_assoc($result)) {
    $dateValue = date('Y-m-d\TH:i', strtotime($row['date_time']));
    $selectedTypeHTML = str_replace('value="' . $row['meeting_type'] . '"', 'value="' . $row['meeting_type'] . '" selected', $selectHTML);
    $selectedModeHTML = str_replace('value="' . $row['mode'] . '"', 'value="' . $row['mode'] . '" selected', $modeSelectHTML);
    $formattedDate = date('F j, Y', strtotime($row['date_time']));  // Format the date
    $meetingType = $meetingTypes[$row['meeting_type']];  // Get the meeting type from the array using the ID

    // Each row becomes a collapsible panel
    $output .= '
    <div class="meeting-panel">
        <div class="meeting-header" id="heading' . $index . '">
            <button type="button" class="meeting-toggle collapsed" data-toggle="collapse" data-target="#collapse' . $index . '" aria-expanded="false" aria-controls="collapse' . $index . '">
                <i class="fa fa-chevron-down"></i> ' . $meetingType . ' - ' . $formattedDate . '
            </button>
        </div>
        <div id="collapse' . $index . '" class="collapse" aria-labelledby="heading' . $index . '" data-parent="#meetingAccordion">
            <div class="meeting-body">
                <div><strong>Type:</strong> ' . $selectedTypeHTML . '</div>
                <strong>Date and Time:</strong><input type="datetime-local" readonly  class="form-control" name="date_time[]" value="' . $dateValue . '"> 
                <div><strong>Mode:</strong> ' . $selectedModeHTML . '</div>
                <div><strong>Remarks:</strong> <textarea class="form-control" readonly name="remarks[]">' . htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8') . '</textarea></div>
            </div>
        </div>
    </div>';
$index++;  // Increment index for the next panel
}

echo $output;

?>
