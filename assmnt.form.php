<?php
include('include/header.php');

// Redirect to login if user is not logged in
if (!isset($_SESSION["userId_code"])) {
    $_SESSION['redirect_after_login'] = "assmnt.form.php?form_id=" . $_GET['form_id'];
    header("Location: login.php");
    exit;
}

// Sanitize and validate form_id
$form_id = isset($_GET['form_id']) ? filter_var($_GET['form_id'], FILTER_SANITIZE_NUMBER_INT) : 0;
if (!$form_id) {
    die("Invalid form ID");
}

// Retrieve user details from session
$user_id = $_SESSION["userId_code"];
$user_name = $_SESSION["fname"] ?? "Guest";
$user_email = $_SESSION["email"] ?? "Not logged in";

// Check if the user has already submitted the form
$stmt = $con->prepare("SELECT COUNT(*) FROM asmt_responses WHERE form_id = ? AND user_id = ?");
$stmt->bind_param("ii", $form_id, $user_id);
$stmt->execute();
$stmt->bind_result($submission_count);
$stmt->fetch();
$stmt->close();

$userHasSubmitted = ($submission_count > 0);

// Fetch form details
$stmt = $con->prepare("SELECT title, description, is_quiz FROM asmt_forms WHERE form_id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$stmt->bind_result($form_title, $form_description, $is_quiz);
$stmt->fetch();
$stmt->close();

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
                            <strong
                                class="card-title"><?php echo htmlspecialchars($is_quiz ? 'Quiz' : 'Assessment Form'); ?></strong>
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
                                    <?php if ($userHasSubmitted) { ?>
                                    <div class="text-center">
                                        <i class="fa fa-check-circle" style="font-size: 4em; color: green;"></i>
                                        <h2>Thank You for Your Response</h2>
                                        <p>Your feedback is highly appreciated and will help us to improve our services.
                                        </p>
                                        <a href="index.php" class="btn btn-dark mt-3">Return to Homepage</a>
                                    </div>
                                    <?php } else { ?>
                                    <div class='form-title'><?php echo htmlspecialchars($form_title); ?></div>
                                    <p class='form-description'><?php echo htmlspecialchars($form_description); ?></p>

                                    <form id="respondentForm" method="post">
                                        <input type="hidden" name="form_id"
                                            value="<?php echo htmlspecialchars($form_id); ?>">
                                        <input type="hidden" name="user_id"
                                            value="<?php echo htmlspecialchars($user_id); ?>">

                                        <?php
                                        // Fetch questions for the form
                                        $stmt = $con->prepare("SELECT question_id, question_text, question_type, options, is_required FROM asmt_questions WHERE form_id = ?");
                                        $stmt->bind_param("i", $form_id);
                                        $stmt->execute();
                                        $result = $stmt->get_result();

                                        while ($question = $result->fetch_assoc()) {
                                            echo '<div class="question-card">';
                                            echo '<div class="question-header">';
                                            echo '<label class="form-control">' . htmlspecialchars($question['question_text']) . ($question['is_required'] ? ' <span class="text-danger">*</span>' : '') . '</label>';
                                            echo '</div>';

                                            echo '<div class="question-body">';
                                            switch ($question['question_type']) {
                                                case 'paragraph':
                                                    echo '<textarea name="answers[' . $question['question_id'] . ']" class="form-control" rows="4"' . ($question['is_required'] ? ' required' : '') . '></textarea>';
                                                    break;
                                                case 'multiple_choice_single':
                                                    $options = explode(',', $question['options']);
                                                    foreach ($options as $option) {
                                                        echo '<div class="form-check">';
                                                        echo '<input type="radio" name="answers[' . $question['question_id'] . ']" value="' . htmlspecialchars($option) . '" class="form-check-input"' . ($question['is_required'] ? ' required' : '') . '>';
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
                                            echo '</div>';
                                            echo '</div>';
                                        }
                                        $stmt->close();
                                        ?>
                                        <div class="submit-button"><button type="submit" class="btn btn-primary">Submit
                                                Answers</button></div>
                                    </form>
                                    <?php } ?>
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

    <script>
    $(document).ready(function() {
        $('#respondentForm').on('submit', function(event) {
            event.preventDefault();

            var formData = $(this).serialize();

            $.ajax({
                url: 'function/assessment.response.php',
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
</body>

</html>