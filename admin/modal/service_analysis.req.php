<div class="modal fade" id="anaylsisReqModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Request Service Meeting</h5>
            </div>
            <div class="modal-body">
                <form action="function/service_action.meeting.php" id="meeting_form" method="post">
                    <input type="text" class="form-control" name="req_id" id="r_req_id" hidden>
                    <div class="form-row">
                        <!-- User ID -->
                        <div class="form-group col-md-6">
                            <label for="user-id">Client</label>
                            <input type="text" class="form-control" id="r_user-name" readonly>
                        </div>

                        <!-- Service Type -->
                        <div class="form-group col-md-6">
                            <label for="service-type">Service Type</label>
                            <input type="text" class="form-control" id="r_service-type" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Office Agency -->
                        <div class="form-group col-md-6">
                            <label for="office-agency">Office/Agency</label>
                            <input type="text" class="form-control" id="r_office-agency" readonly
                                placeholder="Enter office/agency">
                        </div>

                        <!-- Agency Classification -->
                        <div class="form-group col-md-6">
                            <label for="agency-classification">Agency Classification</label>
                            <input type="text" class="form-control" id="r_agency-classification" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Client Type -->
                        <div class="form-group  col-md-6">
                            <label for="client-type">Client Type</label>
                            <input type="text" class="form-control" id="r_client-type" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="client-type">Purpose</label>
                            <input type="text" class="form-control" id="r_purpose" readonly>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary " onclick="sendDocumentRequest();">
                        <i class="fa fa-bell"></i> Notify again to Submit Documents
                    </button>
                    <br>
                    <div id="upload_document_list"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                </form>

            </div>


        </div>

    </div>
</div>