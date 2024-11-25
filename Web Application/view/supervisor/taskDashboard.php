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

$result = mysqli_query($conn, "SELECT * FROM tbl_task WHERE supervisor_id='$user_id' ORDER BY task_id ASC LIMIT $start_from, $limit");



// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(task_id) FROM tbl_task WHERE supervisor_id='$user_id'");
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






$getTask = new task();
$getTask->count_task_emp_pending($user_id);

$count1 = $getTask->count_task_emp_pending($user_id);
$count2 = $getTask->count_task_emp_progress($user_id);
$count3 = $getTask->count_task_emp_OCOM($user_id);
$count4 = $getTask->count_task_emp_NCOM($user_id);

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
                                    <h2>Task Management Dashboard</h2>
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
                                                <i class="fa-solid fa-spinner"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">Task Pending </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-bars-progress"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count2; ?></p>
                                                <p class="head_couter">Task In Progress</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 green_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count3; ?></p>
                                                <p class="head_couter">Task Completed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle fa-beat fa-3x"></i>
                                            </div>
                                        </div>

                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count4; ?></p>
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
                                                <h5 class="card-title">Create Task</h5>
                                                <p class="card-text">Create Task and assigned to Employee</p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createTaskModal<?php echo $emp_id; ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Create
                                                </button>



                                                <!-- Create PMS Modal -->
                                                <div class="modal fade" id="createTaskModal<?php echo $emp_id;   ?>" tabindex="-1" role="dialog" aria-labelledby="createTaskModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?php echo $emp_id ?>">Create Task and Assign to Employee </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form to Create PMS details -->
                                                                <form method="post" action="../../controller/supervisor/create_task_sup.php">
                                                                    <!-- Populate form fields with current employee data -->
                                                                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                                    <input type="hidden" name="supervisor_id" value="<?php echo $deptSupervisor; ?>">

                                                                    <label for="content"><b>Task Name</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <input type="text" class="form-control" name="task_name" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b>Task Description</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <input type="text" class="form-control" name="task_description" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b>Set Deadline</b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <input type="date" class="form-control" name="deadline_date" id="deadline_date" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b><u>Assign To </u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <select class="form-control" name="emp_id">
                                                                                <?php
                                                                                // Assuming $conn is your MySQLi connection
                                                                                $query = "SELECT u.name, u.surname, e.emp_id
                                                                                FROM tbl_user u
                                                                                INNER JOIN tbl_employee e ON u.user_id = e.user_id
                                                                                WHERE e.department = '$department_id'";
                                                                                $resultEMP = mysqli_query($conn, $query);

                                                                                while ($row = mysqli_fetch_assoc($resultEMP)) {
                                                                                    $employeeId = $row['emp_id'];
                                                                                    $employeeName = $row['name'] . ' ' . $row['surname'];

                                                                                    echo "<option value=\"$employeeId\">$employeeName</option>";
                                                                                }
                                                                                mysqli_free_result($resultEMP);
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>


                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success" name="taskSubmit">Create Task</button>
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



                            <div class="full margin_bottom_30"></div>












                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>History of all Tasks created by Supervisor</h2>
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
                                                    <th># Task No</th>
                                                    <th>Assigned To</th>
                                                    <th onclick="sortTable(0)" scope="col">Task Type <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                    <th>Deadline</th>
                                                    <th>Progress</th>
                                                    <th>Status</th>
                                                    <th>Action</th>



                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                    <tr>
                                                        <td><?php echo $row['task_id']; ?></td>
                                                        <td>
                                                            <?php
                                                            $emp_id = $row['emp_id'];
                                                            $emp = new employee();
                                                            $getName = $emp->getEmpName($emp_id);
                                                            echo $getName['name'] . " " . $getName['surname'];
                                                            ?>
                                                        </td>
                                                        <td><?php echo $row['task_name']; ?></td>
                                                        <td><?php echo $row['deadline']; ?></td>
                                                        <td>
                                                            <div class="progress">
                                                                <?php
                                                                $progress = $row['progress'];
                                                                $progressClass = ($progress >= 50) ? 'bg-success' : 'bg-warning';
                                                                echo '<div class="progress-bar ' . $progressClass . ' progress-bar-striped progress-bar-animated" style="width:' . $progress . '%">' . $progress . '%</div>';
                                                                ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            switch ($row['status']) {
                                                                case 'Completed':
                                                                    echo "<span class='badge bg-success text-white'>" . $row['status'] . "</span>";
                                                                    break;

                                                                case 'In Progress':
                                                                    echo "<span class='badge bg-primary text-white'>" . $row['status'] . "</span>";
                                                                    break;

                                                                case 'Pending':
                                                                    echo "<span class='badge bg-warning text-white'>" . $row['status'] . "</span>";
                                                                    break;

                                                                case 'Not Completed':
                                                                    echo "<span class='badge bg-danger text-white'>" . $row['status'] . "</span>";
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewLeaveModal<?php echo $row['task_id']; ?>">
                                                                <i class="fa-solid fa-eye"></i> View
                                                            </button>
                                                        </td>

                                                        <!-- Modify News Status Modal -->
                                                        <div class="modal fade" id="viewLeaveModal<?php echo $row['task_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewLeaveModalLabel<?php echo $row['task_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="viewLeaveModalLabel<?php echo $row['task_id']; ?>">Task Details</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row g-3">
                                                                                <div class="col">
                                                                                    <h6><b>Task Name: </b> <?php echo $row['task_name']; ?></h6>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <h6><b>Assigned To: </b>
                                                                                        <?php
                                                                                        $emp_id = $row['emp_id'];
                                                                                        $emp = new employee();
                                                                                        $getName = $emp->getEmpName($emp_id);
                                                                                        echo $getName['name'] . " " . $getName['surname'];
                                                                                        ?></h6>
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="row g-3">
                                                                                <div class="col">
                                                                                    <h6><b>Task Description: </b> <?php echo $row['description']; ?></h6>
                                                                                </div>
                                                                                <div class="col">
                                                                                    <h6><b>Deadline Date: </b> <?php echo $row['deadline']; ?></h6>
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <div class="row g-3">
                                                                                <div class="col">
                                                                                    <h6><b>Feedback: </b> <?php echo $row['feedback']; ?></h6>

                                                                                </div>
                                                                                <div class="col">
                                                                                    <h6><b>Status: </b> <?php
                                                                                                        switch ($row['status']) {
                                                                                                            case 'Completed':
                                                                                                                echo "<span class='badge bg-success text-white'>" . $row['status'] . "</span>";
                                                                                                                break;

                                                                                                            case 'In Progress':
                                                                                                                echo "<span class='badge bg-primary text-white'>" . $row['status'] . "</span>";
                                                                                                                break;

                                                                                                            case 'Pending':
                                                                                                                echo "<span class='badge bg-warning text-white'>" . $row['status'] . "</span>";
                                                                                                                break;

                                                                                                            case 'Not Completed':
                                                                                                                echo "<span class='badge bg-danger text-white'>" . $row['status'] . "</span>";
                                                                                                                break;
                                                                                                        }
                                                                                                        ?></h6>
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </tr>

                                                <?php } ?>

                                                <!-- Displays the No Result found message to the user -->
                                                <tr id="noResultsMessage" style="display: none;">
                                                    <td colspan="7">No results found.</td>
                                                </tr>

                                                <!-- Add more rows dynamically using PHP/JavaScript -->
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
        updateLeaveDuration(); // Update duration one more time before submission

        // Add additional checks or actions before form submission if needed

        document.forms["leaveForm"].submit(); // Submit the form
    }
</script>




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