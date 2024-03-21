
<!-- Modal for Bank Deposits Logs -->
<div class="modal fade" id="bankDeposit" tabindex="-1" role="dialog" aria-labelledby="bankDepositLogModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document"> <!-- Increased modal size for better layout -->
    <div class="modal-content shadow-lg rounded"> <!-- Added shadow and rounded for a soft appearance -->
      <div class="modal-header bg-dark text-white"> <!-- Changed header color for emphasis -->
        <h5 class="modal-title" id="bankDepositLogModalLabel">Bank Deposit Log</h5>
        <button type="button" class="btn text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="function/bank_depo.php" method="POST">
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
                <label for="depositDate">Deposit Date</label>
                <input type="date" class="form-control" name="depositDate" required>
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
                <label for="depositedBy">Deposited By</label>
                <input type="text" class="form-control" name="depositedBy" required>
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




<!-- Add Account Modal -->
<div class="modal fade" id="viewAccountLog" tabindex="-1" role="dialog" aria-labelledby="addAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="addAccountModalLabel">Account Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body">

          <div class="row mb-3">
            <!-- Bank Name -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="bank_name">Bank Name</label>
                <input type="text" class="form-control" id="v_bank_name" readonly>
              </div>
            </div>

            <!-- Branch Address -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="branch_address">Branch Address</label>
                <input type="text" class="form-control" id="v_branch_address" readonly>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <!-- Account Name -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="account_name">Account Name</label>
                <input type="text" class="form-control" id="v_account_name" readonly>
              </div>
            </div>

            <!-- Account Number -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" class="form-control" id="v_account_number" readonly>
              </div>
            </div>
          </div>

          <div class="row">
            <!-- Balance -->
            <div class="col-md-6">
              <div class="form-group">
                <label for="balance">Initial Balance</label>
                <div class="input-group">
                  <span class="input-group-text">₱</span>
                  <input type="text" class="form-control" id="v_balance" readonly>
                </div>
              </div>
            </div>
          </div>

          <div id="account_logs_details"> </div>

      </div>
      <!-- Modal Footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>