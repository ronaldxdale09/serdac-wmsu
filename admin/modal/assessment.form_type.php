<div class="modal fade" id="formTypeModal" tabindex="-1" role="dialog" aria-labelledby="formTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTypeModalLabel">Manage Form Types</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <button class="btn btn-success mb-3" id="addFormTypeBtn">Add Form Type</button>
                <form id="formTypeForm" style="display: none;">
                    <input type="hidden" id="formTypeId" name="formTypeId">
                    <div class="form-group">
                        <label for="formType">Form Type</label>
                        <input type="text" class="form-control" id="formType" name="formType" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="saveFormType">Save</button>
                    <button type="button" class="btn btn-secondary" id="cancelFormType">Cancel</button>
                </form>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Form Type</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="formTypeTableBody"></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>