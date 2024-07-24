<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">

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
                                <h1>Dashboard</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="page-header float-right">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Dashboard</a></li>
                                    <li><a href="#">Table</a></li>
                                    <li class="active">Contact Messages</li>
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
                            <strong class="card-title">Contact Messages List</strong>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-table-container">
                                <?php
        // Fetch data from the contact_messages table
        $results = mysqli_query($con, "SELECT * FROM contact_messages ORDER BY submitted_at DESC");
        ?>
                                <table class="table table-hover" id="contact_messages_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Timestamp</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Mobile</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Message</th>
                                            <th scope="col">Timestamp</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php 
                while ($row = mysqli_fetch_array($results)) {
                ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['mobile']; ?></td>
                                            <td><?php echo $row['subject']; ?></td>
                                            <td><?php echo $row['message']; ?></td>
                                            <td><?php echo $row['submitted_at']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    <?php include('include/footer.php');?>

    <script>
    $(document).ready(function() {
        // Setup - add a text input to each footer cell
        $('#contact_messages_table tfoot th').each(function() {
            var title = $(this).text();
            $(this).html(
                '<input type="text" class="form-control form-control-sm" placeholder="Filter ' +
                title + '" />');
        });

        var table = $('#contact_messages_table').DataTable({
            dom: 'Bfrtip',
            buttons: ['excelHtml5', 'pdfHtml5', 'print'],
            initComplete: function() {
                // Apply the search
                this.api().columns().every(function() {
                    var that = this;
                    $('input', this.footer()).on('keyup change clear', function() {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                });
            }
        });

        // Move the footer with filters to the top of the table
        $('#contact_messages_table tfoot tr').appendTo('#contact_messages_table thead');
    });
    </script>

    <style>
    #contact_messages_table thead input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
    </style>
</body>


</html>