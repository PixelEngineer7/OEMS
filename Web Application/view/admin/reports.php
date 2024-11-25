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
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Reports</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="white_shd full mb-4">
                                <div class="container mt-5">
                                    <h4><i class="fa-solid fa-users-between-lines"></i> Reports on Employees Details</h4>
                                    <form class="row g-3 align-items-center mt-4 margin_bottom_30" id="employeeReportForm" method="GET">

                                        <div class="col-auto">
                                            <label class="visually-hidden" for="inlineFormSelectPref">Where Employee Status : &nbsp;&nbsp;</label>
                                            <select class="form-select" id="inlineFormSelectPref" name="employeeStatus">
                                                <option value="1" <?php echo isset($_GET['employeeStatus']) && $_GET['employeeStatus'] == '1' ? 'selected' : ''; ?>>Active Employees</option>
                                                <option value="0" <?php echo isset($_GET['employeeStatus']) && $_GET['employeeStatus'] == '0' ? 'selected' : ''; ?>>Non-Active Employees</option>
                                            </select>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary btn-sm" name="empReports">
                                                <i class="fa-solid fa-spinner fa-spin"></i> Generate
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Table Section -->
                                <div class="container mt-3 mb-3">

                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapsibleTable" aria-expanded="false" aria-controls="collapsibleTable">
                                        Toggle Table
                                    </button>

                                    <!-- Print Button -->

                                    <button class="btn btn-secondary btn-sm ml-2" onclick="printTable('emp_table')">Print</button>

                                    <button class="btn btn-success btn-sm ml-2" onclick="javascript:window.location='../../controller/exports/exportEmployee.php' ;">Export</button>

                                    <div class=" collapse" id="collapsibleTable">
                                        <div class="table-responsive">
                                            <table class="table table-sm" id="emp_table">
                                                <br>
                                                <thead>

                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Surname</th>
                                                        <th onclick="sortTable(2)" scope="col">Category<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Position</th>
                                                        <th>Department</th>
                                                        <th>Contact</th>
                                                        <th onclick="sortTable(6)" scope="col">Date Joined<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch data based on the selected status
                                                    $selectedStatus = isset($_GET['employeeStatus']) ? $_GET['employeeStatus'] : '1';
                                                    $result = fetchDataBasedOnStatus($selectedStatus);

                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $row['name']; ?></td>
                                                                <td><?php echo $row['surname']; ?></td>
                                                                <td><?php echo $row['role']; ?></td>
                                                                <td><?php echo $row['position']; ?></td>
                                                                <td> <?php
                                                                        $getName = new department();
                                                                        $depCode = $row['department'];
                                                                        $deptNameArray = $getName->getDepartmentName($depCode);

                                                                        if (!empty($deptNameArray)) {
                                                                            $deptName = $deptNameArray[0]['departmentName'];
                                                                            $deptSupervisor = $deptNameArray[0]['departmentSupervisor'];
                                                                            echo $deptName;
                                                                        }
                                                                        ?></td>


                                                                <td><?php echo $row['mobile_number']; ?></td>
                                                                <td><?php echo $row['date_joined']; ?></td>
                                                                <td><?php if ((int)$row['isActive'] == 1)
                                                                        echo "<span class='badge bg-success text-white'>Active</span>";
                                                                    else
                                                                        echo "<span class='badge bg-danger text-white'>Revoked
                                                                    </span>"; ?></td>
                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr id="noResultsMessage">
                                                            <td colspan="8">No results found.</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <!-- NEW ROW FOR REPORTS!!!!!!!-->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="white_shd full mb-4">
                                <div class="container mt-5">
                                    <h4><i class="fa-solid fa-list-check"></i> Reports on Employee Tasks</h4>
                                    <form class="row g-3 align-items-center mt-4 margin_bottom_30" id="taskReportForm" method="GET">

                                        <div class="col-auto">
                                            <label class="visually-hidden" for="inlineFormSelectPref">Where Task Status : &nbsp;&nbsp;</label>
                                            <select class="form-select" id="inlineFormSelectPref" name="taskStatus">
                                                <option value="Completed" <?php echo isset($_GET['taskStatus']) && $_GET['taskStatus'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Pending" <?php echo isset($_GET['taskStatus']) && $_GET['taskStatus'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="In Progress" <?php echo isset($_GET['taskStatus']) && $_GET['taskStatus'] == 'In Progress' ? 'selected' : ''; ?>>In Progress</option>
                                            </select>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-warning btn-sm" name="taskReports">
                                                <i class="fa-solid fa-spinner fa-spin"></i> Generate
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Table Section -->
                                <div class="container mt-3 mb-3">

                                    <button class="btn btn-warning btn-sm" type="button" data-toggle="collapse" data-target="#collapsibleTable2" aria-expanded="false" aria-controls="collapsibleTable2">
                                        Toggle Table
                                    </button>

                                    <!-- Print Button -->

                                    <button class="btn btn-secondary btn-sm ml-2" onclick="printTable('task_table')">Print</button>
                                    <button class="btn btn-success btn-sm ml-2" onclick="javascript:window.location='../../controller/exports/exportTask.php' ;">Export</button>
                                    <div class="collapse" id="collapsibleTable2">
                                        <div class="table-responsive">
                                            <table class="table table-sm print-table" id="task_table">
                                                <br>
                                                <thead>

                                                    <tr>
                                                        <th># Task ID</th>
                                                        <th>Assigned By</th>
                                                        <th onclick="sortTable(2)" scope="col">Task Name<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Description</th>
                                                        <th onclick="sortTable(6)" scope="col">Deadline<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Status</th>
                                                        <th>Feedback</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch data based on the selected status
                                                    $selected_task = isset($_GET['taskStatus']) ? $_GET['taskStatus'] : 'Completed';
                                                    $result_task = fetchDataBasedOnTask($selected_task);

                                                    if (mysqli_num_rows($result_task) > 0) {
                                                        while ($row = mysqli_fetch_array($result_task)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $row['task_id']; ?></td>
                                                                <td><?php $row['supervisor_id'];
                                                                    $getName = new user();
                                                                    $usr_id = $row['supervisor_id'];
                                                                    $empNameArray = $getName->getEmpName($usr_id);



                                                                    if (!empty($empNameArray)) {
                                                                        $supName = $empNameArray[0]['name'] . " " . $empNameArray[0]['surname'];

                                                                        echo $supName;
                                                                    }






                                                                    ?></td>
                                                                <td><?php echo $row['task_name']; ?></td>
                                                                <td><?php echo $row['description']; ?></td>
                                                                <td><?php echo $row['deadline']; ?></td>
                                                                <td><?php echo $row['status']; ?></td>
                                                                <td><?php echo $row['feedback']; ?></td>

                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr id="noResultsMessage">
                                                            <td colspan="8">No results found.</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- END NEW ROW FOR REPORTS!!!!!!!-->

                        <!-- NEW ROW FOR REPORTS!!!!!!!-->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="white_shd full mb-4">
                                <div class="container mt-5">
                                    <h4><i class="fa-regular fa-calendar-xmark"></i> Reports on Employee Leaves</h4>
                                    <form class="row g-3 align-items-center mt-4 margin_bottom_30" id="leaveReportForm" method="GET">

                                        <div class="col-auto">
                                            <label class="visually-hidden" for="inlineFormSelectPref">Where Employee Leave Status : &nbsp;&nbsp;</label>
                                            <select class="form-select" id="inlineFormSelectPref" name="leaveStatus">
                                                <option value="Approved" <?php echo isset($_GET['leaveStatus']) && $_GET['leaveStatus'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                                <option value="Rejected" <?php echo isset($_GET['leaveStatus']) && $_GET['leaveStatus'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                                <option value="Pending" <?php echo isset($_GET['leaveStatus']) && $_GET['leaveStatus'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                            </select>
                                        </div>

                                        <div class="col-auto">
                                            <button type="submit" class="btn cur-p btn-danger btn-sm" name="leaveReports">
                                                <i class="fa-solid fa-spinner fa-spin"></i> Generate
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Table Section -->
                                <div class="container mt-3 mb-3">

                                    <button class="btn cur-p btn-danger btn-sm" type="button" data-toggle="collapse" data-target="#collapsibleTable3" aria-expanded="false" aria-controls="collapsibleTable3">
                                        Toggle Table
                                    </button>

                                    <!-- Print Button -->

                                    <button class="btn btn-secondary btn-sm ml-2" onclick="printTable('leave_table')">Print</button>
                                    <button class="btn btn-success btn-sm ml-2" onclick="javascript:window.location='../../controller/exports/exportLeaves.php' ;">Export</button>

                                    <div class="collapse" id="collapsibleTable3">
                                        <div class="table-responsive">
                                            <table class="table table-sm print-table" id="leave_table">
                                                <br>
                                                <thead>

                                                    <tr>
                                                        <th># Leave ID</th>
                                                        <th>Employee Name</th>
                                                        <th onclick="sortTable(2)" scope="col">Leave Type<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Start Date</th>
                                                        <th>End Date</th>
                                                        <th onclick="sortTable(6)" scope="col">Duration<i class="fa-solid fa-arrow-up-a-z"></i></th>
                                                        <th>Status</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Fetch data based on the selected status
                                                    $selected_leave = isset($_GET['leaveStatus']) ? $_GET['leaveStatus'] : 'Approved';
                                                    $result_leave = fetchDataBasedOnLeave($selected_leave);

                                                    if (mysqli_num_rows($result_leave) > 0) {
                                                        while ($row = mysqli_fetch_array($result_leave)) {
                                                    ?>
                                                            <tr>
                                                                <td><?php echo $row['leave_id']; ?></td>
                                                                <td><?php
                                                                    $getName = new employee();
                                                                    $usr_id = $row['emp_id'];
                                                                    $empNameArr = $getName->getEmpName($usr_id);





                                                                    if (!empty($empNameArr)) {
                                                                        $empName = $empNameArr['name'] . " " . $empNameArr['surname'];

                                                                        echo $empName;
                                                                    }






                                                                    ?></td>
                                                                <td><?php echo $row['leave_type']; ?></td>
                                                                <td><?php echo $row['start_date']; ?></td>
                                                                <td><?php echo $row['end_date']; ?></td>
                                                                <td><?php echo $row['leave_total']; ?></td>
                                                                <td><?php echo $row['approval_status']; ?></td>

                                                            </tr>
                                                        <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <tr id="noResultsMessage">
                                                            <td colspan="8">No results found.</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- END NEW ROW FOR REPORTS!!!!!!!-->











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
<script>
    function printTable(tableId) {
        // Apply Bootstrap styles for printing
        var styleSheet = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" media="print">';
        document.head.insertAdjacentHTML('beforeend', styleSheet);

        // Set the print styles
        var printStyles = '<style>@media print { body { visibility: hidden; } .print-content { visibility: visible; } }</style>';
        document.head.insertAdjacentHTML('beforeend', printStyles);

        // Add a class to the table for printing
        var table = document.getElementById(tableId);
        table.classList.add('print-content');

        // Trigger the print dialog
        window.print();

        // Remove the print styles and class after printing
        document.head.removeChild(document.head.lastChild);
        table.classList.remove('print-content');
    }
</script>


<?php
// Function to fetch data based on selected status
function fetchDataBasedOnStatus($status)
{

    $database = new DBHandler();
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = "oems";
    $conn = $database->connectToDatabase();
    // Implement your logic to fetch data based on the selected status
    // This is a placeholder; replace it with your actual database query.
    $query = "SELECT *
                                    FROM tbl_employee e
                                    LEFT JOIN tbl_user u ON u.user_id = e.user_id
                                    WHERE u.isActive ='$status'";
    $result = mysqli_query($conn, $query);

    return $result;
}
?>

<?php
// Function to fetch data based on selected status
function fetchDataBasedOnTask($task)
{

    $database = new DBHandler();
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = "oems";
    $conn = $database->connectToDatabase();
    // Implement your logic to fetch data based on the selected status
    // This is a placeholder; replace it with your actual database query.
    $query = "SELECT *
                                    FROM tbl_task t
                                    LEFT JOIN tbl_user u ON u.user_id = t.supervisor_id
                                    WHERE t.status ='$task'";
    $result = mysqli_query($conn, $query);

    return $result;
}
?>

<?php
// Function to fetch data based on selected status
function fetchDataBasedOnLeave($leave)
{

    $database = new DBHandler();
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = "oems";
    $conn = $database->connectToDatabase();
    // Implement your logic to fetch data based on the selected status
    // This is a placeholder; replace it with your actual database query.
    $query = "SELECT *
                                    FROM tbl_leave 
                                    WHERE approval_status ='$leave'";
    $result = mysqli_query($conn, $query);

    return $result;
}
?>


</html>