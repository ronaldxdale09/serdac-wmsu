<h1>Summary Service Report</h1>
<hr>
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter Options</h5>
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
                            <option value="activity">Activity</option>
                            <option value="participants">Participants</option>
                            <option value="status">Status</option>
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
                <button class="btn btn-sm btn-info" id="exportBtn">
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

<script>
// report.js
$(document).ready(function() {
    // Populate year dropdown
    const currentYear = new Date().getFullYear();
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

        switch (filterType) {
            case 'activity':
                ['capability-training', 'data-analysis', 'tech-assistance'].forEach(function(
                    value) {
                    $('#filterValue').append($('<option>', {
                        value: value,
                        text: value.replace('-', ' ').toUpperCase()
                    }));
                });
                break;
            case 'participants':
                ['Researcher', 'Government Employee', 'Faculty'].forEach(function(value) {
                    $('#filterValue').append($('<option>', {
                        value: value,
                        text: value
                    }));
                });
                break;
            case 'status':
                ['Completed', 'In Progress', 'Cancelled'].forEach(function(value) {
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

        $.ajax({
            url: 'fetch/report_activity.php',
            type: 'GET',
            data: formData,
            dataType: 'json',
            success: function(data) {
                displayReport(data);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                $('#reportResult').html(
                    '<div class="alert alert-danger">Error generating report. Please try again.</div>'
                );
            }
        });
    });

    // Export to CSV
    $('#exportBtn').click(function() {
        exportToCSV();
    });

    function displayReport(data) {
        let tableHtml = `
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Period</th>
                        <th>Total Requests</th>
                        <th>Completed</th>
                        <th>In Progress</th>
                        <th>Cancelled</th>
                        <th>Avg. Completion Time (days)</th>
                        <th>Unique Users</th>
                        <th>Training Requests</th>
                        <th>Analysis Requests</th>
                        <th>Assistance Requests</th>
                        <th>Avg. Participants</th>
                    </tr>
                </thead>
                <tbody>
        `;

        data.forEach(function(row) {
            tableHtml += `
                <tr>
                    <td>${row.period}</td>
                    <td>${row.total_requests}</td>
                    <td>${row.completed_requests}</td>
                    <td>${row.in_progress_requests}</td>
                    <td>${row.cancelled_requests}</td>
                    <td>${parseFloat(row.avg_completion_time).toFixed(2)}</td>
                    <td>${row.unique_users}</td>
                    <td>${row.training_requests}</td>
                    <td>${row.analysis_requests}</td>
                    <td>${row.assistance_requests}</td>
                    <td>${parseFloat(row.avg_participants).toFixed(2)}</td>
                </tr>
            `;
        });

        tableHtml += `
                </tbody>
            </table>
        `;

        $('#reportResult').html(tableHtml);

        // Add chart visualization
        displayChart(data);
    }

    function displayChart(data) {
        const ctx = document.getElementById('reportChart').getContext('2d');

        // Prepare data for the chart
        const labels = data.map(row => row.period);
        const totalRequests = data.map(row => row.total_requests);
        const completedRequests = data.map(row => row.completed_requests);
        const inProgressRequests = data.map(row => row.in_progress_requests);
        const cancelledRequests = data.map(row => row.cancelled_requests);

        if (window.myChart instanceof Chart) {
            window.myChart.destroy();
        }

        window.myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Total Requests',
                        data: totalRequests,
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Completed',
                        data: completedRequests,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'In Progress',
                        data: inProgressRequests,
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cancelled',
                        data: cancelledRequests,
                        backgroundColor: 'rgba(255, 99, 132, 0.6)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

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
        downloadLink.download = 'service_request_report.csv';
        downloadLink.href = window.URL.createObjectURL(csvFile);
        downloadLink.style.display = 'none';
        document.body.appendChild(downloadLink);
        downloadLink.click();
    }
});
</script>