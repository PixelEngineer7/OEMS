<?php
require('../../model/user.php');
require('../../model/department.php');
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

if (isset($_POST["btnSubmit"])) {
   $departmentName = $_POST['departmentName'];
   $departmentDetails = $_POST['departmentDetails'];
   $departmentSupervisor = $_POST['departmentSupervisor'];

   $dept = new department();
   $dept->createDepartment($departmentName, $departmentDetails, $departmentSupervisor);
   $_SESSION['updateSuccess'] = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Header  -->
<?php include '../../components/header.php'; ?>
<!-- End of Header  -->

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
                           <h2>Create Department on System</h2>
                        </div>
                     </div>
                  </div>
                  <!-- row -->
                  <div class="row">
                     <!-- invoice section -->
                     <div class="col-md-12">
                        <div class="white_shd full margin_bottom_30">
                           <div class="full graph_head">
                              <div class="heading1 margin_0">
                                 <h2><i class="fa fa-user"></i> Department Creation onto Infinity Networks System
                                 </h2>
                              </div>
                           </div>

                           <div class="card-body">
                              <?php if ($result_staffs) { ?>
                                 <form class="forms-sample padding_infor_info" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                       <label for="Department Name">Department Name</label>
                                       <input name="departmentName" type="text" class="form-control" placeholder="Eg. Software Development" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="Department Description">Department Description</label>
                                       <input name="departmentDetails" type="text" class="form-control" placeholder="Eg. Regroup all software developers,engineers,mobile developers and QA Specialists" required>
                                    </div>
                                    <div class="form-group">
                                       <label for="employee">Select Supervisor to Assign from Dropdown List</label>
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

                                    <button type="submit" class="btn btn-primary mr-2" name="btnSubmit">Submit</button>
                                    <button type="cancel" class="btn btn-light" onclick="javascript:window.location='../../view/admin/userCreationDashboard.php';">Cancel</button>
                                 </form>
                              <?php } ?>
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
            text: "Department Created successfully!",
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