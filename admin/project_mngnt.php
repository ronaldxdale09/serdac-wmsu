<?php include('include/header.php')?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="css/assmt.form.view.css">
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<body>
    <!-- Left Panel -->
    <?php include('include/sidebar.php')?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php include('include/navbar.php')?>

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
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li class="active">Projects</li>
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
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <strong class="card-title">Project List</strong>
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#createProjectModal">
                                <i class="fas fa-plus"></i> New Project
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive custom-table-container">
                                <?php
                // Fetch data from the repo_projects table
                    $results = mysqli_query($con, "SELECT * FROM repo_projects");
                ?>
                                <table class="table table-hover" id="projects_table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Project ID</th>
                                            <th scope="col">Program Title</th>
                                            <th scope="col">Project Title</th>
                                            <th scope="col">Project Leader</th>
                                            <th scope="col">Leader Agency</th>
                                            <th scope="col">Implementing Agency</th>
                                            <th scope="col">Start Date</th>
                                            <th scope="col">End Date</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
            while ($row = mysqli_fetch_array($results)) { 
            ?>
                                        <tr>
                                            <td><?php echo $row['ProjectID']; ?></td>
                                            <td><?php echo $row['ProgramTitle']; ?></td>
                                            <td><?php echo $row['ProjectTitle']; ?></td>
                                            <td><?php echo $row['ProjectLeader']; ?></td>
                                            <td><?php echo $row['ProjectLeaderAgency']; ?></td>
                                            <td><?php echo $row['ImplementingAgency']; ?></td>
                                            <td><?php echo $row['ProjectDurationStart']; ?></td>
                                            <td><?php echo $row['ProjectDurationEnd']; ?></td>
                                            <td><?php echo $row['Status']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-dark btnEdit"
                                                    data-project='<?php echo json_encode($row); ?>'>
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger btnDelete"
                                                    data-project='<?php echo json_encode($row); ?>'>
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
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
    <?php include('modal/repo_project.modal.php');?>

    <script>
    $(document).ready(function() {
        $(document).ready(function() {
            var table = $('#projects_table').DataTable({
                dom: 'Bfrtip',
                buttons: ['excelHtml5', 'pdfHtml5', 'print']
            });
        });

        $('.btnEdit').on('click', function() {
            var project = $(this).data('project');

            // Fill the form with project data
            $('#editProjectID').val(project.ProjectID);
            $('#editProgramTitle').val(project.ProgramTitle);
            $('#editProjectTitle').val(project.ProjectTitle);
            $('#editProjectLeader').val(project.ProjectLeader);
            $('#editProjectLeaderSex').val(project.ProjectLeaderSex);
            $('#editProjectLeaderAgency').val(project.ProjectLeaderAgency);
            $('#editProjectLeaderContact').val(project.ProjectLeaderContact);
            $('#editCooperatingAgencies').val(project.CooperatingAgencies);
            $('#editImplementingAgency').val(project.ImplementingAgency);
            $('#editImplementingAgencyAddress').val(project.ImplementingAgencyAddress);
            $('#editBaseStation').val(project.BaseStation);
            $('#editOtherImplementationSites').val(project.OtherImplementationSites);
            $('#editStartDate').val(project.ProjectDurationStart);
            $('#editEndDate').val(project.ProjectDurationEnd);
            $('#editExtensionDate').val(project.ExtensionDate);
            $('#editProjectCost').val(project.ProjectCost);
            $('#editSdgAddressed').val(project.SDGAddressed);
            $('#editProjectAbstract').val(project.ProjectAbstract);
            $('#editFundedBy').val(project.FundedBy);
            $('#editFacilitatedBy').val(project.FacilitatedBy);
            $('#editStatus').val(project.Status);

            // Show the modal
            var modal = new bootstrap.Modal(document.getElementById('editProjectModal'));
            modal.show();
        });


    });
    </script>


</body>

</html>