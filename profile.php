<?php include('include/header.php');

if (isset($_SESSION["userId_code"])) {
    $id = $_SESSION['userId_code'];
    $id = preg_replace('~\D~', '', $id);

    $sql = "SELECT * FROM users WHERE user_id = $id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        $name = $record['fname'].' '.$record['midname'].' '.$record['lname'];
        $contact = $record['contact_no'];
        $email = $record['email'];
        $region = $record['region'];
        $city = $record['city'];
        $province = $record['province'];

        echo "
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('fname').value = '".addslashes($record['fname'])."';
                document.getElementById('midname').value = '".addslashes($record['midname'])."';
                document.getElementById('lname').value = '".addslashes($record['lname'])."';
                document.getElementById('email').value = '".addslashes($record['email'])."';
                document.getElementById('contact_no').value = '".addslashes($record['contact_no'])."';
                setRegionCityProvince('".addslashes($record['region'])."', '".addslashes($record['city'])."', '".addslashes($record['province'])."');
            });
        </script>
        ";

        $sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE user_id='$id'");
        $res = mysqli_fetch_array($sql);
        $req_count = $res['Total'];
    } else {
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
<link rel="stylesheet" href="css/profile.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

<body>
    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->

    <section class="meetings-page" id="meetings">

        <div class="container">
            <div class="col-lg-12">
                <div class="container-fluid px-1 py-5 mx-auto">
                    <div class="row">
                        <div class="col-12">
                            <div class="profile-card-3 z-depth-3">
                                <div class="card">
                                    <div class="card-body position-relative">
                                        <div class="row">
                                            <!-- User image -->
                                            <div class="col-md-3 text-center">
                                                <div class="user-box mt-3">
                                                    <img src="https://png.pngtree.com/png-vector/20190114/ourmid/pngtree-vector-avatar-icon-png-image_313572.jpg"
                                                        alt="user avatar" class="img-fluid rounded-circle">
                                                </div>
                                            </div>
                                            <!-- User details -->
                                            <div class="col-md-9">
                                                <div class="user-info">
                                                    <h5 class="mb-1"><?php echo $name ?></h5>
                                                    <h6 class="text-muted">Account Created March 01, 2024</h6>
                                                </div>
                                                <ul class="list-group shadow-none mt-3">
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="list-icon mr-3">
                                                            <i class="fa fa-phone-square fa-lg"></i>
                                                        </div>
                                                        <div class="list-details">
                                                            <span><?php echo $contact ?></span>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="list-icon mr-3">
                                                            <i class="fa fa-envelope fa-lg"></i>
                                                        </div>
                                                        <div class="list-details">
                                                            <span><?php echo $email ?></span>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button class="btn btn-secondary btn-sm logout-btn"
                                            onclick="location.href='function/logout.php'">Logout</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-lg-12">
                            <div class="card z-depth-3">
                                <div class="card-body details-card">
                                    <ul class="nav nav-pills nav-pills-primary nav-justified">
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                                                class="nav-link active show"><i class="icon-user"></i> <span
                                                    class="hidden-xs">Profile</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#messages" data-toggle="pill"
                                                class="nav-link"><i class="icon-envelope-open"></i> <span
                                                    class="hidden-xs">REQUEST <span class="badge bg-danger text-light">
                                                        <?php echo  $req_count ?> </span></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void();" data-target="#edit" data-toggle="pill"
                                                class="nav-link"><i class="icon-note"></i> <span
                                                    class="hidden-xs">DOWNLOAD</span></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 tab-min-height">
                                        <div class="tab-pane active show" id="profile">
                                            <h5 class="mb-3">User Profile</h5>
                                            <?php include('user/profile.php'); ?>
                                        </div>
                                        <div class="tab-pane" id="messages">
                                            <?php include('user/request.php'); ?>
                                        </div>
                                        <div class="tab-pane" id="edit">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <script src="assets/js/isotope.min.js"></script>
        <script src="assets/js/owl-carousel.js"></script>
        <script src="assets/js/lightbox.js"></script>
        <script src="assets/js/tabs.js"></script>
        <script src="assets/js/video.js"></script>
        <script src="assets/js/slick-slider.js"></script>
        <script src="assets/js/custom.js"></script>
        <br>
    </section>

    <?php include('modal/profile_modal.php');?>
    <?php include('modal/service_analysis.req.php');?>
    <?php include('modal/service_meeting.php');?>

    <?php include('include/footer.php');?>


</body>

</html>