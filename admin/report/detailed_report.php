<h1>Service Request Report</h1>
<hr>
<div class="row mb-3">
    <div class="col-md-12">
        <div class="p-3 bg-light border rounded">
            <div class="row mb-3">
                <div class="col">
                    <label for="service_type">Service Type:</label>
                    <select id="service_type" class="form-control">
                        <option value="">All</option>
                        <option value="data-analysis">Data Analysis</option>
                        <option value="capability-training">Capability Training</option>
                        <option value="technical-assistance">Technical Assistance</option>
                    </select>
                </div>
                <div class="col">
                    <label for="status">Status:</label>
                    <select id="status" class="form-control">
                        <option value="">All</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Cancelled">Cancelled</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="col">
                    <label for="client_type">Client Type:</label>
                    <select id="client_type" class="form-control">
                        <option value="">All</option>
                        <option value="Government">Government</option>
                        <option value="Private">Private</option>
                        <option value="Academic">Academic</option>
                    </select>
                </div>
                <div class="col">
                    <label for="agency_classification">Agency Classification:</label>
                    <select id="agency_classification" class="form-control">
                        <option value="">All</option>
                        <option value="Public Agency">Public Agency</option>
                        <option value="Private Agency">Private Agency</option>
                        <option value="Goverment Organization">Government Organization</option>
                        <option value="Non-Goverment Organization">Non-Government Organization</option>
                        <option value="University">University</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col">
                    <label for="office_agency">Office/Agency:</label>
                    <select id="office_agency" class="form-control office_agency chosen-select" style="width: 100%;">
                        <option value="">All</option>
                        <!-- This will be populated dynamically -->
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="start_date">Start Date:</label>
                    <input type="date" id="start_date" class="form-control">
                </div>
                <div class="col">
                    <label for="end_date">End Date:</label>
                    <input type="date" id="end_date" class="form-control">
                </div>
                <div class="col">
                    <label>&nbsp;</label>
                    <button id="generate_report" class="btn btn-primary form-control">Generate Report</button>
                </div>
            </div>
        </div>
    </div>
</div>

<table id="detailed_report_table" class="table table-striped table-bordered" style="width:100%">
    <thead>
        <tr>
            <th>Request ID</th>
            <th>Service Type</th>
            <th>Office/Agency</th>
            <th>Agency Classification</th>
            <th>Client Type</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Scheduled Date</th>
            <th>Ongoing Date</th>
            <th>Completed Date</th>
            <th>Cancelled Date</th>
            <th>Participants</th>
            <th>Selected Purposes</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {


    // Populate office agency dropdown
    $.ajax({
        url: 'fetch/fetch_office_agency.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            var officeAgencySelect = $('#office_agency');
            $.each(data, function(index, agency) {
                officeAgencySelect.append(new Option(agency, agency));
            });
            officeAgencySelect.trigger('change'); // Notify Select2 of the updated options
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + status + " - " + error);
        }
    });
    var table = $('#detailed_report_table').DataTable({
        "processing": true,
        "serverSide": false,
        "scrollX": true,
        "columns": [{
                "data": "request_id"
            },
            {
                "data": "service_type"
            },
            {
                "data": "office_agency"
            },
            {
                "data": "agency_classification"
            },
            {
                "data": "client_type"
            },
            {
                "data": "status"
            },
            {
                "data": "request_date"
            },
            {
                "data": "scheduled_date"
            },
            {
                "data": "ongoing_date"
            },
            {
                "data": "completed_date"
            },
            {
                "data": "cancelled_date"
            },
            {
                "data": "participants"
            },
            {
                "data": "selected_purposes"
            }
        ],
        dom: 'Bfrtip', // Define where the buttons should be placed
        buttons: [
            'copy', 'csv', 'excel', {
                extend: 'pdfHtml5',
                title: 'SERDAC SERVICE REPORT', // Add title to the PDF
                orientation: 'landscape', // Set the orientation to landscape
                pageSize: 'A4', // Set the page size to A4
                customize: function(doc) {
                    // Add a custom header
                    doc.content.splice(0, 0, {
                        style: 'header'
                    });
                    // Customize table layout
                    var layout = {};
                    layout['hLineWidth'] = function(i) {
                        return 0.5;
                    };
                    layout['vLineWidth'] = function(i) {
                        return 0.5;
                    };
                    layout['hLineColor'] = function(i) {
                        return '#aaa';
                    };
                    layout['vLineColor'] = function(i) {
                        return '#aaa';
                    };
                    layout['paddingLeft'] = function(i) {
                        return 4;
                    };
                    layout['paddingRight'] = function(i) {
                        return 4;
                    };
                    layout['paddingTop'] = function(i) {
                        return 4;
                    };
                    layout['paddingBottom'] = function(i) {
                        return 4;
                    };
                    doc.content[1].layout = layout;

                    // Styling the table headers
                    doc.styles.tableHeader = {
                        bold: true,
                        fontSize: 11,
                        color: 'black',
                        fillColor: '#f2f2f2',
                        alignment: 'center'
                    };

                    // General styles
                    doc.styles.header = {
                        fontSize: 18,
                        bold: true,
                        alignment: 'center',
                        margin: [0, 0, 0, 10]
                    };
                    doc.styles.table = {
                        fontSize: 10,
                        margin: [0, 5, 0, 15]
                    };
                    doc.styles.tableBodyOdd = {
                        fillColor: '#f9f9f9'
                    };
                }
            }, 'print'
        ]
    });


    $('#generate_report').click(function() {
        var service_type = $('#service_type').val();
        var status = $('#status').val();
        var client_type = $('#client_type').val();
        var agency_classification = $('#agency_classification').val();
        var office_agency = $('#office_agency').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        $.ajax({
            url: 'fetch/report_service.php',
            method: 'GET',
            data: {
                service_type: service_type,
                status: status,
                client_type: client_type,
                agency_classification: agency_classification,
                office_agency: office_agency,
                start_date: start_date,
                end_date: end_date
            },
            dataType: 'json',
            success: function(data) {
                table.clear().rows.add(data).draw();
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
            }
        });
    });
});
</script>