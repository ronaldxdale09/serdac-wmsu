<?php
include '../function/db.php'; // Include your database connection

if(isset($_POST['request_id'])) {
    $request_id = mysqli_real_escape_string($con, $_POST['request_id']);
    
    $query = "SELECT * FROM asmt_forms WHERE request_id = '$request_id'";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['form_id'] . "</td>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['form_type'] . "</td>";
            echo "<td>" . $row['start_date'] . "</td>";
            echo "<td>" . $row['end_date'] . "</td>";
            echo "<td><a href='assmnt.form.php?form_id=" . $row['form_id'] . "' class='btn btn-sm btn-primary'>View</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No assessment forms found for this request.</td></tr>";
    }
} else {
    echo "<tr><td colspan='6'>Invalid request.</td></tr>";
}
?>