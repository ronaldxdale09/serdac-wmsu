<div class="table-responsive custom-table-container">
    <div class="table-header">
        <h2 class="table-title">User Service Participation</h2>
        <p class="table-description">This table displays all the services the user has participated in.
        </p>
    </div>

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
                // Initialize counters
                $total_requests = 0;
                $status_pending = 0;
                $status_approved = 0;
                $status_in_progress = 0;
                $status_cancelled = 0;
                $status_completed = 0;
                $service_data_analysis = 0;
                $service_capability_training = 0;
                $service_technical_assistance = 0;

                // Fetch data from the service_request and service_participant tables
                $query = "
                SELECT sr.*, sp.registration_date, u.fname, u.lname, u.midname,
                       (SELECT COUNT(*) FROM sr_meeting WHERE sr_meeting.request_id = sr.request_id) AS meeting_count,
                       (SELECT COUNT(*) FROM asmt_forms WHERE asmt_forms.request_id = sr.request_id) AS assessment_count
                FROM service_request AS sr
                JOIN service_participant AS sp ON sr.request_id = sp.request_id
                JOIN users AS u ON u.user_id = sp.user_id
                WHERE sp.user_id = $id AND service_type='capability-training'";

                $results = mysqli_query($con, $query);

                if(mysqli_num_rows($results) > 0){
                    while ($row = mysqli_fetch_array($results)) { 
                        $total_requests++;
                        switch ($row['status']) {
                            case "Pending":
                                $status_pending++;
                                break;
                            case "Approved":
                                $status_approved++;
                                break;
                            case "In Progress":
                                $status_in_progress++;
                                break;
                            case "Cancelled":
                                $status_cancelled++;
                                break;
                            case "Completed":
                                $status_completed++;
                                break;
                        }

                        switch ($row['service_type']) {
                            case "data-analysis":
                                $service_data_analysis++;
                                break;
                            case "capability-training":
                                $service_capability_training++;
                                break;
                            case "technical-assistance":
                                $service_technical_assistance++;
                                break;
                        }

                        $status_color = '';
                        switch ($row['status']) {
                            case "Pending":
                                $status_color = 'badge-primary';
                                break;
                            case "Approved":
                                $status_color = 'badge-warning';
                                break;
                            case "In Progress":
                                $status_color = 'badge-dark';
                                break;
                            case "Cancelled":
                                $status_color = 'badge-danger';
                                break;
                            case "Completed":
                                $status_color = 'badge-success';
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
                <td>
                    <?php echo $row['service_type']; ?>
                </td>
                <td><?php echo $row['office_agency']; ?></td>
                <td><?php echo $row['selected_purposes']; ?></td>
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <div class="button-grid">
                        <!-- View button -->
                        <button type="button" class="btn btn-sm btn-primary btnView"
                            data-request='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-book"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-info btnAssessment"
                            data-request-id="<?php echo $row['request_id']; ?>" data-toggle="tooltip"
                            title="Assessment Forms">
                            <i class="fas fa-clipboard-check"></i> Assessments <span
                                class="badge badge-light"><?php echo $row['assessment_count']; ?></span>
                        </button>
                    </div>
                </td>
            </tr>
            <?php
                    }
                } else {
                    echo '<tr><td colspan="6">No record found</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>