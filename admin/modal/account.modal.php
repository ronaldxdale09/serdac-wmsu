<!-- The Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Add New User</h5>
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
                            <label for="userName" class="form-label required">Mid Name:</label>
                            <input type="text" class="form-control" name="midname" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="userName" class="form-label required">Last Name:</label>
                            <input type="text" class="form-control" name="lname" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userContact" class="form-label required">Email :</label>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="userAccess" class="form-label">User Access:</label>
                            <select multiple class="form-control" id="userAccess" name="userAccess[]">
                                <option value="superuser">Super Access</option>
                                <option value="dashboard">Dashboard</option>
                                <!-- More options here -->
                            </select>
                            <small class="form-text text-muted">Hold down the Ctrl (windows) or Command (Mac) button to
                                select multiple options.</small>
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

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirm User Deletion</h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="text-danger"><strong>Warning:</strong> This action cannot be undone. Are you sure you want to permanently delete this user?</p>
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
