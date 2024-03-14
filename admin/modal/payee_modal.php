<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomer" tabindex="-1" role="dialog" aria-labelledby="newCoffeeProductForm" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark border-bottom">
                <h5 class="modal-title" id="newCoffeeProductForm">
                    <i class="fas fa-plus-circle" style="margin-right: 10px;"></i> Add New Payee
                </h5>
                <button type="button" class="btn text-light close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="function/payee_management.php" method="post">
                    <input type="text" id='coffee_id' name="coffee_id" hidden>

                    <div class="form-group">
                        <label class="col-form-label">Supplier:</label>
                        <input type="text" class="form-control rounded" name="supplier">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Address:</label>
                        <input type="text" class="form-control rounded" name="address">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Contact #:</label>
                        <input type="text" class="form-control rounded" name="contact">
                    </div>
                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="incentives">Description/Remarks:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="remarks" placeholder="Description/Remarks">

                            </div>
                        </div>
                        <div class="col">
                            <label for="incentives">Discount:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="discount" value="0">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                <button type="submit" name='add' class="btn btn-warning">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Payee Modal -->
<div class="modal fade" id="editPayee" tabindex="-1" role="dialog" aria-labelledby="editPayeeForm" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark border-bottom">
                <h5 class="modal-title" id="editPayeeForm">
                    <i class="fas fa-edit" style="margin-right: 10px;"></i> Edit Payee
                </h5>
                <button type="button" class="btn text-light close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="function/payee_management.php" method="post">

                    <input type="text"' name="payee_id" id="payee_id"  hidden>

                    <div class="form-group">
                        <label class="col-form-label">Supplier:</label>
                        <input type="text" class="form-control rounded" name="supplier" id="supplier">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Address:</label>
                        <input type="text" class="form-control rounded" name="address" id="address">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Contact #:</label>
                        <input type="text" class="form-control rounded" name="contact" id="contact_no">
                    </div>

                    <br>
                    <div class="row">
                        <div class="col">
                            <label for="incentives">Description/Remarks:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="remarks" placeholder="Description/Remarks">

                            </div>
                        </div>
                        <div class="col">
                            <label for="incentives">Discount:</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="discount" value="0">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                <button type="submit" name=' update' class="btn btn-primary">Update</button>
            </div>
            </form>
        </div>
    </div>
</div>



<!-- Delete Payee Modal -->
<div class="modal fade" id="deletePayee" tabindex="-1" role="dialog" aria-labelledby="deletePayeeForm" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger border-bottom">
                <h5 class="modal-title text-white" id="deletePayeeForm">
                    <i class="fas fa-trash-alt" style="margin-right: 10px;"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn text-light close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this payee? This action cannot be undone.</p>
                <form action="function/payee_management.php" method="post">
                    <input type="text" id='delete_payee_id' name="payee_id" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name='delete' class="btn btn-danger">Delete</button>
            </div>
            </form>
        </div>
    </div>
</div>