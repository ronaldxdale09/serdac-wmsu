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
                <div class="card">
                    <div class="card-body">
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
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">

                            <!-- Assuming Bootstrap CSS is loaded for grid layout and responsive design -->
                            <div class="container-fluid mt-3">
                                <div class="row mb-2">
                                    <div class="col">
                                        <h4>Service Type Demand Overview</h4>

                                    </div>
                                    <div class="col-lg-2">
                                        <select id="year-select" class="form-control">
                                            <option value="2023">2023</option>
                                            <option value="2024" selected>2024</option>
                                            <!-- Add more years as needed -->
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Stacked Bar Chart for Service Request Types -->
                                                <canvas id="service-type-chart"></canvas>
                                            </div>
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
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Recently Requested Services </h4>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <?php 
                                                $query = "SELECT service_request.*, users.fname, users.lname FROM service_request
                                                LEFT JOIN users ON users.user_id = service_request.user_id
                                                ORDER BY request_date DESC LIMIT 20 ";
                                                $results = mysqli_query($con, $query);
                                                                ?>
                                        <table class="table">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Client</th>
                                                    <th scope="col">Service Type</th>
                                                    <th scope="col">Agency</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_assoc($results)) { 
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
                       
                                                    $type_color = $row['service_type'] === 'data-analysis' ? 'badge-success' :
                                                                ($row['service_type'] === 'capability-training' ? 'badge-primary' :
                                                                ($row['service_type'] === 'technical-assistance' ? 'badge-dark' : ''));
                                                ?>
                                                <tr>
                                                    <td><?php echo $row['request_id']; ?></td>
                                                    <td><span
                                                            class="badge <?php echo $status_color; ?>"><?php echo $row['status']; ?></span>
                                                    </td>
                                                    <td class='nowrap'><?php echo $row['fname'].' '.$row['lname']; ?>
                                                    </td>
                                                    <td><span
                                                            class="badge <?php echo $type_color; ?>"><?php echo $row['service_type']; ?></span>
                                                    </td>
                                                    <td><?php echo $row['office_agency']; ?></td>

                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col-lg-8 -->

                       
                    </div>
                </div>
                <!-- /.orders -->
                <!-- To Do and Live Chat -->

                <!-- /To Do and Live Chat -->
                <!-- Calender Chart Weather  -->
               
               
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
        var chart; // Define chart globally to update it

        // Helper function to generate a color
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function initChart(data) {
            if (chart) {
                chart.destroy(); // Destroy the existing chart instance before creating a new one
            }
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                        'Nov', 'Dec'
                    ],
                    datasets: data
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            stacked: true
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
        }

        function fetchData(year) {
            $.ajax({
                url: 'fetch/fetch_serviceDisChart.php',
                method: 'GET',
                data: {
                    year: year
                },
                success: function(data) {
                    var datasets = [];
                    Object.keys(data).forEach(function(serviceType) {
                        var color =
                            getRandomColor(); // Generate a unique color for each dataset
                        var dataset = {
                            label: serviceType,
                            data: [],
                            backgroundColor: color,
                            borderColor: color,
                            borderWidth: 1
                        };
                        for (let i = 1; i <= 12; i++) {
                            dataset.data.push(data[serviceType][i] || 0);
                        }
                        datasets.push(dataset);
                    });
                    initChart(datasets); // Initialize the chart with fetched data
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: Status", status, "Error", error);
                }
            });
        }

        // Event listener for year change
        $('#year-select').change(function() {
            fetchData($(this).val());
        });

        // Initialize chart with default year
        fetchData($('#year-select').val());
    });
    </script>





</body>

</html>