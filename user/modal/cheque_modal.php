<!-- Modal -->
<div class="modal fade" id="newCheque" tabindex="-1" role="dialog" aria-labelledby="chequeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="custom-modal-header modal-header">
                <h5 class="modal-title" id="chequeModalLabel">Issue Cheque</h5>
                <button type="button" class="btn text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="function/cheque_functions.php" method="post">
                    <div class="row">
                        <div class="col">
                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoiceDate">Date of Issued:</label>
                                <input type="date" class="form-control" name="dateIssued" required>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoiceDate">Date of Check:</label>
                                <input type="date" class="form-control" name="dateCheck" required>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Receipt # -->
                            <div class="form-group">
                                <label for="receiptNum">PR/OR :</label>
                                <input type="text" class="form-control" name="pr_or" placeholder="PR/OR" required>
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="payeeName">Payee's Name:</label>
                                <select class="form-control select-payee" name="payee_name" required>
                                    <option value="" selected disabled hidden>Select Payee</option>
                                    <?php
                  // Retrieve customer names from the coffee_customer table
                  $sql = "SELECT supplier,payee_id,discount FROM payees_tbl";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $payee_id = $row['payee_id'];
                      $name = $row['name'];
                      $supplier = $row['supplier'];

                      echo "<option value='$payee_id' data-discount='{$row['discount']}'>$supplier</option>";
                    }
                  }
                  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="prOr">Check # :</label>
                                <input type="text" class="form-control" name="check_no" placeholder="Check No."
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Payee's Name -->
                    <br>
                    <div class="row">
                        <div class="col-7">
                            <label for="totalAmount">Total Amount:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="totalAmount" name="totalAmount" required>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="payeeName">Account :</label>
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
                        </div>


                    </div>

                    <h6 class="mt-4 mb-3">Deductions & Adjustments</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">

                                    <label for="incentives">Incentives:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="incentives" name="incentives"
                                            value="0">
                                        <span class="input-group-text">%</span>

                                    </div>
                                </div>
                                <div class="col">

                                    <label for="incentives">Discount :</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="incentives_total"
                                            name="incentives_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="freight">Freight:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id='freight' name="freight" value="0">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="badOrder">Less: Bad Order:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="badOrder" name="badOrder" value="0">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-7">
                            <label for="totalAmount">Net Amount:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" name="net_amount" id="net_amount" readonly>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="custom-modal-footer modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name='add' class="btn btn-primary">Issue Cheque</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.select-payee').on('change', function() {
        var selectedDiscount = $('option:selected', this).data('discount');

        // Check if discount is undefined or not present
        if (typeof selectedDiscount === "undefined" || !selectedDiscount) {
            selectedDiscount = 0;
        }

        $('#incentives').val(selectedDiscount);
    });
});
</script>





