<div class="modal fade" id="serviceSpeakerModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Capability Training Speakers</h5>
            </div>
            <div class="modal-body">
                <form id="speaker_form" method="post">
                    <input type="text" class="form-control" name="req_id" id="sp_req_id" hidden>
                    <div class="form-row">
                        <!-- User ID -->
                        <div class="form-group col-md-6">
                            <label for="user-id">Client</label>
                            <input type="text" class="form-control" id="sp_user-name" readonly>
                        </div>

                        <!-- Service Type -->
                        <div class="form-group col-md-6">
                            <label for="service-type">Service Type</label>
                            <input type="text" class="form-control" id="sp_service-type" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Office Agency -->
                        <div class="form-group col-md-6">
                            <label for="office-agency">Office/Agency</label>
                            <input type="text" class="form-control" id="sp_office-agency" readonly
                                placeholder="Enter office/agency">
                        </div>

                        <!-- Agency Classification -->
                        <div class="form-group col-md-6">
                            <label for="agency-classification">Agency Classification</label>
                            <input type="text" class="form-control" id="sp_agency-classification" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Client Type -->
                        <div class="form-group  col-md-6">
                            <label for="client-type">Client Type</label>
                            <input type="text" class="form-control" id="sp_client-type" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="client-type">Purpose</label>
                            <input type="text" class="form-control" id="sp_purpose" readonly>
                        </div>
                    </div>
                    <div class="container-research my-4 p-3 border">



                        <div class="form-row">
                            <!-- Client Type -->
                            <div class="form-group  col-md-6">
                                <label for="client-type">Service Title</label>
                                <input type="text" id="service_title" name="service_title" class="form-control"
                                    placeholder="Enter service title"
                                    style="border-radius: 0.35rem; border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                            </div>
                            <div class="form-group  col-md-6">
                                <label for="client-type">Training Venue:</label>
                                <input type="text" id="serviceVenue" name="venue" class="form-control"
                                    placeholder="Enter venue address"
                                    style="border-radius: 0.35rem; border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                            </div>
                        </div>
                        <!-- Date Type Selection -->
                        <div class="row mb-3">
                            <div class="col-12 col-md-6">
                                <label for="dateTypeSelect" class="form-control-label" style="font-weight: bold;">Select
                                    Date Type:</label>
                                <select class="form-control" id="dateTypeSelect" name="date_type"
                                    style="border-radius: 0.35rem; border-color: #d1d3e2;">
                                    <option value="single">Single Date</option>
                                    <option value="range">Date Range</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <!-- From Date -->
                            <div class="form-group col-md-6">
                                <label class="form-control-label" style="font-weight: bold;">From Date:</label>
                                <input type="datetime-local" id="fromDate" name="from_date" class="form-control"
                                    style="border-radius: 0.35rem; border-color: #d1d3e2;">
                            </div>
                            <!-- To Date -->
                            <div class="form-group col-md-6" id="toDateGroup">
                                <label class="form-control-label" style="font-weight: bold;">To Date:</label>
                                <input type="datetime-local" id="toDate" name="to_date" class="form-control"
                                    style="border-radius: 0.35rem; border-color: #d1d3e2;">
                            </div>
                        </div>
                        <div id="speaker_list_table"></div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="confirm" id="btnSaveSpeaker" class="btn btn-dark text-dark"><i
                        class="fas fa-check"></i> Save Training Details</button>
                </form>

            </div>


        </div>

    </div>
</div>


<script>
$(document).ready(function() {
    // Function to adjust the To Date input based on the Date Type selection
    function adjustToDate() {
        var dateType = $("#dateTypeSelect").val();
        var fromDateValue = $("#fromDate").val(); // Assuming the ID for the From Date input is fromDate

        if (dateType === "single") {
            $("#toDate").val(fromDateValue); // Set To Date same as From Date
            $("#toDate").prop('readonly', true); // Make To Date readonly
        } else {
            $("#toDate").prop('readonly', false); // Make To Date editable
        }
    }

    // Initial adjustment
    adjustToDate();

    // Adjust To Date whenever the From Date or the Date Type changes
    $("#dateTypeSelect, #fromDate").change(adjustToDate);
});
</script>