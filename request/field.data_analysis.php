    <style>
.container-research {
    border: 1px solid #dee2e6;
    /* Bootstrap-like grey border */
    background: #f8f9fa;
    /* Light grey background */
    border-radius: 0.25rem;
    /* Slight rounding of corners */
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    /* Subtle shadow for depth */
}

.header-research {
    color: #0056b3;
    /* Professional font choice */
}
    </style>
    <div class="form-card">
        <h5 class="sub-heading mb-4"><i class="fas fa-info-circle"></i> Request Information <br>
            <span class="service-type">[ Data Analysis ]</span>
        </h5>


        <hr>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label required">Office/Agency:
                    </label>
                    <input type="text" id="agency" name="office_agency" placeholder="" class="form-control"
                        onblur="validate2(1)">
                </div>

            </div>
            <div class="col">
                <div class="form-group">
                    <label class="form-control-label required" class="form-control-label">Agency
                        Classification:</label>
                    <select name="agency_classification" class="form-control">
                        <option value="" selected disabled>Select...
                        </option>

                        <option value="Public Agency">Public Agency
                        </option>
                        <option value="Private Agency">Private Agency
                        </option>
                        <option value="Goverment Organization">Goverment
                            Organization</option>

                        <option value="Non-Goverment Organization">
                            Non-Goverment Organization</option>
                        <option value="University">University</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
            </div>
        </div>



        <div class="row">

            <div class="col-6">
                <div class="form-group">
                    <label class="form-control-label required">Type of
                        Client
                        :</label>
                    <select name="client_type" class="form-control">
                        <option value="" selected disabled>Select...
                        </option>
                        <option value="Researcher">Researcher</option>
                        <option value="Goverment Employee">Goverment
                            Employee</option>
                        <option value="Student">Student</option>
                        <option value="Faculty">Faculty</option>
                        <option value="University">University</option>
                        <option value="Development Worker">Development
                            Worker</option>
                        <option value="Policy Maker">Policy Maker
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label class="form-control-label required">Analysis Type:</label>
                    <select name="analysis_type" class="form-control">
                        <option value="" selected disabled>Select...</option>
                        <option value="Statistical Tool">Use the statistical tool</option>
                        <option value="Run Analysis">Request to run the analysis</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="container-research my-4 p-3 border">
            <h3 class="header-research mb-3">Research Details</h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="research-overview" class="form-control-label required">Research Overview:</label>
                        <textarea id="research-overview" name="research_overview" class="form-control"
                            placeholder="Enter an overview of the research" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="general-objective" class="form-control-label required">General Objective:</label>
                        <textarea id="general-objective" name="general_objective" class="form-control"
                            placeholder="Enter the general objective of the research" rows="3"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="specific-objective" class="form-control-label required">Specific Objectives:</label>
                        <textarea id="specific-objective" name="specific_objective" class="form-control"
                            placeholder="Enter specific objectives of the research" rows="3"></textarea>
                    </div>
                </div>
            </div>
        </div>



        <div class="form-group">
            <label for="purpose-select" class="required">Purpose of
                Request</label>
            <select id="purpose-select" name="purpose_options[]" class="form-control" multiple>
                <option value="Research">Research</option>
                <option value="Data Analysis">Data Analysis</option>
                <option value="Policy Development">Policy Development
                </option>
                <option value="Educational">Educational</option>
                <option value="Technical Support">Technical Support
                </option>
                <!-- Add more options as needed -->
            </select>
            <small class="form-text text-muted">Hold down the Ctrl
                (windows) or Command (Mac) button to select multiple
                options.</small>
        </div>

        <div class="form-group">
            <label for="purpose" class="required">Additional
                Details</label>
            <textarea id="purpose" name="additional_purpose_details" rows="4" class="form-control"
                placeholder="Please describe the purpose of your request in detail if needed"></textarea>
        </div>

    </div>