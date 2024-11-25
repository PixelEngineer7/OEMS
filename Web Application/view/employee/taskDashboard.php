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

$result = mysqli_query($conn, "SELECT * FROM tbl_task WHERE emp_id='$emp_id' ORDER BY task_id ASC LIMIT $start_from, $limit");



// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(task_id) FROM tbl_task WHERE emp_id='$emp_id'");
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


$count1 = $getTask->count_task_employee_pending($emp_id);
$count2 = $getTask->count_task_employee_progress($emp_id);
$count3 = $getTask->count_task_employee_OCOM($emp_id);
$count4 = $getTask->count_task_employee_NCOM($emp_id);

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





                            <div class="full margin_bottom_30"></div>












                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <h2>History of Task assigned to : <?php echo $row['name'] . " " . $row['surname'] ?></h2>
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
                                                    <th>Created By</th>
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
                                                            $emp_id = $row['supervisor_id'];
                                                            $emp = new employee();
                                                            $getNameSuper = $emp->getEmpSupID($emp_id);

                                                            $emp_id = $getNameSuper['emp_id'];

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

                                                            <?php
                                                            switch ($row['status']) {
                                                                case 'Completed':
                                                                    echo '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewLeaveModal' . $row['task_id'] . '">
                    <i class="fa-solid fa-eye"></i> View
                </button>     ';
                                                                    break;

                                                                case 'In Progress':
                                                                    echo '<button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#closeTaskModal' . $row['task_id'] . '">
                    <i class="fa-solid fa-circle-plus"></i> Close Task
                </button>';
                                                                    break;

                                                                case 'Pending':
                                                                    echo '<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#startTaskModal' . $row['task_id'] . '">
                    <i class="fa-solid fa-circle-plus"></i> Start Task
                </button>';
                                                                    break;

                                                                case 'Not Completed':
                                                                    echo '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#viewLeaveModal' . $row['task_id'] . '">
                    <i class="fa-solid fa-circle-plus"></i> View
                </button>';
                                                                    break;
                                                            }
                                                            ?>
                                                        </td>





                                                        <!-- View Task Modal -->
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
                                                                                <div class="col">
                                                                                    <h6><b>Feedback: </b> <?php echo $row['feedback']; ?></h6>
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

                                                        <!-- Start Task Modal -->
                                                        <div class="modal fade" id="startTaskModal<?php echo $row['task_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="startTaskModalLabel<?php echo $row['task_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="startTaskModalLabel<?php echo $row['task_id']; ?>">Start Task</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="../../controller/employee/start_task_emp.php">
                                                                            <!-- Populate form fields with current employee data -->
                                                                            <input type="hidden" name="task_identifier" value="<?php echo $row['task_id']; ?>">


                                                                            <div class="container">
                                                                                <div class="row g-3">
                                                                                    <div class="col">
                                                                                        <h6><b>Task Name: </b> <?php echo $row['task_name']; ?></h6>
                                                                                    </div>

                                                                                </div>
                                                                                <br>
                                                                                <div class="row g-3">
                                                                                    <div class="col">
                                                                                        <h6><b>Deadline Date: </b> <?php echo $row['deadline']; ?></h6>
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-warning" name="startTaskSubmit">Start Task</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Close Task Modal -->
                                                        <div class="modal fade" id="closeTaskModal<?php echo $row['task_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="closeTaskModalLabel<?php echo $row['task_id']; ?>" aria-hidden="true">
                                                            <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="closeTaskModalLabel<?php echo $row['task_id']; ?>">Close Task</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" action="../../controller/employee/close_task_emp.php">
                                                                            <!-- Populate form fields with current employee data -->
                                                                            <input type="hidden" name="task_identifier" value="<?php echo $row['task_id']; ?>">


                                                                            <div class="container">
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <h6><b>Task Name: </b> <?php echo $row['task_name']; ?></h6>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <h6><b>Deadline Date: </b> <?php echo $row['deadline']; ?></h6>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <h6><b>Feedback : </b> <br>
                                                                                            <textarea rows="4" cols="20" name="feedback" required></textarea>
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                                <br>
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <label for="work_status">
                                                                                            <h6><b>Work Status: </b></h6>
                                                                                        </label>
                                                                                        <select name="work_status" required>
                                                                                            <option value="Completed" selected>Completed</option>
                                                                                            <option value="Not Completed">Not Completed</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-danger" name="startTaskSubmit">Close Task</button>
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                    </form>
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
    if (isset($_SESSION['startTask'])) {
        unset($_SESSION['startTask']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Task started successfully!",
        })
    ';
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['closeTask'])) {
        unset($_SESSION['closeTask']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Task closed successfully!",
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