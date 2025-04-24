<!doctype html>
<html>

<head>
    <?php include('../function/db.php');
    
    
function checkSession($timeout = 3600) {
    session_start();

    // Check if user is not logged in or session is expired
    if (!isset($_SESSION['isLogin']) || 
        !isset($_SESSION['userId_code']) || 
        !isset($_SESSION['last_activity']) || 
        (time() - $_SESSION['last_activity'] > $timeout)) {
        
        // Destroy session and redirect to login page
        session_destroy();
        header("Location: ../login.php");
        exit();
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();
}


?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SERDAC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" href="../assets/images/serdac.ico">
    <link rel="shortcut icon" href="../assets/images/serdac.ico">
    <link rel="icon" type="image/x-icon" href="../assets/images/serdac.ico">

    <?php include('include/css_cdn.php');?>

    <!-- jQuery first, then other scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/34fuma3udsijpij954yigoo4813n2ue4218jx2x7lel162dk/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<link rel="stylesheet" href="css/custom.button.css">
<link rel="stylesheet" href="css/modal.css">
<style>
#weatherWidget .currentDesc {
    color: #ffffff !important;
}

.traffic-chart {
    min-height: 335px;
}

#flotPie1 {
    height: 150px;
}

#flotPie1 td {
    padding: 3px;
}

#flotPie1 table {
    top: 20px !important;
    right: -10px !important;
}

.chart-container {
    display: table;
    min-width: 270px;
    text-align: left;
    padding-top: 10px;
    padding-bottom: 10px;
}

#flotLine5 {
    height: 105px;
}

#flotBarChart {
    height: 150px;
}

#cellPaiChart {
    height: 160px;
}
</style>

<script>
function formatDate(dateStr) {
    if (!dateStr) return ''; // return empty string if no date provided

    const dateObj = new Date(dateStr);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    };
    return dateObj.toLocaleDateString('en-US', options);
}
</script>