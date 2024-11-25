<?php
require('../../model/user.php');
require('../../model/department.php');
require('../../model/employee.php');


session_start();
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


$database = new DBHandler();
$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];
$emp_id = $row['emp_id'];




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


$result_db = mysqli_query($conn, "SELECT COUNT(pms_id) FROM tbl_pms where emp_id='$emp_id'");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);







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
                                    <h2>Employee Performance Management System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">


                            <div class="col-md-12 margin_bottom_30">


                                <!-- Modifications section -->
                                <div class="col-md margin_bottom_60">
                                    <div class="white_shd text-center pt-3">
                                        <h4 class="pt-3">Performance Management Metrics</h4>

                                        <!-- Table Example -->
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="text-align: center;">Range of Achievement</th>
                                                    <th style="text-align: center;">Score</th>
                                                    <th style="text-align: center;">Definition</th>


                                                    <!-- Add more columns as needed -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Far Exceeded - 111% and above 120%</td>
                                                    <td>30</td>
                                                    <td style="text-align: justify;">The employee greatly exceeded expectations of the objective; the result was exceptional resulting a highly significant impact and played a vital role in achieving critical work unit, with the objective (e.g., saved significant time or money) </td>
                                                    <!-- Add more rows and data as needed -->
                                                </tr>
                                                <tr>
                                                    <td>Exceeded - 101% and upto 110%</td>
                                                    <td>21 up to 29</td>
                                                    <td style="text-align: justify;">The employee exceeded expectations of the objective; the results surpassed the The employee's work required very few minor revisions or changes (fewer than expected). The objective was exceeded with less guidance and support than standards for quality and quantity, and the timeframe associated with the objective</td>
                                                    <!-- Add more rows and data as needed -->
                                                </tr>
                                                <tr>
                                                    <td>Met - 90% up to 100%</td>
                                                    <td>16 up to 20</td>
                                                    <td style="text-align: justify;">The employee fully met the expectations of the objective; the result met the standards for quality, quantity, timeliness, and cost-effectiveness associated with the objective (e.g., met designated budget and/or timeframe) and was achieved with the appropriate level of guidance.</td>
                                                    <!-- Add more rows and data as needed -->
                                                </tr>
                                                <tr>
                                                    <td>Nearly there - 60% up to 89%</td>
                                                    <td>1 to 15</td>
                                                    <td style="text-align: justify;">The employee partially met the expectations of the objective; the result fell short of meeting the standards for quality, quantity, timeliness, and cost-effectiveness associated with the objective.</td>
                                                    <!-- Add more rows and data as needed -->
                                                </tr>
                                                <tr>
                                                    <td>Did not achieve - less than 60%</td>
                                                    <td>0</td>
                                                    <td style="text-align: justify;">The employee did not meet the expectations of the objective even though circumstances allowed for its achievement</td>
                                                    <!-- Add more rows and data as needed -->
                                                </tr>
                                                <!-- Add more rows as needed -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- Modification section Ends-->



                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>History of Employee PMS : <?php echo $name . " " . $surname ?></h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="search-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input id="myInput" type="text" onkeyup="mySearch()" class="form-control" placeholder="Search.." aria-label="Search" aria-describedby="search-addon">

                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm table-hover" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th># PMS Id</th>
                                                        <th onclick="sortTable(1)" scope="col">Employee Name <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>PMS Quarter</th>
                                                        <th>PMS Phase</th>
                                                        <th>Current Status</th>
                                                        <th>Add Metrics</th>
                                                        <th>View PMS Details</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_array($result)) { ?>


                                                        <tr>
                                                            <td><?php echo $row['pms_id']; ?></td>
                                                            <td><?php $empCode = $row['emp_id'];


                                                                $getName = new employee();
                                                                $empNameArray = $getName->getEmpName($empCode);
                                                                $name = $empNameArray['name'];
                                                                $surname = $empNameArray['surname'];
                                                                echo $fullName = $name . " " . $surname;
                                                                ?></td>
                                                            <td><?php

                                                                // Assuming $row['quarter_array'] is a JSON string
                                                                $quarterArray = json_decode($row['quarter_array'], true);

                                                                // Check if decoding was successful
                                                                if ($quarterArray !== null) {
                                                                    // Access individual elements of the array
                                                                    $quarter = $quarterArray[0];
                                                                    $date = $quarterArray[1];
                                                                    $year = substr($date, 0, 4);
                                                                }

                                                                echo $quarter . " " . $year; ?></td>
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
                                                                ?>

                                                            </td>
                                                            <td><?php $row['pms_status'];

                                                                if (!empty($row['pms_status']) && isset($row['pms_status'])) {
                                                                    switch ($row['pms_status']) {
                                                                        case '':
                                                                            echo "<span class='badge bg-danger text-white'>Not Created</span>";
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



                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <?php
                                                                if ($row['pms_status'] == "n+1") : ?>
                                                                    <a class="btn btn-warning" href="pmsUpdate.php?action=update&pms_id=<?= $row['pms_id'] ?>&emp_id=<?= $row['emp_id'] ?>">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i> Update
                                                                    </a>
                                                                <?php endif; ?>
                                                            </td>

                                                            <td>
                                                                <?php echo "<a class='btn btn-success' href='viewPms.php?action=update&pms_id=" . $row['pms_id'] . "&emp_id=" . $row['emp_id'] . "'> <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> View</a>"; ?>
                                                            </td>




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
                            </div>














                            <!-- footer -->
                            <?php include '../../components/footer.php'; ?>
</body>


</html>