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
                <hr>
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-group">
                            <label for="quota">Quota</label>
                            <input type="number" class="form-control" id="s_quota" name="quota"
                                placeholder="Enter quota">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="allow-participants-toggle">Allow Participants</label>
                            <button type="button" class="btn btn-secondary w-100" id="allow-participants-toggle">
                                <i class="fa fa-toggle-off"></i> Allow Participants
                            </button>
                        </div>
                    </div>
                    <div class="col ">
                        <label for="allow-participants-toggle"> Action</label>

                        <button type="button" class="btn btn-primary w-100" id="save-button">
                            Save
                        </button>
                    </div>
                </div>


                <hr>

                <div id="particiapnts_list_table"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    var allowParticipants = false;

    // Function to initialize the toggle button state
    function initializeToggleState(state) {
        allowParticipants = state;
        if (allowParticipants) {
            $('#allow-participants-toggle').removeClass('btn-secondary').addClass('btn-success');
            $('#allow-participants-toggle').html('<i class="fa fa-toggle-on"></i> Allow Participants');
        } else {
            $('#allow-participants-toggle').removeClass('btn-success').addClass('btn-secondary');
            $('#allow-participants-toggle').html('<i class="fa fa-toggle-off"></i> Allow Participants');
        }
    }

    // Toggle button click event
    $('#allow-participants-toggle').on('click', function() {
        allowParticipants = !allowParticipants;
        initializeToggleState(allowParticipants);

        if (!allowParticipants) {
            Swal.fire({
                icon: 'info',
                title: 'Notice',
                text: 'The service will no longer allow any user to join the training.'
            });
        }
    });

    // Save button click event
    $('#save-button').on('click', function() {
        var quota = $('#s_quota').val();
        var requestId = $('#s_req_id').val(); // Assuming you have request ID

        $.ajax({
            url: 'function/update_participants_settings.php',
            type: 'POST',
            data: {
                request_id: requestId,
                quota: quota,
                allow_participants: allowParticipants ? 1 : 0
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Settings have been updated successfully.'
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while saving the settings.'
                });
            }
        });
    });
});


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




    tinymce.init({
        selector: '#emailBody',
        plugins: 'lists wordcount',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright | bullist numlist | removeformat',
        menubar: false,
        statusbar: false,
        height: 300,
        content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }'
    });
    $('#email_inv').click(function() {

        $("[data-dismiss=modal]").trigger({
            type: "click"
        });

        // Wait for the hide transition to complete
        setTimeout(() => {

            var serviceTitle = $('#p_service_title').val();
            var serviceVenue = $('#p_serviceVenue').val();
            var from = $('#p_fromDate').val();
            var to = $('#p_toDate').val();
            var inviteCode = $('#s_invcode').val(); // Grab the invite code
            var requestId = $('#s_req_id').val(); // Grab the request id


            console.log("req_id : ", requestId);
            console.log("Service Title: ", serviceTitle);
            console.log("Service Venue: ", serviceVenue);
            console.log("From Date: ", from);
            console.log("To Date: ", to);
            console.log("Invite Code: ", inviteCode);

            // Manually parse the date string
            function parseDate(dateStr) {
                var parts = dateStr.match(/(\w+) (\d+), (\d+) at (\d+):(\d+) (AM|PM)/);
                var month = parts[1];
                var day = parseInt(parts[2]);
                var year = parseInt(parts[3]);
                var hour = parseInt(parts[4]);
                var minute = parseInt(parts[5]);
                var period = parts[6];

                // Convert month name to month index
                var monthIndex = new Date(Date.parse(month + " 1, 2024")).getMonth();

                // Adjust hour based on AM/PM
                if (period === "PM" && hour < 12) hour += 12;
                if (period === "AM" && hour === 12) hour = 0;

                return new Date(year, monthIndex, day, hour, minute);
            }

            var fromDateTime = parseDate(from);
            var toDateTime = parseDate(to);

            console.log("From DateTime: ", fromDateTime);
            console.log("To DateTime: ", toDateTime);

            // Format the dates for Google Calendar
            var fromFormatted = fromDateTime.toISOString().replace(/-|:|\.\d\d\d/g, "");
            var toFormatted = toDateTime.toISOString().replace(/-|:|\.\d\d\d/g, "");

            // Format the display dates
            var options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                hour12: true
            };
            var fromDisplay = fromDateTime.toLocaleString('en-US', options);
            var toDisplay = toDateTime.toLocaleString('en-US', options);

            console.log("From Display: ", fromDisplay);
            console.log("To Display: ", toDisplay);

            // Construct Google Calendar URL
            var googleCalendarUrl =
                `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${encodeURIComponent(serviceTitle)}&dates=${fromFormatted}/${toFormatted}&details=${encodeURIComponent('Invitation Code: ' + inviteCode)}&location=${encodeURIComponent(serviceVenue)}`;

            console.log("Google Calendar URL: ", googleCalendarUrl);

            // Set the data into the Email Invitation modal fields
            $('#e_service_title').val(serviceTitle);
            $('#e_serviceVenue').val(serviceVenue);
            $('#e_fromDate').val(fromDisplay);
            $('#e_toDate').val(toDisplay);
            $('#e_inviteCode').text(inviteCode);

            // Fetch participants' emails and populate emailList
            $.ajax({
                url: 'fetch/fetch_participant_emails.php',
                type: 'POST',
                data: {
                    request_id: requestId
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.error) {
                        console.log(result.error);
                    } else {
                        var emails = result.emails.join(', ');
                        $('#emailList').val(emails);
                        console.log(emails)

                        var message = `
                        <p>Dear Participant,</p>
                        <p>We are pleased to invite you to our upcoming event, scheduled to take place from <strong>${fromDisplay}</strong> to <strong>${toDisplay}</strong> at <strong>${serviceVenue}</strong>. This event will offer you the opportunity to engage with industry leaders and enhance your skills.</p>
                        <p>Please find the invitation code attached: <strong>${inviteCode}</strong></p>
                        <p>Invitation Link: <strong>https://www.serdac-wmsu.online/service_join.php?inv=${inviteCode}</strong></p>
                        <p><a href="${googleCalendarUrl}" target="_blank" class="btn btn-primary">Save to Google Calendar</a></p>
                        <p>We look forward to your participation.</p>
                        <p>Best regards,<br>SERDAC-WMSU</p>
                    `;
                        tinymce.get('emailBody').setContent(message);

                        // Hide any open modal and show the email modal
                        $('.modal').modal('hide'); // Hide any open modal
                        var emailModal = new bootstrap.Modal(document
                            .getElementById(
                                'emailModal'));
                        emailModal.show(); // Show the next modal
                    }
                },
                error: function() {
                    console.log('Error fetching participant emails.');
                }
            });
        }, 500);
    });

});

$(document).ready(function() {
    function sendEmail() {
        var emails = $('#emailList').val().trim();
        var subject = $('#emailSubject').val().trim();
        var body = tinymce.get('emailBody').getContent().trim();
        var requestId = $('#s_req_id')
            .val(); // Make sure this element exists and contains the correct request_id

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
            url: 'function/email_participants.php',
            type: 'POST',
            data: {
                emails: emails,
                subject: subject,
                body: body,
                request_id: requestId
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