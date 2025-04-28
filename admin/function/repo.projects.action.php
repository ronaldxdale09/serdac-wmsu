<?php
include('../../function/db.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $programTitle = $_POST['programTitle'];
    $projectTitle = $_POST['projectTitle'];
    $projectLeader = $_POST['projectLeader'];
    $projectLeaderSex = $_POST['projectLeaderSex'];
    $projectLeaderAgency = $_POST['projectLeaderAgency'];
    $projectLeaderContact = $_POST['projectLeaderContact'];
    $cooperatingAgencies = $_POST['cooperatingAgencies'];
    $implementingAgency = $_POST['implementingAgency'];
    $implementingAgencyAddress = $_POST['implementingAgencyAddress'];
    $baseStation = $_POST['baseStation'];
    $otherImplementationSites = $_POST['otherImplementationSites'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $extensionDate = $_POST['extensionDate'];
    $projectCost = $_POST['projectCost'];
    $sectors = $_POST['sectors'];
    $sdgAddressed = $_POST['sdgAddressed'];
    $projectAbstract = $_POST['projectAbstract'];
    $fundedBy = $_POST['fundedBy'];
    $facilitatedBy = $_POST['facilitatedBy'];
    $status = $_POST['status'];

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO repo_projects (ProgramTitle, ProjectTitle, ProjectLeader, ProjectLeaderSex, ProjectLeaderAgency, ProjectLeaderContact, CooperatingAgencies, ImplementingAgency, ImplementingAgencyAddress, BaseStation, OtherImplementationSites, ProjectDurationStart, ProjectDurationEnd, ExtensionDate, ProjectCost, sectors, SDGAddressed, ProjectAbstract, FundedBy, FacilitatedBy, Status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($con->error)]);
        exit();
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("ssssssssssssssdssssss", $programTitle, $projectTitle, $projectLeader, $projectLeaderSex, $projectLeaderAgency, $projectLeaderContact, $cooperatingAgencies, $implementingAgency, $implementingAgencyAddress, $baseStation, $otherImplementationSites, $startDate, $endDate, $extensionDate, $projectCost, $sectors, $sdgAddressed, $projectAbstract, $fundedBy, $facilitatedBy, $status);

    // Execute the statement
    if ($stmt->execute() === false) {
        echo json_encode(['success' => false, 'message' => 'Execute failed: ' . htmlspecialchars($stmt->error)]);
    } else {
        echo json_encode(['success' => true, 'message' => 'Project has been created successfully.']);

        // Log the activity
        $activity_type = 'project_creation';
        $activity_description = "Project created: $projectTitle";
        $user_id = 1; // Assuming 1 for the logged-in user, adjust based on your application context
       // log_activity($con, $user_id, $activity_type, $activity_description);
       header("Location: ../project_mngnt.php");

    }

    // Close the statement
    $stmt->close();
}
?>
