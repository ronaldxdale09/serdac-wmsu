<div class="modal fade" id="serviceMeetingModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Request Service Meeting</h5>
            </div>
            <div class="modal-body">
                <form action="function/service_action.meeting.php" id="meeting_form" method="post">
                    <input type="text" class="form-control" name="req_id" id="m_req_id" hidden>
                    <div class="form-row">
                        <!-- User ID -->
                        <div class="form-group col-md-6">
                            <label for="user-id">Client</label>
                            <input type="text" class="form-control" id="m_user-name" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user-id">Email</label>
                            <input type="text" class="form-control" id="m_email" readonly>
                        </div>


                    </div>


                    <div class="form-row">
                        <div class="form-group ">
                            <label for="service-type">Service Type</label>
                            <input type="text" class="form-control" id="m_service-type" readonly>
                        </div>
                        <!-- Office Agency -->
                        <div class="form-group ">
                            <label for="office-agency">Office/Agency</label>
                            <input type="text" class="form-control" id="m_office-agency" readonly
                                placeholder="Enter office/agency">
                        </div>

                        <!-- Agency Classification -->
                        <div class="form-group ">
                            <label for="agency-classification">Agency Classification</label>
                            <input type="text" class="form-control" id="m_agency-classification" readonly>
                        </div>
                    </div>


                    <div class="form-row">
                        <!-- Client Type -->
                        <div class="form-group  col-md-6">
                            <label for="client-type">Client Type</label>
                            <input type="text" class="form-control" id="m_client-type" readonly>
                        </div>
                        <div class="form-group  col-md-6">
                            <label for="client-type">Purpose</label>
                            <input type="text" class="form-control" id="m_purpose" readonly>
                        </div>
                    </div>

                    <div id="meeting_table_modal"></div>
                    <br>
                    <button type="button" class="btn btn-dark" id="addMeeting">
                        <i class="fa fa-plus mr-2"></i> Add New Meeting
                    </button>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- <button type="button" class="btn btn-primary" onclick="printModalContent()"><i class="fas fa-print"></i>
                    Print</button> -->

                <button type="submit" name="confirm" id="btnSaveMeetingForm" class="btn btn-warning text-dark"><i
                        class="fas fa-check"></i> Confirm Meeting</button>
                </form>

            </div>


        </div>

    </div>
</div>

<style>
#meeting-content {
    min-height: 600px;
    /* Adjust this value as needed */
}
</style>

<!-- Notify via Email Modal -->
<div class="modal fade" id="notifyEmailModal" tabindex="-1" aria-labelledby="notifyEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifyEmailModalLabel">Notify via Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="notifyEmailForm">
                    <div class="form-group">
                        <label for="recipient-name">Client Name</label>
                        <input type="text" class="form-control" id="recipient-name" name="recipient_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-email">Recipient Email</label>
                        <input type="email" class="form-control" id="recipient-email" name="recipient_email" required>
                    </div>
                    <div class="form-group">
                        <label for="meeting-content">Meeting Content</label>
                        <textarea class="form-control" id="meeting-content" name="meeting_content" rows="10"
                            style="min-height: 200px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>