<?php include('include/header.php')?>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

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
                                <h1>Schedules</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Schedules</li>
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
                            <strong class="card-title">SERDAC Calendar</strong>
                        </div>
                        <div class="card-body">

                            <div class="calender-cont widget-calender">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>


            </div><!-- .animated -->
        </div><!-- .content -->
        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <!-- Modal -->
    <div class="modal fade" id="meetingDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="meetingDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetingDetailsModalLabel">Meeting Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Client Name:</strong> <span id="clientName"></span></p>
                            <p><strong>Agency:</strong> <span id="agency"></span></p> <!-- New line -->

                            <p><strong>Purpose:</strong> <span id="purpose"></span></p>
                        </div>

                        <div class="col-md-6">
                            <p><strong>Meeting Type:</strong> <span id="meetingType"></span></p>
                            <p><strong>Date & Time:</strong> <span id="meetingDateTime"></span></p>
                            <p><strong>Mode:</strong> <span id="meetingMode"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Service Type:</strong> <span id="serviceType"></span></p>
                            <p><strong>Remarks:</strong></p>
                            <p id="meetingRemarks"></p>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



</body>


<?php include('include/footer.php');?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'fetch/fetch_event.php', // URL of your PHP script that outputs JSON data

        eventClick: function(info) {
            console.log('Event clicked:', info);
            var eventId = info.event.id;

            fetch('fetch/fetch_meeting_details.php?meet_id=' + eventId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('meetingType').textContent = data.meeting_type;
                    document.getElementById('meetingDateTime').textContent = data.date_time;
                    document.getElementById('meetingMode').textContent = data.mode;
                    document.getElementById('serviceType').textContent = data.service_type;
                    document.getElementById('agency').textContent = data.agency; // New line

                    document.getElementById('clientName').textContent = data.fna; // New line
                    document.getElementById('purpose').textContent = data.purpose; // New line
                    document.getElementById('meetingRemarks').textContent = data.remarks;
                    var modal = new bootstrap.Modal(document.getElementById(
                        'meetingDetailsModal'));
                    modal.show();
                });



        }

    });
    calendar.render();
});
</script>

</html>