<div class="modal fade" id="updateCheque" tabindex="-1" role="dialog" aria-labelledby="chequeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="custom-modal-header modal-header">
                <h5 class="modal-title" id="chequeModalLabel">Issue Cheque</h5>
                <button type="button" class="btn text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="myForm" action="function/cheque_functions.php" method="post">
                    <input type="text" hidden class="form-control" id="trans_id" name="trans_id" placeholder="PR/OR ">

                    <div class="row">
                        <div class="col">
                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoiceDate">Date of Issued:</label>
                                <input type="date" class="form-control" name="dateIssued" id='dateIssued'>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Invoice Date -->
                            <div class="form-group">
                                <label for="invoiceDate">Date of Check:</label>
                                <input type="date" class="form-control" name="dateCheck" id='dateCheck'>
                            </div>
                        </div>
                        <div class="col">
                            <!-- Receipt # -->
                            <div class="form-group">
                                <label for="receiptNum">PR/OR :</label>
                                <input type="text" class="form-control" id="pr_or" name="pr_or" placeholder="PR/OR ">
                            </div>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-7">
                            <div class="form-group">
                                <label for="payeeName">Payee's Name:</label>
                                <select class="form-control select-payee" name="payee_name" id="payee_name" required>
                                    <option value="" selected disabled hidden>Select Payee</option>
                                    <?php
                  // Retrieve customer names from the coffee_customer table
                  $sql = "SELECT supplier,payee_id FROM payees_tbl";
                  $result = mysqli_query($con, $sql);
                  if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $payee_id = $row['payee_id'];
                      $name = $row['name'];
                      $supplier = $row['supplier'];

                      echo "<option value='$payee_id'>$supplier</option>";
                    }
                  }
                  ?>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="prOr">Check # :</label>
                                <input type="text" class="form-control" id="check_no" name="check_no"
                                    placeholder="Check No.">
                            </div>
                        </div>
                    </div>

                    <!-- Payee's Name -->
                    <br>
                    <div class="row">
                        <div class="col-7">
                            <label for="totalAmount">Total Amount:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" id="u_totalAmount" name="totalAmount">
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="payeeName">Account :</label>
                                <select class="form-control select-payee" name="account" id="account" required>
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
                        </div>


                    </div>

                    <h6 class="mt-4 mb-3">Deductions & Adjustments</h6>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">

                                    <label for="incentives">Incentives:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="u_incentives" name="incentives">
                                        <span class="input-group-text">%</span>

                                    </div>
                                </div>
                                <div class="col">

                                    <label for="incentives">Incentives Amount:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="u_incentives_total"
                                            name="incentives_total" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="freight">Freight:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id='u_freight' name="freight">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="badOrder">Less: Bad Order:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="text" class="form-control" id="u_badOrder" name="badOrder">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-7">
                            <label for="totalAmount">Net Amount:</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="text" class="form-control" name="net_amount" id="u_net_amount" readonly>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="action_type" id="action_type">
            </div>
            <div class="custom-modal-footer modal-footer">
                <button type="submit" name='update' id="updateButton" class="btn btn-primary"><i
                        class="fas fa-edit"></i> Update</button>
                <button type="submit" name='clear' id="clearedButton" class="btn btn-success"><i
                        class="fas fa-check"></i> Cleared</button>
                <button type="submit" name='void' id="cancelButton" class="btn btn-danger"><i class="fas fa-times"></i>
                    Cancel</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    function computeNetAmount(prefix = '') {
        let totalAmount = parseFloat(document.getElementById(prefix + 'totalAmount').value.replace(/,/g, '')) ||
            0;
        let incentives = parseFloat(document.getElementById(prefix + 'incentives').value.replace(/,/g, '')) ||
            0;
        let incentivesAmount = (incentives / 100) * totalAmount;
        let freight = parseFloat(document.getElementById(prefix + 'freight').value.replace(/,/g, '')) || 0;
        let badOrder = parseFloat(document.getElementById(prefix + 'badOrder').value.replace(/,/g, '')) || 0;

        let netAmount = totalAmount - incentivesAmount - freight - badOrder;

        document.getElementById(prefix + 'incentives_total').value = incentivesAmount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });

        document.getElementById(prefix + 'net_amount').value = netAmount.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function setupEventListeners(prefix = '') {
        const inputs = [
            document.getElementById(prefix + 'totalAmount'),
            document.getElementById(prefix + 'incentives'),
            document.getElementById(prefix + 'freight'),
            document.getElementById(prefix + 'badOrder')
        ];

        inputs.forEach(input => {
            input.addEventListener('input', () => computeNetAmount(prefix));
            input.setAttribute("onkeypress", "return CheckNumeric()");
            input.setAttribute("onkeyup", "FormatCurrency(this)");
        });
    }

    // Setup listeners for newCheque
    setupEventListeners();

    // Setup listeners for updateCheque
    setupEventListeners('u_');
});
</script>

<script>
document.getElementById('myForm').addEventListener('submit', function() {
    var buttons = this.querySelectorAll('button[type="submit"]');
    buttons.forEach(function(button) {
        button.disabled = true;
    });
});

document.addEventListener('DOMContentLoaded', function() {
        var confirmButton = document.querySelector('.confirmClear');
        confirmButton.addEventListener('click', function() {
            this.disabled = true;
            // Optionally, you can add some visual feedback like changing the button text
            this.innerHTML = 'Processing...';
        });
    });
    
</script>




<div class="modal fade" id="updateConfirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to update this cheque?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name='update' class="btn btn-primary confirmUpdate">Confirm Update</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="clearedConfirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to mark this cheque as cleared?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name='clear' class="btn btn-success confirmClear">Confirm Cleared</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="voidConfirmationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to cancel this cheque?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" name='void' class="btn btn-danger confirmVoid">Confirm</button>
            </div>
        </div>
    </div>
</div>