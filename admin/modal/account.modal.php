<!-- The Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="newUserForm" action="function/user.mngmnt.php" method="POST" class="row g-3">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userName" class="form-label required">First Name:</label>
                            <input type="text" class="form-control" name="fname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userMidName" class="form-label required">Mid Name:</label>
                            <input type="text" class="form-control" name="midname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userLastName" class="form-label required">Last Name:</label>
                            <input type="text" class="form-control" name="lname" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userEmail" class="form-label required">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userPassword" class="form-label">Password:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userContact" class="form-label">Contact #:</label>
                            <input type="text" class="form-control" name="contact_no" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userType" class="form-label">User Type:</label>
                            <select class="form-control" id="userType" name="userType" required>
                                <option value="" disabled selected>Select a type</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="userAccess" class="form-label">User Access:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="superadmin" id="superadmin">
                                        <label class="form-check-label" for="accessDashboard">Super Admin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="dashboard" id="accessDashboard">
                                        <label class="form-check-label" for="accessDashboard">Dashboard</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="content_management" id="accessContentManagement">
                                        <label class="form-check-label" for="accessContentManagement">Content
                                            Management</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="articles_create" id="accessCreateArticles">
                                        <label class="form-check-label" for="accessCreateArticles">Create Post</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="articles_manage" id="accessManageArticles">
                                        <label class="form-check-label" for="accessManageArticles">Manage Post</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="services" id="accessServices">
                                        <label class="form-check-label" for="accessServices">Services</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="request_record" id="accessRequestRecord">
                                        <label class="form-check-label" for="accessRequestRecord">Request Record</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="repository" id="accessRepository">
                                        <label class="form-check-label" for="accessRepository">Repository</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="projects" id="accessProjects">
                                        <label class="form-check-label" for="accessProjects">Projects</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="e_books" id="accessEBooks">
                                        <label class="form-check-label" for="accessEBooks">E-Books</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="journals" id="accessJournals">
                                        <label class="form-check-label" for="accessJournals">Journals</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessment" id="accessAssessment">
                                        <label class="form-check-label" for="accessAssessment">Assessment</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="speaker_profile" id="accessSpeakerProfile">
                                        <label class="form-check-label" for="accessSpeakerProfile">Speaker
                                            Profile</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="schedules" id="accessSchedules">
                                        <label class="form-check-label" for="accessSchedules">Schedules</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="account_management" id="accessAccountManagement">
                                        <label class="form-check-label" for="accessAccountManagement">Account
                                            Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="client_list" id="accessClientList">
                                        <label class="form-check-label" for="accessClientList">Client List</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="activity_logs" id="accessActivityLogs">
                                        <label class="form-check-label" for="accessActivityLogs">Activity Logs</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="contact_messages" id="accessContactMessages">
                                        <label class="form-check-label" for="accessContactMessages">Contact
                                            Messages</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="summary_report" id="accessSummaryReport">
                                        <label class="form-check-label" for="accessSummaryReport">Summary Report</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="newUserForm" class="btn btn-primary" name="new">Confirm</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const superAdminCheckbox = document.getElementById('superadmin');
    const checkboxes = document.querySelectorAll('.form-check-input:not(#superadmin)');

    superAdminCheckbox.addEventListener('change', function() {
        if (this.checked) {
            checkboxes.forEach(checkbox => {
                checkbox.disabled = true;
            });
        } else {
            checkboxes.forEach(checkbox => {
                checkbox.disabled = false;
            });
        }
    });
});
</script>
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm User Deletion</h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="text-danger"><strong>Warning:</strong> This action cannot be undone. Are you sure you want to
                    permanently delete this user?</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <form action="function/user.mngmnt.php" method="POST">
                    <input type="hidden" name="user_id" id="deleteUserId">

                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete User</button>
                </form>
            </div>

        </div>
    </div>
</div>




<!-- The Update Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="updateUserForm" action="function/user.mngmnt.php" method="POST" class="row g-3">
                    <input type="hidden" name="user_id" id="updateUserId">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="updateFname" class="form-label required">First Name:</label>
                            <input type="text" class="form-control" name="fname" id="updateFname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="updateMidname" class="form-label required">Mid Name:</label>
                            <input type="text" class="form-control" name="midname" id="updateMidname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="updateLname" class="form-label required">Last Name:</label>
                            <input type="text" class="form-control" name="lname" id="updateLname" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateEmail" class="form-label required">Email:</label>
                            <input type="email" class="form-control" name="email" id="updateEmail" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateContactNo" class="form-label">Contact #:</label>
                            <input type="text" class="form-control" name="contact_no" id="updateContactNo" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateUserType" class="form-label">User Type:</label>
                            <select class="form-control" id="updateUserType" name="userType" required>
                                <option value="" disabled selected>Select a type</option>
                                <option value="Administrator">Administrator</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="updateUserAccess" class="form-label">User Access:</label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="superadmin" id="updateSuperadmin">
                                        <label class="form-check-label" for="updateSuperadmin">Super Admin</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="dashboard" id="updateAccessDashboard">
                                        <label class="form-check-label" for="updateAccessDashboard">Dashboard</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="content_management" id="updateAccessContentManagement">
                                        <label class="form-check-label" for="updateAccessContentManagement">Content
                                            Management</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="articles_create" id="updateAccessCreateArticles">
                                        <label class="form-check-label" for="updateAccessCreateArticles">Create
                                            Post</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="articles_manage" id="updateAccessManageArticles">
                                        <label class="form-check-label" for="updateAccessManageArticles">Manage
                                            Post</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="services" id="updateAccessServices">
                                        <label class="form-check-label" for="updateAccessServices">Services</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="request_record" id="updateAccessRequestRecord">
                                        <label class="form-check-label" for="updateAccessRequestRecord">Request
                                            Record</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="repository" id="updateAccessRepository">
                                        <label class="form-check-label" for="updateAccessRepository">Repository</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="projects" id="updateAccessProjects">
                                        <label class="form-check-label" for="updateAccessProjects">Projects</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="e_books" id="updateAccessEBooks">
                                        <label class="form-check-label" for="updateAccessEBooks">E-Books</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="journals" id="updateAccessJournals">
                                        <label class="form-check-label" for="updateAccessJournals">Journals</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessment" id="updateAccessAssessment">
                                        <label class="form-check-label" for="updateAccessAssessment">Assessment</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="speaker_profile" id="updateAccessSpeakerProfile">
                                        <label class="form-check-label" for="updateAccessSpeakerProfile">Speaker
                                            Profile</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="schedules" id="updateAccessSchedules">
                                        <label class="form-check-label" for="updateAccessSchedules">Schedules</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="account_management" id="updateAccessAccountManagement">
                                        <label class="form-check-label" for="updateAccessAccountManagement">Account
                                            Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="client_list" id="updateAccessClientList">
                                        <label class="form-check-label" for="updateAccessClientList">Client List</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="activity_logs" id="updateAccessActivityLogs">
                                        <label class="form-check-label" for="updateAccessActivityLogs">Activity
                                            Logs</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="contact_messages" id="updateAccessContactMessages">
                                        <label class="form-check-label" for="updateAccessContactMessages">Contact
                                            Messages</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="summary_report" id="updateAccessSummaryReport">
                                        <label class="form-check-label" for="updateAccessSummaryReport">Summary
                                            Report</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="updateUserForm" class="btn btn-primary" name="update">Update</button>
            </div>
        </div>
    </div>
</div>