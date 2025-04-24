<?php include('include/header.php')?>
<link rel="stylesheet" href="css/settings.css">
<link rel="stylesheet" href="css/project_mngmt.css">

<style>
.action-buttons {
    display: flex;
    justify-content: flex-start;
    gap: 10px;
    /* Adds space between buttons */
}

.btn-sm {
    padding: 6px 12px;
    font-size: 0.875rem;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s ease, transform 0.2s ease;
}

.btn-sm i {
    margin-right: 5px;
    /* Space between icon and text */
}

.btn-sm:hover {
    transform: translateY(-2px);
    /* Slight hover effect */
}

.edit-btn {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.edit-btn:hover {
    background-color: #0056b3;
    border-color: #0056b3;
}

.delete-btn {
    background-color: #dc3545;
    border-color: #dc3545;
    color: white;
}

.delete-btn:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-sm i {
    margin: 0;
    /* Remove space for buttons with just icons */
}
</style>

<body class="bg-light">
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="content">
            <div class="settings-wrapper">
                <div class="settings-grid">
                    <!-- Settings Navigation -->
                    <div class="settings-nav">
                        <div class="settings-nav-header">
                            <h5 class="settings-nav-title">Settings</h5>
                            <p class="settings-nav-subtitle">Manage your system preferences</p>
                        </div>
                        <ul class="settings-nav-list">
                            <li class="settings-nav-item">
                                <a href="#cms" class="settings-nav-link active" data-toggle="tab">
                                    <i class="fas fa-newspaper"></i>
                                    <span>Content Management</span>
                                </a>
                                </li>
                            <li class="settings-nav-item">
                                <a href="#registration" class="settings-nav-link" data-toggle="tab">
                                    <i class="fas fa-user-plus"></i>
                                    <span>Registration</span>
                                </a>
                                </li>
                            <li class="settings-nav-item">
                                <a href="#service" class="settings-nav-link" data-toggle="tab">
                                    <i class="fas fa-cogs"></i>
                                    <span>Service Request</span>
                                </a>
                                </li>
                            </ul>
                    </div>

                    <!-- Settings Content -->
                    <div class="settings-content">
                        <div class="tab-content">
                            <!-- CMS Settings -->
                            <div class="tab-pane fade show active" id="cms">
                                <div class="settings-header">
                                    <div>
                                        <h4 class="settings-title">Content Management System</h4>
                                        <p class="settings-description">Manage your website content and information</p>
                                    </div>
                                </div>
                                <div class="settings-body">
                                    <div class="settings-section">
                                        <div class="settings-section-header">
                                            <h6 class="settings-section-title">Website Content</h6>
                                            <p class="settings-section-description">Update your website's main content and information</p>
                                        </div>
                                        <?php include('settings/content_update.php'); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Registration Settings -->
                            <div class="tab-pane fade" id="registration">
                                <div class="settings-header">
                                    <div>
                                        <h4 class="settings-title">Registration Settings</h4>
                                        <p class="settings-description">Configure registration options and requirements</p>
                                    </div>
                                </div>
                                <div class="settings-body">
                                    <div class="settings-section">
                                        <div class="settings-section-header">
                                            <h6 class="settings-section-title">Registration Options</h6>
                                            <p class="settings-section-description">Manage registration fields and requirements</p>
                                        </div>
                                        <?php include('settings/registration_dropdowns.php'); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Request Settings -->
                            <div class="tab-pane fade" id="service">
                                <div class="settings-header">
                                    <div>
                                        <h4 class="settings-title">Service Request Settings</h4>
                                        <p class="settings-description">Configure service request options and workflows</p>
                                    </div>
                                </div>
                                <div class="settings-body">
                                    <div class="settings-section">
                                        <div class="settings-section-header">
                                            <h6 class="settings-section-title">Service Options</h6>
                                            <p class="settings-section-description">Manage service types and configurations</p>
                                        </div>
                                        <?php include('settings/request_dropdown.php'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Handle tab navigation
        $('.settings-nav-link').on('click', function(e) {
            e.preventDefault();
            const target = $(this).attr('href');
            
            // Update navigation state
            $('.settings-nav-link').removeClass('active');
            $(this).addClass('active');
            
            // Update content visibility
            $('.tab-pane').removeClass('show active');
            $(target).addClass('show active');
        });

        // Show initial tab
        const initialTab = window.location.hash || '#cms';
        $(`.settings-nav-link[href="${initialTab}"]`).addClass('active');
        $(initialTab).addClass('show active');

        // Handle form submissions with feedback
        $('.settings-form').on('submit', function(e) {
            e.preventDefault();
            const $form = $(this);
            const $button = $form.find('button[type="submit"]');
            
            // Add loading state
            $button.prop('disabled', true)
                   .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...');

            // Simulate form submission (replace with actual AJAX call)
            setTimeout(() => {
                $button.prop('disabled', false).html('Save Changes');
                showAlert('success', 'Settings saved successfully!');
            }, 1000);
        });

        // Function to show alerts
        function showAlert(type, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            $('.settings-body').prepend(alertHtml);
            
            // Auto dismiss after 3 seconds
            setTimeout(() => {
                $('.alert').alert('close');
            }, 3000);
        }
});
</script>

    <?php include('include/footer.php');?>
</body>
</html>