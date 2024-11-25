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

//Connection to PhpMyadmin database
$conn = mysqli_connect("localhost", "root", "", "");
if (!empty($_FILES)) {
    // Validating SQL file type by extensions
    if (!in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql"
    ))) {
        $response = array(
            "type" => "error",
            "message" => "Invalid File Type , only SQL format is valid!"
        );
    } else {
        if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
            $response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
        }
    }
}

//Function that takes input fo .SQL file as extention to restore the database using Web based API
function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';

    if (file_exists($filePath)) {
        $lines = file($filePath);

        foreach ($lines as $line) {

            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $sql .= $line;

            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach

        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
        exec('rm ' . $filePath);
    } // end if file exists

    return $response;
}




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
                                <div class="container">
                                    <div class="row column1">
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="card shadow">
                                                <center>
                                                    <img src="../../assets/logo/restore.png" class="card-img-top" alt="" style="width: 100px; height: 100px; padding-top: 10px;">
                                                </center>
                                                <div class="card-body">
                                                    <center>
                                                        <b>
                                                            <h5 class="card-title">Restore SQL Database system</h5>
                                                        </b>
                                                    </center>
                                                    <?php if (!empty($response)) : ?>
                                                        <div class="response <?php echo $response["type"]; ?>">
                                                            <?php echo nl2br($response["message"]); ?>
                                                        </div>
                                                    <?php endif; ?>
                                                    <form method="post" action="" enctype="multipart/form-data" id="frm-restore">
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <center>Choose Backup File (.SQL Format)</center>
                                                            </div>
                                                            <div class="col">
                                                                <center><input type="file" name="backup_file" class="btn btn-info" /></center>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="form-row">
                                                            <div class="col">
                                                                <center><input type="submit" name="restore" value="Restore" class="btn btn-primary" /></center>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
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