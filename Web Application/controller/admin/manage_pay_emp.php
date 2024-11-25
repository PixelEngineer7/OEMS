<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pms.php');
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


if (isset($_GET['emp_id'])) {
    $emp_id = ($_GET["emp_id"]);
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

$limit = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

$result = mysqli_query($conn, "SELECT * FROM tbl_pay WHERE emp_id='$emp_id' ORDER BY emp_id ASC LIMIT $start_from, $limit");

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
$empBasicSalary = $empFull["basic_salary"];

$getName = new department();

$deptNameArray = $getName->getDepartmentName($empDept);

if (!empty($deptNameArray)) {
    $deptName = $deptNameArray[0]['departmentName'];
    $deptSupervisor = $deptNameArray[0]['departmentSupervisor'];
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
$sqlPay = "SELECT * FROM tbl_pay WHERE emp_id='$emp_id'";
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
                                    <h2>Payroll Management</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->

                            <div class="col-lg-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Employee Monthly Net Pay Trends</h2>
                                        </div>
                                    </div>
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <div class="chart_section padding_infor_info">
                                        <canvas id="netPayLineChart"></canvas>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Assuming you have a PHP array named $payData containing the pay information
                                            const payData = <?php echo json_encode($payData); ?>;

                                            // Extract unique months from the pay data
                                            const uniqueMonths = [...new Set(payData.map(entry => entry.month))];

                                            // Create an array with all 12 months
                                            const allMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                                            // Ensure all 12 months are in the labels array
                                            const labels = allMonths.map(month => uniqueMonths.includes(month) ? month : '');

                                            const ctxNetPayLineChart = document.getElementById('netPayLineChart').getContext('2d');
                                            if (ctxNetPayLineChart) {
                                                new Chart(ctxNetPayLineChart, {
                                                    type: 'line', // Use 'line' for line chart
                                                    data: {
                                                        labels: labels,
                                                        datasets: payData.map(entry => ({
                                                            label: `Employee ${entry.emp_id}`,
                                                            data: allMonths.map(month => {
                                                                const empData = payData.find(e => e.emp_id === entry.emp_id && e.month === month);
                                                                return empData ? empData.net_pay : 0;
                                                            }),
                                                            borderColor: getRandomColor(), // Custom function to generate random colors
                                                            fill: false
                                                        }))
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        title: {
                                                            display: true,
                                                            text: 'Net Pay Overview'
                                                        },
                                                        scales: {
                                                            x: {
                                                                title: {
                                                                    display: true,
                                                                    text: 'Month'
                                                                }
                                                            },
                                                            y: {
                                                                title: {
                                                                    display: true,
                                                                    text: 'Net Pay ($)'
                                                                },
                                                                beginAtZero: true
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                console.error("Canvas element with ID 'netPayLineChart' not found.");
                                            }

                                            // Function to generate a random color
                                            function getRandomColor() {
                                                const letters = '0123456789ABCDEF';
                                                let color = '#';
                                                for (let i = 0; i < 6; i++) {
                                                    color += letters[Math.floor(Math.random() * 16)];
                                                }
                                                return color;
                                            }
                                        });
                                    </script>
                                </div>
                            </div>

                            <!-- Buttons Cards Panel-->
                            <div class="col-md-12 margin_bottom_30">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                            <div class="card-body">
                                                <h5 class="card-title">Create Payslip</h5>
                                                <p class="card-text">Create Payslip for Employee</p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPayModal<?php echo $emp_id; ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Create
                                                </button>

                                                <!-- Create PMS Modal -->
                                                <div class="modal fade" id="createPayModal<?php echo $emp_id;   ?>" tabindex="-1" role="dialog" aria-labelledby="createPayModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?php echo $emp_id ?>">Create Payslip for Employee </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form to Create PMS details -->
                                                                <form method="post" action="../../controller/admin/create_pay_emp.php">
                                                                    <!-- Populate form fields with current employee data -->
                                                                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                                    <input type="hidden" name="basic_salary" value="<?php echo $empBasicSalary; ?>">

                                                                    <label for="content"><b><u>Pay Period</u></b></label>
                                                                    <br>
                                                                    <strong>
                                                                        All amount are in Mauritian Rupees(Mur) / Rs.
                                                                    </strong>
                                                                    <br>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="month">Month</label>
                                                                            <select class="form-control" name="month">
                                                                                <option value="January" selected>January</option>
                                                                                <option value="February">February</option>
                                                                                <option value="March">March</option>
                                                                                <option value="April">April</option>
                                                                                <option value="May">May</option>
                                                                                <option value="June">June</option>
                                                                                <option value="July">July</option>
                                                                                <option value="August">August</option>
                                                                                <option value="September">September</option>
                                                                                <option value="October">October</option>
                                                                                <option value="November">November</option>
                                                                                <option value="December">December</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="year">Year</label>
                                                                            <select class="form-control" name="year">
                                                                                <?php
                                                                                // Assuming you want to generate options for the years dynamically, e.g., from current year to 5 years ahead
                                                                                $currentYear = date("Y");
                                                                                $endYear = $currentYear + 5;

                                                                                for ($year = $currentYear; $year <= $endYear; $year++) {
                                                                                    echo "<option value=\"$year\">$year</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <label for="content"><b><u>Earnings</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="basic_salary">Basic Salary</label>
                                                                            <input type="text" class="form-control" value="Rs. <?php echo $empBasicSalary; ?>" readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="overtime">Overtime</label>
                                                                            <input type="text" class="form-control" name="overtime" id="overtime" placeholder="Enter overtime" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="bus_fare">Bus Fare</label>
                                                                            <input type="text" class="form-control" name="bus_fare" id="bus_fare" placeholder="Enter bus fare" required>
                                                                        </div>

                                                                    </div>
                                                                    <label for="content"><b><u>Deductions</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="csg_contri">CSG Contribution</label>
                                                                            <input type="text" class="form-control" name="csg_contri" id="csg_contri" value="<?php echo 0.015 * $empBasicSalary; ?>" readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="medical_contri">Medical Contribution</label>
                                                                            <input type="text" class="form-control" name="medical_contri" id="medical_contri" value="<?php echo 0.01 * $empBasicSalary; ?>" readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="nsf_contri">NSF Contribution</label>
                                                                            <input type="text" class="form-control" name="nsf_contri" id="nsf_contri" value="<?php echo 0.0094 * $empBasicSalary; ?>" readonly>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b><u>Overall Pay Information</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="gross_pay">Gross Pay</label>
                                                                            <input type="text" class="form-control" name="gross_pay" id="gross_pay" readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="deduction">Deductions</label>
                                                                            <input type="text" class="form-control" name="deduction" id="deduction" readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="net_pay">Net Pay</label>
                                                                            <input type="text" class="form-control" name="net_pay" id="net_pay" readonly>
                                                                        </div>

                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success" name="create_pay">Save Changes</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md margin_bottom_60">

                                <!-- Modifications section -->

                                <div class="white_shd text-center pt-3">
                                    <h4 class="pt-3"><u>Employee : <?php echo $empName . " " . $empSurname; ?> Details</u></h4>

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
                                                                        ?> Unit
                                            </div>
                                            <hr>

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



<!-- JavaScript function to print modal content -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to calculate Gross Pay
        function calculateGrossPay() {
            var basicSalary = parseFloat(<?php echo $empBasicSalary; ?>);
            var overtime = parseFloat(document.getElementsByName('overtime')[0].value) || 0;
            var busFare = parseFloat(document.getElementsByName('bus_fare')[0].value) || 0;

            var grossPay = basicSalary + overtime + busFare;
            document.getElementById('gross_pay').value = grossPay.toFixed(2);
        }

        // Attach the calculateGrossPay function to input events
        document.getElementsByName('overtime')[0].addEventListener('input', calculateGrossPay);
        document.getElementsByName('bus_fare')[0].addEventListener('input', calculateGrossPay);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to calculate Deductions
        function calculateDeduction() {
            var medical_contri = parseFloat(document.getElementById('medical_contri').value) || 0;
            var csg_contri = parseFloat(document.getElementById('csg_contri').value) || 0;
            var nsf_contri = parseFloat(document.getElementById('nsf_contri').value) || 0;

            var deduction = medical_contri + csg_contri + nsf_contri;
            document.getElementById('deduction').value = deduction.toFixed(2);
        }

        // Attach the calculateDeduction function to input events
        calculateDeduction(); // Initial calculation on page load
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to calculate Gross Pay
        function calculateNetPay() {

            var gross_pay = parseFloat(document.getElementsByName('gross_pay')[0].value) || 0;
            var deduction = parseFloat(document.getElementsByName('deduction')[0].value) || 0;

            var netPay = gross_pay - deduction;
            document.getElementById('net_pay').value = netPay.toFixed(2);
        }

        // Attach the calculateGrossPay function to input events
        document.getElementsByName('overtime')[0].addEventListener('input', calculateNetPay);
        document.getElementsByName('bus_fare')[0].addEventListener('input', calculateNetPay);
    });
</script>



</html>