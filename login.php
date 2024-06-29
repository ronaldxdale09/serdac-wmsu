<!DOCTYPE html>
<html>
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

if (isset($_GET["code"])) {
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
window.onload = function() {
    document.getElementById('show-activate').style.display = 'block';
};
</script>
<?php endif; ?>

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
        <div class="alert alert-success alert-dismissible fade show" style="display:none" role="alert"
            id="show-activate">
            <strong>Activation Successful</strong> – Your account has been successfully activated. Welcome aboard!
        </div>
        <div class="headline">
            <h1>WELCOME<br>SERDAC-WMSU</h1>
        </div>
        <form class="form" method="post" action="#" id="loginForm">
            <div class="form-group">
                <input type="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password">
            </div>
            <div class="forget-password">
                <div class="check-box">
                    <input type="checkbox" id="checkbox">
                    <label for="checkbox">Remember me</label>
                </div>
                <a href="reset_pass.php">Forget password?</a>
            </div>
            <button type="submit" class="btn">LOGIN</button>
            <div class="account-exist">
                Create a new account? <a href="registration.php" id="signup">Signup</a>
                <button onclick="location.href='index.php';" class="btn-dashboard">Return to Homepage</button>

            </div>
        </form>
    </div>
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