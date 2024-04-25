<div class="modal fade" id="serviceSpeakerModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Request Service Meeting</h5>
            </div>
            <div class="modal-body">
                <form action="function/service_action.meeting.php" id="meeting_form" method="post">
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

                    <div id="speaker_list_table"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="confirm" id="btnSaveMeetingForm" class="btn btn-warning text-dark"><i
                        class="fas fa-check"></i> Confirm Meeting</button>
                </form>

            </div>


        </div>

    </div>
</div>