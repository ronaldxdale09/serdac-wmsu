<!DOCTYPE html>
<html>

<head>
    <title>SERDAC-WMSU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="css/login.css">
    <link rel="icon" type="image/x-icon" href="assets/images/serdac.ico">

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <div class="wrapper">
        <div class="logos-container">
            <img src="assets/images/serdac.png" alt="School Logo 1" class="school-logo" />
            <img src="assets/images/wmsu.png" alt="School Logo 2" class="school-logo" />
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
                <a href="#">Forget password?</a>
            </div>
            <button type="submit" class="btn">LOGIN</button>
            <div class="account-exist">
                Create New a account? <a href="#" id="signup">Signup</a>
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
                    icon: 'error', 
                    title: 'Login Failed', 
                    text: 'Incorrect email or password. Please try again.', 
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