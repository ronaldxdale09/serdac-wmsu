<?php

// Fetch user access level from the database or session
$user_id = $_SESSION['userId_code'];
$query = "SELECT adminAccess FROM users WHERE user_id = $user_id";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);
$userAccess = isset($row['adminAccess']) ? json_decode($row['adminAccess'], true) : [];

// Ensure $userAccess is an array
if (!is_array($userAccess)) {
    $userAccess = [];
}

function hasAccess($accessList, $access) {
    return in_array($access, $accessList) || in_array('superadmin', $accessList);
}
?>
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?php if (hasAccess($userAccess, 'dashboard')): ?>
                <li class="active">
                    <a href="index.php"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'content_management')): ?>
                <li class="menu-title">Content Management</li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-book"></i>Articles
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (hasAccess($userAccess, 'articles_create')): ?>
                        <li><a href="new_article.php">Create Post</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'articles_manage')): ?>
                        <li><a href="articles.php">Manage Post</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'services')): ?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-table"></i>Services
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (hasAccess($userAccess, 'request_record')): ?>
                        <li><a href="request_record.php">Request Record</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'assessment')): ?>
                        <li><a href="assessment.php">Assessment</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'repository')): ?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-database"></i> Repository
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (hasAccess($userAccess, 'projects')): ?>
                        <li><a href="project_mngnt.php"> Projects</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'e_books')): ?>
                        <li><a href="ebook_mngnt.php"> E-Book</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'journals')): ?>
                        <!-- <li><a href="request_record.php"> Journals</a></li> -->
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'profile')): ?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-user"></i> Profile
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (hasAccess($userAccess, 'speaker_profile')): ?>
                        <li><a href="speaker_profile.php">Speaker Profile</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'client_list')): ?>
                        <li><a href="client_list.php">Client List</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'account_management')): ?>
                        <li><a href="account_mngmt.php">Account Management</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'reports')): ?>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="menu-icon fa fa-file"></i>Reports
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <?php if (hasAccess($userAccess, 'report_client')): ?>
                        <li><a href="report.php">Services Report</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'report_client')): ?>
                        <li><a href="report_client.php">Client Report</a></li>
                        <?php endif; ?>
                        <?php if (hasAccess($userAccess, 'assessments_reports')): ?>
                        <li><a href="assessments_reports.php">Assessments</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'schedules')): ?>
                <li>
                    <a href="schedules.php"><i class="menu-icon ti-calendar"></i>Schedules </a>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'activity_logs')): ?>
                <li>
                    <a href="activity_log.php"><i class="menu-icon ti-book"></i>Activity Logs </a>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'contact_messages')): ?>
                <li>
                    <a href="contact_messages.php"><i class="menu-icon ti-comments"></i>Contact Messages </a>
                </li>
                <?php endif; ?>

                <?php if (hasAccess($userAccess, 'settings')): ?>
                <li>
                    <a href="settings.php"><i class="menu-icon fas fa-cog"></i>Settings </a>
                </li>
                <?php endif; ?>

            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>