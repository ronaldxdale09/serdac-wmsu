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

            echo "
            <script>
                $(document).ready(function() {

                    $('#fname').val('".$record['fname']. "');
                    $('#midname').val('".$record['midname']. "');
                    $('#lname').val('".$record['lname']. "');
                    $('#email').val('".$record['email']. "');
                    $('#contact').val('".$record['contact_no']. "'); 
                    
                    $('#city').val('".$record['city']. "');
                    $('#province').val('".$record['province']. "'); 
                    $('#barangay').val('".$record['barangay']. "'); 

                });


                
            </script>
        ";

        $sql = mysqli_query($con, "SELECT COUNT(*) as Total FROM service_request WHERE user_id='$id'  ");
        $res = mysqli_fetch_array($sql);
        $req_count = $res['Total'];
        }

    }
    else{
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
                                            <form>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">First
                                                        name</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="text" value="Mark">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Last
                                                        name</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="text" value="Jhonsan">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-lg-3 col-form-label form-control-label">Email</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="email"
                                                            value="mark@example.com">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Change
                                                        profile</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="file">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-lg-3 col-form-label form-control-label">Website</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="url" value="">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-lg-3 col-form-label form-control-label">Address</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="text" value=""
                                                            placeholder="Street">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" value=""
                                                            placeholder="City">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input class="form-control" type="text" value=""
                                                            placeholder="State">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-lg-3 col-form-label form-control-label">Username</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="text" value="jhonsanmark">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-lg-3 col-form-label form-control-label">Password</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="password" value="11111122333">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Confirm
                                                        password</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="password" value="11111122333">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                                    <div class="col-lg-9">
                                                        <input type="reset" class="btn btn-secondary" value="Cancel">
                                                        <input type="button" class="btn btn-primary"
                                                            value="Save Changes">
                                                    </div>
                                                </div>
                                            </form>
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