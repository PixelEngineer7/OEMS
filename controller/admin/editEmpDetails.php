<?php
require('../../model/user.php');
require('../../model/department.php');
require('../../model/employee.php');
session_start();
$database = new DBHandler();
$user = new user();
$getDept = new department();
$getEmp = new employee();
$resultDept = $getDept->getDepartmentDetails($database);

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
$result = mysqli_query($conn, "SELECT * FROM tbl_user
                               INNER JOIN tbl_employee ON tbl_user.user_id = tbl_employee.user_id
                               WHERE tbl_user.role = 'Employee'
                               ORDER BY tbl_user.user_id ASC LIMIT $start_from, $limit");

$total_records_query = "SELECT COUNT(emp_id) FROM tbl_employee";
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
                                            <h2>List of All Employees on System</h2>
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
                                                        <th># Staff No</th>
                                                        <th onclick="sortTable(1)" scope="col">First Name <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Last Name</th>
                                                        <th>Position</th>
                                                        <th>Department</th>
                                                        <th>Years of Service</th>
                                                        <th>Mobile</th>
                                                        <th>User Access</th>
                                                        <th>Modify Details</th>



                                                    </tr>
                                                </thead>
                                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                                    <tbody>
                                                        <tr>

                                                            <td><?php echo $row['user_id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['surname']; ?></td>

                                                            <td><?php echo $row['position']; ?></td>
                                                            <td> <?php
                                                                    $getName = new department();
                                                                    $depCode = $row['department'];
                                                                    $deptNameArray = $getName->getDepartmentName($depCode);

                                                                    if (!empty($deptNameArray)) {
                                                                        $deptName = $deptNameArray[0]['departmentName'];
                                                                        echo $deptName;
                                                                    }
                                                                    ?></td>
                                                            <td><?php $date_joined = $row['date_joined'];
                                                                echo $years_of_service = $getEmp->calculateYearsOfService($date_joined);

                                                                ?></td>
                                                            <td><?php echo $row['mobile_number']; ?></td>
                                                            <td><?php if ((int)$row['isActive'] == 1)
                                                                    echo "<span class='badge bg-success text-white'>Active</span>";
                                                                else
                                                                    echo "<span class='badge bg-danger text-white'>Revoked
                                                                    </span>"; ?></td>


                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['user_id']; ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Modify
                                                                </button>
                                                            </td>

                                                            <!-- Edit Employee Modal -->
                                                            <div class="modal fade" id="editModal<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['user_id']; ?>">Edit Employee Details</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to edit employee details -->
                                                                            <form method="post" action="update_employee.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

                                                                                <div class="form-group">
                                                                                    <label for="position">Position</label>
                                                                                    <input type="text" class="form-control" name="position" required value="<?php echo $row['position']; ?>">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="mobile_number">Mobile Number</label>
                                                                                    <input pattern="[5]{1}[0-9]{7}" value="<?php echo $row['mobile_number']; ?>" title="Please enter valid Mobile number Eg: 5777XXXX" type="tel" class="form-control" name="mobile_number" required></input>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="employee">Assign to Department</label>
                                                                                    <select class="form-control" name="department">
                                                                                        <?php
                                                                                        foreach ($resultDept as $row) {
                                                                                            $department_id = $row['department_id'];
                                                                                            $name = $row['departmentName'];
                                                                                            echo '<option value="' . $department_id . '">' . $name . '</option>';
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="updateEmployee">Save Changes</button>
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
                                                    </tbody>

                                                <?php } ?>
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
                window.location.href = "editEmpDetails.php";
            }
        });
        ';
    }
    ?>
</script>

</html>