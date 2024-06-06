<div class="modal fade" id="serviceRequestDetailsModal" tabindex="-1" aria-labelledby="requestServiceDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="requestServiceDetailsModalLabel">Request Service Details</h5>
            </div>
            <div class="modal-body" id="print_request">
                <!-- Form -->

                <form action="function/request.action.php" method="post">
                    <div class="container-research my-4 p-3 border">
                        <h3 class="header-research mb-3 text-center">Request Details</h3>
                        <hr>
                        <input type="text" class="form-control" name="user_id" id="p_user_id" hidden>
                        <input type="text" class="form-control" name="req_id" id="p_req_id" hidden>
                        <input type="text" class="form-control" name="sched_date" id="p_sched_date" hidden>

                        <div class="form-row">
                            <!-- User ID -->
                            <div class="form-group  col">
                                <label for="user-id">Client</label>
                                <input type="text" class="form-control" id="p_user-name" readonly>
                            </div>

                            <!-- Service Type -->
                            <div class="form-group  col">
                                <label for="service-type">Service Type</label>
                                <input type="text" class="form-control" id="service-type" readonly>
                            </div>

                            <div class="form-group  col">
                                <label for="client-type">Client Type</label>
                                <input type="text" class="form-control" id="client-type" readonly>
                            </div>

                        </div>


                        <div class="form-row">
                            <!-- Office Agency -->
                            <div class="form-group col-md-6">
                                <label for="office-agency">Office/Agency</label>
                                <input type="text" class="form-control" id="office-agency" readonly
                                    placeholder="Enter office/agency">
                            </div>

                            <!-- Agency Classification -->
                            <div class="form-group col-md-6">
                                <label for="agency-classification">Agency Classification</label>
                                <input type="text" class="form-control" id="agency-classification" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                            <!-- Client Type -->
                            <div class="form-group  col-md-6">
                                <label for="client-type">Purpose</label>
                                <input type="text" class="form-control" id="purpose" readonly>
                            </div>
                            <div class="form-group col-md">
                                <label for="purpose">Additional Details </label>
                                <textarea readonly class="form-control" id="additional_details" rows="3"></textarea>
                            </div>

                        </div>



                        <div id='service-specific'> </div>

                        <hr>

                        <div class="selected_schedule"></div>
                        <br>


                        <div class="form-group">
                            <label for="remarks">Admin Remarks (Optional):</label>
                            <textarea class="form-control" id="sched_remarks" name="remarks" rows="3"
                                placeholder="Enter any additional comments or information here."></textarea>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()"><i class="fas fa-print"></i>
                    Print</button> -->


                <button type="button" class="btn btn-danger btnCancelRequest" data-toggle="modal"
                    data-target="#cancelServiceRequestModal" data-request-id="123">
                    <i class="fas fa-times-circle"></i> Cancel Request
                </button>
                <button type="button" class="btn btn-success assign_sched" id="assign-sched"><i
                        class="fas fa-calendar-alt"></i> Assign Schedule</button>
                <button type="submit" name="confirm" hidden class="btn btn-warning text-dark" id="submit-request"><i
                        class="fas fa-check"></i> Confirm Request</button>
            </div>
        </div>

        </form>
    </div>
</div>



<script>
function printModalContent() {
    var element = document.getElementById('print_request'); // Get the modal element

    html2canvas(element).then(function(canvas) {
        var myWindow = window.open('', 'Print', 'height=600,width=800');
        myWindow.document.write('<html><head><title>Print</title></head><body>');
        myWindow.document.body.appendChild(canvas); // Append the canvas
        myWindow.document.write('</body></html>');
        myWindow.document.close();
        myWindow.focus();

        // Timeout to allow rendering on the canvas
        setTimeout(function() {
            myWindow.print();
            myWindow.close();
        }, 500);
    });
}
</script>
<!-- Schedule Modal -->
<div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Schedule Date</h5>
            </div>
            <div class="modal-body">
                <!-- Add your date selection input here -->
                <input type="datetime-local" class="form-control" id="schedule-date">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirm-schedule">Confirm Schedule</button>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Service Request Modal -->
<div class="modal fade" id="cancelServiceRequestModal" tabindex="-1" role="dialog"
    aria-labelledby="cancelServiceRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelServiceRequestModalLabel">Cancel Service Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="function/request.action.php" method="post">
                    <p>Are you sure you want to cancel this service request?</p>
                    <input type="hidden" id="cancelRequestId" name="request_id">
                    <div class="form-group">
                        <label for="cancelRemarks">Cancellation Remarks:</label>
                        <textarea class="form-control" id="cancelRemarks" name="remarks" rows="3" required></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="cancel" class="btn btn-danger" id="confirmCancelRequest">Confirm
                    Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>