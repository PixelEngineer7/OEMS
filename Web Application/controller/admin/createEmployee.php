<?php
require('../../model/user.php');
require('../../model/employee.php');
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
$getDept = new department();

$result = $getUser->getEmp($database);
$resultDept = $getDept->getDepartmentDetails($database);

if (isset($_POST["btnSubmit"])) {
   $user_id = $_POST['employee_id'];
   $position = $_POST['position'];
   $nic = $_POST['nic'];
   $mobile_number = $_POST['mobile_number'];
   $phone_number = $_POST['phone_number'];
   $address = $_POST['address'];
   $emergency_contact_name = $_POST['emergency_contact_name'];
   $emergency_contact_number = $_POST['emergency_contact_number'];
   $date_joined = $_POST['date_joined'];
   $qualification = $_POST['qualification'];
   $department = $_POST['department'];
   $basic_salary = $_POST['basic_salary'];
   $profile_img = $_FILES['profile_img']['name'];
   $profile_img_temp = $_FILES['profile_img']['tmp_name'];



   $emp = new employee();

   $emp->createEmployee($user_id, $position, $nic, $mobile_number, $phone_number, $address, $emergency_contact_name, $emergency_contact_number, $date_joined, $qualification, $department, $profile_img, $basic_salary);



   // Validate and process file upload
   if (isset($profile_img) && !empty($profile_img)) {
      $uploaddir = '../../assets/images/';
      $uploadfile = $uploaddir . basename($profile_img);

      if (move_uploaded_file($profile_img_temp, $uploadfile)) {
         // File uploaded successfully
         "File is valid, and was successfully uploaded.";
      } else {
         // File upload failed
         "Upload failed.";
      }
   }
   $_SESSION['updateSuccess'] = true;
}
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
            <div class="midde_cont">
               <div class="container-fluid">
                  <div class="row column_title">
                     <div class="col-md-12">
                        <div class="page_title">
                           <h2>Create Employee on System</h2>
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
                                 <h2><i class="fa fa-user-plus"></i> Employee Registration Form</h2>
                              </div>
                           </div>

                           <div class="card-body">
                              <?php if ($result) { ?>
                                 <form class="forms-sample padding_infor_info" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                       <label for="employee">Select Employee From Dropdown List</label>
                                       <select class="form-control" name="employee_id">
                                          <?php
                                          foreach ($result as $row) {
                                             $userID = $row['user_id'];
                                             $fullName = $row['name'] . ' ' . $row['surname'];
                                             echo '<option value="' . $userID . '">' . $fullName . '</option>';
                                          }
                                          ?>
                                       </select>
                                    </div>

                                    <div class="form-group">
                                       <label>Profile Picture</label>&nbsp;&nbsp;
                                       <input type="file" name="profile_img" class="btn btn-secondary" accept="image/*" onchange="preview()" />
                                       &nbsp;<img id="frame" src="" width="100px" height="100px" alt="Image Preview" />
                                    </div>

                                    <div class="form-group">
                                       <label for="position">Position Occupy</label>
                                       <input name="position" type="text" class="form-control" placeholder="Eg. Software Engineer" required>
                                    </div>

                                    <div class="form-group">
                                       <label for="nic">Mauritian NIC(MNIC)</label>
                                       <input name="nic" type="text" class="form-control" placeholder="Mauritian National Identity Card Number Eg. H070890040101A" required>
                                    </div>

                                    <div class="form-group">
                                       <label for="mobile_number">Mobile Number</label>
                                       <input pattern="[5]{1}[0-9]{7}" placeholder="Eg. 57770000" title="Please enter valid Mobile number Eg: 5777XXXX" type="tel" class="form-control" name="mobile_number" required></input>
                                    </div>

                                    <div class="form-group">
                                       <label for="phone_number">Phone Number</label>
                                       <input pattern="[0-9]{7}" placeholder="Eg. 2030000" title="Please enter valid Phone number Eg: 203XXXX" type="tel" class="form-control" name="phone_number" required></input>
                                    </div>

                                    <div class="form-group">
                                       <label for="address">Residential Address</label>
                                       <input type="text" class="form-control" name="address" placeholder="Eg. 4, Wall Street" required></input>
                                    </div>

                                    <div class="form-group">
                                       <label for="emergency_contact_name">Emergency Contact Person</label>
                                       <input name="emergency_contact_name" type="text" class="form-control" placeholder="Eg. Erling Halaand">
                                    </div>

                                    <div class="form-group">
                                       <label for="emergency_contact_number">Emergency Contact Number</label>
                                       <input pattern="^\+?[0-9]{1,3}\s?\(?\d{2,4}\)?[\s.-]?\d{3,4}[\s.-]?\d{3,4}$" placeholder="Eg. +123 (45) 6789-0123" title="Please enter a valid phone number" type="tel" class="form-control" name="emergency_contact_number" required>

                                    </div>

                                    <div class="form-group">
                                       <label for="date_joined">Date Joined Company</label>
                                       <input name="date_joined" type="date" class="form-control">
                                    </div>

                                    <div class="form-group">
                                       <label for="qualification">Highest Educational qualification</label>
                                       <input name="qualification" type="text" class="form-control" placeholder="Eg. Degree">
                                    </div>

                                    <div class="form-group">
                                       <label for="basic_salary">Basic Salary</label>
                                       <input name="basic_salary" type="text" class="form-control" pattern="[0-9]+" required>
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


                                    <button type="submit" class="btn btn-primary mr-2" name="btnSubmit">Submit</button>
                                    <button type="reset" class="btn btn-warning mr-2" name="btnReset">Reset</button>
                                    <button type="button" class="btn btn-light" onclick="javascript:window.location='../../view/admin/userCreationDashboard.php';">Cancel</button>
                                 </form>
                              <?php } ?>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- footer -->
                  <?php include '../../components/footer.php'; ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</body>

<script>
   <?php
   if (isset($_SESSION['updateSuccess'])) {
      unset($_SESSION['updateSuccess']);
      echo '
        Swal.fire({
            icon: "success",
            title: "Good job!",
            text: "Employee Created successfully!",
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