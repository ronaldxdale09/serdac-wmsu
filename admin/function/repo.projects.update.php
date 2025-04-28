<?php
include('../../function/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['projectID'])) {
    $projectID = intval($_POST['projectID']);
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

    $sql = "UPDATE repo_projects SET ProgramTitle=?, ProjectTitle=?, ProjectLeader=?, ProjectLeaderSex=?, ProjectLeaderAgency=?, ProjectLeaderContact=?, CooperatingAgencies=?, ImplementingAgency=?, ImplementingAgencyAddress=?, BaseStation=?, OtherImplementationSites=?, ProjectDurationStart=?, ProjectDurationEnd=?, ExtensionDate=?, ProjectCost=?, sectors=?, SDGAddressed=?, ProjectAbstract=?, FundedBy=?, FacilitatedBy=?, Status=? WHERE ProjectID=?";
    $stmt = $con->prepare($sql);

    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . htmlspecialchars($con->error)]);
        exit();
    }

    $stmt->bind_param("ssssssssssssssdssssssi", $programTitle, $projectTitle, $projectLeader, $projectLeaderSex, $projectLeaderAgency, $projectLeaderContact, $cooperatingAgencies, $implementingAgency, $implementingAgencyAddress, $baseStation, $otherImplementationSites, $startDate, $endDate, $extensionDate, $projectCost, $sectors, $sdgAddressed, $projectAbstract, $fundedBy, $facilitatedBy, $status, $projectID);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Project updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Update failed: ' . htmlspecialchars($stmt->error)]);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
