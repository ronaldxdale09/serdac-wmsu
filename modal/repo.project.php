<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel"> Project Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" action="function/repo.projects.action.php" method="POST">
                    <input type="hidden" id="editProjectID" name="projectID">

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="editStatus">Status</label>
                            <select class="form-control" readonly id="editStatus" name="status" required>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editProgramTitle">Program Title</label>
                            <input type="text" class="form-control" readonly id="editProgramTitle" name="programTitle" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editProjectTitle">Project Title</label>
                            <input type="text" class="form-control" readonly id="editProjectTitle" name="projectTitle" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editProjectLeader">Project Leader</label>
                            <input type="text" class="form-control" readonly id="editProjectLeader" name="projectLeader" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="editProjectLeaderSex">Project Leader Sex</label>
                            <select class="form-control" readonly id="editProjectLeaderSex" name="projectLeaderSex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="editProjectLeaderAgency">Project Leader Agency</label>
                            <input type="text" class="form-control" readonly id="editProjectLeaderAgency" name="projectLeaderAgency" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editProjectLeaderContact">Project Leader Contact</label>
                            <textarea class="form-control" readonly id="editProjectLeaderContact" name="projectLeaderContact" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editCooperatingAgencies">Cooperating Agencies</label>
                            <textarea class="form-control" readonly id="editCooperatingAgencies" name="cooperatingAgencies" rows="2" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editImplementingAgency">Implementing Agency</label>
                            <input type="text" class="form-control" readonly id="editImplementingAgency" name="implementingAgency" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editImplementingAgencyAddress">Implementing Agency Address</label>
                            <input type="text" class="form-control" readonly id="editImplementingAgencyAddress" name="implementingAgencyAddress" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editBaseStation">Base Station</label>
                            <input type="text" class="form-control" readonly id="editBaseStation" name="baseStation" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editOtherImplementationSites">Other Implementation Sites</label>
                            <textarea class="form-control" readonly id="editOtherImplementationSites" name="otherImplementationSites" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="editStartDate">Start Date</label>
                            <input type="date" class="form-control" readonly id="editStartDate" name="startDate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editEndDate">End Date</label>
                            <input type="date" class="form-control" readonly id="editEndDate" name="endDate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="editExtensionDate">Extension Date</label>
                            <input type="date" class="form-control" readonly id="editExtensionDate" name="extensionDate">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editProjectCost">Project Cost</label>
                            <input type="number" class="form-control" readonly id="editProjectCost" name="projectCost" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editSdgAddressed">SDG Addressed</label>
                            <input type="text" class="form-control" readonly id="editSdgAddressed" name="sdgAddressed" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editProjectAbstract">Project Abstract</label>
                            <textarea class="form-control" readonly id="editProjectAbstract" name="projectAbstract" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editFundedBy">Funded By</label>
                            <select class="form-control" readonly id="editFundedBy" name="fundedBy" required>
                                <option value="DOST-PCAARRD">DOST-PCAARRD</option>
                                <option value="DOST-IX">DOST-IX</option>
                                <option value="DTI-IX">DTI-IX</option>
                                <option value="DA-IX">DA-IX</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editFacilitatedBy">Facilitated By</label>
                            <select class="form-control" readonly id="editFacilitatedBy" name="facilitatedBy">
                                <option value="WESMAARRDEC">WESMAARRDEC</option>
                                <option value="SERDAC">SERDAC</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
