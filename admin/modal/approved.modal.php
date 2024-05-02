<!-- Mark as Complete Modal -->
<div class="modal fade" id="serviceProceedModal" tabindex="-1" aria-labelledby="serviceProceedModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Larger modal -->
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="transitionOngoingModalLabel" style="font-weight: bold;">Initiate 'In
                    Progress' Phase for Service Request</h5>

            </div>

            <!-- Modal Body -->
            <div class="modal-body" style="background-color: #f8f9fc;">
                <form action="function/request.action.php" method="post">

                    <p>Please review the information carefully. By confirming, you are agreeing to proceed with the
                        request, transitioning this service to 'In Process' status. This action initiates the service
                        and may not be easily reversible.</p>


                    <div class="form-group">
                        <label for="remarks">Admin Remarks (Optional):</label>
                        <textarea class="form-control"  name="remarks" rows="3"
                            placeholder="Enter any additional comments or information here."></textarea>
                    </div>
                    <!-- Hidden Request ID -->
                    <input type="hidden" name="request_id" id="d_req_id">

                    <!-- Modal Footer -->
                    <div class="modal-footer" style="background-color: #f8f9fc;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="progress">Proceed</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>