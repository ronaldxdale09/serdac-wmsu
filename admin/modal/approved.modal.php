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
                         <input type="text" class="form-control" id="s_user-name" readonly>
                     </div>

                     <!-- Service Type -->
                     <div class="form-group col-md-6">
                         <label for="service-type">Service Type</label>
                         <input type="text" class="form-control" id="s_service-type" readonly>
                     </div>
                 </div>

                 <div class="form-row">
                     <!-- Office Agency -->
                     <div class="form-group col-md-6">
                         <label for="office-agency">Office/Agency</label>
                         <input type="text" class="form-control" id="s_office-agency" readonly
                             placeholder="Enter office/agency">
                     </div>

                     <!-- Agency Classification -->
                     <div class="form-group col-md-6">
                         <label for="agency-classification">Agency Classification</label>
                         <input type="text" class="form-control" id="s_agency-classification" readonly>
                     </div>
                 </div>


                 <div class="form-row">
                     <!-- Client Type -->
                     <div class="form-group  col-md-6">
                         <label for="client-type">Client Type</label>
                         <input type="text" class="form-control" id="s_client-type" readonly>
                     </div>
                 </div>

                 <!-- Purpose -->
                 <div class="form-group">
                     <label for="purpose">Purpose</label>
                     <textarea readonly class="form-control" id="s_purpose" rows="3"></textarea>
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
    var inviteCode = "34323425"; // Convert the number to a string to use as text in QR code
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