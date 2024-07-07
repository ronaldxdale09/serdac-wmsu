<!-- Add New Speaker Modal -->
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="speakerOccupation" class="form-label required">Occupation:</label>
                            <input type="text" class="form-control" name="occupation" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="speakerSpecialization" class="form-label required">Specialization:</label>
                            <input type="text" class="form-control" name="specialization" required>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="updateSpeakerOccupation" class="form-label required">Occupation:</label>
                            <input type="text" class="form-control" name="occupation" id="updateSpeakerOccupation" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="updateSpeakerSpecialization" class="form-label required">Specialization:</label>
                            <input type="text" class="form-control" name="specialization" id="updateSpeakerSpecialization" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="updateSpeakerForm" class="btn btn-primary" name="update">Update</button>
            </div>
        </div>
    </div>
</div>