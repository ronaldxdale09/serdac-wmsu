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
                <input type="text" class="form-control" name="s_invcode" id="s_invcode" hidden>


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
                        <p class="invite-instruction">Copy the code above to invite participants to this event</p>

                    </div>
                </div>
                <div class="form-row">
                    <!-- User ID -->
                    <div class="form-group col-md-6">
                        <label for="user-id">Requested By :</label>
                        <input type="text" class="form-control" id="participants_client" readonly>
                    </div>

                    <!-- Service Type -->
                    <div class="form-group col-md-6">
                        <label for="service-type">Service Type</label>
                        <input type="text" class="form-control" id="p_service-type" readonly>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Client Type -->
                    <div class="form-group  col-md-12">
                        <label for="client-type">Service Title</label>
                        <input type="text" id="p_service_title" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                    </div>
                    <div class="form-group  col-md-12">
                        <label for="client-type">Training Venue:</label>
                        <input type="text" id="p_serviceVenue" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                    </div>
                </div>

                <div class="form-row">
                    <!-- From Date -->
                    <div class="form-group col-md-6">
                        <label class="form-control-label" style="font-weight: bold;">From Date:</label>
                        <input type="text" id="p_fromDate" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2;">
                    </div>

                    <!-- To Date -->
                    <div class="form-group col-md-6" id="toDateGroup">
                        <label class="form-control-label" style="font-weight: bold;">To Date:</label>
                        <input type="text" id="p_toDate" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2;">
                    </div>

                </div>
                <button type="button" class="btn btn-dark" id="email_inv">
                    Send Invitational Email
                </button>
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
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<!-- The Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="emailModalLabel">Send Invitational Email</h5>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal -->
                <div class="form-row">
                    <!-- Client Type -->
                    <div class="form-group  col-md-12">
                        <label for="client-type">Service Title</label>
                        <input type="text" id="e_service_title" class="form-control" readonly
                            style=" border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                    </div>
                    <div class="form-group  col-md-12">
                        <label for="client-type">Training Venue:</label>
                        <input type="text" id="e_serviceVenue" class="form-control" readonly
                            style="border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                    </div>
                </div>
                <div class="form-row">
                    <!-- From Date -->
                    <div class="form-group col-md-6">
                        <label class="form-control-label" style="font-weight: bold;">From Date:</label>
                        <input type="text" id="e_fromDate" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2;">
                    </div>

                    <!-- To Date -->
                    <div class="form-group col-md-6" id="toDateGroup">
                        <label class="form-control-label" style="font-weight: bold;">To Date:</label>
                        <input type="text" id="e_toDate" class="form-control" readonly
                            style="border-radius: 0.35rem; border-color: #d1d3e2;">
                    </div>

                </div>

                <form id="emailForm">
                    <div class="form-group">
                        <label for="emailList">Email Addresses (separated by commas):</label>
                        <textarea class="form-control" id="emailList" rows="3"
                            placeholder="Enter emails, separated by commas"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="emailSubject">Subject:</label>
                        <input type="text" class="form-control" id="emailSubject" placeholder="Enter subject"
                            style="border: 1px solid #7a0621; font-size: 1rem;" value="Invitation to Participate">

                    </div>
                    <div class="form-group">
                        <label for="emailBody">Message:</label>
                        <textarea class="form-control" id="emailBody" rows="10"
                            placeholder="Write your message here"> </textarea>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="sendEmail()">Send Email</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

    CKEDITOR.replace('emailBody');

    $('#email_inv').click(function() {
        var serviceTitle = $('#p_service_title').val();
        var serviceVenue = $('#p_serviceVenue').val();
        var from = $('#p_fromDate').val();
        var to = $('#p_toDate').val();

        var inviteCode = $('#s_invcode').val(); // Grab the invite code

        // Set the data into the Email Invitation modal fields
        $('#e_service_title').val(serviceTitle);
        $('#e_serviceVenue').val(serviceVenue);

        $('#e_fromDate').val(from);
        $('#e_toDate').val(to);



        $('#e_inviteCode').text(inviteCode); // Update the simple DOM element

        // Dynamically update CKEditor content
        var message = `
            <p>Dear Participant,</p>
            <p>We are pleased to invite you to our upcoming event, scheduled to take place from <strong>${from}</strong> to <strong>${to}</strong> at <strong>${serviceVenue}</strong>. This event will offer you the opportunity to engage with industry leaders and enhance your skills.</p>
            <p>Please find the invitation code attached: <strong>${inviteCode}</strong></p>
            <p>Invitation Link: <strong>https://www.serdac-wmsu.online/service_join.php?inv=${inviteCode}</strong></p>

            <p>We look forward to your participation.</p>
            <p>Best regards,<br>SERDAC-WMSU</p>
        `;
        CKEDITOR.instances['emailBody'].setData(message); // Set the dynamic data

        // Hide any open modal and show the email modal
        $("[data-dismiss=modal]").trigger("click");
        var emailModal = new bootstrap.Modal(document.getElementById('emailModal'));
        emailModal.show(); // Show the next modal
    });
});


$(document).ready(function() {
    function sendEmail() {
        var emails = $('#emailList').val().trim();
        var subject = $('#emailSubject').val().trim();
        var body = CKEDITOR.instances.emailBody.getData().trim();

        // Show loading screen
        Swal.fire({
            title: 'Sending...',
            text: 'Please wait while the email is being sent.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Implement AJAX call to send the emails
        $.ajax({
            url: 'function/email_participants.php', // Your endpoint for sending emails
            type: 'POST',
            data: {
                emails: emails,
                subject: subject,
                body: body
            },
            success: function(response) {
                // Hide loading dialog
                Swal.close();

                // Show success alert
                Swal.fire({
                    title: 'Success!',
                    text: 'Email sent successfully!',
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
                $("[data-dismiss=modal]").trigger("click");

                // Optionally hide the modal after successful sending
            },
            error: function(xhr, status, error) {
                // Hide loading dialog
                Swal.close();

                // Show error alert
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to send the email. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'Ok'
                });
            }
        });
    }

    // Bind the sendEmail function to the button's click event
    $('#emailModal .btn-primary').click(sendEmail);
});
</script>