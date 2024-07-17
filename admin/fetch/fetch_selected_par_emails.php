<?php
include('../../function/db.php');




$sql = "SELECT user_id, CONCAT(fname, ' ', IFNULL(midname, ''), ' ', lname) AS fullName, 
               email, CONCAT(barangay, ', ', city, ', ', province, ' ', zipcode) AS address, 
               occupation 
        FROM users 
        WHERE userType = 'Client'";

$result = $con->query($sql);

$clients = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
}

echo json_encode($clients);

?>
