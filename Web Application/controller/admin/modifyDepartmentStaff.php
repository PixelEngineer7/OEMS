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


if ($role == 'Administrator' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Administrator' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT


$database = new DBHandler();
$getUser = new user();
$result_staffs = $getUser->getEmployees($database);

//Code for Pagination and retrieval of data from database
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
    $page = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$result = mysqli_query($conn, "SELECT * FROM tbl_department ORDER BY department_id ASC LIMIT $start_from, $limit");




$total_records_query = "SELECT COUNT(department_id) FROM tbl_department";
$total_records_result = mysqli_query($conn, $total_records_query);
$total_records_row = mysqli_fetch_row($total_records_result);
$total_records = $total_records_row[0];
$total_pages = ceil($total_records / $limit);





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
                                    <h2>User Creation Dashboard</h2>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>List of All Department on System</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="search-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input id="myInput" type="text" onkeyup="mySearch()" class="form-control" placeholder="Search.." aria-label="Search" aria-describedby="search-addon">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th># Department No</th>
                                                        <th onclick="sortTable(1)" scope="col">Department Name <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Content Details</th>
                                                        <th>Supervisor</th>
                                                        <th>Modify Details</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                        <tr>

                                                            <td><?php echo $row['department_id']; ?></td>
                                                            <td><?php echo $row['departmentName']; ?></td>
                                                            <td><?php echo $row['departmentDetails']; ?></td>

                                                            <td>

                                                                <?php

                                                                $getEmpD = new user();
                                                                $depSupervisor = $row['departmentSupervisor'];

                                                                $deptSupArray = $getEmpD->getEmpName($depSupervisor);

                                                                if (!empty($deptSupArray)) {
                                                                    $departmentSupervisor = $deptSupArray[0]['name'] . ' ' . $deptSupArray[0]['surname'];
                                                                    echo $departmentSupervisor;
                                                                }
                                                                ?>
                                                            </td>



                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['department_id']; ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Modify
                                                                </button>
                                                            </td>

                                                            <!-- Edit Employee Modal -->
                                                            <div class="modal fade" id="editModal<?php echo $row['department_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['department_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['department_id']; ?>">Edit Department Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>

                                                                        <div class="modal-body">
                                                                            <!-- Form to edit employee details -->
                                                                            <form method="post" action="updateDepartment.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="department_id" value="<?php echo $row['department_id']; ?>">

                                                                                <div class="form-group">
                                                                                    <label for="departmentName">Department Name</label>
                                                                                    <input type="text" class="form-control" name="departmentName" required value="<?php echo $row['departmentName']; ?>">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="departmentDetails">Department Details</label>
                                                                                    <input type="text" class="form-control" name="departmentDetails" required value="<?php echo $row['departmentDetails']; ?>">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="employee">Select Employee to Assign as Supervisor Dropdown List</label>
                                                                                    <select class="form-control" name="departmentSupervisor">
                                                                                        <?php
                                                                                        foreach ($result_staffs as $row) {
                                                                                            $userID = $row['user_id'];
                                                                                            $fullName = $row['name'] . ' ' . $row['surname'];
                                                                                            echo '<option value="' . $userID . '">' . $fullName . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="updateDepartment">Save Changes</button>
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

                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Pagination -->
                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <?php
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    if ($i === 1) {
                                                        echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    } else {
                                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </nav>

                                        <!-- End Pagination -->
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
            title: "Good job!",
            text: "Employee details updated successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "modifyDepartmentStaff.php";
            }
        });
        ';
    }
    ?>
</script>

</html>