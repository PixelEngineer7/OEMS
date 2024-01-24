<?php
require('../../model/user.php');
require('../../model/department.php');
require('../../model/employee.php');


session_start();
$database = new DBHandler();
$user = new user();


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
$result = mysqli_query($conn, "SELECT * FROM tbl_user ORDER BY user_id ASC LIMIT $start_from, $limit");

$result_db = mysqli_query($conn, "SELECT COUNT(user_id) FROM tbl_user");
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
                  </div>
                  <!-- row -->
                  <div class="row">
                     <!-- invoice section -->
                     <div class="row column1">
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30 yellow_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa fa-users"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $countUser; ?></p>
                                    <p class="head_couter">Registered Users</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30 blue1_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fa-solid fa-people-roof"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $countDepartment; ?></p>
                                    <p class="head_couter">Total Departments</p>
                                 </div>

                              </div>
                           </div>
                        </div>
                        <div class="col-md-6 col-lg-3">
                           <div class="full counter_section margin_bottom_30 green_bg">
                              <div class="couter_icon">
                                 <div>
                                    <i class="fas fa-users-cog"></i>
                                 </div>
                              </div>
                              <div class="counter_no">
                                 <div>
                                    <p class="total_no"><?php echo $countEmployee; ?></p>
                                    <p class="head_couter">Manage Employee</p>
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
                                    <p class="total_no"><?php echo $countRequireAttention; ?></p>
                                    <p class="head_couter">Require Attention</p>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                     <div class="col-md-12 margin_bottom_30">
                        <div class="row">
                           <div class="col-md-4 mb-4">
                              <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                 <div class="card-body">
                                    <h5 class="card-title">Registration of User</h5>
                                    <p class="card-text">Register | Create a user on the system can be Employee , Manager or Administrator</p>
                                 </div>
                                 <div class="card-footer text-center">
                                    <button type="button" class="btn btn-secondary" onclick="window.location='../../controller/admin/createUser.php';"> <i class="fa-solid fa-square-plus"></i> Create</button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 mb-4">
                              <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                 <div class="card-body">
                                    <h5 class="card-title">Employee Creation</h5>
                                    <p class="card-text">Employee Creation from list of registered user where category assigned as "Employee"</p>
                                 </div>
                                 <div class="card-footer text-center">
                                    <button type="button" class="btn btn-success" onclick="window.location='../../controller/admin/createEmployee.php';"><i class="fa-solid fa-square-plus"></i> Create</button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 mb-4">
                              <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                 <div class="card-body">
                                    <h5 class="card-title">Department Creation</h5>
                                    <p class="card-text">Create Department with details and assign its Manager</p>
                                 </div>
                                 <div class="card-footer text-center">
                                    <button type="button" class="btn btn-info" onclick="window.location='../../controller/admin/createDepartment.php';"><i class="fa-solid fa-square-plus"></i> Create</button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 mb-4">
                              <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                 <div class="card-body">
                                    <h5 class="card-title">Modify Employee Records</h5>
                                    <p class="card-text">Modify or Add Missing details of employee from a list</p>
                                 </div>
                                 <div class="card-footer text-center">
                                    <button type="button" class="btn btn-danger" onclick="window.location='../../controller/admin/editEmpDetails.php';"> <i class="fa-solid fa-pen-to-square"></i> Modify</button>
                                 </div>
                              </div>
                           </div>
                           <div class="col-md-4 mb-4">
                              <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                 <div class="card-body">
                                    <h5 class="card-title">Modify Department</h5>
                                    <p class="card-text">Modify , Add Missing details or Assign new Manager to department from a list</p>
                                 </div>
                                 <div class="card-footer text-center">
                                    <button type="button" class="btn btn-warning" onclick="window.location='../../controller/admin/modifyDepartmentStaff.php';"><i class="fa-solid fa-pen-to-square"></i> Modify</button>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>



                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2>List of Registered User on System</h2>
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
                                          <th>Email Address</th>
                                          <th>Category</th>
                                          <th onclick="sortTable(0)" scope="col">User Access <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                          <th>Modify UAC</th>



                                       </tr>
                                    </thead>
                                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                                       <tbody>
                                          <tr>
                                             <td><?php echo $row['user_id']; ?></td>
                                             <td><?php echo $row['name']; ?></td>
                                             <td><?php echo $row['surname']; ?></td>
                                             <td><?php echo $row['email']; ?></td>
                                             <td><?php echo $row['role']; ?></td>
                                             <td><?php if ((int)$row['isActive'] == 1)
                                                      echo "<span class='badge bg-success text-white'>Active</span>";
                                                   else
                                                      echo "<span class='badge bg-danger text-white'>Revoked
                                                                    </span>"; ?></td>

                                             <!-- Add an "Edit" button that triggers the modal -->
                                             <td>
                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['user_id']; ?>">
                                                   <i class="fa fa-refresh" aria-hidden="true"></i> Update
                                                </button>
                                             </td>

                                             <!-- Edit Employee Modal -->
                                             <div class="modal fade" id="editModal<?php echo $row['user_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                   <div class="modal-content">
                                                      <div class="modal-header">
                                                         <h5 class="modal-title" id="editModalLabel<?php echo $row['user_id']; ?>">User Access Control</h5>
                                                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                         </button>
                                                      </div>
                                                      <div class="modal-body">
                                                         <!-- Form to edit employee details -->
                                                         <form method="post" action="uac.php">
                                                            <!-- Populate form fields with current employee data -->
                                                            <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">

                                                            <div class="form-group">
                                                               <label for="user_access">Revoke User Access</label>
                                                               <select class="form-control" name="uac">
                                                                  <option value="0">Yes</option>
                                                                  <option value="1">No</option>
                                                               </select>
                                                            </div>


                                                            <div class="modal-footer">
                                                               <button type="submit" class="btn btn-success" name="updateUAC">Save Changes</button>
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