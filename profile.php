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
                               
<div class="card profile-card">
    <div class="card-body position-relative p-4">
        <div class="row g-4 align-items-center">
            <!-- User image -->
            <div class="col-lg-3 col-md-4 text-center">
                <img src="https://png.pngtree.com/png-vector/20190114/ourmid/pngtree-vector-avatar-icon-png-image_313572.jpg"
                    alt="user avatar" class="img-fluid rounded-circle profile-image">
            </div>
            <!-- User details -->
            <div class="col-lg-9 col-md-8">
                <div class="profile-info">
                    <h4 class="mb-3"><?php echo $name ?></h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <div class="d-flex align-items-center">
                                <div class="list-icon me-3">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="list-details">
                                    <span><?php echo $contact ?></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="d-flex align-items-center">
                                <div class="list-icon me-3">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="list-details">
                                    <span><?php echo $email ?></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <button class="btn btn-outline-secondary btn-sm logout-btn"
            onclick="location.href='function/logout.php'">
            <i class="fas fa-sign-out-alt me-1"></i> Logout
        </button>
    </div>
</div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-lg-12">
                            <div class="card z-depth-3">
                                <div class="card-body details-card">
                                <ul class="nav nav-pills nav-pills-primary flex-column flex-md-row">
    <li class="nav-item flex-md-fill text-md-center mb-2 mb-md-0">
        <a href="?tab=profile" class="nav-link <?php echo $tab === 'profile' ? 'active' : ''; ?>">
            <i class="fas fa-user"></i> <span class="d-md-inline">Profile</span>
        </a>
    </li>
    <li class="nav-item flex-md-fill text-md-center mb-2 mb-md-0">
        <a href="?tab=request" class="nav-link <?php echo $tab === 'request' ? 'active' : ''; ?>">
            <i class="fas fa-envelope-open"></i> <span class="d-md-inline">SERVICE REQUEST</span>
            <?php if ($req_count > 0): ?>
                <span class="badge bg-danger text-light ms-1"><?php echo $req_count ?></span>
            <?php endif; ?>
        </a>
    </li>
    <li class="nav-item flex-md-fill text-md-center">
        <a href="?tab=training" class="nav-link <?php echo $tab === 'training' ? 'active' : ''; ?>">
            <i class="fas fa-edit"></i> <span class="d-md-inline">TRAININGS</span>
            <?php if ($current_trainings_count > 0): ?>
                <span class="badge bg-danger text-light ms-1"><?php echo $current_trainings_count ?></span>
            <?php endif; ?>
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
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
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