<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Data table</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">List of Articles</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-table-container">
                                <?php
                            // Fetch data from the service_request table
                            $results = mysqli_query($con, "SELECT * FROM service_request
                            LEFT JOIN users ON users.user_id = service_request.user_id
                            WHERE service_request.status = 'Approved' ");
                            ?>
                                <table class="table table-hover" id='service_request_table'>
                                    <thead>
                                        <tr>
                                            <th scope="col">Request ID</th>

                                            <th scope="col">Schedule</th>
                                            <th scope="col">Service Type</th>
                                            <th scope="col">Office / Agency</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Participants</th>

                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($results)) { 
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
                                            <td class="nowrap">
                                                <?php echo date('M j, Y', strtotime($row['scheduled_date'])); ?></td>

                                            <td><?php echo $row['service_type']; ?></td>
                                            <td><?php echo $row['office_agency']; ?></td>
                                            <td><span class="badge <?php echo $status_color; ?>">
                                                    <?php echo $row['status']; ?>
                                                </span></td>

                                            <td><?php echo $row['participants']; ?></td>

                                            <td>

                                                <button type="button" class="btn btn-sm btn-primary mb-1 btnEdit"
                                                    data-request='<?php echo json_encode($row); ?>'>
                                                    <i class="fas fa-book"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-dark mb-1 btnParticiapnts"
                                                    data-req='<?php echo json_encode($row); ?>'>
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>



                        </div>
                    </div>
                </div>


            </div><!-- .animated -->
        </div><!-- .content -->
        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>


</body>

</html>