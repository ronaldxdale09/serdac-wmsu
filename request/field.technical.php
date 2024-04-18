    <div class="form-card">
        <h5 class="sub-heading mb-4"><i class="fas fa-info-circle"></i> Request Information <br>
            <span class="service-type">[ Technical Assistance ]</span>
        </h5>
        <div id="selected-service-card" class="selected-service text-center"></div>
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
            <div class="col">
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
            <div class="col">
                <div class="form-group">
                    <label for="mode-of-assistance" class="form-control-label required">Mode of Assistance:</label>
                    <select id="mode-of-assistance" name="mode_of_assistance" class="form-control">
                        <option value="" selected disabled>Select mode...</option>
                        <option value="Online">Online</option>
                        <option value="Face to Face">Face to Face</option>
                    </select>
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