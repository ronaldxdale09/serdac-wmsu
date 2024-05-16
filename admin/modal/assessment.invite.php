<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="emailModalLabel">Invite Participants</h5>
            </div>
            <div class="modal-body">
                <!-- Form inside the modal -->
                <div class="form-group">
                    <label for="formTitle">Form Title</label>
                    <input type="text" id="formTitle" class="form-control" readonly
                        style="border-color: #d1d3e2; font-size: 1.25rem; text-align: center;">
                </div>
                <div class="form-group">
                    <label for="formDescription">Form Description</label>
                    <textarea id="formDescription" class="form-control" rows="2" readonly
                        style="border-color: #d1d3e2; font-size: 1.25rem; text-align: center;"></textarea>
                </div>
                <div class="form-group">
                    <label for="inviteLink">Invite Link</label>
                    <div class="input-group">
                        <input type="text" id="inviteLink" class="form-control" readonly
                            value="http://example.com/invite-link" style="border-color: #d1d3e2;">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyInviteLink()">
                                <i class="fa fa-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <form id="emailForm">
                    <div class="form-group">
                        <label for="emailList">Email Addresses (separated by commas)</label>
                        <textarea class="form-control" id="emailList" rows="3"
                            placeholder="Enter emails, separated by commas"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="emailSubject">Subject</label>
                        <input type="text" class="form-control" id="emailSubject" placeholder="Enter subject"
                            style="border: 1px solid #7a0621; font-size: 1rem;" value="Invitation to Participate">
                    </div>
                    <div class="form-group">
                        <label for="emailBody">Message</label>
                        <textarea class="form-control" id="emailBody" rows="10"
                            placeholder="Write your message here"></textarea>
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
function copyInviteLink() {
    var copyText = document.getElementById("inviteLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices
    document.execCommand("copy");
    alert("Invite link copied: " + copyText.value);
}



function sendEmail() {
    var emails = $('#emailList').val().trim();
    var subject = $('#emailSubject').val().trim();
    var body = $('#emailBody').val().trim();

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
</script>