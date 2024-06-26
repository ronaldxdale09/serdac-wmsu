<div class="modal fade" id="completeRequestModal" tabindex="-1" aria-labelledby="completeRequestModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="completeRequestModalLabel" style="font-weight: bold;">Complete Service
                    Request</h5>
            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="background-color: #f8f9fc;">
                <form action="function/request.action.php" method="post">
                    <p>Please confirm that you have completed all required tasks for this service. By confirming, you
                        are marking the service as 'Completed'. This action is significant and should be taken with
                        certainty.</p>

                    <div class="form-group">
                        <label for="remarks">Admin Remarks (Optional):</label>
                        <textarea class="form-control" name="remarks" rows="3"
                            placeholder="Enter any final comments or important notes here."></textarea>
                    </div>

                    <!-- Payment Status Dropdown -->
                    <div class="form-group">
                        <label for="payment_status">Payment Status:</label>
                        <select class="form-control" name="payment_status" id="payment_status" readonly>
                            <option value="paid" selected>Paid</option>
                        </select>
                    </div>

                    <!-- Payment Amount Input -->
                    <div class="form-group">
                        <label for="payment_amount">Payment Amount:</label>
                        <input type="number" class="form-control" name="payment_amount" id="payment_amount"
                            placeholder="Enter the payment amount" step="0.01">
                    </div>

                    <!-- Hidden Request ID -->
                    <input type="hidden" name="request_id" id="c_req_id">

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="background-color: #f8f9fc;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" name="complete">Mark as Complete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>