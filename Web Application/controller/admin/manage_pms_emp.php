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

$limit = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;

$result = mysqli_query($conn, "SELECT * FROM tbl_pms WHERE emp_id='$emp_id' ORDER BY pms_id ASC LIMIT $start_from, $limit");

// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id) FROM tbl_pms WHERE emp_id='$emp_id'");
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





$count_emp_pms = new pms();
$count1 = $count_emp_pms->count_pms_emp_completed($emp_id);
$count2 = $count_emp_pms->count_pms_emp_active($emp_id);
$count3 = $count_emp_pms->count_pms_emp_pending($emp_id);
$count4 = $count_emp_pms->count_pms_emp_n_2($emp_id);
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
                                    <h2>Performance Management System Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 orange_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">PMS Completed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 brown_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-chart-line"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count2; ?></p>
                                                <p class="head_couter">PMS Active</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 green_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-hourglass-half"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count3; ?></p>
                                                <p class="head_couter">Pending Approval </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle"></i>
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
                                                <h5 class="card-title">Create PMS</h5>
                                                <p class="card-text">Create PMS for Employee</p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPMSModal<?php echo $emp_id; ?>">
                                                    <i class="fa-solid fa-pen-to-square"></i> Create
                                                </button>

                                                <!-- Create PMS Modal -->
                                                <div class="modal fade" id="createPMSModal<?php echo $emp_id;   ?>" tabindex="-1" role="dialog" aria-labelledby="createPMSModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editModalLabel<?php echo $emp_id ?>">Create PMS for Employee </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Form to Create PMS details -->
                                                                <form method="post" action="../../controller/admin/create_pms.php">
                                                                    <!-- Populate form fields with current employee data -->
                                                                    <input type="hidden" name="emp_id" value="<?php echo $emp_id; ?>">
                                                                    <input type="hidden" name="supervisor_id" value="<?php echo $deptSupervisor; ?>">

                                                                    <label for="content"><b><u>PMS Period</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="period">Period</label>
                                                                            <select class="form-control" name="period_array[]">
                                                                                <option value="Quarter 1">Quarter 1</option>
                                                                                <option value="Quarter 2">Quarter 2</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="month">Month and Year</label>
                                                                            <input type="date" id="dateMonth" name="period_array[]" class="form-control" required>
                                                                        </div>

                                                                    </div>




                                                                    <label for="content"><b><u>Key Performance Areas</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="kpa1">KPA 1</label>
                                                                            <input type="text" class="form-control" name="kpa_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpa2">KPA 2</label>
                                                                            <input type="text" class="form-control" name="kpa_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpa3">KPA 3</label>
                                                                            <input type="text" class="form-control" name="kpa_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpa4">KPA 4</label>
                                                                            <input type="text" class="form-control" name="kpa_array[]" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b><u>Ojectives Set</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="obj1">Objective 1</label>
                                                                            <input type="text" class="form-control" name="obj_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="obj2">Objective 2</label>
                                                                            <input type="text" class="form-control" name="obj_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="obj3">Objective 3</label>
                                                                            <input type="text" class="form-control" name="obj_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="obj4">Objective 4</label>
                                                                            <input type="text" class="form-control" name="obj_array[]" required>
                                                                        </div>
                                                                    </div>

                                                                    <label for="content"><b><u>Key Performance Indicators</u></b></label>
                                                                    <div class="form-group row">
                                                                        <div class="col">
                                                                            <label for="kpi1">KPI 1</label>
                                                                            <input type="text" class="form-control" name="kpi_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpi2">KPI 2</label>
                                                                            <input type="text" class="form-control" name="kpi_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpi3">KPI 3</label>
                                                                            <input type="text" class="form-control" name="kpi_array[]" required>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="kpi4">KPI 4</label>
                                                                            <input type="text" class="form-control" name="kpi_array[]" required>
                                                                        </div>
                                                                    </div>




                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-success" name="create_pms">Save Changes</button>
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
                                        <h2>History of Employee PMS - <?php echo $empName . " " . $empSurname; ?> Metrics</h2>
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
                                                    <th># PMS No</th>
                                                    <th onclick="sortTable(1)" scope="col">PMS Period<i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                    <th>Year | Months</th>
                                                    <th>PMS Phase</th>
                                                    <th>Status</th>
                                                    <th>Modify Status</th>
                                                    <th>Modify PMS Entry</th>
                                                    <th>Score Entry</th>
                                                    <th>View PMS</th>


                                                </tr>
                                            </thead>


                                            <?php if (mysqli_num_rows($result) > 0) : ?>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_assoc($result)) :
                                                        $quarterArray = json_decode($row['quarter_array'], true);
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $row['pms_id']; ?></td>
                                                            <td><?php echo $quarterArray[0]; ?></td>
                                                            <td><?php echo $quarterArray[1]; ?></td>
                                                            <td><?php $row['pms_status'];

                                                                if (!empty($row['pms_status']) && isset($row['pms_status'])) {
                                                                    switch ($row['pms_status']) {
                                                                        case 'Pending':
                                                                            echo "<span class='badge bg-secondary text-white'>Pending with Management</span>";
                                                                            break;
                                                                        case 'n+1':
                                                                            echo "<span class='badge bg-warning text-white'>Pending at Employee</span>";
                                                                            break;
                                                                        case 'n+2':
                                                                            echo "<span class='badge bg-info text-white'>Pending at Supervisor</span>";
                                                                            break;
                                                                        case 'Completed':
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
                                                            <td><?php $row['management_status'];

                                                                if (!empty($row['management_status']) && isset($row['management_status'])) {
                                                                    switch ($row['management_status']) {
                                                                        case '':
                                                                            echo "<span class='badge bg-danger text-white'>Not Available</span>";
                                                                            break;
                                                                        case 'OB':
                                                                            echo "<span class='badge bg-warning text-white'>Objectives Created</span>";
                                                                            break;
                                                                        case 'MU':
                                                                            echo "<span class='badge bg-info text-white'>Metrics Updated</span>";
                                                                            break;
                                                                        case 'RP':
                                                                            echo "<span class='badge bg-success text-white'>Results Provided</span>";
                                                                            break;
                                                                        case 'SU':
                                                                            echo "<span class='badge bg-secondary text-white'>Score Updated</span>";
                                                                            break;
                                                                        default:
                                                                            echo "<span class='badge bg-danger text-white'>Not Created</span>";
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "<span class='badge bg-danger text-white'>Status Not Available</span>";
                                                                }
                                                                ?></td>

                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editPMSModal<?php echo $row['pms_id']; ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Update
                                                                </button>
                                                            </td>

                                                            <!-- Modify News Status Modal -->
                                                            <div class="modal fade" id="editPMSModal<?php echo $row['pms_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editPMSModalLabel<?php echo $row['pms_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-md" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['pms_id']; ?>">Update PMS Status </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form method="post" action="../../controller/admin/update_pms_status.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="pms_id" value="<?php echo $row['pms_id']; ?>">

                                                                                <div class="form-group">
                                                                                    <label for="user_access">Update PMS Status</label>
                                                                                    <select class="form-control" name="pms_status">
                                                                                        <option value="n+1">Pending at Employee</option>
                                                                                        <option value="n+2">Pending at Supervisor</option>
                                                                                        <option value="Completed">Completed</option>
                                                                                        <option value="Pending">Pending</option>
                                                                                    </select>
                                                                                </div>


                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="updatePMStatus">Save Changes</button>
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <td>
                                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modifyModal<?php echo $row['pms_id']; ?>">
                                                                    <i class="fa-solid fa-pencil"></i> Modify
                                                                </button>
                                                            </td>

                                                            <!-- Triggers the modal that will edit the contents -->
                                                            <div class="modal fade" id="modifyModal<?php echo $row['pms_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modifyModalLabel<?php echo $row['pms_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="modifyModalLabel<?php echo $row['pms_id']; ?>">Modify Employee Performance Sheet</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form method="post" action="../../controller/admin/modifyPMS.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="pms_id" value="<?php echo $row['pms_id']; ?>">
                                                                                <?php
                                                                                $getPMS = new pms();
                                                                                $getEMP = $getPMS->getPMSEmployee($row['pms_id']);

                                                                                foreach ($getEMP as $innerArray) {
                                                                                    // Decode JSON arrays
                                                                                    $quarterArray = json_decode($innerArray['quarter_array'], true);
                                                                                    $kpaArray = json_decode($innerArray['kpa_array'], true);
                                                                                    $kpiArray = json_decode($innerArray['kpi_array'], true);
                                                                                    $objectiveArray = json_decode($innerArray['objective_array'], true);
                                                                                ?>

                                                                                    <div class="form-group">
                                                                                        <label for="period"><b>PMS Period</b></label>
                                                                                        <div class="row">
                                                                                            <div class="col">
                                                                                                <label for="period">Period : </label>
                                                                                                <?php echo $quarterArray[0]; ?>
                                                                                            </div>
                                                                                            <div class="col">
                                                                                                <label for="month">Month and Year : </label>
                                                                                                <?php echo $quarterArray[1]; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="kpas"><b>Key Performance Areas</b></label>
                                                                                        <div class="row">
                                                                                            <?php
                                                                                            foreach ($kpaArray as $index => $kpa) {
                                                                                                echo '<div class="col">';
                                                                                                echo '<label for="kpa' . $index . '">KPA ' . ($index + 1) . ':</label>';
                                                                                                echo '<input type="text" class="form-control" name="kpa[' . $index . ']" value="' . $kpa . '">';
                                                                                                echo '</div>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="objectives"><b>Objectives Set</b></label>
                                                                                        <div class="row">
                                                                                            <?php
                                                                                            foreach ($objectiveArray as $index => $objective) {
                                                                                                echo '<div class="col">';
                                                                                                echo '<label for="objective' . $index . '">Objective ' . ($index + 1) . ':</label>';
                                                                                                echo '<input type="text" class="form-control" name="objective[' . $index . ']" value="' . $objective . '">';
                                                                                                echo '</div>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="form-group">
                                                                                        <label for="kpis"><b>Key Performance Indicators</b></label>
                                                                                        <div class="row">
                                                                                            <?php
                                                                                            foreach ($kpiArray as $index => $kpi) {
                                                                                                echo '<div class="col">';
                                                                                                echo '<label for="kpi' . $index . '">KPI ' . ($index + 1) . ':</label>';
                                                                                                echo '<input type="text" class="form-control" name="kpi[' . $index . ']" value="' . $kpi . '">';
                                                                                                echo '</div>';
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="modSubmit" class="btn btn-primary">Save Changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!-- Add Score button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addScoreModal<?php echo $row['pms_id'];
                                                                                                                                                            ?>">
                                                                    <i class="fa-solid fa-puzzle-piece"></i> Add
                                                                </button>
                                                            </td>

                                                            <!-- Modify News Status Modal -->
                                                            <div class="modal fade" id="addScoreModal<?php echo $row['pms_id'];
                                                                                                        ?>" tabindex="-1" role="dialog" aria-labelledby="addScoreModalLabel<?php echo $row['pms_id'];
                                                                                                                                                                            ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="addScoreModalLabel<?php echo $row['pms_id'];
                                                                                                                            ?>">Add Score to Employee PMS Sheet</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form method="post" action="../../controller/admin/addScore.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="pms_id" value="<?php echo $row['pms_id']; ?>">

                                                                                <?php
                                                                                $getPMS = new pms();
                                                                                $getEMP = $getPMS->getPMSEmployee($row['pms_id']);

                                                                                $kpiArray = json_decode($getEMP[0]['kpi_array'], true);
                                                                                $objectiveArray = json_decode($getEMP[0]['objective_array'], true);
                                                                                $metricArray = json_decode($getEMP[0]['metric_array'], true);

                                                                                // Check if decoding was successful
                                                                                if ($kpaArray !== null) {
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
                                                                                    $metric1 = $metricArray[0];
                                                                                    $metric2 = $metricArray[1];
                                                                                    $metric3 = $metricArray[2];
                                                                                    $metric4 = $metricArray[3];
                                                                                }

                                                                                ?>

                                                                                <div class="form-group">
                                                                                    <label for="period"><b>PMS Period</b></label>
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <label for="period">Period : </label>
                                                                                            <?php echo $quarterArray[0]; ?>
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <label for="month">Month and Year : </label>
                                                                                            <?php echo $quarterArray[1]; ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <h5>Key Performance Indicators</h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">KPI No 1 : <?php echo $kpi1; ?></div>
                                                                                        <div class="col">KPI No 2 : <?php echo $kpi2; ?></div>
                                                                                        <div class="col">KPI No 3 : <?php echo $kpi3; ?></div>
                                                                                        <div class="col">KPI No 4 : <?php echo $kpi4; ?></div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <h5>Key Objectives</h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">Objectives No 1 : <?php echo $obj1; ?></div>
                                                                                        <div class="col">Objectives No 2 : <?php echo $obj2; ?></div>
                                                                                        <div class="col">Objectives No 3 : <?php echo $obj3; ?></div>
                                                                                        <div class="col">Objectives No 4 : <?php echo $obj4; ?></div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <h5>Metrics</h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">Metrics No 1 : <?php if (empty($metrics1)) {
                                                                                                                            echo "Pending Employee Input";
                                                                                                                        } else {
                                                                                                                            echo $metrics1;
                                                                                                                        } ?></div>
                                                                                        <div class="col">Metrics No 2 : <?php if (empty($metrics2)) {
                                                                                                                            echo "Pending Employee Input";
                                                                                                                        } else {
                                                                                                                            echo $metrics2;
                                                                                                                        } ?></div>
                                                                                        <div class="col">Metrics No 3 : <?php if (empty($metrics3)) {
                                                                                                                            echo "Pending Employee Input";
                                                                                                                        } else {
                                                                                                                            echo $metrics3;
                                                                                                                        } ?></div>
                                                                                        <div class="col">Metrics No 4 : <?php if (empty($metrics4)) {
                                                                                                                            echo "Pending Employee Input";
                                                                                                                        } else {
                                                                                                                            echo $metrics4;
                                                                                                                        } ?></div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <h5>Input PMS Score</h5>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">Score No 1 : <input type="number" class="form-control" name="score_array[]" min="0" max="35" required></div>
                                                                                        <div class="col">Score No 2 : <input type="number" class="form-control" name="score_array[]" min="0" max="35" required></div>
                                                                                        <div class="col">Score No 3 : <input type="number" class="form-control" name="score_array[]" min="0" max="35" required></div>
                                                                                        <div class="col">Score No 4 : <input type="number" class="form-control" name="score_array[]" min="0" max="35" required></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-primary" name="scoreSubmit">Save Changes</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <td> <a class="btn btn-success" href="view_pms_emp.php?action=update&pms_id=<?= $row['pms_id'] ?>&emp_id=<?= $row['emp_id'] ?>">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </a></td>
                                                            <!-- Add more columns as needed -->
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
    <?php
    if (isset($_SESSION['updateSuccess'])) {
        unset($_SESSION['updateSuccess']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Created successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "pmsDashboard.php";
            }
        });
        ';
    } else {
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['updatePMS'])) {
        unset($_SESSION['updatePMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Updated successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
            }
        });
        ';
    } else {
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['modifyPMS'])) {
        unset($_SESSION['modifyPMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Modified successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
            }
        });
    ';
    } else {
    }
    ?>
</script>
<script>
    <?php
    if (isset($_SESSION['addScorePMS'])) {
        unset($_SESSION['addScorePMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Score Added successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
            }
        });
    ';
    } else {
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