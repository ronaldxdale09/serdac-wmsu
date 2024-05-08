<?php
include('../../function/db.php');

$request_id = $_POST['request_id'];  // Ensure this is safely handled

// Fetch documents related to the specific request ID
$query = "SELECT * FROM sr_dataanalysis_files WHERE type='Result' and request_id = $request_id";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}


function formatSizeUnits($bytes) {
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}


$output = '
<br>
<table class="table" style="width: 100% !important;" id="docResTable">
    <thead class="table-dark">
        <tr>
            <th>Filename</th>
            <th>Size</th>
            <th>Date Submitted</th>
            <th>Remarks</th>
            <th>Type</th>

            <th>Action</th>
        </tr>
    </thead>
    <tbody>';

// Check if there are any records returned by the query
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $fileSizeFormatted = formatSizeUnits($row['size']);
        $fileUrl = "../files/uploads/" . rawurlencode($row['filename']); // Adjust the path as per your uploads directory
        $dateFormatted = date('M d, Y', strtotime($row['date_uploaded']));

        $output .= '
            <tr>
                <td>' . htmlspecialchars($row['filename'], ENT_QUOTES, 'UTF-8') . '</td>
                <td>' . $fileSizeFormatted . '</td>
                <td>' . $dateFormatted . '</td>
                <td><textarea class="form-control" readonly name="remarks[]">' . htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8') . '</textarea></td>
                <td>Result</td>
                <td><a href="' . $fileUrl . '" class="btn btn-sm btn-success" download>Download</a></td>
            </tr>';
    }
} else {
    // Display a professional message if no documents are uploaded
    $output .= '<tr><td colspan="3" class="text-center">No documents available for download at this time.</td></tr>';
}

$output .= '</tbody></table>';


echo $output;
?>
