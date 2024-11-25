<?php
//Name:RAMLOCHUND Gitendrajeet 
//Project: OEMS
//Scope: Administrator Dashboard

require('../../model/user.php');
require('../../model/department.php');
require('../../model/employee.php');
require('../../model/pms.php');

session_start();

// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Supervisor' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Supervisor' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT


$database = new DBHandler();
$user = new user();
if (isset($_GET['pms_id'], $_GET['emp_id']))
    $emp_id = $_SESSION['emp_id'] ?? $_GET["emp_id"];
$pms_id = $_SESSION['pms_id'] ?? $_GET["pms_id"];


$user_Identification = $_SESSION['email'];

$usr = new user();
$getID = $usr->getEmployeeID($user_Identification);
$user_id = $getID[0]['user_id'];

//Gets User logged in details
$database = new DBHandler();
$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];

//Retrieves all Details for the Employee using the emp_id
$database = new DBHandler();
$getEmpFull = new employee();
$empFull = $getEmpFull->getEmpFullDetails($emp_id);

$empName = $empFull["name"];
$empSurname = $empFull["surname"];
$empType = $empFull["role"];
$empDateJoined = $empFull["date_joined"];
$empPosition = $empFull["position"];
$empDept = $empFull["department"];

//Retrieves all PMS Details using the pms_id
$database = new DBHandler();
$getEmpPms = new pms();
$empPmsFull = $getEmpPms->getPMSEmployee($pms_id);

// Assuming $row['quarter_array'] is a JSON string
$quarterArray = json_decode($empPmsFull[0]['quarter_array'], true);
$kpaArray = json_decode($empPmsFull[0]['kpa_array'], true);
$kpiArray = json_decode($empPmsFull[0]['kpi_array'], true);
$objectiveArray = json_decode($empPmsFull[0]['objective_array'], true);
$metricArray = json_decode($empPmsFull[0]['metric_array'], true);
$scoreArray = json_decode($empPmsFull[0]['score_array'], true);


// Check if decoding was successful
if ($quarterArray !== null) {
    // Access individual elements of the array
    $pmsQuarter = $quarterArray[0];
    $date = $quarterArray[1];
    $pmsYear = substr($date, 0, 4);
}
// Check if decoding was successful
if ($kpaArray !== null) {
    // Access individual elements of the array
    $kpa1 = $kpaArray[0];
    $kpa2 = $kpaArray[1];
    $kpa3 = $kpaArray[2];
    $kpa4 = $kpaArray[3];
}
// Check if decoding was successful
if ($kpiArray !== null) {
    // Access individual elements of the array
    $kpi1 = $kpiArray[0];
    $kpi2 = $kpiArray[1];
    $kpi3 = $kpiArray[2];
    $kpi4 = $kpiArray[3];
}
// Check if decoding was successful
if ($objectiveArray !== null) {
    // Access individual elements of the array
    $obj1 = $objectiveArray[0];
    $obj2 = $objectiveArray[1];
    $obj3 = $objectiveArray[2];
    $obj4 = $objectiveArray[3];
}

if ($metricArray !== null) {
    // Access individual elements of the array
    $metrics1 = $metricArray[0];
    $metrics2 = $metricArray[1];
    $metrics3 = $metricArray[2];
    $metrics4 = $metricArray[3];
}

if ($scoreArray !== null) {
    // Access individual elements of the array
    $score1 = $scoreArray[0];
    $score2 = $scoreArray[1];
    $score3 = $scoreArray[2];
    $score4 = $scoreArray[3];

    $avgScore = ($score1 + $score2 + $score3 + $score4) / 4;
}








