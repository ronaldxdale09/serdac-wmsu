<div class="table-responsive custom-table-container">
    <table class="table table-hover" id='service_request_table'>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Service</th>
                <th scope="col">Office</th>
                <th scope="col">Purpose</th>
                <th scope="col">Status</th>
                <th scope="col"></th>

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
                            case "In Progress":
                                    $status_color = 'badge-primary';
                                    break;
                            case "Cancelled":
                                $status_color = 'badge-danger';
                                break;
                        }

                        $type_color = '';
                        if ($row['service_type'] === "data-analysis") {
                            $type_color = 'badge-success';
                        } elseif ($row['service_type'] === "capability-training") {
                            $type_color = 'badge-primary';
                        } elseif ($row['service_type'] === "technical-assistance") {
                            $type_color = 'badge-dark';
                        }
                        ?>
            <tr>
                <td><?php echo $row['request_id']; ?></td>
                <td><span class="badge <?php echo $type_color; ?>">
                        <?php echo $row['service_type']; ?>
                    </span>
                </td>
                <td><?php echo $row['office_agency']; ?></td>
                <td><?php echo $row['selected_purposes']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span>

                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary  btnView"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-book"></i>
                    </button>
                    <?php if ($row['service_type'] === "data-analysis" && $row['status'] === "In Progress") { ?>
                    <button type="button" class="btn btn-sm btn-dark btnRequirement"
                        data-request='<?php echo json_encode($row); ?>'>
                        <i class="fas fa-tasks"></i> Docu
                    </button>
                    <?php } ?>
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

<?php include('modal/service_analysis.req.php');?>