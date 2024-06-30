<style>

</style>
<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-8">
                <div class="left-content">
                    <p>Satellite Socio-Economic Research and Data Analytics Center - WMSU </p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="right-icons">
                    <ul>
                        <li><a href="https://www.facebook.com/satellite.serdac.wmsu" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <div class="logo">
                        <img src="assets/images/logo_nav.png" alt="Logo" class="navbar-logo">
                    </div>

                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="news.php">News</a></li>
                        <li class="has-sub servnav">
                            <a href="javascript:void(0)">Repository</a>
                            <ul class="sub-menu">
                                <li><a href="project_list.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                                <li><a href="publication.php"><i class="fas fa-book"></i> E-Books</a></li>
                            </ul>
                        </li>
                        <li class="has-sub servnav">
                            <a href="javascript:void(0)">SERVICES</a>
                            <ul class="sub-menu">
                                <li><a href="request.php"><i class="fas fa-chalkboard-teacher"></i> REQUEST SERVICE</a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="contact_us.php">Contact Us</a></li>

                        <?php
                        if (isset($_SESSION["userId_code"]) && !empty($_SESSION["userId_code"])) {
                            if (($_SESSION["accessType"]) == 'Administrator') {
                                echo '<li><a href="admin/index.php"><i class="fas fa-user"></i> PORTAL </a></li>';
                            } else {
                                echo '<li><a href="profile.php"><i class="fas fa-user"></i> PROFILE </a></li>';
                            }
                        } else {
                            echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> LOGIN </a></li>';
                        }
                        ?>
                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>