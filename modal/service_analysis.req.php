<style>
.request-progress-message p {
    font-size: 1.2em;
    /* Adjust size as needed */
    color: #2a2a2a;
    /* Dark grey text color for readability */
    padding: 10px 20px;
    /* Padding for spacing around the text */
    background-color: #f0f8ff;
    /* Light background color to match uploader */
    border-radius: 5px;
    /* Slightly rounded corners for the message box */
    margin-bottom: 20px;
    /* Space between message and uploader */
    border: 1px solid #d1eaff;
    /* Subtle border color */
    text-align: center;
    /* Center the text for better focus */
}

.file-uploader {
    font-family: Arial, sans-serif;
    width: 100%;
    border: 2px dashed #00A1FF;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    margin: 20px;
    background-color: #f0f8ff;
}

.upload-box {
    cursor: pointer;
    color: #007bff;
    padding: 10px;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.upload-box:hover {
    background-color: #e0f7ff;
}

.upload-box i {
    font-size: 24px;
}

.file-list h4 {
    margin-top: 20px;
    color: #333;
}

#file-list {
    list-style: none;
    padding: 0;
}

#file-list li {
    background-color: #e9ecef;
    padding: 8px 10px;
    margin-top: 8px;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.file-icon {
    width: 50px;
    display: inline-block;
    padding-right: 10px;
    text-align: center;
}

.remove-btn {
    background-color: transparent;
    border: none;
    cursor: pointer;
    color: #dc3545;
}
</style>

<div class="modal fade" id="anaylsisReqModal" tabindex="-1" role="dialog"
    aria-labelledby="requestServiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Request Processing Requirements</h5>
            </div>
            <div class="modal-body">
                <form action="function/request.analysis_files.php" method="post" enctype="multipart/form-data">
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

                    <div id="upload_document_list"></div>

                    <div class="form-row">

                        <div class="request-progress-message">
                            <p>Your request is currently being processed. To facilitate the next steps, SERDAC requires
                                the submission of manuscripts, datasets, and any other relevant documents pertinent to
                                your request.</p>

                        </div>

                        <div class="file-uploader">
                            <div class="upload-box" onclick="document.getElementById('file-input').click();">
                                <i class="fa fa-cloud-upload-alt"></i>
                                <span>Click To Upload</span>
                            </div>
                            <input type="file" id="file-input" name="files[]" multiple accept=".doc,.docx,.pdf,.csv"
                                style="display:none;">

                            <div class="file-list">
                                <h4>Uploaded Documents</h4>
                                <ul id="file-list"></ul>
                            </div>
                        </div>

                    </div>


            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>


                <button type="submit" name="confirm" id="btnSaveMeetingForm" class="btn btn-warning text-dark"><i
                        class="fas fa-check"></i>Upload Document</button>
                </form>

            </div>


        </div>

    </div>
</div>

<script>
// Check if the handler has already been set
if (!window.fileInputHandlerSet) {
    var fileInput = document.getElementById('file-input');

    function handleFileChange(e) {
        var files = e.target.files;
        var list = document.getElementById('file-list');

        Array.from(files).forEach((file, index) => {
            var li = document.createElement('li');
            li.textContent = file.name + ' - Uploading...';

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
                li.textContent = file.name + ' - Uploaded';
                li.appendChild(removeBtn);
            }, 1500);
        });
    }

    // Attach the event listener
    fileInput.addEventListener('change', handleFileChange);

    // Set a flag to indicate the handler has been set
    window.fileInputHandlerSet = true;
}
</script>