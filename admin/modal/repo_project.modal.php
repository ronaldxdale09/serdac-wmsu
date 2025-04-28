<div class="modal fade" id="createProjectModal" tabindex="-1" role="dialog" aria-labelledby="createProjectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProjectModalLabel">Create New Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 700px; overflow-y: auto;">
                <form id="createProjectForm" action="function/repo.projects.action.php" method="POST">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="programTitle">Program Title</label>
                            <input type="text" class="form-control" id="programTitle" name="programTitle" required>
                        </div>
                        <div class="form-group col">
                            <label for="projectTitle">Project Title</label>
                            <input type="text" class="form-control" id="projectTitle" name="projectTitle" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="projectLeader">Project Leader</label>
                            <input type="text" class="form-control" id="projectLeader" name="projectLeader" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="projectLeaderSex">Project Leader Sex</label>
                            <select class="form-control" id="projectLeaderSex" name="projectLeaderSex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="projectLeaderAgency">Project Leader Agency</label>
                            <input type="text" class="form-control" id="projectLeaderAgency" name="projectLeaderAgency"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="projectLeaderContact">Project Leader Address/TelNo/Fax/Email</label>
                            <textarea class="form-control" id="projectLeaderContact" name="projectLeaderContact"
                                rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cooperatingAgencies">Cooperating Agencies</label>
                            <textarea class="form-control" id="cooperatingAgencies" name="cooperatingAgencies" rows="2"
                                required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="implementingAgency">Implementing Agency</label>
                            <input type="text" class="form-control" id="implementingAgency" name="implementingAgency"
                                required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="implementingAgencyAddress">Address of Implementing Agency</label>
                            <input type="text" class="form-control" id="implementingAgencyAddress"
                                name="implementingAgencyAddress" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="baseStation">Base Station</label>
                            <input type="text" class="form-control" id="baseStation" name="baseStation" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="otherImplementationSites">Other Implementation Sites (if applicable)</label>
                            <textarea class="form-control" id="otherImplementationSites" name="otherImplementationSites"
                                rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="startDate">Project Duration Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="endDate">Project Duration End Date</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="extensionDate">Extension Date (if applicable)</label>
                            <input type="date" class="form-control" id="extensionDate" name="extensionDate">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="projectCost">Project Cost</label>
                            <input type="number" step="0.01" class="form-control" id="projectCost" name="projectCost" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="sectors">Sectors</label>
                            <input type="text" class="form-control" id="sectors" name="sectors" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="sdgAddressed">SDG Addressed</label>
                            <input type="text" class="form-control" id="sdgAddressed" name="sdgAddressed" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="projectAbstract">Project Abstract</label>
                            <textarea class="form-control" id="projectAbstract" name="projectAbstract" rows="3"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fundedBy">Funded By</label>
                            <select class="form-control" id="fundedBy" name="fundedBy" required>
                                <option value="DOST-PCAARRD">DOST-PCAARRD</option>
                                <option value="DOST-IX">DOST-IX</option>
                                <option value="DTI-IX">DTI-IX</option>
                                <option value="DA-IX">DA-IX</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="facilitatedBy">Facilitated By</label>
                            <select class="form-control" id="facilitatedBy" name="facilitatedBy">
                                <option value="WESMAARRDEC">WESMAARRDEC</option>
                                <option value="SERDAC">SERDAC</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

            </div>

            <div class="modal-footer">
                <div class="form-row">
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Save Project</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>


<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal" tabindex="-1" role="dialog" aria-labelledby="editProjectModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Edit Project</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProjectForm" action="function/repo.projects.action.php" method="POST">
                    <input type="hidden" id="editProjectID" name="projectID">

                    <div class="form-row">
                        <div class="form-group col">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                        <div class="form-group col">
                            <label for="editProgramTitle">Program Title</label>
                            <input type="text" class="form-control" id="editProgramTitle" name="programTitle" required>
                        </div>
                        <div class="form-group col">
                            <label for="editProjectTitle">Project Title</label>
                            <input type="text" class="form-control" id="editProjectTitle" name="projectTitle" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editProjectLeader">Project Leader</label>
                            <input type="text" class="form-control" id="editProjectLeader" name="projectLeader"
                                required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editProjectLeaderSex">Project Leader Sex</label>
                            <select class="form-control" id="editProjectLeaderSex" name="projectLeaderSex" required>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editProjectLeaderAgency">Project Leader Agency</label>
                            <input type="text" class="form-control" id="editProjectLeaderAgency"
                                name="projectLeaderAgency" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editProjectLeaderContact">Project Leader Address/TelNo/Fax/Email</label>
                            <textarea class="form-control" id="editProjectLeaderContact" name="projectLeaderContact"
                                rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editCooperatingAgencies">Cooperating Agencies</label>
                            <textarea class="form-control" id="editCooperatingAgencies" name="cooperatingAgencies"
                                rows="2" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editImplementingAgency">Implementing Agency</label>
                            <input type="text" class="form-control" id="editImplementingAgency"
                                name="implementingAgency" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editImplementingAgencyAddress">Address of Implementing Agency</label>
                            <input type="text" class="form-control" id="editImplementingAgencyAddress"
                                name="implementingAgencyAddress" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editBaseStation">Base Station</label>
                            <input type="text" class="form-control" id="editBaseStation" name="baseStation" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editOtherImplementationSites">Other Implementation Sites (if
                                applicable)</label>
                            <textarea class="form-control" id="editOtherImplementationSites"
                                name="otherImplementationSites" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editStartDate">Project Duration Start Date</label>
                            <input type="date" class="form-control" id="editStartDate" name="startDate" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editEndDate">Project Duration End Date</label>
                            <input type="date" class="form-control" id="editEndDate" name="endDate" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editExtensionDate">Extension Date (if applicable)</label>
                            <input type="date" class="form-control" id="editExtensionDate" name="extensionDate">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editProjectCost">Project Cost</label>
                            <input type="number" step="0.01" class="form-control" id="editProjectCost" name="projectCost" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editSectors">Sectors</label>
                            <input type="text" class="form-control" id="editSectors" name="sectors" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editSdgAddressed">SDG Addressed</label>
                            <input type="text" class="form-control" id="editSdgAddressed" name="sdgAddressed" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="editProjectAbstract">Project Abstract</label>
                            <textarea class="form-control" id="editProjectAbstract" name="projectAbstract" rows="3"
                                required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editFundedBy">Funded By</label>
                            <select class="form-control" id="editFundedBy" name="fundedBy" required>
                                <option value="DOST-PCAARRD">DOST-PCAARRD</option>
                                <option value="DOST-IX">DOST-IX</option>
                                <option value="DTI-IX">DTI-IX</option>
                                <option value="DA-IX">DA-IX</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editFacilitatedBy">Facilitated By</label>
                            <select class="form-control" id="editFacilitatedBy" name="facilitatedBy">
                                <option value="WESMAARRDEC">WESMAARRDEC</option>
                                <option value="SERDAC">SERDAC</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#editProjectForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: 'function/repo.projects.update.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                // Optionally show a toast or alert
                location.reload();
            },
            error: function() {
                alert('Failed to update project.');
            }
        });
    });
});
</script>