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



$database = new DBHandler();
$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

//var_dump($getProfileDetails);

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



// Use a prepared statement
$result = mysqli_query($conn, "SELECT * FROM tbl_pms WHERE emp_id='$emp_id' ORDER BY pms_id ASC LIMIT $start_from, $limit");


//$result = mysqli_query($conn, "SELECT * FROM tbl_pms WHERE supervisor_id=$user_id ORDER BY user_id ASC LIMIT $start_from, $limit");

$result_db = mysqli_query($conn, "SELECT COUNT(pms_id) FROM tbl_pms where emp_id='$emp_id'");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);

$database = new DBHandler();
$usr = new user();
$RU = $usr->countUser($database);
foreach ($RU as $rowA)
    $countUser = (int)$rowA['total'];


$dept = new department();
$AD = $dept->countDepartment($database);
foreach ($AD as $rowB)
    $countDepartment = (int)$rowB['total'];

$dept = new employee();
$AE = $dept->countEmployee($database);
foreach ($AE as $rowC)
    $countEmployee = (int)$rowC['total'];

$dept = new employee();
$RA = $dept->countRequireAttention($database);
foreach ($RA as $rowD)
    $countRequireAttention = (int)$rowD['total'];





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
                                    <h2>Employee Performance Management System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- invoice section -->
                            <div class="row column1">

                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>Performance Management of Supervisor : <?php echo $name . " " . $surname ?></h2>
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
                                                            <th>PMS Status</th>
                                                            <th>Current Status</th>
                                                            <th>Add Metrics</th>
                                                            <th>View PMS Details</th>



                                                        </tr>
                                                    </thead>
                                                    <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                        <tbody>
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
                                                                            case 'Pending':
                                                                                echo "<span class='badge bg-danger text-white'>Pending with Management</span>";
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
                                                                    <?php if (empty($row['metric_array'])) : ?>
                                                                        <a class="btn btn-warning" href="pmsSelfUpdate.php?action=update&pms_id=<?= $row['pms_id'] ?>&emp_id=<?= $row['emp_id'] ?>">
                                                                            <i class="fa fa-plus" aria-hidden="true"></i> Update
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </td>

                                                                <td>
                                                                    <?php echo "<a class='btn btn-success' href='viewSelfPms.php?action=update&pms_id=" . $row['pms_id'] . "&emp_id=" . $row['emp_id'] . "'> <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> View</a>"; ?>
                                                                </td>




                                                            </tr>

                                                            <!-- Displays the No Result found message to user -->
                                                            <tr id="noResultsMessage" style="display: none;">
                                                                <td colspan="7">No results found.</td>
                                                            </tr>
                                                            <!-- Add more rows dynamically using PHP/JavaScript -->
                                                        </tbody>



                                                    <?php } ?>
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
<script>
    <?php
    if (isset($_SESSION['updateSuccess'])) {
        unset($_SESSION['updateSuccess']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "User Access Control Updated successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "userCreationDashboard.php";
            }
        });
        ';
    }
    ?>
</script>

</html>