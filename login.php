<?php

// Existing code
include('function/db.php');

if (isset($_SESSION["isLogin"])) {
    if ($_SESSION["isLogin"] == 1) {
        header("Location: index.php");
        exit();
    }
    // If isLogin is not 1 (e.g., 0), allow login
}

$codeExists = false;
$activationAttempted = false;

if (isset($_GET["code"])) {
    $activationAttempted = true;
    $activationCode = $_GET['code'];
    // Prepare a statement to avoid SQL injection
    $stmt = $con->prepare("SELECT * FROM users WHERE activationCode = ?");
    $stmt->bind_param("s", $activationCode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Valid activation code
        $codeExists = true;
        $stmt = $con->prepare("UPDATE users SET `isActive` = 1 WHERE activationCode = ?");
        $stmt->bind_param("s", $activationCode);
        $stmt->execute();
    }
    $stmt->close();
}
$con->close();
?>

<!-- After closing the PHP tag, place your HTML outside of PHP -->
<?php if ($codeExists): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var activateAlert = document.getElementById('show-activate');
    if (activateAlert) activateAlert.style.display = 'block';
});
</script>
<?php elseif ($activationAttempted): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var failAlert = document.getElementById('show-activate-fail');
    if (failAlert) failAlert.style.display = 'block';
});
</script>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
    <title>SERDAC-WMSU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>

<body>
    <div class="login-container">
        <div class="login-wrapper">
            <div class="login-left">
                <div class="login-overlay"></div>
                <div class="login-content">
                    <h1>Welcome to SERDAC-WMSU</h1>
                    <p>Socio-Economic Research and Data Analytics Center</p>
                </div>
            </div>
            
            <div class="login-right">
                <div class="logos-container">
                    <img src="assets/images/serdac.png" alt="SERDAC Logo" class="school-logo" />
                    <img src="assets/images/wmsu.png" alt="WMSU Logo" class="school-logo" />
                </div>

                <div class="alert alert-success alert-dismissible fade show" style="display:none" role="alert" id="show-activate">
                    <strong>Activation Successful</strong> – Your account has been successfully activated. Welcome aboard!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="alert alert-danger alert-dismissible fade show" style="display:none" role="alert" id="show-activate-fail">
                    <strong>Activation Failed</strong> – The activation link is invalid or has already been used.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="login-form-container">
                    <h2>Sign In</h2>
                    <p class="login-subtitle">Please login to your account</p>

                    <form class="login-form" method="post" action="#" id="loginForm">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" placeholder="Email Address" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Password" required>
                                <span class="input-group-text password-toggle">
                                    <i class="fas fa-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <div class="form-options">
                            <div class="remember-me">
                                <input type="checkbox" id="checkbox">
                                <label for="checkbox">Remember me</label>
                            </div>
                            <a href="reset_pass.php" class="forgot-password">Forgot password?</a>
                        </div>

                        <button type="submit" class="btn-login">Sign In</button>

                        <div class="login-footer">
                            <p>Don't have an account? <a href="registration.php">Sign Up</a></p>
                            <a href="index.php" class="btn-return">Return to Homepage</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        const passwordToggles = document.querySelectorAll('.password-toggle');
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.replace('fa-eye-slash', 'fa-eye');
                } else {
                    input.type = 'password';
                    icon.classList.replace('fa-eye', 'fa-eye-slash');
                }
            });
        });
    });

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        fetch('function/login.php', {
            method: 'post',
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Login Failed',
                    text: data.message,
                    confirmButtonColor: '#800000',
                    confirmButtonText: 'Try Again'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
</body>

</html>