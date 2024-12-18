<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/activity_log.css">

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
                                <h1>Activity Log Management</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li class="active">Activity Logs</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header">
                            <strong class="card-title">Activity Log List</strong>
                        </div>
                        <div class="card-body">
                            <div class="inventory-table">
                                <table class="table table-bordered table-hover table-striped" id='activity_log'>
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User ID</th>
                                            <th scope="col">Activity Type</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <?php
                                 $results = mysqli_query($con, "SELECT * from user_activity_log ORDER BY activity_timestamp DESC"); ?>
                                    <tbody>
                                        <?php while ($row = mysqli_fetch_array($results)) { ?>
                                        <tr>
                                            <td><?php echo $row['log_id']; ?></td>
                                            <td><?php echo $row['user_id']; ?></td>
                                            <td><?php echo $row['activity_type']; ?></td>
                                            <td><?php echo $row['activity_description']; ?></td>
                                            <td><?php echo $row['activity_timestamp']; ?></td>

                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- .animated -->
        </div><!-- .content -->

    </div>

    <?php include('include/footer.php');?>
   

    <script>
    $(document).ready(function() {
        var table = $('#activity_log').DataTable({
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdfHtml5', 'print']
        });
    });
    </script>
</body>


</html>