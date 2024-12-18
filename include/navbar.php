<style>


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

/* Update notification icon styles */
.notificon {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-left: auto;
}

.notification-dropdown {
    position: relative;
    margin-left: 0;
    /* Remove the previous margin */
}


.notification-icon {
    position: relative;
    cursor: pointer;
}

.notification-badge {
    position: absolute;
    right: -8px;
    padding: 2px 5px;
    border-radius: 50%;
    background: red;
    color: white;
    font-size: 10px;
    line-height: 1;
}

.notification-content {
    display: none;
    position: absolute;
    right: -10px;
    top: 100%;
    background-color: #ffffff;
    min-width: 300px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-radius: 8px;
    z-index: 1000;
    max-height: 400px;
    overflow-y: auto;
    margin-top: 12px;
    padding: 8px 0;
    font-family: Arial, sans-serif;
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
    transition: background-color 0.2s ease;
    cursor: pointer;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background-color: #f9f9f9;
}

.notification-item p {
    margin: 0 0 4px 0;
    font-size: 14px;
    color: #333;
    line-height: 1.4;
}

.notification-item small {
    font-size: 12px;
    color: #888;
}

.notification-item:last-child {
    border-bottom: none;
}

/* Scrollbar styling for webkit browsers */
.notification-content::-webkit-scrollbar {
    width: 8px;
}

.notification-content::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.notification-content::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.notification-content::-webkit-scrollbar-thumb:hover {
    background: #555;
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
                        <li><a href="https://www.facebook.com/satellite.serdac.wmsu" target="_blank"><i
                                    class="fa fa-facebook"></i></a>
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
                                <li><a href="service_join.php"><i class="fas fa-user-plus"></i> JOIN TRAINING</a></li>

                        </li>
                    </ul>
                    </li>
                    <li><a href="contact_us.php">Contact Us</a></li>

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
    
    // Notification icon and dropdown
    echo '<li class="notification-dropdown">';
    echo '<a href="#" class="notification-icon" id="notificationToggle">';
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
    echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> LOGIN</a></li>';
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    var notificationToggle = document.getElementById('notificationToggle');
    var notificationContent = document.getElementById('notificationContent');

    if (notificationToggle && notificationContent) {
        notificationToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (notificationContent.style.display === 'block') {
                notificationContent.style.display = 'none';
            } else {
                notificationContent.style.display = 'block';
            }
        });

        // Close the dropdown when clicking outside of it
        document.addEventListener('click', function(e) {
            if (!notificationToggle.contains(e.target) && !notificationContent.contains(e.target)) {
                notificationContent.style.display = 'none';
            }
        });

        // Handle clicks on notification items
        notificationContent.addEventListener('click', function(e) {
            var notificationItem = e.target.closest('.notification-item');
            if (notificationItem) {
                var notificationId = notificationItem.dataset.notificationId;
                if (notificationId) {
                    // Mark notification as read
                    markNotificationAsRead(notificationId);
                    // Redirect to the notification details page or perform any other action
                    window.location.href = 'profile.php?tab=request';
                }
            }
            e.stopPropagation();
        });
    }
});

function markNotificationAsRead(notificationId) {
    // Send an AJAX request to mark the notification as read
    fetch('function/mark_notification_read.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'notification_id=' + notificationId
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update UI if needed (e.g., remove the notification, update counter)
                console.log('Notification marked as read');
            }
        })
        .catch(error => console.error('Error:', error));
}
</script>