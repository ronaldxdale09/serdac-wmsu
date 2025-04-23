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
    <title>SERDAC-WMSU - Assessment Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/assmt.form.view.css">
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        background: linear-gradient(135deg, rgba(128, 0, 0, 0.05) 0%, rgba(128, 0, 0, 0.1) 100%);
        background-size: cover;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        padding: 40px 15px;
    }

    @media (max-width: 768px) {
        .container {
            padding: 20px 15px;
        }
    }
    </style>
</head>

<body>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas <?php echo $is_quiz ? 'fa-clipboard-question' : 'fa-clipboard-list'; ?> me-2"></i>
                                <?php echo htmlspecialchars($is_quiz ? 'Quiz Assessment' : 'Feedback Form'); ?>
                            </h2>
                        </div>
                        <div class="card-body">
                            <div class="user-info">
                                <div class="row align-items-center">
                                    <div class="col-md-12 text-right">
                                        <p>
                                            <i class="fas fa-user me-2"></i>
                                            <strong>User:</strong> <?php echo htmlspecialchars($user_name); ?> |
                                            <i class="fas fa-envelope me-2"></i>
                                            <strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-builder-container">
                                <?php if ($userHasSubmitted) { ?>
                                <div class="text-center">
                                    <i class="fas fa-check-circle fa-4x"></i>
                                    <h2>Thank You for Your Response</h2>
                                    <p>Your feedback is highly appreciated and will help us improve our services.</p>
                                    <a href="index.php" class="btn btn-dark mt-3">
                                        <i class="fas fa-home me-2"></i>Return to Homepage
                                    </a>
                                </div>
                                <?php } else { ?>
                                <div class='form-title'><?php echo htmlspecialchars($form_title); ?></div>
                                <p class='form-description'><?php echo htmlspecialchars($form_description); ?></p>

                                <form id="respondentForm" method="post">
                                    <input type="hidden" name="form_id" value="<?php echo htmlspecialchars($form_id); ?>">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">

                                    <?php
                                    $stmt = $con->prepare("SELECT question_id, question_text, question_type, options, is_required FROM asmt_questions WHERE form_id = ?");
                                    $stmt->bind_param("i", $form_id);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    $questionNumber = 1;

                                    while ($question = $result->fetch_assoc()) {
                                        echo '<div class="question-card">';
                                        echo '<div class="question-header">';
                                        echo '<label class="form-control-label">';
                                        echo '<span class="question-number">' . $questionNumber . '. </span>';
                                        echo htmlspecialchars($question['question_text']);
                                        if ($question['is_required']) {
                                            echo ' <span class="text-danger">*</span>';
                                        }
                                        echo '</label>';
                                        echo '</div>';

                                        echo '<div class="question-body">';
                                        switch ($question['question_type']) {
                                            case 'paragraph':
                                                echo '<div class="form-group">';
                                                echo '<textarea name="answers[' . $question['question_id'] . ']" class="form-control" rows="4" placeholder="Enter your answer here..."' . ($question['is_required'] ? ' required' : '') . '></textarea>';
                                                echo '</div>';
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
                                        $questionNumber++;
                                    }
                                    $stmt->close();
                                    ?>
                                    <div class="submit-button">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-2"></i>Submit Answers
                                        </button>
                                    </div>
                                </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="assets/js/custom.js"></script>

    <script>
    $(document).ready(function() {
        // Add loading state to form submission
        $('#respondentForm').on('submit', function(event) {
            event.preventDefault();
            const submitButton = $(this).find('button[type="submit"]');
            const originalText = submitButton.html();
            
            // Change button state
            submitButton.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin me-2"></i>Submitting...');

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
                                <i class="fas fa-check-circle fa-4x"></i>
                                <h2>Thank You for Your Response</h2>
                                <p>Your feedback is highly appreciated and will help us improve our services.</p>
                                <a href="index.php" class="btn btn-dark mt-3">
                                    <i class="fas fa-home me-2"></i>Return to Homepage
                                </a>
                            </div>
                        `);
                        Swal.fire({
                            icon: 'success',
                            title: 'Submitted Successfully!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: response.message
                        });
                        submitButton.prop('disabled', false).html(originalText);
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'There was a problem submitting your answers. Please try again.'
                    });
                    submitButton.prop('disabled', false).html(originalText);
                }
            });
        });

        // Add smooth scroll animation to questions
        $('.question-card').each(function(index) {
            $(this).css('opacity', '0');
            $(this).css('transform', 'translateY(20px)');
            setTimeout(() => {
                $(this).css('transition', 'all 0.5s ease');
                $(this).css('opacity', '1');
                $(this).css('transform', 'translateY(0)');
            }, index * 100);
        });
    });
    </script>
</body>

</html>