<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/employee.php');
require('../../model/user.php');
require('../../model/pay.php');

// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Employee' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Employee' && $isActive == 1) {
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



$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];
$emp_id = $row['emp_id'];
$department_id = $row['department'];





//$emp_id = "EMP0001";

$database = new DBHandler();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}

$limit = 10;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$supervisor_id = $emp_id;

$result = mysqli_query($conn, "SELECT * FROM tbl_pay WHERE emp_id='$emp_id' ORDER BY pay_id ASC LIMIT $start_from, $limit");



// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(pay_id) FROM tbl_pay WHERE emp_id='$emp_id'");
if (!$result_db) {
    die('Error in SQL query: ' . mysqli_error($conn));
}

$row_db = mysqli_fetch_row($result_db);

if ($row_db) {
    // Rows found
    $total_records = $row_db[0];
    $total_pages = ceil($total_records / $limit);
} else {
    // No rows found
    $total_records = 0;
    $total_pages = 0;
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

$getName = new department();

$deptNameArray = $getName->getDepartmentName($empDept);

if (!empty($deptNameArray)) {
    $deptName = $deptNameArray[0]['departmentName'];
    $deptSupervisor = $deptNameArray[0]['departmentSupervisor'];
}






$getPay = new pay();


$count1 = $getPay->count_earnings_emp($emp_id);
$count2 =  $getPay->count_deductions_emp($emp_id);
$count3 =  $getPay->count_netPay_emp($emp_id);
$count4 =  $getPay->count_csg_emp($emp_id);

?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/empNavBar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/empTopBar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>PaySlip Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 blue1_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-vault"></i>

                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no">Rs <?php echo $count1; ?></p>
                                                <p class="head_couter">Total Earnings</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-hand-holding-dollar"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no">Rs <?php echo $count2; ?></p>
                                                <p class="head_couter">Total Deductions</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 green_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-money-bill-transfer"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no">Rs <?php echo $count3; ?></p>
                                                <p class="head_couter">Total Net Pay</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-people-arrows"></i>
                                            </div>
                                        </div>

                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no">Rs <?php echo $count4; ?></p>
                                                <p class="head_couter">Total CSG Contributuion</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>


                            <div class="full margin_bottom_30"></div>


                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>Employee PaySlip - <?php echo $empName . " " . $empSurname; ?> </h2>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="search-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                        <input id="myInput" type="text" onkeyup="mySearch()" class="form-control" placeholder="Search.." aria-label="Search" aria-describedby="search-addon">
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-sm" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th># Pay No</th>
                                                    <th>Name</th>
                                                    <th onclick="sortTable(1)" scope="col">Month<i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                    <th>Year</th>
                                                    <th>Status</th>
                                                    <th>Payslip</th>




                                                </tr>
                                            </thead>


                                            <?php if (mysqli_num_rows($result) > 0) : ?>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_assoc($result)) :

                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['pay_id']; ?></td>

                                                            <td><?php echo $empName . " " . $empSurname; ?></td>
                                                            <td><?php echo $row['month']; ?></td>
                                                            <td><?php echo $row['year']; ?></td>
                                                            <td><?php $row['pay_status'];

                                                                if (!empty($row['pay_status']) && isset($row['pay_status'])) {
                                                                    switch ($row['pay_status']) {
                                                                        case 'Complete':
                                                                            echo "<span class='badge bg-success text-white'>Completed</span>";
                                                                            break;
                                                                        default:
                                                                            echo "<span class='badge bg-danger text-white'>Not Created</span>";
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "<span class='badge bg-danger text-white'>Status Not Available</span>";
                                                                }
                                                                ?>

                                                            </td>
                                                            <td> <a class="btn btn-success" href="view_pay_emp.php?action=update&pay_id=<?= $row['pay_id'] ?>&emp_id=<?= $row['emp_id'] ?>">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a></td>


                                                        </tr>
                                                    <?php endwhile; ?>
                                                </tbody>
                                            <?php else : ?>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="10">No records found.</td>
                                                    </tr>
                                                </tbody>
                                            <?php endif; ?>
                                        </table>
                                    </div>

                                    <nav aria-label="Page navigation">
                                        <ul class="pagination justify-content-center">
                                            <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                if ($i === (int)$page) {
                                                    // Highlight the active page link with the "active" class
                                                    echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                } else {
                                                    echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </nav>
                                </div>
                            </div>













                            <!-- footer -->
                            <?php include '../../components/footer.php'; ?>
</body>

<script>
    // Function to calculate and update leave duration
    function updateLeaveDuration() {
        // Get the start date and end date values
        var startDate = new Date(document.getElementById('start_date').value);
        var endDate = new Date(document.getElementById('end_date').value);

        // Check if end date is greater than or equal to start date
        if (endDate < startDate) {
            // Display an error message (you can customize this part)
            alert("End date must be greater than or equal to start date");
            return; // Exit the function
        }

        // Calculate the difference in days
        var timeDifference = endDate - startDate;
        var leaveDays = Math.ceil(timeDifference / (1000 * 3600 * 24));

        // Update the span and hidden input fields
        document.getElementById('leaveDuration').innerText = leaveDays + ' days';
        document.getElementById('leave_duration').value = leaveDays;
    }

    // Function to update leave duration before form submission
    function updateLeaveDurationOnSubmit() {
        updateLeaveDuration(); // Update duration one more time before submission

        // Add additional checks or actions before form submission if needed

        document.forms["leaveForm"].submit(); // Submit the form
    }
</script>





<!-- JavaScript function to print modal content -->
<script>
    document.getElementById("btnPrint").onclick = function() {
        printElement(document.getElementById("printThis"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>





<script>
    $(function() {
        $("#monthPicker").datepicker({
            dateFormat: 'mm/yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    });
</script>
<style>
    /* Your regular styles here */
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

</html>