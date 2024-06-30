<?php include('include/header.php');

    ?>
<?php
if (isset($_GET["form_id"])) {
    $form_id =  $_GET['form_id'];
    $formQuery = "SELECT * FROM asmt_forms WHERE form_id = $form_id";
    $formResult = mysqli_query($con, $formQuery);

    if ($formResult && mysqli_num_rows($formResult) > 0) {
        $formRecord = mysqli_fetch_assoc($formResult);
        echo "
        <script>
            $(document).ready(function() {
                $('input[name=title]').val('{$formRecord['title']}');
                $('textarea[name=description]').val('{$formRecord['description']}');
                $('select[name=form_type]').val('{$formRecord['form_type']}');
                $('select[name=request_id]').val('{$formRecord['request_id']}');

                $('input[name=start_date]').val('{$formRecord['start_date']}');
                $('input[name=end_date]').val('{$formRecord['end_date']}');
                $('input[name=quota]').val('{$formRecord['quota']}');
                $('input[name=response_limit]').val('{$formRecord['response_limit']}');


                fetchQuestions($form_id);
            });
        </script>
        ";
    }
} else {
    echo "
    <script>
        $(document).ready(function() {
            fetchQuestions(0); // No form_id, load default or empty form
        });
    </script>
    ";
}

// Fetch distinct service types from the service_request table
$query = "SELECT DISTINCT service_type FROM service_request";
$result = mysqli_query($con, $query);

if (!$result) {
    die('Query Failed: ' . mysqli_error($con));
}

$serviceOptions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $serviceOptions[] = $row['service_type'];
}




?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.builder.css">


<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Data table</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Assessment Form</strong>
                        </div>
                        <div class="card-body">
                            <div class="container mt-4">
                                <div class="form-builder-container">
                                    <form id="myForm">
                                        <div class="form-section">
                                            <!-- New Settings Section -->
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-row row">

                                                        <div class="form-group col-md-6">
                                                            <label for="startDate">Start Date</label>
                                                            <input type="date" id="startDate" name="start_date"
                                                                class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="endDate">End Date</label>
                                                            <input type="date" id="endDate" name="end_date"
                                                                class="form-control">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="quota">Quota</label>
                                                            <input type="number" id="quota" name="quota"
                                                                class="form-control" placeholder="Enter Quota">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="responseLimit">Response Limit per User</label>
                                                            <input type="number" id="responseLimit"
                                                                name="response_limit" class="form-control"
                                                                placeholder="Enter Limit" value="1">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- End of New Settings Section -->

                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control form-title"
                                                    placeholder="Enter Title Here">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" class="form-control" rows="2"
                                                    placeholder="Enter Description Here"></textarea>
                                            </div>
                                            <div class="form-row row">
                                                <div class="form-group col-md-6">
                                                    <label for="formType">Form Type</label>
                                                    <select id="formType" name="form_type" class="form-control">
                                                        <option value="" selected >Select Form Type</option>
                                                        <?php
                                                            // Fetch form types from the asmt_form_type table
                                                            $sql = "SELECT * FROM asmt_form_type";
                                                            $result = $con->query($sql);
                                                            
                                                            if ($result->num_rows > 0) {
                                                                while($row = $result->fetch_assoc()) {
                                                                    echo "<option value='".htmlspecialchars($row["form_type"])."'>".htmlspecialchars($row["form_type"])."</option>";
                                                                }
                                                            } else {
                                                                echo "<option value='' disabled>No form types available</option>";
                                                            }
                                                            ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="serviceType">Service Request ID</label>
                                                    <select id="serviceType" name="request_id" class="form-control">
                                                        <option value="" selected disabled>Select Service Type</option>
                                                        <?php
                                                        // Fetch service types from the service_request table
                                                        $sql = "SELECT * FROM service_request";
                                                        $result = $con->query($sql);

                                                        if ($result->num_rows > 0) {
                                                            while($row = $result->fetch_assoc()) {
                                                                echo "<option value='".$row["request_id"]."'>Req ID:".$row["request_id"]." - ".$row["service_type"]."</option>";
                                                            }
                                                        } else {
                                                            echo "<option value='' disabled>No services available</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="question_list_container" class="form-builder-container">
                                            <!-- Questions will be loaded here -->
                                        </div>
                                        <input type="hidden" name="form_id"
                                            value="<?php echo isset($form_id) ? $form_id : 0; ?>">
                                        <input type="hidden" name="is_update" id="is_update" value="0">
                                    </form>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button class="btn btn-primary" type="button" id="add-item">+ Add Item</button>
                                <button class="btn btn-success" type="button" id="saveFormButton">Save Form</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal for update or save as new -->
    <div class="modal fade" id="saveModal" tabindex="-1" role="dialog" aria-labelledby="saveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="saveModalLabel">Save Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Do you want to update this form or save it as a new form?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateFormButton">Update Form</button>
                    <button type="button" class="btn btn-success" id="saveAsNewFormButton">Save as New Form</button>
                </div>
            </div>
        </div>
    </div>



    <?php include('include/footer.php');?>

    <script>
    $(document).ready(function() {
        function fetchQuestions(form_id) {
            $.ajax({
                url: 'table/form.build.php',
                method: 'POST',
                data: {
                    form_id: form_id
                },
                success: function(data) {
                    $('#question_list_container').html(data);
                    // Re-initialize event listeners or other functionalities if needed
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching questions:', textStatus, errorThrown);
                }
            });
        }

        var formId = <?php echo isset($form_id) ? $form_id : 'null'; ?>;

        fetchQuestions(formId || 0);


    });
    </script>




</body>

</html>