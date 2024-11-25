<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/balance.php');
require('../../model/user.php');
require('../../model/leave.php');


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
$allowedRoles = ['Supervisor', 'Employee'];

$result = mysqli_query($conn, "SELECT *
    FROM tbl_user u
    LEFT JOIN tbl_employee e ON u.user_id = e.user_id
    WHERE u.role IN ('" . implode("','", $allowedRoles) . "') AND e.user_id IS NOT NULL
    ORDER BY emp_id ASC
    LIMIT $start_from, $limit");


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id)
FROM tbl_employee");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);





$lve_bal = new leave();

$count1 = $lve_bal->count_leave_n_plus_one();
$count2 = $lve_bal->count_leave_n_plus_two();
$count3 = $lve_bal->count_leave();
$count4 = $lve_bal->count_leave_attention();
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
                                    <h2>Employee Leaves Management Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 brown_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-person-circle-exclamation"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">Pending at Supervisor</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-users-between-lines"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count2; ?></p>
                                                <p class="head_couter">Pending at HR</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 blue1_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-square-pen"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count3; ?></p>
                                                <p class="head_couter">Leaves Application</p>
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




                            <!-- List of NewsFeed on Systems-->
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>List of Employee Eligible for Leaves</h2>
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
                                                        <th># Employee No</th>
                                                        <th onclick="sortTable(1)" scope="col">Name<i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Surname</th>
                                                        <th>Department</th>
                                                        <th>Grade</th>
                                                        <th>Create Leaves</th>
                                                        <th>Manage Leaves</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                        <tr>

                                                            <td><?php echo $row['emp_id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['surname']; ?></td>
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

                                                            <td><?php echo $row['position']; ?> </td>


                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <?php
                                                                $emp_id = $row['emp_id'];

                                                                $check = new balance();
                                                                $checkEmp = $check->checkEmpExist($emp_id);

                                                                // Use $checkEmp in the condition instead of "false"
                                                                if (!$checkEmp) {
                                                                    echo '<button type="button" class="btn btn-info" data-toggle="modal" data-target="#editLeaveModal' . $row['emp_id'] . '">
            <i class="fa-solid fa-pen-to-square"></i> Create
          </button>';
                                                                }
                                                                ?>









                                                            </td>

                                                            <!-- Modify News Status Modal -->
                                                            <div class="modal fade" id="editLeaveModal<?php echo $row['emp_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editLeaveModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editLeaveModalLabel<?php echo $row['emp_id']; ?>"> Create Employee Leave Balance </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form method="post" action="../../controller/admin/create_leave_bal.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">

                                                                                <div class="form-group">
                                                                                    <div class="col">
                                                                                        <label for="period">Wellness Leave Balance</label>
                                                                                        <input type="number" id="dateMonth" name="wellness_leave" class="form-control" min=0 max=5 required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="month">Vacation Leave Balance</label>
                                                                                        <input type="number" id="dateMonth" name="vacation_leave" class="form-control" min=0 max=90 required>
                                                                                    </div>

                                                                                    <div class="col">
                                                                                        <label for="month">Sick Leave Balance</label>
                                                                                        <input type="number" id="dateMonth" name="sick_leave" class="form-control" min=0 max=22 required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="createLeaveBal">Save Changes</button>
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <a class="btn btn-primary" href="../../controller/admin/manage_leaves_emp.php?action=update&emp_id=<?= $row['emp_id'] ?>">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i> Manage
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <!-- Add more rows dynamically using PHP/JavaScript -->
                                                </tbody>
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
            text: "Employee Leave Balances Created successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "leaveDashboard.php";
            }
        });
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
            text: "Employee Leave updated and deducted where required from Employee Leave Balance!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "leaveDashboard.php";
            }
        });
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