<?php include('include/header.php');

// Execute SQL query to get the average completion time for completed requests
$result = $con->query("SELECT AVG(DATEDIFF(completed_date, request_date)) AS avg_time FROM service_request WHERE status = 'Completed'");
if ($result) {
    $row = $result->fetch_assoc();
    $avgResolutionTime = round($row['avg_time'], 2);
} else {
    $avgResolutionTime = 0; // default or error handling
}

// Execute SQL query to get the count of requests by client type
$results = $con->query("SELECT client_type, COUNT(*) AS count FROM service_request GROUP BY client_type");
$clientTypes = [];
while ($row = $results->fetch_assoc()) {
    $clientTypes[$row['client_type']] = $row['count'];
}

// Execute SQL query to get monthly request counts
$result = $con->query("SELECT MONTH(request_date) AS month, COUNT(*) AS count FROM service_request WHERE YEAR(request_date) = YEAR(CURDATE()) GROUP BY MONTH(request_date)");
$monthlyCounts = [];
while ($row = $result->fetch_assoc()) {
    $monthlyCounts[$row['month']] = $row['count'];
}

?>
    <link rel="stylesheet" href="css/dashboard.css">

<body>

    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="content">
            <!-- Animated -->
            <div class="animated fadeIn">
                <!-- Widgets  -->
                <?php include('statistical_card/dashboard_card.php')?>

                <!-- /Widgets -->
                <!--  Traffic  -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="box-title">Service Type Demand Overview</h4>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-body">
                                        <!-- Pie Chart for Service Request Types -->
                                        <canvas id="service-type-chart"></canvas>
                                    </div>
                                </div>

                            </div> <!-- /.row -->
                            <div class="card-body">
                                <!-- Stat Cards Container -->
                                <div class="stat-cards">

                                    <!-- Average Resolution Time Card -->
                                    <div class="stat-card">
                                        <h4 class="stat-title">Average Resolution Time</h4>
                                        <div class="stat-value"><?php echo $avgResolutionTime; ?> days</div>
                                        <div class="stat-icon">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <!-- Requests by Client Type Card -->
                                    <div class="stat-card">
                                        <h4 class="stat-title">Requests by Client Type</h4>
                                        <?php foreach ($clientTypes as $type => $count): ?>
                                        <div class="stat-text"><?php echo $type; ?>: <?php echo $count; ?></div>
                                        <?php endforeach; ?>
                                        <div class="stat-icon">
                                            <i class="fa fa-users" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <!-- Monthly Requests Card -->
                                    <div class="stat-card">
                                        <h4 class="stat-title">Monthly Requests</h4>
                                        <?php foreach ($monthlyCounts as $month => $count): ?>
                                        <div class="stat-text">Month <?php echo $month; ?>: <?php echo $count; ?></div>
                                        <?php endforeach; ?>
                                        <div class="stat-icon">
                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div><!-- /# column -->
                </div>
                <!--  /Traffic -->

                <!--  /Traffic -->
                <div class="clearfix"></div>
                <!-- Orders -->
                <div class="orders">
                    <div class="row">
                        <div class="col-xl-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Orders </h4>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table ">
                                            <thead>
                                                <tr>
                                                    <th class="serial">#</th>
                                                    <th class="avatar">Avatar</th>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="serial">1.</td>
                                                    <td class="avatar">
                                                        <div class="round-img">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/avatar/1.jpg" alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> #5469 </td>
                                                    <td> <span class="name">Louis Stanley</span> </td>
                                                    <td> <span class="product">iMax</span> </td>
                                                    <td><span class="count">231</span></td>
                                                    <td>
                                                        <span class="badge badge-complete">Complete</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">2.</td>
                                                    <td class="avatar">
                                                        <div class="round-img">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/avatar/2.jpg" alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> #5468 </td>
                                                    <td> <span class="name">Gregory Dixon</span> </td>
                                                    <td> <span class="product">iPad</span> </td>
                                                    <td><span class="count">250</span></td>
                                                    <td>
                                                        <span class="badge badge-complete">Complete</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">3.</td>
                                                    <td class="avatar">
                                                        <div class="round-img">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/avatar/3.jpg" alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> #5467 </td>
                                                    <td> <span class="name">Catherine Dixon</span> </td>
                                                    <td> <span class="product">SSD</span> </td>
                                                    <td><span class="count">250</span></td>
                                                    <td>
                                                        <span class="badge badge-complete">Complete</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="serial">4.</td>
                                                    <td class="avatar">
                                                        <div class="round-img">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/avatar/4.jpg" alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> #5466 </td>
                                                    <td> <span class="name">Mary Silva</span> </td>
                                                    <td> <span class="product">Magic Mouse</span> </td>
                                                    <td><span class="count">250</span></td>
                                                    <td>
                                                        <span class="badge badge-pending">Pending</span>
                                                    </td>
                                                </tr>
                                                <tr class=" pb-0">
                                                    <td class="serial">5.</td>
                                                    <td class="avatar pb-0">
                                                        <div class="round-img">
                                                            <a href="#"><img class="rounded-circle"
                                                                    src="images/avatar/6.jpg" alt=""></a>
                                                        </div>
                                                    </td>
                                                    <td> #5465 </td>
                                                    <td> <span class="name">Johnny Stephens</span> </td>
                                                    <td> <span class="product">Monitor</span> </td>
                                                    <td><span class="count">250</span></td>
                                                    <td>
                                                        <span class="badge badge-complete">Complete</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col-lg-8 -->

                        <div class="col-xl-4">
                            <div class="row">
                                <div class="col-lg-6 col-xl-12">
                                    <div class="card br-0">
                                        <div class="card-body">
                                            <div class="chart-container ov-h">
                                                <div id="flotPie1" class="float-chart"></div>
                                            </div>
                                        </div>
                                    </div><!-- /.card -->
                                </div>

                                <div class="col-lg-6 col-xl-12">
                                    <div class="card bg-flat-color-3  ">
                                        <div class="card-body">
                                            <h4 class="card-title m-0  white-color ">August 2018</h4>
                                        </div>
                                        <div class="card-body">
                                            <div id="flotLine5" class="flot-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.col-md-4 -->
                    </div>
                </div>
                <!-- /.orders -->
                <!-- To Do and Live Chat -->

                <!-- /To Do and Live Chat -->
                <!-- Calender Chart Weather  -->
                <div class="row">


                    <div class="col-lg-4 col-md-6">
                        <div class="card ov-h">
                            <div class="card-body bg-flat-color-2">
                                <div id="flotBarChart" class="float-chart ml-4 mr-4"></div>
                            </div>
                            <div id="cellPaiChart" class="float-chart"></div>
                        </div><!-- /.card -->
                    </div>

                </div>
                <!-- /Calender Chart Weather -->
                <!-- Modal - Calendar - Add New Event -->
                <div class="modal fade none-border" id="event-modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><strong>Add New Event</strong></h4>
                            </div>
                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect"
                                    data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success save-event waves-effect waves-light">Create
                                    event</button>
                                <button type="button" class="btn btn-danger delete-event waves-effect waves-light"
                                    data-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /#event-modal -->
                <!-- Modal - Calendar - Add Category -->
                <div class="modal fade none-border" id="add-category">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"
                                    aria-hidden="true">&times;</button>
                                <h4 class="modal-title"><strong>Add a category </strong></h4>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label">Category Name</label>
                                            <input class="form-control form-white" placeholder="Enter name" type="text"
                                                name="category-name" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Choose Category Color</label>
                                            <select class="form-control form-white" data-placeholder="Choose a color..."
                                                name="category-color">
                                                <option value="success">Success</option>
                                                <option value="danger">Danger</option>
                                                <option value="info">Info</option>
                                                <option value="pink">Pink</option>
                                                <option value="primary">Primary</option>
                                                <option value="warning">Warning</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect"
                                    data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light save-category"
                                    data-dismiss="modal">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>

    <!--Local Stuff-->
    <script>
    $(document).ready(function() {
        var ctx = $('#service-type-chart').get(0).getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Number of Requests',
                    data: [],
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)', // Bright red
                        'rgba(54, 162, 235, 1)', // Bright blue
                        'rgba(255, 206, 86, 1)', // Bright yellow
                        'rgba(75, 192, 192, 1)' // Bright teal
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Fetch data using jQuery AJAX
        $.ajax({
            url: 'fetch/fetch_serviceDisChart.php',
            method: 'GET',
            success: function(data) {
                data.forEach(function(item) {
                    chart.data.labels.push(item.service_type);
                    chart.data.datasets[0].data.push(parseInt(item.count, 10));
                });
                chart.update();
            },
            error: function(xhr, status, error) {
                console.error("AJAX error: Status", status, "Error", error);
            }
        });

    });
    </script>

</body>

</html>