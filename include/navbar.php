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
                        <li><a href="https://www.facebook.com/satellite.serdac.wmsu"><i class="fa fa-facebook"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- ***** Logo Start ***** -->
                    <!-- ***** Logo End ***** -->
                    <!-- ***** Menu Start ***** -->
                    <ul class="nav">
                        <li><a href="index.php" class="active">Home</a></li>
                        <li><a href="meetings.php">News</a></li>
                        <li class="scroll-to-section"><a href="#apply">Publications</a></li>
                        <li class="has-sub servnav">
                            <a href="javascript:void(0)">SERVICES</a>
                            <ul class="sub-menu">
                                <li><a href="request.php">REQUEST SERVICE</a></li>
                                <!-- <li><a href="meeting-details.html">Capability Training</a></li> -->

                            </ul>
                        </li>
                        <li class="scroll-to-section"><a href="#courses">ABOUT US</a></li>
                        <li class="scroll-to-section"><a href="#contact">Contact Us</a></li>
                        
                        <?php
                        // Check if the session variable exists and has data
                        if (isset($_SESSION["userId_code"]) && !empty($_SESSION["userId_code"])) {
                            // If data exists in the session, show 'PORTAL' link
                            if (($_SESSION["accessType"]) == 'Administrator') 
                            {
                                echo '<li><a href="admin/index.php"><i class="fas fa-user"></i> PORTAL </a></li>';

                            }
                            else {
                                echo '<li><a href="profile.php"><i class="fas fa-user"></i> PROFILE </a></li>';

                            }
                        } else {
                            // If no data in the session, show 'LOGIN' link
                            echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> LOGIN </a></li>';
                        }
                        ?>

                    </ul>
                    <a class='menu-trigger'>
                        <span>Menu</span>
                    </a>
                    <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
</header>