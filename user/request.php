<div class="table-responsive custom-table-container">
    <table class="table table-hover" id='service_request_table'>
        <thead>
            <tr>
                <th scope="col">Request ID</th>
                <th scope="col">Service Type</th>
                <th scope="col">Office / Agency</th>
                <th scope="col">Purpose</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Fetch data from the service_request table
                $results = mysqli_query($con, "SELECT * FROM service_request
                LEFT JOIN users ON users.user_id = service_request.user_id
                WHERE users.user_id=$id ");

                if(mysqli_num_rows($results) > 0){
                    while ($row = mysqli_fetch_array($results)) { 
                        // Status color coding (optional)
                        $status_color = '';
                        switch ($row['status']) {
                            case "Pending":
                                $status_color = 'badge-warning';
                                break;
                            case "Approved":
                                $status_color = 'badge-success';
                                break;
                            case "Rejected":
                                $status_color = 'badge-danger';
                                break;
                        }
                        ?>
                        <tr>
                            <td><?php echo $row['request_id']; ?></td>
                            <td><?php echo $row['service_type']; ?></td>
                            <td><?php echo $row['office_agency']; ?></td>
                            <td><?php echo $row['purpose']; ?></td>
                            <td><span class="badge <?php echo $status_color; ?>">
                                    <?php echo $row['status']; ?>
                                </span></td>
                            <td>
                                <!-- Other columns or action buttons if any -->
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5">No record found</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
