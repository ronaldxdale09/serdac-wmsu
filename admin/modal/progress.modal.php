<div class="modal fade" id="reqserviceDetails" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Request Service Details</h5>
            </div>
            <div class="modal-body">

                <div class="form-row">
                    <!-- User ID -->
                    <div class="form-group col-md-6">
                        <label for="user-id">Client</label>
                        <input type="text" class="form-control" id="d_user-name" readonly>
                    </div>

                    <!-- Service Type -->
                    <div class="form-group col-md-6">
                        <label for="service-type">Service Type</label>
                        <input type="text" class="form-control" id="d_service-type" readonly>
                    </div>
                </div>


                <div class="form-row">
                    <!-- Office Agency -->
                    <div class="form-group col-md-6">
                        <label for="office-agency">Office/Agency</label>
                        <input type="text" class="form-control" id="d_office-agency" readonly
                            placeholder="Enter office/agency">
                    </div>

                    <!-- Agency Classification -->
                    <div class="form-group col-md-6">
                        <label for="agency-classification">Agency Classification</label>
                        <input type="text" class="form-control" id="d_agency-classification" readonly>
                    </div>
                </div>


                <div class="form-row">
                    <!-- Client Type -->
                    <div class="form-group  col-md-4">
                        <label for="client-type">Client Type</label>
                        <input type="text" class="form-control" id="d_client-type" readonly>
                    </div>

                </div>

                <div class="form-row">
                    <!-- Client Type -->
                    <div class="form-group  col-md-6">
                        <label for="client-type">Purpose</label>
                        <input type="text" class="form-control" id="d_purpose" readonly>
                    </div>
                </div>

                <!-- Purpose -->
                <div class="form-group">
                    <label for="purpose">Additional Details </label>
                    <textarea readonly class="form-control" id="d_additional_details" rows="3"></textarea>
                </div>
                <hr>

                <div class="d_selected_schedule"></div>
                <br>

                <div class="form-group">
                    <label for="remarks">Admin Remarks (Optional):</label>
                    <textarea readonly class="form-control" id="d_remarks" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>


    </div>
</div>






<!-- Modal -->
<div class="modal fade" id="participantsModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">List of Participants</h5>
            </div>
            <div class="modal-body">
                <!-- Form -->


                <input type="text" class="form-control" name="user_id" id="s_user_id" hidden>
                <input type="text" class="form-control" name="req_id" id="s_req_id" hidden>
                <input type="text" class="form-control" name="sched_date" id="s_sched_date" hidden>

                <div class="invite-code-container">
                    <div class="invite-code-header">
                        INVITE CODE
                    </div>
                    <div class="invite-code-container">
                        <div class="invite-code-box">
                            <span id="inviteCode"></span>
                            <button onclick="copyCode()" class="copy-btn">
                                <i class="fa fa-clone"></i>
                            </button>
                        </div>
                        <button onclick="generateQRCode()" class="btn btn-primary qr-btn">Generate QR Code</button>
                        <div id="qrCode" style="margin-top: 15px;"></div>

                    </div>
                    <p class="invite-instruction">Copy the code above to invite participants to this event</p>

                </div>
                <div class="form-row">
                    <!-- User ID -->
                    <div class="form-group col-md-6">
                        <label for="user-id">Client</label>
                        <input type="text" class="form-control" id="participants_client" readonly>
                    </div>

                    <!-- Service Type -->
                    <div class="form-group col-md-6">
                        <label for="service-type">Service Type</label>
                        <input type="text" class="form-control" id="p_service-type" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Office Agency -->
                    <div class="form-group col-md-6">
                        <label for="office-agency">Office/Agency</label>
                        <input type="text" class="form-control" id="p_office-agency" readonly
                            placeholder="Enter office/agency">
                    </div>

                    <!-- Agency Classification -->
                    <div class="form-group col-md-6">
                        <label for="agency-classification">Agency Classification</label>
                        <input type="text" class="form-control" id="p_agency-classification" readonly>
                    </div>
                </div>




                <div id="particiapnts_list_table"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<script>
function generateQRCode() {
    var inviteCodeText = document.getElementById('inviteCode').textContent;

    var inviteCode = 'serdac-wmsu.online/service_join.php?inv=' +
        inviteCodeText; // Convert the number to a string to use as text in QR code
    var qrContainer = document.getElementById('qrCode');

    // Clear previous QR Code
    qrContainer.innerHTML = '';

    // Create a QR code and render it inside the qrContainer
    var qrCode = new QRCode(qrContainer, {
        text: inviteCode, // Make sure to use a string for the text
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
}


function copyCode() {
    var copyText = document.getElementById("inviteCode");
    var range = document.createRange();
    range.selectNode(copyText);
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
    alert("Invite code copied to clipboard!"); // Replace with more subtle feedback in production
}
</script>




<div class="modal fade" id="completeRequestModal" tabindex="-1" aria-labelledby="completeRequestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="completeRequestModalLabel" style="font-weight: bold;">Complete Service
                    Request</h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="background-color: #f8f9fc;">
                <form action="function/request.action.php" method="post">
                    <p>Please confirm that you have completed all required tasks for this service. By confirming, you
                        are marking the service as 'Completed'. This action is significant and should be taken with
                        certainty.</p>

                    <div class="form-group">
                        <label for="remarks">Admin Remarks (Optional):</label>
                        <textarea class="form-control" name="remarks" rows="3"
                            placeholder="Enter any final comments or important notes here."></textarea>
                    </div>
                    <!-- Hidden Request ID -->
                    <input type="hidden" name="request_id" id="c_req_id">

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="background-color: #f8f9fc;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="complete">Mark as Complete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>