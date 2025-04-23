<style>
/* Remove the conflicting notification styles from here since they're in navbar.css */
.header-area .main-nav .nav {
    display: flex;
    align-items: center;
}

/* Profile/Portal and notification container */
.user-section {
    display: flex;
    align-items: center;
    gap: 20px;
}

body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

.header-area + .hero-section {
    margin-top: -1px; /* This removes any potential gap */
}
</style>

<?php 

function getUnreadNotifications($con, $userId, $limit = 5) {
    $query = "SELECT * FROM client_notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC LIMIT ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $limit);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}
?>
<link rel="stylesheet" href="css/homepage.css">

<link rel="stylesheet" href="css/navbar.css">

<!-- Sub Header -->
<div class="sub-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-8">
                <div class="left-content">
                    <p>Satellite Socio-Economic Research and Data Analytics Center - WMSU</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="right-icons">
                    <ul>
                        <li><a href="https://www.facebook.com/satellite.serdac.wmsu" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="index.php">
                            <img src="assets/images/logo_nav.png" alt="SERDAC Logo" class="navbar-logo">
                        </a>
                    </div>

                    <!-- Navigation Menu -->
                    <ul class="nav">
                        <li><a href="index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">HOME</a></li>
                        <li><a href="news.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'news.php') ? 'active' : ''; ?>">NEWS</a></li>
                        <li class="has-sub">
                            <a href="javascript:void(0)">REPOSITORY</a>
                            <ul class="sub-menu">
                                <li><a href="project_list.php"><i class="fas fa-project-diagram"></i> Projects</a></li>
                                <li><a href="publication.php"><i class="fas fa-book"></i> E-Books</a></li>
                            </ul>
                        </li>
                        <li class="has-sub">
                            <a href="javascript:void(0)">SERVICES</a>
                            <ul class="sub-menu">
                                <li><a href="request.php"><i class="fas fa-chalkboard-teacher"></i>   Request Service</a></li>
                                <li><a href="service_join.php"><i class="fas fa-user-plus"></i> Join Training</a></li>
                            </ul>
                        </li>
                        <li><a href="contact_us.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact_us.php') ? 'active' : ''; ?>">CONTACT US</a></li>

                        <?php
                        if (isset($_SESSION["userId_code"]) && !empty($_SESSION["userId_code"])) {
                            $userId = $_SESSION["userId_code"];
                            $unreadNotifications = getUnreadNotifications($con, $userId);
                            $unreadCount = mysqli_num_rows($unreadNotifications);
                            
                            echo '<div class="user-section">';
                            
                            if (($_SESSION["accessType"]) == 'Administrator') {
                                echo '<li><a href="admin/index.php"><i class="fas fa-user"></i> PORTAL</a></li>';
                            } else {
                                echo '<li><a href="profile.php"><i class="fas fa-user"></i> PROFILE</a></li>';
                            }
                            
                            // Updated notification icon and dropdown
                            echo '<li class="notification-dropdown">';
                            echo '<a href="javascript:void(0)" class="notification-icon" id="notificationToggle">';
                            echo '<i class="fas fa-bell"></i>';
                            if ($unreadCount > 0) {
                                echo '<span class="notification-badge">' . $unreadCount . '</span>';
                            }
                            echo '</a>';
                            
                            echo '<div class="notification-content" id="notificationContent">';
                            if ($unreadCount > 0) {
                                while ($row = mysqli_fetch_assoc($unreadNotifications)) {
                                    echo '<div class="notification-item" data-notification-id="' . $row['notification_id'] . '">';
                                    echo '<p>' . htmlspecialchars($row['message']) . '</p>';
                                    echo '<small>' . date('M j, Y H:i', strtotime($row['created_at'])) . '</small>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="notification-item"><p>No new notifications</p></div>';
                            }
                            echo '</div>';
                            echo '</li>';
                            echo '</div>';
                        } else {
                            echo '<li><a href="request.php" class="btn-primary"><i class="fas fa-handshake"></i> REQUEST SERVICE</a></li>';
                            echo '<li><a href="login.php" class="btn-login"><i class="fas fa-sign-in-alt"></i> LOGIN</a></li>';
                        }
                        ?>
                    </ul>
                    
                    <!-- Mobile Menu Trigger -->
                    <div class='menu-trigger'>
                        <i class="fas fa-bars"></i>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <!-- Mobile Nav Overlay -->
    <div class="mobile-nav-overlay"></div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuTrigger = document.querySelector('.menu-trigger');
    const nav = document.querySelector('.header-area .main-nav .nav');
    const overlay = document.querySelector('.mobile-nav-overlay');
    const hasSubItems = document.querySelectorAll('.header-area .main-nav .nav li.has-sub');
    
    // Toggle mobile menu
    if (menuTrigger && nav && overlay) {
        menuTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Toggle classes
            this.classList.toggle('active');
            nav.classList.toggle('show');
            overlay.classList.toggle('show');
            
            // Toggle body scroll
            if (nav.classList.contains('show')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        });

        // Close menu when clicking overlay
        overlay.addEventListener('click', function() {
            menuTrigger.classList.remove('active');
            nav.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });

        // Prevent menu from closing when clicking inside nav
        nav.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    }

    // Handle dropdowns
    hasSubItems.forEach(item => {
        const link = item.querySelector('a');
        const submenu = item.querySelector('.sub-menu');
        
        if (link && submenu) {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 991) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close other open submenus
                    hasSubItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('open')) {
                            otherItem.classList.remove('open');
                            const otherSubmenu = otherItem.querySelector('.sub-menu');
                            if (otherSubmenu) {
                                otherSubmenu.style.maxHeight = '0px';
                            }
                        }
                    });
                    
                    // Toggle current submenu
                    item.classList.toggle('open');
                    if (item.classList.contains('open')) {
                        submenu.style.maxHeight = submenu.scrollHeight + "px";
                    } else {
                        submenu.style.maxHeight = "0px";
                    }
                }
            });
        }
    });

    // Close mobile menu on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 991) {
            if (menuTrigger) menuTrigger.classList.remove('active');
            if (nav) nav.classList.remove('show');
            if (overlay) overlay.classList.remove('show');
            document.body.style.overflow = '';
            
            // Reset all submenus
            hasSubItems.forEach(item => {
                item.classList.remove('open');
                const submenu = item.querySelector('.sub-menu');
                if (submenu) {
                    submenu.style.maxHeight = '';
                }
            });
        }
    });

    // Enhanced notification handling
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationContent = document.getElementById('notificationContent');
    const mobileOverlay = document.querySelector('.mobile-nav-overlay');

    if (notificationToggle && notificationContent) {
        // Toggle notification dropdown
        notificationToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Close any open mobile menu first
            const nav = document.querySelector('.header-area .main-nav .nav');
            const menuTrigger = document.querySelector('.menu-trigger');
            if (nav && nav.classList.contains('show')) {
                nav.classList.remove('show');
                menuTrigger.classList.remove('active');
                mobileOverlay.classList.remove('show');
            }

            // Toggle notification dropdown
            const isOpen = notificationContent.classList.contains('show');
            
            // Close all other dropdowns first
            document.querySelectorAll('.notification-content.show').forEach(dropdown => {
                if (dropdown !== notificationContent) {
                    dropdown.classList.remove('show');
                }
            });

            // Toggle current dropdown
            notificationContent.classList.toggle('show');
            
            // Show overlay on mobile when notifications are open
            if (window.innerWidth <= 991) {
                if (!isOpen) {
                    mobileOverlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                } else {
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
        });

        // Close notification when clicking a notification item
        notificationContent.addEventListener('click', function(e) {
            if (e.target.closest('.notification-item')) {
                notificationContent.classList.remove('show');
                if (window.innerWidth <= 991) {
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
        });

        // Close notification when clicking outside
        document.addEventListener('click', function(e) {
            if (!notificationToggle.contains(e.target) && !notificationContent.contains(e.target)) {
                notificationContent.classList.remove('show');
                if (window.innerWidth <= 991) {
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            }
        });

        // Close notification on overlay click (mobile)
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                if (notificationContent.classList.contains('show')) {
                    notificationContent.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (notificationContent.classList.contains('show')) {
                if (window.innerWidth > 991) {
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                } else {
                    mobileOverlay.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }
        });
    }

    // Sticky header
    const header = document.querySelector('.header-area');
    const subHeader = document.querySelector('.sub-header');
    let lastScroll = 0;

    window.addEventListener('scroll', function() {
        const currentScroll = window.pageYOffset;
        const subHeaderHeight = subHeader ? subHeader.offsetHeight : 0;

        if (currentScroll > subHeaderHeight) {
            header.classList.add('header-sticky');
            if (currentScroll > lastScroll) {
                header.style.transform = 'translateY(-100%)';
            } else {
                header.style.transform = 'translateY(0)';
            }
        } else {
            header.classList.remove('header-sticky');
            header.style.transform = '';
        }
        lastScroll = currentScroll;
    });
});
</script>