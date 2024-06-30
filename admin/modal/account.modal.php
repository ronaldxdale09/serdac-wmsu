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
                                        <label class="form-check-label" for="superadmin">Super Admin</label>
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
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessment" id="accessAssessment">
                                        <label class="form-check-label" for="accessAssessment">Assessment</label>
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
                                            value="profile" id="accessProfile">
                                        <label class="form-check-label" for="accessProfile">Profile</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="speaker_profile" id="accessSpeakerProfile">
                                        <label class="form-check-label" for="accessSpeakerProfile">Speaker
                                            Profile</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="client_list" id="accessClientList">
                                        <label class="form-check-label" for="accessClientList">Client List</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="account_management" id="accessAccountManagement">
                                        <label class="form-check-label" for="accessAccountManagement">Account
                                            Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="reports" id="accessReports">
                                        <label class="form-check-label" for="accessReports">Reports</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="report_client" id="accessReportClient">
                                        <label class="form-check-label" for="accessReportClient">Client Report</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessments_reports" id="accessAssessmentsReports">
                                        <label class="form-check-label" for="accessAssessmentsReports">Assessments
                                            Reports</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="schedules" id="accessSchedules">
                                        <label class="form-check-label" for="accessSchedules">Schedules</label>
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

    // Define the hierarchy of checkboxes
    const checkboxHierarchy = {
        'accessContentManagement': ['accessCreateArticles', 'accessManageArticles'],
        'accessServices': ['accessRequestRecord', 'accessAssessment'],
        'accessRepository': ['accessProjects', 'accessEBooks', 'accessJournals'],
        'accessProfile': ['accessSpeakerProfile', 'accessClientList', 'accessAccountManagement'],
        'accessReports': ['accessReportClient', 'accessAssessmentsReports']
    };

    // Function to update parent checkbox
    function updateParentCheckbox(parentId) {
        const parent = document.getElementById(parentId);
        const children = checkboxHierarchy[parentId].map(id => document.getElementById(id));
        const allChecked = children.every(child => child.checked);
        const someChecked = children.some(child => child.checked);

        parent.checked = someChecked; // Changed this line
        parent.indeterminate = someChecked && !allChecked;
    }

    // Function to update child checkboxes
    function updateChildCheckboxes(parentId, checked) {
        checkboxHierarchy[parentId].forEach(childId => {
            const child = document.getElementById(childId);
            child.checked = checked;
            child.disabled = checked;
        });
    }

    // Function to find parent ID of a child checkbox
    function findParentId(childId) {
        return Object.keys(checkboxHierarchy).find(key =>
            checkboxHierarchy[key].includes(childId)
        );
    }

    // Add event listeners to all checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parentId = findParentId(this.id);
            if (parentId) {
                // This is a child checkbox
                const parent = document.getElementById(parentId);
                if (this.checked && !parent.checked) {
                    parent.checked = true;
                }
                updateParentCheckbox(parentId);
            } else if (checkboxHierarchy[this.id]) {
                // This is a parent checkbox
                updateChildCheckboxes(this.id, this.checked);
            }
        });
    });

    // Super Admin checkbox logic
    superAdminCheckbox.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            checkbox.disabled = this.checked;
        });
    });

    // Initial setup
    Object.keys(checkboxHierarchy).forEach(updateParentCheckbox);

    // Function to reset the form
    function resetForm() {
        document.getElementById('newUserForm').reset();
        document.getElementById('createUserModalLabel').textContent = 'Add New User';
        checkboxes.forEach(checkbox => {
            checkbox.disabled = false;
            checkbox.indeterminate = false;
        });
        Object.keys(checkboxHierarchy).forEach(updateParentCheckbox);
    }

    // Reset form when modal is hidden
    $('#createUserModal').on('hidden.bs.modal', function(e) {
        resetForm();
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
                    <!-- Existing fields -->
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

                    <!-- New Password Update Section -->
                    <div class="col-md-12">
                        <hr>
                        <h6>Update Password (Optional)</h6>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateNewPassword" class="form-label">New Password:</label>
                            <input type="password" class="form-control" name="newPassword" id="updateNewPassword">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateConfirmPassword" class="form-label">Confirm New Password:</label>
                            <input type="password" class="form-control" name="confirmPassword"
                                id="updateConfirmPassword">
                        </div>
                    </div>

                    <!-- User Access Checkboxes -->
                    <div class="col-md-12">
                        <hr>
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
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessment" id="updateAccessAssessment">
                                        <label class="form-check-label" for="updateAccessAssessment">Assessment</label>
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
                                            value="profile" id="updateAccessProfile">
                                        <label class="form-check-label" for="updateAccessProfile">Profile</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="speaker_profile" id="updateAccessSpeakerProfile">
                                        <label class="form-check-label" for="updateAccessSpeakerProfile">Speaker
                                            Profile</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="client_list" id="updateAccessClientList">
                                        <label class="form-check-label" for="updateAccessClientList">Client List</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="account_management" id="updateAccessAccountManagement">
                                        <label class="form-check-label" for="updateAccessAccountManagement">Account
                                            Management</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="reports" id="updateAccessReports">
                                        <label class="form-check-label" for="updateAccessReports">Reports</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="report_client" id="updateAccessReportClient">
                                        <label class="form-check-label" for="updateAccessReportClient">Client
                                            Report</label>
                                    </div>
                                    <div class="form-check ml-3">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="assessments_reports" id="updateAccessAssessmentsReports">
                                        <label class="form-check-label" for="updateAccessAssessmentsReports">Assessments
                                            Reports</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="userAccess[]"
                                            value="schedules" id="updateAccessSchedules">
                                        <label class="form-check-label" for="updateAccessSchedules">Schedules</label>
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

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    const superAdminCheckbox = document.getElementById('updateSuperadmin');
    const checkboxes = document.querySelectorAll('#updateUserForm .form-check-input:not(#updateSuperadmin)');

    // Define the hierarchy of checkboxes
    const checkboxHierarchy = {
        'updateAccessContentManagement': ['updateAccessCreateArticles', 'updateAccessManageArticles'],
        'updateAccessServices': ['updateAccessRequestRecord', 'updateAccessAssessment'],
        'updateAccessRepository': ['updateAccessProjects', 'updateAccessEBooks', 'updateAccessJournals'],
        'updateAccessProfile': ['updateAccessSpeakerProfile', 'updateAccessClientList',
            'updateAccessAccountManagement'
        ],
        'updateAccessReports': ['updateAccessReportClient', 'updateAccessAssessmentsReports']
    };

    // Function to update parent checkbox
    function updateParentCheckbox(parentId) {
        const parent = document.getElementById(parentId);
        const children = checkboxHierarchy[parentId].map(id => document.getElementById(id));
        const allChecked = children.every(child => child.checked);
        const someChecked = children.some(child => child.checked);

        parent.checked = someChecked;
        parent.indeterminate = someChecked && !allChecked;
    }

    // Function to update child checkboxes
    function updateChildCheckboxes(parentId, checked) {
        checkboxHierarchy[parentId].forEach(childId => {
            const child = document.getElementById(childId);
            child.checked = checked;
            child.disabled = checked;
        });
    }

    // Function to find parent ID of a child checkbox
    function findParentId(childId) {
        return Object.keys(checkboxHierarchy).find(key =>
            checkboxHierarchy[key].includes(childId)
        );
    }

    // Add event listeners to all checkboxes
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const parentId = findParentId(this.id);
            if (parentId) {
                // This is a child checkbox
                const parent = document.getElementById(parentId);
                if (this.checked && !parent.checked) {
                    parent.checked = true;
                }
                updateParentCheckbox(parentId);
            } else if (checkboxHierarchy[this.id]) {
                // This is a parent checkbox
                updateChildCheckboxes(this.id, this.checked);
            }
        });
    });

    // Super Admin checkbox logic
    superAdminCheckbox.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
            checkbox.disabled = this.checked;
        });
    });

    // Initial setup
    Object.keys(checkboxHierarchy).forEach(updateParentCheckbox);

    // Password validation
    const updateUserForm = document.getElementById('updateUserForm');
    updateUserForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('updateNewPassword').value;
        const confirmPassword = document.getElementById('updateConfirmPassword').value;

        if (newPassword || confirmPassword) {
            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New password and confirmation do not match!');
            }
        }
    });
});

