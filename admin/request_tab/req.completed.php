
<div class="row">
    <!-- Check Status Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterStatus"> Service Type:</label>
        <select id="filterStatus" class="form-control">
            <option value="">All</option>
            <option value="Shipped Out">Capability Training</option>
            <option value="Sold">Data Analysis</option>
            <option value="In Progress">In Progress</option>

        </select>
    </div>


    <!-- Month Filter -->
    <div class="col-md-3 mb-3">
        <label for="filterMonth">Month:</label>
        <select id="filterMonth" class="form-control">
            <option value="">All</option>
            <?php
            for ($i = 1; $i <= 12; $i++) {
                echo '<option value="' . $i . '">' . date("F", mktime(0, 0, 0, $i, 10)) . '</option>';
            }
            ?>
        </select>
    </div>
    <div class="col-md-3 mb-3">
        <label for="filterYear">Year:</label>
        <select id="filterYear" class="form-control">
            <option value="">All</option>
            <?php
            $currentYear = date("Y");
            $startYear = 2022;
            for ($i = $startYear; $i <= $currentYear; $i++) {
                echo '<option value="' . $i . '">' . $i . '</option>';
            }
            ?>
        </select>
    </div>

</div>

<div class="table-responsive custom-table-container">
    <?php
                            // Fetch data from the service_request table
                            $results = mysqli_query($con, "SELECT * FROM service_request
                            LEFT JOIN users ON users.user_id = service_request.user_id
                            WHERE service_request.status = 'Completed' ");
                            ?>
    <table class="table table-hover" id='service_completed_table'>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Status</th>
                <th scope="col">Client</th>

                <th scope="col">Service Type</th>
                <th scope="col">Agency</th>

                <th scope="col">Remarks</th>


                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_array($results)) { 
                // Status color coding (optional)
            $status_color = '';
            $type_color = '';
            switch ($row['status']) {
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
                <td><span class="badge <?php echo $status_color; ?>">
                        <?php echo $row['status']; ?>
                    </span></td>

                <td class='nowrap'><?php echo $row['fname'].' '.$row['lname'].' '; ?></td>


                <td><span class="badge <?php echo $type_color; ?>">
                        <?php echo $row['service_type']; ?>
                    </span></td>
                <td><?php echo $row['office_agency']; ?></td>


                <td><?php echo $row['inprogress_remarks']; ?></td>

                <td>
                    <div class="button-grid">
                        <button type="button" class="btn btn-sm btn-primary btnComView" data-toggle="tooltip"
                            data-placement="top" title="View Request" data-request='<?php echo json_encode($row); ?>'>
                            <i class="fas fa-book"></i> Details
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary btnComMeeting"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip"
                            title="Progress Meeting">
                            <i class="fas fa-calendar"></i> Meetings
                        </button>

                        <?php if ($row['service_type'] == 'data-analysis'): ?>
                        <button type="button" class="btn btn-sm btn-warning text-dark btnRequirement"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Requirements">
                            <i class="fas fa-tasks"></i> Documents
                        </button>
                        <?php endif; ?>

                        <?php if ($row['service_type'] == 'capability-training'): ?>
                        <button type="button" class="btn btn-sm btn-dark btnSpeaker"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Speaker">
                            <i class="fas fa-users"></i> Speakers
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btnParticiapnts"
                            data-request='<?php echo json_encode($row); ?>' data-toggle="tooltip" title="Participants">
                            <i class="fas fa-user-friends"></i> Participants
                        </button>



                        <?php endif; ?>

                    </div>


                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
 
</div>
