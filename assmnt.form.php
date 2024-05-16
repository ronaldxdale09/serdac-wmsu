<?php 
include('include/header.php');

if (isset($_GET["form_id"])) {
    $form_id = $_GET['form_id'];
    $form_id = preg_replace('~\D~', '', $form_id);
}

// Retrieve user details from session
$user_name = isset($_SESSION["fname"]) ? $_SESSION["fname"] : "Guest";
$user_email = isset($_SESSION["email"]) ? $_SESSION["email"] : "Not logged in";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/assmt.form.view.css">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        background-image: url('assets/images/form_bg.jpg');
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    </style>
</head>

<body>
    <br>

    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Assessment Form</strong>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <p><strong>User:</strong> <?php echo htmlspecialchars($user_name); ?> |
                                        <strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="container mt-4">
                                <div class="form-builder-container">
                                    <?php
                                    // Assuming you have a database connection established
                                    // $con = new mysqli('hostname', 'username', 'password', 'database');

                                    // Replace this with the desired form_id
                                    $form_id = 99; 

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
    </section>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/custom.js"></script>

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
                    $('.form-builder-container').html(`
                                <div class="text-center">
                                    <i class="fa fa-check-circle" style="font-size: 4em; color: green;"></i>
                                    <h2>Thank You for Your Response</h2>
                                    <p>Your feedback is highly appreciated and will help us to improve our services.</p>
                                    <a href="index.php" class="btn btn-dark mt-3">Return to Homepage</a>
                                </div>
                            `);
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