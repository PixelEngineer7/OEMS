<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pms.php');
require('../../model/employee.php');
require('../../model/balance.php');
require('../../model/leave.php');
require('../../model/user.php');
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

$result = mysqli_query($conn, "SELECT * FROM tbl_leave WHERE supervisor_id='$user_id' ORDER BY leave_id ASC LIMIT $start_from, $limit");

// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id) FROM tbl_leave WHERE supervisor_id='$user_id'");
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





$leave_bal = new balance();
$require_attention = new leave();
$bal_well  = $leave_bal->count_bal_well($emp_id);
$bal_sick = $leave_bal->count_bal_sick($emp_id);
$bal_vacation = $leave_bal->count_bal_vacation($emp_id);
$count4 = $require_attention->count_leave_emp_rejected($emp_id);

?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>

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
                                    <h2>Employee Leave Management Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-spa"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php if ($bal_well < 0)
                                                                        echo "0";
                                                                    else {
                                                                        echo $bal_well;
                                                                    } ?></p>
                                                <p class="head_couter">Balance Wellness </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-syringe"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php if ($bal_sick < 0)
                                                                        echo "0";
                                                                    else {
                                                                        echo $bal_sick;
                                                                    } ?></p>
                                                <p class="head_couter">Balance Sick</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 brown_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-plane-departure"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php if ($bal_vacation < 0)
                                                                        echo "0";
                                                                    else {
                                                                        echo $bal_vacation;
                                                                    } ?></p>
                                                <p class="head_couter">Balance Vacation</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 blue1_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle fa-beat fa-3x"></i>
                                            </div>
                                        </div>

                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php if ($count4 < 0)
                                                                        echo "0";
                                                                    else {
                                                                        echo $count4;
                                                                    } ?></p>
                                                <p class="head_couter">Require Attention</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>




                            </div>

                            <!-- Buttons Cards Panel-->
                            <div class="col-md-12 margin_bottom_30">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                            <div class="card-body">
                                                <h5 class="card-title">Create Leave</h5>
                                                <p class="card-text">Create Leave for Self</p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createLeaveModal<?php echo $emp_id; ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Create
                                                </button>



                                                <!-- Create PMS Modal -->
                                                <div class="modal fade" id="createLeaveModal<?php echo $emp_id;   ?>" tabindex="-1" role="dialog" aria-labelledby="createLeaveModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?php echo $emp_id ?>">Create Leave for Employee </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form to Create PMS details -->
                                                                <form method="post" action="../../controller/supervisor/create_leave_supervisor.php" id="leaveForm">
                                                                    <!-- Populate form fields with current employee data -->
                                                                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                                    <input type="hidden" name="supervisor_id" value="<?php echo $deptSupervisor; ?>">

                                                                    <label for="content"><b><u>Leave Type</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <select class="form-control" name="leave_type" id="leaveType">
                                                                                <option value="vacation">Vacation Leave</option>
                                                                                <option value="sick">Sick Leave</option>
                                                                                <option value="wellness">Wellness Leave</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Display balance -->
                                                                    <div class="balance" id="vacationBalance" style="display: none;">
                                                                        Vacation Leave Balance: <?php echo $bal_vacation; ?>
                                                                    </div>

                                                                    <div class="balance" id="sickBalance" style="display: none;">
                                                                        Sick Leave Balance: <?php echo $bal_sick; ?>
                                                                    </div>

                                                                    <div class="balance" id="wellnessBalance" style="display: none;">
                                                                        Wellness Leave Balance: <?php echo $bal_well; ?>
                                                                    </div>

                                                                    <br>



                                                                    <label for="content"><b>Select Start Date and End Date</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="start_date">Start Date</label>
                                                                            <input type="date" class="form-control" name="start_date" id="start_date" oninput="updateLeaveDuration()" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="end_date">End Date</label>
                                                                            <input type="date" class="form-control" name="end_date" id="end_date" oninput="updateLeaveDuration()" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b>Total Leave Duration</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="start_date">Duration: <span id="leaveDuration">0 days</span></label>
                                                                            <!-- Add a hidden input field to store the calculated duration -->
                                                                            <input type="hidden" name="leave_duration" id="leave_duration" value="0">
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b>Leave Reason</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <input type="text" class="form-control" name="leave_reason">
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success" name="leaveSubmit" id="leaveSubmitButton" onclick="updateLeaveDurationOnSubmit()">Save Changes</button>
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
                                        <br>
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
                                    <br>

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
                                        <h2>Leaves History of Employee under Supervisor - <?php echo $empName . " " . $empSurname; ?></h2>
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
                                                    <th># Leave No</th>
                                                    <th>Employee Name</th>
                                                    <th onclick="sortTable(0)" scope="col">Leave Type <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th onclick="sortTable(1)" scope="col">Duration <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                    <th>Absence Phase</th>
                                                    <th>Leave Status</th>
                                                    <th>Approval</th>
                                                    <th>View Details</th>


                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                    <tr>

                                                        <td><?php echo $row['leave_id']; ?></td>
                                                        <td><?php $emp_id = $row['emp_id'];
                                                            $emp = new employee();
                                                            $getName = $emp->getEmpName($emp_id);

                                                            echo $getName['name'] . " " . $getName['surname'];


                                                            ?></td>
                                                        <td><?php echo strtoupper($row['leave_type']); ?></td>
                                                        <td><?php echo $row['start_date']; ?></td>
                                                        <td><?php echo $row['end_date']; ?></td>
                                                        <td><?php echo $row['leave_total']; ?> Days</td>
                                                        <td><?php echo $row['absence_status']; ?></td>
                                                        <td>
                                                            <?php
                                                            switch ($row['approval_status']) {
                                                                case 'Approved':
                                                                    echo "<span class='badge bg-success text-white'>" . $row['approval_status'] . "</span>";
                                                                    break;

                                                                case 'Rejected':
                                                                    echo "<span class='badge bg-danger text-white'>" . $row['approval_status'] . "</span>";
                                                                    break;

                                                                case 'Pending N+1':
                                                                    echo "<span class='badge bg-warning text-white'>" . $row['approval_status'] . "</span>";
                                                                    break;
                                                                case 'Pending N+2':
                                                                    echo "<span class='badge bg-secondary text-white'>" . $row['approval_status'] . "</span>";
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>

                                                        <td>
                                                            <?php
                                                            switch ($row['approval_status']) {
                                                                case 'Approved':
                                                                    // Do nothing, or display a badge indicating approval if needed
                                                                    break;

                                                                case 'Rejected':
                                                                    //Pas fer rien , rest emplace
                                                                    break;
                                                                case 'Pending N+2':
                                                                    //Pas fer rien , rest emplace
                                                                    break;

                                                                case 'Pending N+1':
                                                                    echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editLeaveModal' . $row['leave_id'] . '">
                    <i class="fa-solid fa-pen-to-square"></i> Open
                </button>';
                                                                    break;

                                                                default:
                                                                    // Handle other cases if needed
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>


                                                        <!-- Modify News Status Modal -->
                                                        <div class="modal fade" id="editLeaveModal<?php echo $row['leave_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editLeaveModalLabel<?php echo $row['leave_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-md" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="editLeaveModalLabel<?php echo $row['leave_id']; ?>">Manage Leaves Approval Administrator </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Form to update NewsFeed Status -->
                                                                        <form method="post" action="../../controller/supervisor/approve_sup_bal.php">
                                                                            <!-- Populate form fields with current employee data -->
                                                                            <input type="hidden" name="leave_id" value="<?php echo $row['leave_id']; ?>">
                                                                            <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                                                                            <input type="hidden" name="leave_type" value="<?php echo $row['leave_type']; ?>">
                                                                            <input type="hidden" name="leave_total" value="<?php echo $row['leave_total']; ?>">

                                                                            <div class="form-group">
                                                                                <label for="admin_approval">Leaves Approval </label>
                                                                                <select class="form-control" name="approval_status">
                                                                                    <option value="Approved">Leaves Approved</option>
                                                                                    <option value="Rejected">Leaves Rejected</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="submit" class="btn btn-success" name="approveLeave">Save Changes</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <td>
                                                            <?php
                                                            switch ($row['approval_status']) {
                                                                case 'Approved':
                                                                    echo '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewLeaveModal' . $row['leave_id'] . '">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </button>';
                                                                    break;

                                                                case 'Rejected':
                                                                    echo '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewLeaveModal' . $row['leave_id'] . '">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </button>';
                                                                    break;

                                                                case 'Pending':

                                                                    break;

                                                                default:
                                                                    // Handle other cases if needed
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <!-- Modify News Status Modal -->
                                                        <div class="modal fade" id="viewLeaveModal<?php echo $row['leave_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewLeaveModalLabel<?php echo $row['leave_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="viewLeaveModalLabel<?php echo $row['leave_id']; ?>"> View Leaves Details </h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <!-- Form to update NewsFeed Status -->
                                                                        <form>
                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <b>Leave Type : </b> <?php echo $row['leave_type']; ?>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <b>Leave Duration : </b> <?php echo $row['leave_total']; ?>
                                                                                    </div>

                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <b>Start Date: </b> <?php echo $row['start_date']; ?>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <b>End Date : </b> <?php echo $row['end_date']; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <b>Leave Reason: </b> <?php echo $row['leave_reason']; ?>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <b>Leave Status : </b> <?php echo $row['approval_status']; ?>
                                                                                    </div>

                                                                                </div>


                                                                            </div>




                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>





                                                    </tr>
                                                    <!-- Displays the No Result found message to user -->
                                                    <tr id="noResultsMessage" style="display: none;">
                                                        <td colspan="7">No results found.</td>
                                                    </tr>
                                                    <!-- Add more rows dynamically using PHP/JavaScript -->

                                                <?php } ?>

                                            </tbody>
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
        // Get the start date and end date values
        var startDate = document.getElementById('start_date').value;
        var endDate = document.getElementById('end_date').value;

        // Check if start and end dates are selected
        if (!startDate || !endDate) {
            alert("Please select both start and end dates");
            return false; // Prevent form submission
        }
        // Update leave duration
        updateLeaveDuration();

        // Get the selected leave type and corresponding balance from the HTML
        var leaveType = document.getElementById('leaveType').value;
        var balance;

        switch (leaveType) {
            case 'vacation':
                balance = <?php echo $bal_vacation; ?>;
                break;
            case 'sick':
                balance = <?php echo $bal_sick; ?>;
                break;
            case 'wellness':
                balance = <?php echo $bal_well; ?>;
                break;
        }

        // Get the leave duration
        var leaveDays = parseInt(document.getElementById('leave_duration').value);

        // Check if duration is greater than balance
        if (leaveDays > balance) {
            // Display an error message
            alert("Leave duration cannot be greater than available balance for " + leaveType);
            document.getElementById('leaveSubmitButton').disabled = true;
            var form = document.getElementById('leaveForm'); // Replace 'yourFormId' with the actual ID of your form
            // Reset the form
            form.reset();
            return false; // Prevent form submission
        } else {
            // Get a reference to the form element

            document.getElementById('leaveSubmitButton').disabled = false;
        }

        // Submit the form if conditions are met
        document.forms["leaveForm"].submit();
    }
</script>

<script>
    // Attach change event listener to select element
    $('#leaveType').change(function() {
        // Hide all balance displays
        $('.balance').hide();

        // Get selected leave type
        var leaveType = $(this).val();

        // Show the balance display corresponding to the selected leave type
        $('#' + leaveType + 'Balance').show();

        // Check if leave balance is exhausted
        var balance = <?php echo $bal_vacation; ?>; // Default to vacation balance
        switch (leaveType) {
            case 'sick':
                balance = <?php echo $bal_sick; ?>;
                if (balance <= 0) {
                    alert("Leave Balance for Sick has been exhausted");
                }
                break;
            case 'wellness':
                balance = <?php echo $bal_well; ?>;
                if (balance <= 0) {
                    alert("Leave Balance for Wellness has been exhausted");
                }
                break;
            default: // vacation
                if (balance <= 0) {
                    alert("Leave Balance for Vacation has been exhausted");
                }
                break;
        }
    });
</script>

<script>
    <?php
    if (isset($_SESSION['createLeave'])) {
        unset($_SESSION['createLeave']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee Leave Created successfully!",
        })
    ';
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['approvedSuccess'])) {
        unset($_SESSION['approvedSuccess']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
           
        })
    ';
    }
    ?>
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

</html>