    <div class="form-card">

        <h5 class="sub-heading mb-4"><i class="fas fa-info-circle"></i> Request Information <br>
            <span class="service-type">[ Capability Training ]</span>
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
            <div class="col-4">
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

        </div>


        <div class="container mt-4">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label for="purpose-options" class="required">Purpose of Request</label>
                        <div id="purpose-options" class="row">
                            <div class="col-sm-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="purpose_options[]"
                                        id="purpose-research" value="Research">
                                    <label class="form-check-label ml-2" for="purpose-research"
                                        style="font-weight: normal;">Research</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="purpose_options[]"
                                        id="purpose-data-analysis" value="Data Analysis">
                                    <label class="form-check-label ml-2" for="purpose-data-analysis"
                                        style="font-weight: normal;">Data Analysis</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="purpose_options[]"
                                        id="purpose-policy-development" value="Policy Development">
                                    <label class="form-check-label ml-2" for="purpose-policy-development"
                                        style="font-weight: normal;">Policy Development</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="purpose_options[]"
                                        id="purpose-educational" value="Educational">
                                    <label class="form-check-label ml-2" for="purpose-educational"
                                        style="font-weight: normal;">Educational</label>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="purpose_options[]"
                                        id="purpose-technical-support" value="Technical Support">
                                    <label class="form-check-label ml-2" for="purpose-technical-support"
                                        style="font-weight: normal;">Technical Support</label>
                                </div>
                            </div>
                            <!-- Add more checkboxes as needed -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="purpose" class="required">Additional
                Details</label>
            <textarea id="purpose" name="additional_purpose_details" rows="4" class="form-control"
                placeholder="Please describe the purpose of your request in detail if needed"></textarea>
        </div>


    </div>