?>
<!DOCTYPE html>
<html lang="en">
<!-- Components Header  -->
<?php include '../../components/header.php'; ?>
<!-- End of Header  -->

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/supNavBar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/supTopBar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Employee Performance Management System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Modifications section -->
                            <div class="col-md margin_bottom_60">
                                <div class="white_shd text-center pt-3">
                                    <h4 class="pt-3"><u>Performance Management System -<?php echo $empName . " " . $empSurname; ?> Metrics</u></h4>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <b>Employee ID : </b> <?php echo $emp_id; ?>
                                            </div>
                                            <div class="col">
                                                <b>Name : </b> <?php echo $empName; ?>
                                            </div>
                                            <div class="col">
                                                <b>Surname : </b> <?php echo $empSurname; ?>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <b>Employment Type : </b> <?php echo $empType; ?>
                                            </div>
                                            <div class="col">
                                                <b>Date Joined Company : </b> <?php echo $empDateJoined; ?>
                                            </div>
                                            <div class="col">
                                                <b>Post Occupy : </b><?php echo $empPosition; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>

                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <b>Department : </b> <?php
                                                                        $dept = new department();
                                                                        $deptName = $dept->getDeptName($empDept);
                                                                        echo  $deptName[0]['departmentName'];
                                                                        ?>
                                            </div>
                                            <div class="col">
                                                <b>PMS Quater : </b> <?php echo $pmsQuarter; ?>
                                            </div>
                                            <div class="col">
                                                <b>PMS Year : </b> <?php echo $pmsYear; ?>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="container">
                                        <div class="row">
                                            <div class="col">
                                                <h5>Employee PMS Score : </h5> <?php if (empty($avgScore)) {
                                                                                    echo "Not available";
                                                                                } else {
                                                                                    echo $avgScore;
                                                                                } ?>
                                            </div>
                                            <div class="col">
                                                <h5>Employee PMS Result : </h5> <?php
                                                                                if (empty($avgScore)) {
                                                                                    echo "Not available";
                                                                                } else
                                                                                    switch (true) {
                                                                                        case ($avgScore > 30):
                                                                                            echo "Far Exceeded";
                                                                                            break;

                                                                                        case ($avgScore >= 21 && $avgScore <= 29):
                                                                                            echo "Exceeded";
                                                                                            break;

                                                                                        case ($avgScore >= 16 && $avgScore <= 20):
                                                                                            echo "Met";
                                                                                            break;

                                                                                        case ($avgScore >= 1 && $avgScore <= 15):
                                                                                            echo "Nearly There";
                                                                                            break;

                                                                                        case ($avgScore == 0):
                                                                                            echo "Did not achieve";
                                                                                            break;

                                                                                        default:
                                                                                            echo "Invalid Score"; // Handle any other cases if needed
                                                                                            break;
                                                                                    }
                                                                                ?>
                                            </div>

                                        </div>

                                    </div>
                                    <hr>
                                </div>
                            </div>
                            <!-- Modification section Ends-->
                            <!-- Modifications section -->
                            <div class="col-md margin_bottom_60">
                                <div class="white_shd text-center pt-3">
                                    <h4 class="pt-3">Objectives Details</h4>

                                    <!-- Table Example -->
                                    <div class="table-responsive">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left;">Key Performance Areas</th>
                                                    <th style="text-align: left;">Objectives</th>
                                                    <th style="text-align: left;">Key Performance Indicators</th>
                                                    <th style="text-align: left;">Metrics</th>
                                                    <th style="text-align: left;">Score</th>





                                                    <!-- Add more columns as needed -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $emp_id; ?><tr>
                                                    <td style="text-align: left;"><?php echo $kpa1; ?></td>
                                                    <td style="text-align: left;"><?php echo $obj1; ?></td>
                                                    <td style="text-align: left;"><?php echo $kpi1; ?></td>
                                                    <td style="text-align: left;"><?php if (empty($metrics1)) {
                                                                                        echo "Pending Input by Employee";
                                                                                    } else {
                                                                                        echo $metrics1;
                                                                                    } ?></td>
                                                    <td style="text-align: left;"><?php if (empty($score1)) {
                                                                                        echo "Not available";
                                                                                    } else {
                                                                                        echo $score1;
                                                                                    } ?></td>
                                                    <!-- Add more cells as needed -->
                                                </tr>

                                                <tr>
                                                    <td style="text-align: left;"><?php echo $kpa2; ?></td>
                                                    <td style="text-align: left;"><?php echo $obj2; ?></td>
                                                    <td style="text-align: left;"><?php echo $kpi2; ?></td>
                                                    <td style="text-align: left;"><?php if (empty($metrics2)) {
                                                                                        echo "Pending Input by Employee";
                                                                                    } else {
                                                                                        echo $metrics2;
                                                                                    } ?></td>
                                                    <td style="text-align: left;"><?php if (empty($score2)) {
                                                                                        echo "Not available";
                                                                                    } else {
                                                                                        echo $score2;
                                                                                    } ?></td>
                                                    <!-- Add more cells as needed -->
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><?php echo $kpa3; ?></td>
                                                    <td style="text-align: left;"><?php echo $obj3; ?></td>
                                                    <td style="text-align: left;"><?php echo $kpi3; ?></td>
                                                    <td style="text-align: left;"><?php if (empty($metrics3)) {
                                                                                        echo "Pending Input by Employee";
                                                                                    } else {
                                                                                        echo $metrics3;
                                                                                    } ?></td>
                                                    <td style="text-align: left;"><?php if (empty($score3)) {
                                                                                        echo "Not available";
                                                                                    } else {
                                                                                        echo $score3;
                                                                                    } ?></td>
                                                    <!-- Add more cells as needed -->
                                                </tr>
                                                <tr>
                                                    <td style="text-align: left;"><?php echo $kpa4; ?></td>
                                                    <td style="text-align: left;"><?php echo $obj4; ?></td>
                                                    <td style="text-align: left;"><?php echo $kpi4; ?></td>
                                                    <td style="text-align: left;"><?php if (empty($metrics4)) {
                                                                                        echo "Pending Input by Employee";
                                                                                    } else {
                                                                                        echo $metrics4;
                                                                                    } ?></td>
                                                    <td style="text-align: left;"><?php if (empty($score4)) {
                                                                                        echo "Not available";
                                                                                    } else {
                                                                                        echo $score4;
                                                                                    } ?></td>
                                                    <!-- Add more cells as needed -->
                                                </tr>

                                                <!-- Add more rows as needed -->
                                            </tbody>
                                        </table>




                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modification section Ends-->





                    </div>
                </div>
















                <!-- footer -->
                <?php include '../../components/footer.php'; ?>
</body>
<script>
    <?php
    if (isset($_SESSION['updateMetric'])) {
        unset($_SESSION['updateMetric']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "PMS Metrics Created successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "pmsDashboard.php";
            }
        });
        ';
    }
    ?>
</script>

</html>