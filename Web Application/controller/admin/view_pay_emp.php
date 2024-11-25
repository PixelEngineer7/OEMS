<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pay.php');
require('../../model/employee.php');
require('../../model/user.php');


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


if (isset($_GET['emp_id']) && ($_GET['pay_id'])) {
    $emp_id = ($_GET["emp_id"]);
    $pay_id = ($_GET["pay_id"]);
}

$database = new DBHandler();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}



// Your SQL statement to fetch pay data
$sqlPay = "SELECT * FROM tbl_pay";
$resultPay = $conn->query($sqlPay);

// Check if the query for pay data was successful
if ($resultPay) {
    $payData = [];
    while ($row = $resultPay->fetch_assoc()) {
        $netPay = is_numeric($row['net_pay']) ? $row['net_pay'] : 0;
        $payData[] = [
            'emp_id' => $row['emp_id'],
            'month' => $row['month'],
            'year' => $row['year'],
            'net_pay' => $netPay
            // Add more fields as needed
        ];
    }

    // Free the result set
    $resultPay->free();
} else {
    // Handle query error for pay data
    echo "Error: " . $sqlPay . "<br>" . $conn->error;
}

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
$empBasicSalary = $empFull["basic_salary"];

$getName = new department();

$deptNameArray = $getName->getDepartmentName($empDept);

if (!empty($deptNameArray)) {
    $deptName = $deptNameArray[0]['departmentName'];
    $deptSupervisor = $deptNameArray[0]['departmentSupervisor'];
}

$pay = new pay();
$empPay = $pay->getPaySlipEmp($pay_id);
$basic_salary = $empPay[0]["basic_salary"];
$year = $empPay[0]["year"];
$month = $empPay[0]["month"];
$bus_fare = $empPay[0]["bus_fare"];
$overtime = $empPay[0]["overtime"];
$medical_contri = $empPay[0]["medical_contri"];
$deductions = $empPay[0]["deductions"];
$nsf_contri = $empPay[0]["nsf_contri"];
$csg_contri = $empPay[0]["csg_contri"];
$gross_pay = ($basic_salary + $overtime + $bus_fare);
$net_pay = $empPay[0]["net_pay"];


?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>
<style>
    @media print {

        /* Apply specific styles for printing */
        body {
            columns: unset;
            /* Disable columns */
        }

        /* Adjust other styles as needed */
        .row {
            display: block;
        }

        /* Add more styles as needed */
    }
</style>

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
                                    <h1>Infinity Networks Pay Slip</h1>
                                </div>
                            </div>
                        </div>
                        <!-- row -->

                        <!-- Dashboard Notifications Panel-->
                        <div class="white_shd text-center pt-3">
                            <img src="../../assets/images/header.png" alt="Company Logo" width="175" height="100">
                            <h3 class="pt-3"><u>Infinity Networks Pay Slip</u></h3>
                            <br>

                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <b>Employee ID :</b> <?php echo $emp_id; ?>
                                    </div>
                                    <div class="col">
                                        <b>Name :</b> <?php echo $empName; ?>
                                    </div>
                                    <div class="col">
                                        <b>Surname :</b> <?php echo $empSurname; ?>
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
                                        <b>Department : </b> <?php
                                                                $dept = new department();
                                                                $deptName = $dept->getDeptName($empDept);
                                                                echo  $deptName[0]['departmentName'];
                                                                ?> Unit
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
                                        <b>Month :</b> <?php echo $month; ?>
                                    </div>
                                    <div class="col">
                                        <b>Year :</b> <?php echo $year; ?>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="container">
                                <div class="row">
                                    <!-- Earnings Section (Left Half) -->
                                    <div class="col-md-6 border-right">
                                        <h4><u>Earnings in MUR(Rs.)</u></h4>
                                        <br>
                                        <div class="form-group">
                                            <h6>Basic Salary: <?php echo $basic_salary; ?></h6>
                                        </div>
                                        <div class="form-group">
                                            <h6>Overtime: <?php echo $overtime; ?></h6>
                                        </div>
                                        <div class="form-group">
                                            <h6>Bus Fare: <?php echo $bus_fare; ?></h6>
                                        </div>
                                    </div>

                                    <!-- Deductions Section (Right Half) -->
                                    <div class="col-md-6">
                                        <div class="col-md-6">
                                            <h4><u>Deductions in MUR(Rs.)</u></h4>
                                            <br>
                                            <div class="form-group">
                                                <h6>Medical Contribution: <?php echo $medical_contri; ?></h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>CSG Contribution: <?php echo $csg_contri; ?></h6>
                                            </div>
                                            <div class="form-group">
                                                <h6>NSF Contribution: <?php echo $nsf_contri; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <h4><u>Gross Pay</u></h4>
                                        <h5><?php echo $gross_pay; ?></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h4><u>Deductions</u></h4>
                                        <h5><?php echo $deductions; ?></h5>
                                    </div>
                                    <div class="col-md-4">
                                        <h4><u>Net Pay</u></h4>
                                        <h5><?php echo $net_pay; ?></h5>
                                    </div>
                                </div>
                                <hr>

                                <!-- Print Button -->

                            </div>
                        </div>
                        <div class="row md-6">
                            <div class="col-md-12 mb-4">
                                <button onclick="print()" class="btn btn-primary">Print Payslip</button>
                            </div>
                        </div>



                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
</body>

</html>