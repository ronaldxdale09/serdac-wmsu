<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="./"><img src="assets/images/logo.png" alt="Logo"></a>
            <a class="navbar-brand hidden" href="./"><img src="images/serdac-icon.png" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">
               

                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger" id="notificationCount">0</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="notification">
                        <p class="red" id="notificationHeader">You have 0 notifications</p>
                        <div id="notificationList"></div>
                    </div>
                </div>
                <?php 
                // Fetch the latest 4 messages
                $query = "SELECT name, message, submitted_at FROM contact_messages ORDER BY submitted_at DESC LIMIT 4";
                $result = mysqli_query($con, $query);

                $messages = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $messages[] = $row;
                }
                ?>
                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                        <span class="count bg-primary"><?php echo count($messages); ?></span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="message">
                        <p class="red">You have <?php echo count($messages); ?> Mails</p>
                        <?php foreach ($messages as $message) { ?>
                        <a class="dropdown-item media" href="contact_messages.php">
                            <span class="photo media-left"><img alt="avatar" src="assets/images/serdac.png"></span>
                            <div class="message media-body">
                                <span class="name float-left"><?php echo htmlspecialchars($message['name']); ?></span>
                                <span
                                    class="time float-right"><?php echo htmlspecialchars($message['submitted_at']); ?></span>
                                <p><?php echo htmlspecialchars($message['message']); ?></p>
                            </div>
                        </a>
                        <?php } ?>
                    </div>
                </div>


            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="images/serdac-icon.png" alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="#"><i class="fa fa- user"></i>My Profile</a>

                    <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span
                            class="count">13</span></a>

                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                    <a class="nav-link" href="function/logout.php"><i class="fa fa-power -off"></i>Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>
<script>
$(document).ready(function() {
    function loadNotifications() {
        $.ajax({
            url: 'fetch/fetch_notifications.php', // Your endpoint for fetching notifications
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var notificationCount = data.length;
                $('#notificationCount').text(notificationCount);
                $('#notificationHeader').text('You have ' + notificationCount + ' notifications');

                var notificationList = $('#notificationList');
                notificationList.empty();
                data.forEach(function(notification) {
                    var iconClass = 'fa-info'; // Default icon
                    if (notification.activity_type === 'check') iconClass = 'fa-check';
                    else if (notification.activity_type === 'warning') iconClass =
                        'fa-warning';

                    var notificationItem = `
                        <a class="dropdown-item media" href="#">
                            <i class="fa ${iconClass}"></i>
                            <p>${notification.activity_description}</p>
                        </a>`;
                    notificationList.append(notificationItem);
                });
            },
            error: function(xhr, status, error) {
                console.error('Failed to fetch notifications:', error);
            }
        });
    }

    // Load notifications on page load
    loadNotifications();
});
</script>