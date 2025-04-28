<link rel="stylesheet" href="css/service_analysis.req.css">



<div class="modal fade" id="anaylsisReqModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Documents</h5>
            </div>
            <div class="modal-body">
                <form action="function/service_analysis_files_res.php" id="meeting_form" method="post"
                    enctype="multipart/form-data">

                    <input type="text" class="form-control" name="req_id" id="r_req_id" hidden>
                    <div class="form-row">
                        <!-- User ID -->
                        <div class="form-group col-md-6">
                            <label for="user-id">Client</label>
                            <input type="text" class="form-control" id="r_user-name" readonly>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="user-id">Email</label>
                            <input type="text" class="form-control" id="r_email" readonly>
                        </div>

                    </div>


                    <div class="form-row">
                        <!-- Service Type -->
                        <div class="form-group col">
                            <label for="service-type">Service Type</label>
                            <input type="text" class="form-control" id="r_service-type" readonly>
                        </div>
                        <!-- Office Agency -->
                        <div class="form-group col ">
                            <label for="office-agency">Office/Agency</label>
                            <input type="text" class="form-control" id="r_office-agency" readonly
                                placeholder="Enter office/agency">
                        </div>

                        <!-- Agency Classification -->
                        <div class="form-group col">
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
                    <button type="button" class="btn btn-dark notify_docu">
                        <i class="fa fa-bell"></i> Notify again to Submit Documents
                    </button>
                    <br> <br>



                    <!-- Tab links -->
                    <div class="tab">
                        <button type="button" class="tablinks active" onclick="openTab(event, 'Tab1')">
                            <i class="fa fa-folder-open"></i> Client Documents
                        </button>
                        <button type="button" class="tablinks" onclick="openTab(event, 'Tab2')">
                            <i class="fa fa-file-alt"></i> Result Files
                        </button>
                    </div>

                    <!-- Tab content -->
                    <div id="Tab1" class="tabcontent active">
                        <h3 class="document-title">Documents Submitted by Client</h3>
                        <div id="upload_document_list"></div>

                    </div>
                    <div id="Tab2" class="tabcontent">
                        <div class="form-row">
                            <h3 class="document-title">Data Analysis Results</h3>
                            <div id="upload_document_result" style="width: 100% !important;"></div>
                            <div class="file-uploader">
                                <div class="upload-box" onclick="document.getElementById('file-input').click();">
                                    <i class="fa fa-cloud-upload-alt"></i>
                                    <span>Click To Upload</span>
                                </div>
                                <input type="file" id="file-input" name="files[]" multiple
                                    accept=".doc, .docx, .pdf, .csv" style="display: none;">
                                <div class="file-list">
                                    <h4>Uploaded Documents</h4>
                                    <ul id="file-list"></ul>
                                </div>
                            </div>
                            <button type="submit" name="confirm" class="btn btn-warning text-dark">
                                <i class="fas fa-check"></i> Upload Document
                            </button>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
            </div>
        </div>

    </div>
</div>


<!-- notify -->

<!-- Notify via Email Modal -->
<div class="modal fade" id="notifyEmailDocu" tabindex="-1" aria-labelledby="notifyEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifyEmailModalLabel">Notify via Email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formDocuEmail">
                    <div class="form-group">
                        <label for="recipient-name">Client Name</label>
                        <input type="text" class="form-control" id="d_recipient-name" name="recipient_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="recipient-email">Recipient Email</label>
                        <input type="email" class="form-control" id="d_recipient-email" name="recipient_email" required>
                    </div>
                    <div class="form-group">
                        <label for="meeting-content">Meeting Content</label>
                        <textarea class="form-control" id="d_meeting-content" name="meeting_content" rows="10"
                            style="min-height: 200px;"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
// Notify via Email Button Click Handler
$(document).on('click', '.notify_docu', function() {
    // Manually hide all currently visible modals
    $("[data-dismiss=modal]").trigger({
        type: "click"
    });

    // Wait for the hide transition to complete
    setTimeout(() => {
        var modalBody = $(this).closest('.modal-body');
        var clientName = modalBody.find('#r_user-name').val().trim();
        var clientEmail = modalBody.find('#r_email').val().trim();
        var serviceType = modalBody.find('#r_service-type').val().trim();
        var officeAgency = modalBody.find('#r_office-agency').val().trim();
        var agencyClassification = modalBody.find('#r_agency-classification').val().trim();
        var clientType = modalBody.find('#r_client-type').val().trim();
        var purpose = modalBody.find('#r_purpose').val().trim();

        var emailContent = `
            Dear ${clientName},

            This is a reminder to submit the required documents for your ${serviceType} service request.

            Details:
            - Office/Agency: ${officeAgency}
            - Agency Classification: ${agencyClassification}
            - Client Type: ${clientType}
            - Purpose: ${purpose}

            Please make sure to submit the documents at your earliest convenience.

            You can review and upload the required documents by logging into your profile here:
            [SERDAC-WMSU Profile](https://satserdac-wmsu.com/profile.php)

            Best regards,
            SERDAC-WMSU
            https://satserdac-wmsu.com
        `;

        // Assuming the existence of a modal for email notification
        $('#d_recipient-name').val(clientName);
        $('#d_recipient-email').val(clientEmail);
        $('#d_meeting-content').val(emailContent);

        var modal = new bootstrap.Modal(document.getElementById('notifyEmailDocu'));
        modal.show();
    }, 500); // Adjust this timeout if necessary
});



// Notify Email Form Submission Handler
$('#formDocuEmail').on('submit', function(e) {
    e.preventDefault();

    var formData = $(this).serialize();

    // Display loading alert
    Swal.fire({
        title: 'Sending Email...',
        text: 'Please wait while we send the email notification.',
        icon: 'info',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: 'function/document_notification.php', // Update with your server script
        type: 'POST',
        data: formData,
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Email Sent',
                text: 'The notification email has been sent successfully!'
            });

            $('#notifyEmailModal').modal('hide');
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send the notification email.'
            });
            console.error('Error sending email notification:', error);
        }
    });
});




function openTab(evt, TabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(TabName).style.display = "block";
    evt.currentTarget.className += " active";
}
</script>

<script>
if (!window.fileInputHandlerSet) {
    var fileInput = document.getElementById('file-input');

    function handleFileChange(e) {
        var files = e.target.files;
        var list = document.getElementById('file-list');

        Array.from(files).forEach((file, index) => {
            var li = document.createElement('li');
            li.textContent = file.name + ' - ';

            // Remarks input
            var remarksInput = document.createElement('input');
            remarksInput.type = 'text';
            remarksInput.placeholder = 'Enter remarks';
            remarksInput.className = 'remarks-input';
            remarksInput.name = 'remarks_file[]';
            li.appendChild(remarksInput);

            // Progress bar
            var progressBar = document.createElement('div');
            progressBar.className = 'progress-bar';
            li.appendChild(progressBar);

            // Remove button
            var removeBtn = document.createElement('button');
            removeBtn.className = 'remove-btn';
            removeBtn.innerHTML = '✕';
            removeBtn.onclick = function() {
                li.parentNode.removeChild(li);
            };
            li.appendChild(removeBtn);

            list.appendChild(li);

            // Simulate upload progress
            setTimeout(() => {
                progressBar.style.width = '100%';
                li.textContent = file.name + ' - Verified ';
                li.appendChild(remarksInput);
                li.appendChild(progressBar);
                li.appendChild(removeBtn);
            }, 1500);
        });
    }

    fileInput.addEventListener('change', handleFileChange);
    window.fileInputHandlerSet = true;
}
</script>