<?php include('include/header.php')?>
<link rel="stylesheet" href="css/project_mngmt.css">

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
                    <table>
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
                                    <div class="actions-dropdown">
                                        <button class="btn btn-outline" onclick="toggleDropdown(this)">
                                            Actions
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"
                                                onclick="viewProject(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                <i class="fas fa-eye" style="color: var(--primary-color)"></i>
                                                View Project
                                            </a>
                                            <a class="dropdown-item" href="#"
                                                onclick="editProject(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                <i class="fas fa-pen" style="color: #eab308"></i>
                                                Edit Project
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#"
                                                onclick="deleteProject(<?php echo htmlspecialchars(json_encode($row)); ?>)"
                                                style="color: #ef4444">
                                                <i class="fas fa-trash-alt"></i>
                                                Delete Project
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