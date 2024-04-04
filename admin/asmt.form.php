<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
.form-title {
    text-align: center;
    font-size: 28px; /* Increased font size */
    margin-bottom: 1.5rem;
    font-weight: bold;
}

.form-description { /* New class for description */
    text-align: center;
    font-size: 18px; /* Font size for description */
    margin-bottom: 1rem;
}

.question-card {
    background: #fff;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    padding: 1.5rem; /* Increased padding */
    margin-bottom: 1.5rem;
    font-size: 18px; /* Increased font size */
}

.question-header {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem; /* Space between header and body */
}

.question-header .form-control,
.question-header .form-control.question-type {
    margin-right: 0.5rem;
    font-size: 16px; /* Increased font size */
}

.delete-question {
    color: #dc3545;
    cursor: pointer;
    font-size: 1.8rem; /* Increased icon size */
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
.card{
    background-color: #d7e4fa;
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
                                    <?php
                                        // Assuming you have a database connection established
                                        // $con = new mysqli('hostname', 'username', 'password', 'database');

                                        $form_id = 31; // Replace this with the desired form_id

                                        // Fetch form details
                                        $formQuery = "SELECT title, description FROM asmt_forms WHERE form_id = $form_id";
                                        $formResult = mysqli_query($con, $formQuery);
                                        if ($formRow = mysqli_fetch_assoc($formResult)) {
                                            echo "<div class='form-title'>" . htmlspecialchars($formRow['title']) . "</div>";
                                            echo "<p class='text-center'>" . htmlspecialchars($formRow['description']) . "</p>";
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

                                            switch ($question['question_type']) {
                                                case 'paragraph':
                                                    echo '<div class="question-body"><textarea name="answers[' . $question['question_id'] . ']" class="form-control"></textarea></div>';
                                                    break;
                                                case 'multiple_choice_single':
                                                    $options = explode(',', $question['options']);
                                                    echo '<div class="question-body">';
                                                    foreach ($options as $option) {
                                                        echo '<div class="form-check">';
                                                        echo '<input type="radio" name="answers[' . $question['question_id'] . ']" value="' . htmlspecialchars($option) . '" class="form-check-input">';
                                                        echo '<label class="form-check-label">' . htmlspecialchars($option) . '</label>';
                                                        echo '</div>';
                                                    }
                                                    echo '</div>'; // Close question-body
                                                    break;
                                                case 'multiple_choice_multiple':
                                                    $options = explode(',', $question['options']);
                                                    echo '<div class="question-body">';
                                                    foreach ($options as $option) {
                                                        echo '<div class="form-check">';
                                                        echo '<input type="checkbox" name="answers[' . $question['question_id'] . '][]" value="' . htmlspecialchars($option) . '" class="form-check-input">';
                                                        echo '<label class="form-check-label">' . htmlspecialchars($option) . '</label>';
                                                        echo '</div>';
                                                    }
                                                    echo '</div>'; // Close question-body
                                                    break;
                                            }
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

</html>