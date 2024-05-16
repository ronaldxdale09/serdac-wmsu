<style>
.document-title {
    font-size: 1.5rem;
    /* Adjust size as needed */
    color: #333;
    /* Dark grey for readability */
    text-align: center;
    /* Centers text horizontally */
    width: 100%;
    /* Maintains padding if needed, though it might be unnecessary with centering */
}


/* Style the tab */
.tab {
    background-color: #800000;
    /* Maroon background */
    border: 1px solid #ccc;
    overflow: hidden;
}

/* Style the buttons inside the tab */
.tab button {
    background-color: inherit;
    /* Inherits maroon from .tab */
    color: #ffffff;
    /* White text for readability */
    float: left;
    border: none;
    outline: none;
    cursor: pointer;
    padding: 14px 16px;
    transition: 0.3s;
    font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
    background-color: #b30000;
    /* A slightly lighter maroon on hover */
    color: #ffffff;
    /* Maintains white text on hover */
}

/* Create an active/current tablink class */
.tab button.active {
    background-color: #990000;
    /* A different shade of maroon for active state */
    color: #ffffff;
    /* White text for active state */
}

/* Style the tab content */
.tabcontent {
    display: none;
    padding: 6px 12px;
    border: 1px solid #ccc;
    border-top: none;
    background-color: white;
    /* White text for content */
}

.tabcontent.active {
    display: block;
}
</style>
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

.file-uploader .remarks-input {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    box-sizing: border-box;
    /* Includes padding and border in the element's width/height */
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>

<div class="modal fade" id="anaylsisReqModal" tabindex="-999999" role="dialog"
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
                        <hr>
                        <h3 class="document-title">Documents Submitted by Client</h3>
                        <hr>
                        <div id="upload_document_list"></div>
                        <div class="form-row">



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
                    <div id="Tab2" class="tabcontent">
                        <div class="form-row">
                            <hr>
                            <h3 class="document-title">Data Analysis Results</h3>
                            <hr>
                            <div id="upload_document_result" style="width: 100% !important;"></div>


                        </div>
                    </div>





            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>




                <div id="btnUploadDoc" style="display: none;">
                    <button type="submit" name="confirm"  class="btn btn-warning text-dark"><i
                            class="fas fa-check"></i>Upload Document</button>
                </div>

                </form>

            </div>


        </div>

    </div>
</div>
<script>
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
            remarksInput.name = 'remarks[]';
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
                li.appendChild(removeBtn);
            }, 1500);
        });
    }

    fileInput.addEventListener('change', handleFileChange);
    window.fileInputHandlerSet = true;
}
</script>