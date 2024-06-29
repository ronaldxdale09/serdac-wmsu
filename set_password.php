<!DOCTYPE html>
<html>
<?php



// Existing code
include('function/db.php');

if (!isset($_GET["token"]) || empty($_GET["token"])) {
    header("Location: index.php");
    exit();
}

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
            <h1>SET NEW PASSWORD</h1>
        </div>
        <form class="form" method="post" action="#" id="resetPasswordForm">
            <div class="form-group">
                <input type="password" name="password" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <button type="submit" class="btn">Reset Password</button>
            <div class="account-exist">
                Remembered your password? <a href="login.php" id="login">Login</a>
                <button onclick="location.href='reset_pass.php';" class="btn-dashboard"> Send Request Again</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRBl8s2Rl3J3I6cVrYm4joFtQQvffzE4aRj/fdr1A" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $('#resetPasswordForm').on('submit', function(e) {
        e.preventDefault();
        var password = $('#resetPasswordForm input[name="password"]').val();
        var confirmPassword = $('#resetPasswordForm input[name="confirm_password"]').val();
        var token = $('#resetPasswordForm input[name="token"]').val();

        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Passwords do not match.'
            });
            return;
        }

        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we reset your password.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            type: 'POST',
            url: 'function/process_reset_password.php',
            data: {
                password: password,
                token: token
            },
            success: function(response) {
                Swal.close();
                try {
                    response = JSON.parse(response);
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Your password has been reset.'
                        }).then(() => {
                            window.location.href = response.redirect;
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error processing your request.'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'There was an error processing your request.'
                });
            }
        });
    });
    </script>

</body>

</html>

<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    fetch('function/login.php', {
            method: 'post',
            body: formData
        }).then(response => response.json())
        .then(data => {
            console.log('Response data:', data); // Add this line to inspect the data
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Login Failed',
                    text: data.message,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Try Again'
                });

            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
</script>