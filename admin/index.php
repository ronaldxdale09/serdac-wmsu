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
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Stacked Bar Chart for Service Request Types -->
                                                <canvas id="service-type-chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <!-- Pie Chart for Overall Service Distribution -->
                                                <canvas id="service-type-pie-chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--  /Traffic -->

                <!--  /Traffic -->
                <div class="clearfix"></div>
                <!-- Orders -->
                <div class="orders mt-5">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="box-title">Recently Requested Services</h4>
                                </div>
                                <div class="card-body--">
                                    <div class="table-stats order-table ov-h">
                                        <table class="table" id="service-table">
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
                                                <!-- Dynamic Content Here -->
                                            </tbody>
                                        </table>
                                    </div> <!-- /.table-stats -->
                                </div>
                            </div> <!-- /.card -->
                        </div> <!-- /.col-lg-8 -->
                    </div> <!-- /.row -->
                </div> <!-- /.orders -->
                <!-- To Do and Live Chat -->

                <!-- /To Do and Live Chat -->
                <!-- Calender Chart Weather  -->


            </div>
        </div>
        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>

    <script>
    $(document).ready(function() {
        var barCtx = $('#service-type-chart').get(0).getContext('2d');
        var pieCtx = $('#service-type-pie-chart').get(0).getContext('2d');
        var barChart;
        var pieChart;

        var colors = {};

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function initBarChart(data) {
            if (barChart) {
                barChart.destroy();
            }
            barChart = new Chart(barCtx, {
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
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    onClick: function(evt, elements) {
                        console.log("Bar chart clicked",
                        elements); // Debugging: log clicked elements
                        if (elements.length > 0) {
                            var element = elements[0];
                            var datasetIndex = element.datasetIndex;
                            var datasetLabel = barChart.data.datasets[datasetIndex].label;
                            console.log("Dataset label clicked: ",
                            datasetLabel); // Debugging: log the dataset label
                            updateTable(datasetLabel);
                        }
                    }
                }
            });
        }

        function initPieChart(data) {
            if (pieChart) {
                pieChart.destroy();
            }
            pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(data),
                    datasets: [{
                        data: Object.values(data),
                        backgroundColor: Object.keys(data).map(serviceType => colors[
                            serviceType]),
                        borderColor: '#fff',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    onClick: function(evt, elements) {
                        console.log("Pie chart clicked",
                        elements); // Debugging: log clicked elements
                        if (elements.length > 0) {
                            var element = elements[0];
                            var index = element.index !== undefined ? element.index : element
                            ._index;
                            var label = pieChart.data.labels[index];
                            console.log("Pie chart label clicked: ",
                            label); // Debugging: log the label
                            updateTable(label);
                        }
                    }
                }
            });
        }

        function updateTable(serviceType) {
            $.ajax({
                url: 'fetch/fetch_serviceTable.php',
                method: 'GET',
                data: {
                    service_type: serviceType
                },
                success: function(data) {
                    console.log("Data fetched for table update: ", data); // Log the fetched data

                    if (typeof data === 'string') {
                        data = JSON.parse(data); // Parse if data is a JSON string
                    }

                    var rows = '';
                    if (data.error) {
                        console.error("Data error: ", data.error); // Log any errors
                    } else if (Array.isArray(data)) {
                        data.forEach(function(row) {
                            var statusColor = '';
                            switch (row.status) {
                                case "Pending":
                                    statusColor = 'badge-primary';
                                    break;
                                case "Approved":
                                    statusColor = 'badge-warning';
                                    break;
                                case "In Progress":
                                    statusColor = 'badge-dark';
                                    break;
                                case "Cancelled":
                                    statusColor = 'badge-danger';
                                    break;
                                case "Completed":
                                    statusColor = 'badge-success';
                                    break;
                            }
                            rows += `
                            <tr>
                                <td>${row.request_id}</td>
                                <td><span class="badge ${statusColor}">${row.status}</span></td>
                                <td>${row.fname} ${row.lname}</td>
                                <td>${row.service_type}</td>
                                <td>${row.office_agency}</td>
                            </tr>
                        `;
                        });
                    } else {
                        console.error("Unexpected data format: ", data);
                    }
                    $('#service-table tbody').html(rows);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: Status", status, "Error", error);
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
                success: function(response) {
                    console.log("Chart data fetched: ", response); // Log the fetched chart data

                    if (typeof response === 'string') {
                        response = JSON.parse(response); // Parse if response is a JSON string
                    }

                    var barData = [];
                    var pieData = {};

                    Object.keys(response).forEach(function(serviceType) {
                        if (!colors[serviceType]) {
                            colors[serviceType] = getRandomColor();
                        }
                        var dataset = {
                            label: serviceType,
                            data: [],
                            backgroundColor: colors[serviceType],
                            borderColor: colors[serviceType],
                            borderWidth: 1
                        };
                        var total = 0;

                        for (let i = 1; i <= 12; i++) {
                            var value = response[serviceType][i] || 0;
                            dataset.data.push(value);
                            total += value;
                        }

                        barData.push(dataset);
                        pieData[serviceType] = total;
                    });

                    initBarChart(barData);
                    initPieChart(pieData);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error: Status", status, "Error", error);
                }
            });
        }

        $('#year-select').change(function() {
            fetchData($(this).val());
        });

        fetchData($('#year-select').val());

        updateTable('');
    });
    </script>

</body>

</html>