// Function to populate the update form
function populateUpdateForm(userData) {
    document.getElementById('updateUserId').value = userData.user_id;
    document.getElementById('updateFname').value = userData.fname;
    document.getElementById('updateMidname').value = userData.midname;
    document.getElementById('updateLname').value = userData.lname;
    document.getElementById('updateEmail').value = userData.email;
    document.getElementById('updateContactNo').value = userData.contact_no;
    document.getElementById('updateUserType').value = userData.userType;

    // Clear password fields
    document.getElementById('updateNewPassword').value = '';
    document.getElementById('updateConfirmPassword').value = '';

    // Reset all checkboxes
    document.querySelectorAll('#updateUserForm .form-check-input').forEach(checkbox => {
        checkbox.checked = false;
        checkbox.disabled = false;
    });

    // Set user access checkboxes
    if (userData.userAccess) {
        const userAccess = JSON.parse(userData.userAccess);
        userAccess.forEach(access => {
            const checkbox = document.getElementById('update' + access.charAt(0).toUpperCase() + access.slice(
                1));
            if (checkbox) {
                checkbox.checked = true;
            }
        });
    }

    // Update parent checkboxes
    Object.keys(checkboxHierarchy).forEach(updateParentCheckbox);

    // Handle Super Admin
    if (document.getElementById('updateSuperadmin').checked) {
        document.querySelectorAll('#updateUserForm .form-check-input:not(#updateSuperadmin)').forEach(checkbox => {
            checkbox.checked = true;
            checkbox.disabled = true;
        });
    }
}
</script>