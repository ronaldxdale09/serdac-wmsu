<?php
include("../function/db.php");
// Modified getOptions function
function getOptions($con, $table, $valueColumn, $textColumn) {
    $options = "";
    $sql = "SELECT $valueColumn, $textColumn FROM $table ORDER BY $textColumn";
    $result = $con->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $options .= "<option value='" . htmlspecialchars($row[$valueColumn]) . "'>" . htmlspecialchars($row[$textColumn]) . "</option>";
        }
    }
    return $options;
}

// Check if the connection is established
if (!$con) {
    die("Database connection failed. Please check your connection settings.");
}

// Get agency classifications
$agencyClassifications = getOptions($con, "r_agency_classification", "classification", "classification");

// Get client types
$clientTypes = getOptions($con, "r_client_type", "type", "type");

// Get purposes of request
$purposesQuery = "SELECT id, purpose FROM r_purpose_of_request ORDER BY purpose";
$purposes = $con->query($purposesQuery);

if (!$purposes) {
    die("Error executing query: " . $con->error);
}
?>


<div class="form-card">

    <h5 class="sub-heading mb-4"><i class="fas fa-info-circle"></i> Request Information <br>
        <span class="service-type">[ Capability Training ]</span>
    </h5>
    <div id="selected-service-card" class="selected-service text-center"></div>
    <hr>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <label class="form-control-label required">Office/Agency:
                </label>
                <input type="text" id="agency" name="office_agency" placeholder="" class="form-control"
                    onblur="validate2(1)">
            </div>

        </div>
        <div class="col">
            <div class="form-group">
                <label class="form-control-label required" class="form-control-label">Agency
                    Classification:</label>
                <select name="agency_classification" class="form-control">
                    <option value="" selected disabled>Select...
                    </option>
                    <?php echo $agencyClassifications; ?>

                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="form-group">
                <label class="form-control-label required">Type of
                    Client
                    :</label>
                <select name="client_type" class="form-control">
                    <option value="" selected disabled>Select...
                    </option>
                    <?php echo $clientTypes; ?>
                </select>
            </div>
        </div>

    </div>


    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label for="purpose-options" class="required">Purpose of Request</label>
                    <div id="purpose-options" class="row">
                        <?php
                        if ($purposes->num_rows > 0) {
                            while($row = $purposes->fetch_assoc()) {
                                $id = htmlspecialchars($row['id']);
                                $purpose = htmlspecialchars($row['purpose']);
                                echo "
                                <div class='col-sm-6 col-md-4'>
                                    <div class='form-check'>
                                        <input class='form-check-input' type='checkbox' name='purpose_options[]'
                                            id='purpose-{$id}' value='{$purpose}'>
                                        <label class='form-check-label ml-2' for='purpose-{$id}'
                                            style='font-weight: normal;'>{$purpose}</label>
                                    </div>
                                </div>";
                            }
                        }
                        ?>
                        <!-- Add more checkboxes as needed -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="purpose" class="required">Additional
            Details</label>
        <textarea id="purpose" name="additional_purpose_details" rows="4" class="form-control"
            placeholder="Please describe the purpose of your request in detail if needed"></textarea>
    </div>


</div>