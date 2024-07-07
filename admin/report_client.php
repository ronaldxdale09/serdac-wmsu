<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

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
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li class="active">Projects</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid mt-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Registered Client Report</h5>
                            </div>
                            <div class="card-body">
                                <form id="reportForm">
                                    <div class="mb-3">
                                        <label for="reportType" class="form-label">Report Type</label>
                                        <select id="reportType" name="reportType" class="form-control">
                                            <option value="monthly">Monthly</option>
                                            <option value="quarterly">Quarterly</option>
                                            <option value="yearly">Yearly</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <select id="year" name="year" class="form-control">
                                            <!-- Populated by JavaScript -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filterType" class="form-label">Filter By</label>
                                        <select id="filterType" name="filterType" class="form-control">
                                            <option value="occupation">Occupation</option>
                                            <option value="education_level">Education Level</option>
                                            <option value="region">Region</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="filterValue" class="form-label">Filter Value</label>
                                        <select id="filterValue" name="filterValue" class="form-control">
                                            <!-- Populated by JavaScript -->
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-generate">
                                        <i class="fas fa-sync-alt me-2"></i>Generate Report
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Report Results</h5>
                                <button class="btn btn-sm btn-outline-secondary" id="exportBtn">
                                    <i class="fas fa-download me-2"></i>Export to CSV
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">

                                    <div id="reportResult">
                                        <!-- Report table will be inserted here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Visualization</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="reportChart"></canvas>
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

    <script>
    // user_report.js
    $(document).ready(function() {
        let chart = null;

        // Populate year dropdown
        const currentYear = new Date().getFullYear();
        $('#year').append($('<option>', {
            value: 'all',
            text: 'All Years'
        }));
        for (let i = currentYear; i >= currentYear - 2; i--) {
            $('#year').append($('<option>', {
                value: i,
                text: i
            }));
        }

        // Update filter values based on filter type
        $('#filterType').change(function() {
            const filterType = $(this).val();
            $('#filterValue').empty();

            // Add "All" option
            $('#filterValue').append($('<option>', {
                value: 'all',
                text: 'All'
            }));

            switch (filterType) {
                case 'occupation':
                    ['student', 'employed_ft', 'employed_pt'].forEach(function(value) {
                        $('#filterValue').append($('<option>', {
                            value: value,
                            text: value.replace('_', ' ').toUpperCase()
                        }));
                    });
                    break;
                case 'education_level':
                    ['elementary', 'high_school', 'college', 'post_graduate'].forEach(function(value) {
                        $('#filterValue').append($('<option>', {
                            value: value,
                            text: value.replace('_', ' ').toUpperCase()
                        }));
                    });
                    break;
                case 'region':
                    // Add regions here
                    ['Region IX (Zamboanga Peninzula)', 'Region IV-A (CALABARZON)'].forEach(function(
                        value) {
                        $('#filterValue').append($('<option>', {
                            value: value,
                            text: value
                        }));
                    });
                    break;
            }
        });

        // Handle form submission
        $('#reportForm').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            console.log("Form Data:", formData);

            $.ajax({
                url: 'fetch/report_client.php',
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    console.log("AJAX Response:", response);
                    if (response.error) {
                        $('#reportResult').html('<div class="alert alert-danger">' +
                            response.error + '</div>');
                    } else if (response.data && response.data.length > 0) {
                        displayReport(response.data);
                        displayChart(response.data);
                    } else {
                        $('#reportResult').html(
                            '<div class="alert alert-warning">No data available for the selected criteria.</div>'
                        );
                        if (chart) {
                            chart.destroy();
                            chart = null;
                        }
                    }
                    if (response.debug) {
                        console.log("Debug Info:", response.debug);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    $('#reportResult').html(
                        '<div class="alert alert-danger">Error generating report. Please try again.</div>'
                    );
                }
            });
        });

        function displayReport(data) {
            let tableHtml = `
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Period</th>
                        <th>Total Users</th>
                        <th>Male Users</th>
                        <th>Female Users</th>
                        <th>Students</th>
                        <th>Full-time Employed</th>
                        <th>Part-time Employed</th>
                        <th>Elementary Education</th>
                        <th>High School Education</th>
                        <th>College Education</th>
                        <th>Post-graduate Education</th>
                    </tr>
                </thead>
                <tbody>
        `;

            data.forEach(function(row) {
                tableHtml += `
                <tr>
                    <td>${row.period || 'Unknown'}</td>
                    <td>${row.total_users}</td>
                    <td>${row.male_users}</td>
                    <td>${row.female_users}</td>
                    <td>${row.student_users}</td>
                    <td>${row.employed_ft_users}</td>
                    <td>${row.employed_pt_users}</td>
                    <td>${row.elementary_edu}</td>
                    <td>${row.high_school_edu}</td>
                    <td>${row.college_edu}</td>
                    <td>${row.post_graduate_edu}</td>
                </tr>
            `;
            });

            tableHtml += `
                </tbody>
            </table>
        `;

            $('#reportResult').html(tableHtml);
        }

        function displayChart(data) {
            const ctx = document.getElementById('reportChart').getContext('2d');

            // Prepare data for the chart
            const labels = data.map(row => row.period || 'Unknown');
            const totalUsers = data.map(row => parseInt(row.total_users));
            const maleUsers = data.map(row => parseInt(row.male_users));
            const femaleUsers = data.map(row => parseInt(row.female_users));

            // Destroy existing chart if it exists
            if (chart) {
                chart.destroy();
            }

            // Create new chart
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Total Users',
                            data: totalUsers,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Male Users',
                            data: maleUsers,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Female Users',
                            data: femaleUsers,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: true,
                        },
                        y: {
                            stacked: true,
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'User Distribution Over Time'
                        },
                        legend: {
                            position: 'top',
                        }
                    }
                }
            });
        }

        // Initialize the page
        $('#filterType').trigger('change');
        $('#reportForm').trigger('submit');
    });
    // Export to CSV
    $('#exportBtn').click(function() {
        exportToCSV();
    });

    function exportToCSV() {
        const table = document.querySelector('table');
        let csv = [];
        for (let i = 0; i < table.rows.length; i++) {
            let row = [],
                cols = table.rows[i].querySelectorAll('td, th');
            for (let j = 0; j < cols.length; j++) {
                let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, '').replace(/(\s\s)/gm, ' ');
                data = data.replace(/"/g, '""');
                row.push('"' + data + '"');
            }
            csv.push(row.join(','));
        }
        let csvFile = new Blob([csv.join('\n')], {
            type: 'text/csv'
        });
        let downloadLink = document.createElement('a');
        downloadLink.download = 'report_client.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }
    </script>


</body>

</html>