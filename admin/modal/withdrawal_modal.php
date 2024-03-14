
<!-- Modal for Bank Deposits Logs -->
<div class="modal fade" id="withdrawalModal" tabindex="-1" role="dialog" aria-labelledby="bankDepositLogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal size for better layout -->
    <div class="modal-content shadow-lg rounded"> <!-- Added shadow and rounded for a soft appearance -->
      <div class="modal-header bg-dark text-white"> <!-- Changed header color for emphasis -->
        <h5 class="modal-title" id="bankDepositLogModalLabel">Account Withdrawal</h5>
        <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="function/bank_withdraw.php" method="POST">
          <div class="row"> <!-- Bootstrap grid system -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="bankName">Bank Name</label>
                <select class="form-control select-payee" name="account" required>
                  <option value="" selected disabled hidden>Select Account</option>
                  <?php
                  // Retrieve customer names from the coffee_customer table
                  $sql = "SELECT bank_id,bank_name FROM bank_details";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $bank_id = $row['bank_id'];
                      $bank_name = $row['bank_name'];

                      echo "<option value='$bank_id'>$bank_name</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="depositDate">Withdrawal Date</label>
                <input type="date" class="form-control" name="withdrawDate" required>
              </div>
              <div class="form-group">
                <label for="amount">Amount</label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input type="text" class="form-control" name="amount" onkeypress="return CheckNumeric()" onkeyup="FormatCurrency(this)">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="depositedBy">Withdrawn By</label>
                <input type="text" class="form-control" name="withdrawnBy" required>
              </div>
              <div class="form-group">
                <label for="referenceNumber">Reference Number</label>
                <input type="text" class="form-control" name="referenceNumber">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" name="remarks" rows="3"></textarea>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add" class="btn btn-primary">Save</button>
      </div>
      </form>
    </div>
  </div>
</div>



