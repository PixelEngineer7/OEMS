<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/employee.php');
require('../../model/user.php');
require('../../model/task.php');



// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Administrator' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Administrator' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT

$database = new DBHandler();
$user = new user();

$user_Identification = $_SESSION['email'];

$usr = new user();
$getID = $usr->getEmployeeID($user_Identification);
$user_id = $getID[0]['user_id'];



?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/navbar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/topbar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Backup and Restore System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="container">
                                <div class="row column1">
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <center><img src="../../assets/logo/backup.png" class="card-img-top" alt="" style="width: 100px; height:100px; padding-top:10px;"></center>
                                            <div class="card-body">
                                                <center>
                                                    <h5 class="card-title">Backup SQL Database system</h5>
                                                </center>
                                                <center>
                                                    <p class="card-text">Generate a backup of the database</p>
                                                </center>
                                            </div>
                                            <div class="card-footer">
                                                <center><button type="button" class="btn btn-success" onclick="javascript:window.location='../../controller/exports/backupSQL.php';">Generate SQL Backup</button></center>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4 mb-4">
                                        <div class="card h-100">
                                            <center><img src="../../assets/logo/restore.png" class="card-img-top" alt="" style="width: 100px; height: 100px;padding-top:10px;"></center>
                                            <div class="card-body">
                                                <center>
                                                    <h5 class="card-title">Restore SQL Database system</h5>
                                                </center>
                                                <center>
                                                    <p class="card-text">Restore database of the system</p>
                                                </center>
                                            </div>
                                            <div class="card-footer">
                                                <center><button type="button" class="btn btn-info" onclick="javascript:window.location='restore.php';">Restore Database</button></center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="full margin_bottom_30"></div>
                            <div class="full margin_bottom_30"></div>
                            <div class="full margin_bottom_30"></div>
                            <div class="full margin_bottom_30"></div>
                            <div class="full margin_bottom_30"></div>
                            <div class="full margin_bottom_30"></div>






















                            <!-- footer -->
                            <?php include '../../components/footer.php'; ?>
</body>


<script>
    <?php
    if (isset($_SESSION['createTask'])) {
        unset($_SESSION['createTask']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Task Created and assigned successfully!",
        })
    ';
    }
    ?>
</script>
<!-- JavaScript function to print modal content -->

</html>