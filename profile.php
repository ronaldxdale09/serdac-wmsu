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

        $sql = mysqli_query($con, "SELECT COUNT(*) as Total 
                           FROM service_request sr
                           JOIN service_participant sp ON sr.request_id = sp.request_id
                           WHERE sp.user_id = '$id' 
                           AND sr.service_type = 'capability-training'
                           AND sr.status IN ('In Progress', 'Scheduled')");

        $res = mysqli_fetch_array($sql);
        $current_trainings_count = $res['Total'];

        $tab = isset($_GET['tab']) ? $_GET['tab'] : 'profile';
        $validTabs = ['profile', 'request', 'training'];
        if (!in_array($tab, $validTabs)) {
            $tab = 'profile';
        }

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
                                            <a href="?tab=profile"
                                                class="nav-link <?php echo $tab === 'profile' ? 'active' : ''; ?>">
                                                <i class="fas fa-user"></i> <span class="hidden-xs">Profile</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="?tab=request"
                                                class="nav-link <?php echo $tab === 'request' ? 'active' : ''; ?>">
                                                <i class="fas fa-envelope-open"></i> <span class="hidden-xs">SERVICE
                                                    REQUEST
                                                    <span
                                                        class="badge bg-danger text-light"><?php echo $req_count ?></span></span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="?tab=training"
                                                class="nav-link <?php echo $tab === 'training' ? 'active' : ''; ?>">
                                                <i class="fas fa-edit"></i> <span class="hidden-xs">TRAININGS
                                                    <span
                                                        class="badge bg-danger text-light"><?php echo $current_trainings_count ?></span></span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content p-3 tab-min-height">
                                        <?php if ($tab === 'profile' || $tab === ''): ?>
                                        <div class="tab-pane active" id="profile">
                                            <h5 class="mb-3">User Profile</h5>
                                            <?php include('user/profile.php'); ?>
                                        </div>
                                        <?php elseif ($tab === 'request'): ?>
                                        <div class="tab-pane active" id="request">
                                            <?php include('user/request.php'); ?>
                                        </div>
                                        <?php elseif ($tab === 'training'): ?>
                                        <div class="tab-pane active" id="training">
                                            <?php include('user/training.php'); ?>
                                        </div>
                                        <?php endif; ?>
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

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js">
        </script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
        <br>
    </section>

    <?php include('modal/profile_modal.php');?>
    <?php include('modal/service_analysis.req.php');?>
    <?php include('modal/service_meeting.php');?>

    <?php include('include/footer.php');?>

    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="notificationTableContainer">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>