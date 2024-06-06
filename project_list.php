<?php include('include/header.php');

?>
<link rel="stylesheet" href="css/profile.css">

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">

<body>
    <?php include('include/navbar.php');?>
    <!-- ***** Header Area End ***** -->
    <section class="heading-page header-text" id="top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>PROJECTS</h2>

                </div>
            </div>
        </div>
    </section>
    <section id="contact" class="contact">
        <div class="container" data-aos="fade-up">

            <div class="section-title">


            </div>

            <div class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <strong class="card-title">Project List</strong>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive custom-table-container">
                                    <?php
                                // Fetch data from the repo_projects table with only the required columns
                                $results = mysqli_query($con, "SELECT * FROM repo_projects");
                                ?>
                                    <table class="table table-hover" id="projects_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Project ID</th>
                                                <th scope="col">Project Title</th>
                                                <th scope="col">Project Leader</th>
                                                <th scope="col">Implementing Agency</th>
                                                <th scope="col">Start Date</th>
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
                                                <td><?php echo $row['ProjectTitle']; ?></td>
                                                <td><?php echo $row['ProjectLeader']; ?></td>
                                                <td><?php echo $row['ImplementingAgency']; ?></td>
                                                <td><?php echo $row['ProjectDurationStart']; ?></td>
                                                <td><?php echo $row['Status']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-dark btnEdit"
                                                        data-project='<?php echo json_encode($row); ?>'>
                                                        <i class="fa fa-eye"></i>
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

        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <?php include('modal/repo.project.php');?>
        <script>
        $(document).ready(function() {
        

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

    </section>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="asscripts/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <br>


    <?php include('include/footer.php');?>


</body>

</html>