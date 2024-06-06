<div class="modal fade" id="createSpeakerModal" tabindex="-1" aria-labelledby="createSpeakerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createSpeakerModalLabel">Add New Speaker</h5>
            </div>

            <div class="modal-body">
                <form id="newSpeakerForm" action="function/speaker_action.php" method="POST" class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="speakerName" class="form-label required">Name:</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="speakerAddress" class="form-label required">Address:</label>
                            <textarea class="form-control" name="address" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="speakerEmail" class="form-label required">Email:</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="speakerContact" class="form-label required">Contact #:</label>
                            <input type="text" class="form-control" name="contact" required>
                        </div>
                    </div>

                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="newSpeakerForm" class="btn btn-primary" name="new">Confirm</button>
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
                <p class="text-danger"><strong>Warning:</strong> This action cannot be undone. Are you sure you want to
                    permanently delete this user?</p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <form action="function/user.mngmnt.php" method="POST">
                    <input type="hidden" name="user_id" id="deleteUserId">

                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger" name="delete">Delete </button>
                </form>
            </div>

        </div>
    </div>
</div>



<!-- Update Speaker Modal -->
<div class="modal fade" id="updateSpeakerModal" tabindex="-1" aria-labelledby="updateSpeakerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="updateSpeakerModalLabel">Update Speaker</h5>
            </div>

            <div class="modal-body">
                <form id="updateSpeakerForm" action="function/speaker_action.php" method="POST" class="row g-3">
                    <input type="hidden" name="speaker_id" id="updateSpeakerId">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateSpeakerName" class="form-label required">Name:</label>
                            <input type="text" class="form-control" name="name" id="updateSpeakerName" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="updateSpeakerAddress" class="form-label required">Address:</label>
                            <textarea class="form-control" name="address" id="updateSpeakerAddress" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateSpeakerEmail" class="form-label required">Email:</label>
                            <input type="email" class="form-control" name="email" id="updateSpeakerEmail" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateSpeakerContact" class="form-label required">Contact #:</label>
                            <input type="text" class="form-control" name="contact" id="updateSpeakerContact" required>
                        </div>
                    </div>
                    <hr>
                    <div class="container">

                        <div id="speaker_list_talk"></div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>