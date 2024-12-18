<?php include('include/header.php');

$tab = '';
if (isset($_GET['tab'])) {
    $tab = filter_var($_GET['tab']);
}
?>
<link rel='stylesheet' href='css/tab-report.css'>

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

        <!-- Content -->
        <div class="breadcrumbs">
            <div class="breadcrumbs-inner">
                <div class="row m-0">
                    <div class="col-sm-4">
                        <div class="page-header float-left">
                            <div class="page-title">
                                <h1>Service Request Report</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li class="active">Service Request Report</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="inventory-table">
                    <div class="wrapper" id="myTab">
                        <input type="radio" name="slider" id="home" <?php if ($tab == '') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>
                        <input type="radio" name="slider" id="blog" <?php if ($tab == '2') {
                                                                                echo 'checked';
                                                                            } else {
                                                                                echo '';
                                                                            } ?>>

                        <nav>
                            <!-- Pending Approval -->
                            <label for="home" class="home">
                                <i class="fas fa-hourglass-half"></i> Summary Report
                                <span class="badge bg-danger text-light"></span>
                            </label>

                            <!-- Scheduled -->
                            <label for="blog" class="blog">
                                <i class="fas fa-calendar-alt"></i> Service Detailed Report
                                <span class="badge bg-danger text-light"></span>
                            </label>



                            <div class="slider"></div>
                        </nav>
                        <section>
                            <div class="content content-1">
                                <?php include('report/summary_report.php'); ?>

                            </div>
                            <div class="content content-2">
                                <?php include('report/detailed_report.php'); ?>


                            </div>

                        </section>
                    </div>

                </div>
            </div>
        </div>

    </div>



    <?php include('include/footer.php');?>

</body>

</html>