<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">



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
                            <strong class="card-title">Assessment Form</strong>
                        </div>
                        <div class="card-body">
                            <div class="container mt-4">
                                <div class="form-builder-container">
                                    <?php
                            // Assuming you have a database connection established
                            // $con = new mysqli('hostname', 'username', 'password', 'database');

                            $form_id = 47; // Replace this with the desired form_id

                            // Fetch form details
                            $formQuery = "SELECT title, description FROM asmt_forms WHERE form_id = $form_id";
                            $formResult = mysqli_query($con, $formQuery);
                            if ($formRow = mysqli_fetch_assoc($formResult)) {
                                echo "<div class='form-title'>" . htmlspecialchars($formRow['title']) . "</div>";
                                echo "<p class='form-description'>" . htmlspecialchars($formRow['description']) . "</p>";
                            }

                            // Fetch questions for the form
                            $questionsQuery = "SELECT question_id, question_text, question_type, options FROM asmt_questions WHERE form_id = $form_id";
                            $questionsResult = mysqli_query($con, $questionsQuery);

                            echo '<form id="respondentForm" method="post" action="submit_answers.php">';
                            while ($question = mysqli_fetch_assoc($questionsResult)) {
                                echo '<div class="question-card">';
                                echo '<div class="question-header">';
                                echo '<label class="form-control">' . htmlspecialchars($question['question_text']) . '</label>';
                                echo '</div>'; // Close question-header

                                echo '<div class="question-body">';
                                switch ($question['question_type']) {
                                    case 'paragraph':
                                        echo '<textarea name="answers[' . $question['question_id'] . ']" class="form-control" rows="4"></textarea>';
                                        break;
                                    case 'multiple_choice_single':
                                        $options = explode(',', $question['options']);
                                        foreach ($options as $option) {
                                            echo '<div class="form-check">';
                                            echo '<input type="radio" name="answers[' . $question['question_id'] . ']" value="' . htmlspecialchars($option) . '" class="form-check-input">';
                                            echo '<label class="form-check-label">' . htmlspecialchars($option) . '</label>';
                                            echo '</div>';
                                        }
                                        break;
                                    case 'multiple_choice_multiple':
                                        $options = explode(',', $question['options']);
                                        foreach ($options as $option) {
                                            echo '<div class="form-check">';
                                            echo '<input type="checkbox" name="answers[' . $question['question_id'] . '][]" value="' . htmlspecialchars($option) . '" class="form-check-input">';
                                            echo '<label class="form-check-label">' . htmlspecialchars($option) . '</label>';
                                            echo '</div>';
                                        }
                                        break;
                                }
                                echo '</div>'; // Close question-body
                                echo '</div>'; // Close question-card
                            }
                            echo '<div class="submit-button"><button type="submit" class="btn btn-primary">Submit Answers</button></div>';
                            echo '</form>';

                            // Close the database connection
                            // mysqli_close($con);
                            ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    </div><!-- .animated -->
    <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>


</body>

<script>
$(document).ready(function() {
    $('#respondentForm').on('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting the traditional way

        var formData = $(this).serialize(); // Serialize the form data

        $.ajax({
            url: 'function/assessment.response.php', // PHP script to handle form submission
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire(
                        'Submitted!',
                        response.message,
                        'success'
                    );
                } else {
                    Swal.fire(
                        'Error!',
                        response.message,
                        'error'
                    );
                }
            },
            error: function() {
                Swal.fire(
                    'Error!',
                    'There was a problem submitting your answers. Please try again.',
                    'error'
                );
            }
        });
    });
});
</script>

</html>