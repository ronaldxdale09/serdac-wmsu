<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.form-title {
    text-align: center;
    font-size: 24px;
    /* Choose the size that fits your design */
    margin-bottom: 1rem;
    font-weight: bold;
    /* Optional: if you want the title to be bold */
}


.question-card {
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

.question-header {
    display: flex;
    align-items: center;
}

.question-header .form-control,
.question-header .form-control.question-type {
    margin-right: 0.5rem;
}

.delete-question {
    color: #dc3545;
    cursor: pointer;
    font-size: 1.5rem;
    line-height: 1;
}

.delete-question:hover {
    color: #bd2130;
}

.required-checkbox {
    display: flex;
    align-items: center;
    margin-top: 0.5rem;
}

.required-checkbox .form-check-input {
    margin-top: 0;
    margin-right: 0.25rem;
}

.question-body .answers-container {
    margin-top: 0.5rem;
}

.input-group-text {
    min-width: 38px;
    text-align: center;
}

.input-group .btn-outline-secondary,
.input-group .btn-outline-danger {
    padding: 0.375rem 0.75rem;
}
</style>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <strong class="card-title">List of Articles</strong>
                        </div>
                        <div class="card-body">
                            <div class="container mt-4">
                                <div class="form-builder-container">
                                    <form id="myForm">
                                        <div class="form-section">
                                            <div class="form-group">
                                                <input type="text" name="title" class="form-control form-title"
                                                    placeholder="Enter Title Here">
                                            </div>
                                            <div class="form-group">
                                                <textarea name="description" class="form-control" rows="2"
                                                    placeholder="Enter Description Here"></textarea>
                                            </div>
                                        </div>

                                        <div id="question_list_container" class="form-builder-container">
                                            <!-- Questions will be loaded here -->
                                        </div>


                                    </form>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between"> <button class="btn btn-primary" type="button"
                                    id="add-item">+ Add Item</button>
                                <button class="btn btn-success" type="button" id="saveFormButton">Save
                                    Form</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->

        <script>
        $(document).ready(function() {
            // Fetch and display questions when the page loads
            fetchQuestions();

            // Rest of your existing JavaScript...

            function fetchQuestions() {
                $.ajax({
                    url: 'table/form.build.php', // Path to your PHP script
                    method: 'POST',
                    success: function(data) {
                        $('#question_list_container').html(data);
                        // Re-initialize event listeners or other functionalities if needed
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching questions:', textStatus, errorThrown);
                    }
                });
            }
        });




        $(document).ready(function() {
            $('#saveFormButton').click(function() {
                console.log('test')
                var formData = $('#myForm').serialize(); // Serialize form data
                console.log(formData); // Add this line to inspect the serialized data

                $.ajax({
                    url: 'function/assessment.form.php', // Replace with the path to your PHP script
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Replace 'response' with a condition or data returned from your PHP script
                        if (response === 'success') {
                            Swal.fire(
                                'Saved!',
                                'Your form has been saved.',
                                'success'
                            );
                        } else {
                            // Handle the error message from the PHP script
                            Swal.fire(
                                'Error!',
                                'There was an issue saving your form.',
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Your form could not be saved. Please try again.',
                            'error'
                        );
                    }
                });
            });
        });


        </script>


    </div>

    </div>
    <?php include('include/footer.php');?>


</body>

</html>