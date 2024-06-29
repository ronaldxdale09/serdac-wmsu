<!DOCTYPE html>
<html>
<?php



// Existing code
include('function/db.php');

?>


<head>
    <title>SERDAC-WMSU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

<body>
    <div class="wrapper">
        <div class="logos-container">
            <img src="assets/images/serdac.png" alt="School Logo 1" class="school-logo" />
            <img src="assets/images/wmsu.png" alt="School Logo 2" class="school-logo" />
        </div>
        <div class="headline">
            <h1>RESET PASSWORD</h1>
        </div>
        <form class="form" method="post" action="#" id="resetPasswordForm">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <button type="submit" class="btn">Send Reset Link</button>
            <div class="account-exist">
                Remembered your password? <a href="login.php" id="login">Login</a>
                <button onclick="location.href='index.php';" class="btn-dashboard">Return to Homepage</button>
            </div>
        </form>
    </div>
    <script>
    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        var email = $('#resetPasswordForm input[name="email"]').val();

        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we send the reset link.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: 'function/send_reset_pass_link.php',
            data: {
                email: email
            },
            success: function(response) {
                Swal.close();
                response = JSON.parse(response);
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Password reset link has been sent to your email.'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error sending the reset link.'
                });
            }
        });
    });
    </script>

</body>

</html>