<?php
session_start();
require('../../model/database.php');
require('../../model/user.php');
require('../../model/department.php');
require('../../model/pay.php');
require('../../model/employee.php');


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


if (isset($_GET['emp_id']) && ($_GET['pay_id'])) {
    $emp_id = ($_GET["emp_id"]);
    $pay_id = ($_GET["pay_id"]);
}

$database = new DBHandler();
$user = new user();

$user_Identification = $_SESSION['email'];

$usr = new user();
$getID = $usr->getEmployeeID($user_Identification);
$user_id = $getID[0]['user_id'];



$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];
$emp_id = $row['emp_id'];
$department_id = $row['department'];


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
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>Employee ID : <?php echo $emp_id; ?></b></td>
                                            <td><b>Name : <?php echo $empName; ?></b></td>

                                        <tr>
                                            <td><b>Surname : <?php echo $empSurname; ?></b></td>

                                            <td><b>Employment Type : <?php echo $empType; ?></b></td>

                                        </tr>
                                        <tr>
                                            <td><b>Department : <?php
                                                                $dept = new department();
                                                                $deptName = $dept->getDeptName($empDept);
                                                                echo $deptName[0]['departmentName'] . ' Unit';
                                                                ?></b></td>
                                            <td>Post Occupy : <?php echo $empPosition; ?></td>

                                            </td>
                                        </tr>
                                        <tr>

                                            <td><b>Month : <?php echo $month; ?></b></td>
                                            <td> Year : <?php echo $year; ?></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>



                            <div class="container">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><b>Earnings</b></th>
                                            <th><b>Amount(Rs)</b></th>
                                            <th><b>Deductions</b></th>
                                            <th><b>Amount(Rs)</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Basic Salary</td>
                                            <td><?php echo $basic_salary; ?></td>
                                            <td class="deductions-column">Medical Contribution</td>
                                            <td><?php echo $medical_contri; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Overtime</td>
                                            <td><?php echo $overtime; ?></td>
                                            <td class="deductions-column">CSG Contribution</td>
                                            <td><?php echo $csg_contri; ?></td>
                                        </tr>

                                        <tr>
                                            <td>Bus Fare</td>
                                            <td><?php echo $bus_fare; ?></td>
                                            <td class="deductions-column">NSF Contribution</td>
                                            <td><?php echo $nsf_contri; ?></td>
                                        </tr>

                                    </tbody>
                                </table>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th><b>Gross Pay(Rs)</b></th>
                                            <th><b>Deductions(Rs)</b></th>
                                            <th><b>Net Pay(Rs)</b></th>
                                        </tr>
                                    <tbody>
                                        <tr>
                                            <td><?php echo $gross_pay; ?></td>
                                            <td><?php echo $deductions; ?></td>
                                            <td class="deductions-column"><?php echo $net_pay; ?></td>

                                        </tr>
                                    </tbody>


                                </table>


                            </div>

                            <hr>

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