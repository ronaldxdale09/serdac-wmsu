<?php include('include/header.php')?>
<link rel="stylesheet" href="css/project_mngmt.css">
<link rel="stylesheet" href="assets/css/lib/datatable/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="assets/css/lib/datatable/buttons.dataTables.min.css">

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
        <?php
                // Fetch data from the repo_projects table
           $results = mysqli_query($con, "SELECT * FROM repo_projects");  ?>
        <div class="content">
            <div class="card">
                <!-- Header Section -->
                <div class="card-header">
                    <div class="header-content">
                        <h5 class="header-title">
                            <i class="fas fa-project-diagram"></i>
                            Project List
                        </h5>
                        <div class="btn-group">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#createProjectModal">
                                <i class="fas fa-plus"></i>
                                New Project
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-container">
                    <table id="projects_table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Project ID</th>
                                <th>Program Title</th>
                                <th>Project Title</th>
                                <th>Project Leader</th>
                                <th>Leader Agency</th>
                                <th>Implementing Agency</th>
                                <th>Dates</th>
                                <th style="text-align: center">Status</th>
                                <th style="text-align: right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                while ($row = mysqli_fetch_array($results)) { 
                    $startDate = date('F j, Y', strtotime($row['ProjectDurationStart']));
                    $endDate = date('F j, Y', strtotime($row['ProjectDurationEnd']));
                ?>
                            <tr>
                                <td class="text-muted">#<?php echo $row['ProjectID']; ?></td>
                                <td class="fw-medium"><?php echo $row['ProgramTitle']; ?></td>
                                <td><?php echo $row['ProjectTitle']; ?></td>
                                <td><?php echo $row['ProjectLeader']; ?></td>
                                <td><?php echo $row['ProjectLeaderAgency']; ?></td>
                                <td><?php echo $row['ImplementingAgency']; ?></td>
                                <td>
                                    <div>
                                        <div><i class="far fa-calendar me-1"></i><?php echo $startDate; ?></div>
                                        <div><i class="far fa-calendar me-1"></i><?php echo $endDate; ?></div>
                                    </div>
                                </td>
                                <td style="text-align: center">
                                    <span
                                        class="badge <?php echo $row['Status'] === 'Completed' ? 'badge-success' : 'badge-primary'; ?>">
                                        <?php echo $row['Status']; ?>
                                    </span>
                                </td>
                                <td style="text-align: right">
                                    <div class="dropdown">
                                        <button class="btn btn-outline dropdown-toggle" type="button" id="dropdownMenuButton<?php echo $row['ProjectID']; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton<?php echo $row['ProjectID']; ?>">
                                            <!-- <a class="dropdown-item" href="#" onclick='viewProject(<?php echo json_encode($row); ?>)'>
                                                <i class="fas fa-eye" style="color: var(--primary-color)"></i> View Project
                                            </a> -->
                                            <a class="dropdown-item" href="#" onclick='editProject(<?php echo json_encode($row); ?>)'>
                                                <i class="fas fa-pen" style="color: #eab308"></i> View Project
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" onclick='deleteProject(<?php echo json_encode($row); ?>)' style="color: #ef4444">
                                                <i class="fas fa-trash-alt"></i> Delete Project
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <!-- Footer -->

    </div>
    
    <?php include('modal/repo_project.modal.php');?>
    <!-- Delete Project Modal -->
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" role="dialog" aria-labelledby="deleteProjectModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteProjectModalLabel">Delete Project</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete the project <strong id="deleteProjectTitle"></strong>?</p>
            <input type="hidden" id="deleteProjectID" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteProject">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <?php include('include/footer.php');?>

    <script src="assets/js/lib/data-table/jquery.dataTables.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/lib/data-table/dataTables.buttons.min.js"></script>
    <script src="assets/js/lib/data-table/jszip.min.js"></script>
    <script src="assets/js/lib/data-table/pdfmake.min.js"></script>
    <script src="assets/js/lib/data-table/vfs_fonts.js"></script>
    <script src="assets/js/lib/data-table/buttons.html5.min.js"></script>
    <script src="assets/js/lib/data-table/buttons.print.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#projects_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'CSV'
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel'
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF'
                },
                {
                    extend: 'print',
                    text: 'Print'
                }
            ]
        });
    });

    $(document).on('click', '.dropdown-menu .dropdown-item', function(e) {
        e.preventDefault();
    });

    window.editProject = function(project) {
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
        $('#editSectors').val(project.sectors);
        $('#editSdgAddressed').val(project.SDGAddressed);
        $('#editProjectAbstract').val(project.ProjectAbstract);
        $('#editFundedBy').val(project.FundedBy);
        $('#editFacilitatedBy').val(project.FacilitatedBy);
        $('#editStatus').val(project.Status);
        // Show the modal
        var modal = new bootstrap.Modal(document.getElementById('editProjectModal'));
        modal.show();
    }

    window.viewProject = function(project) {
        // Implement your view modal logic here
        alert('View Project: ' + project.ProjectTitle);
    }

    window.deleteProject = function(project) {
        $('#deleteProjectID').val(project.ProjectID);
        $('#deleteProjectTitle').text(project.ProjectTitle);
        var modal = new bootstrap.Modal(document.getElementById('deleteProjectModal'));
        modal.show();
    }

    $('#confirmDeleteProject').on('click', function() {
        var projectID = $('#deleteProjectID').val();
        $.ajax({
            url: 'function/repo.projects.delete.php',
            method: 'POST',
            data: { projectID: projectID },
            success: function(response) {
                // Optionally show a toast or alert
                location.reload();
            },
            error: function() {
                alert('Failed to delete project.');
            }
        });
    });
    </script>


</body>

</html>