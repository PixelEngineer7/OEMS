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


if ($role == 'Employee' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Employee' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT

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

$EmployeeDetails = new user();
$fetchDetails = $EmployeeDetails->getEmpDetails($user_id);

foreach ($fetchDetails as $arr) {

    $email = $arr['email'];
    $position = $arr['position'];
    $nic = $arr['nic'];
    $mobileNumber = $arr['mobile_number'];
    $phoneNumber = $arr['phone_number'];
    $address = $arr['address'];
    $emergency_contact_name = $arr['emergency_contact_name'];
    $emergency_contact_number = $arr['emergency_contact_number'];
    $date_joined = $arr['date_joined'];
    $qualification = $arr['qualification'];
    $department = $arr['department'];
}
$yearsOfService = $getEmp->calculateYearsOfService($date_joined);










?>
<!DOCTYPE html>
<html lang="en">
<!-- Components Header  -->
<?php include '../../components/header.php'; ?>
<!-- End of Header  -->

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
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Profile</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row column1">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2><?php echo $name . " " . $surname  ?>'s Profile</h2>
                                        </div>
                                    </div>
                                    <div class="full price_table padding_infor_info">
                                        <div class="row">
                                            <!-- user profile section -->
                                            <!-- profile image -->
                                            <div class="col-lg-12">
                                                <div class="full dis_flex center_text">
                                                    <div class="profile_img"> <?php echo '<img class="img-responsive" width="550" src="../../assets/images/' . $profile_img . '">'; ?></div>
                                                    <div class="profile_contant">
                                                        <div class="contact_inner">
                                                            <h3><?php echo $name . " " . $surname  ?></h3>
                                                            <h4>About: <?php echo $position; ?></h4>
                                                            <h4> Currently : <?php echo $yearsOfService; ?> in Service</h4>

                                                        </div>



                                                    </div>
                                                </div>
                                            </div>









                                            <!-- end user profile section -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <!-- Modifications section -->
                        <div class="col-md mb-2">
                            <div class="white_shd text-center pt-3">
                                <h4 class="pt-3"><u>Personal Details</u></h4>

                                <div class="container">

                                    <div class="row">
                                        <div class="col mb-4">
                                            <b><i class="fa-solid fa-sitemap"></i> Department : </b><?php
                                                                                                    $dept = new department();
                                                                                                    $deptName = $dept->getDeptName($department);
                                                                                                    echo $deptName[0]['departmentName'];
                                                                                                    ?>
                                        </div>
                                        <div class="col">
                                            <i class="fa-solid fa-calendar-days"></i> Date Joined Company : <?php echo $date_joined; ?>
                                        </div>
                                        <div class="col">
                                            <i class="fa fa-envelope-o"></i> Email Address : <?php echo $email; ?>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col mb-4">
                                            <i class="fa fa-phone"></i> Work Phone Number : <?php echo $phoneNumber; ?></li>
                                        </div>
                                        <div class="col">
                                            <i class="fa fa-mobile"></i> Mobile Number : <?php echo $mobileNumber; ?></li>
                                        </div>
                                        <div class="col">
                                            <i class="fa-solid fa-id-card"></i> National Identity Card Number: <?php echo $nic; ?></li>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-4">
                                            <i class="fa-solid fa-map-location-dot"></i> Residential Address : <?php echo $address; ?></li>
                                        </div>
                                        <div class="col">
                                            <i class="fa-solid fa-address-book"></i></i> Emergency Contact Person : <?php echo $emergency_contact_name; ?></li>
                                        </div>
                                        <div class="col">
                                            <i class="fa-solid fa-phone-volume"></i> Emergency Contact Number : <?php echo $emergency_contact_number; ?></li>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col mb-4">
                                            <i class="fa-solid fa-phone-volume"></i> Emergency Contact Number : <?php echo $emergency_contact_number; ?></li>
                                        </div>
                                        <div class="col">
                                            <i class="fa-solid fa-user-graduate"></i> Highest Eduactional Qualification : <?php echo $qualification; ?></li>
                                        </div>
                                        <div class="col">

                                        </div>
                                    </div>
                                    <br>

                                    <button type="button" class="btn btn-primary mt-3 mb-3" data-toggle="modal" data-target="#changePasswordModal">
                                        Change Password
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- Change password form -->
                                                    <form method="post" id="changePasswordForm" action="../../controller/employee/changePassword.php">
                                                        <input type="text" name="user_id" value="<?php echo $user_id; ?>" hidden>
                                                        <div class="form-group">
                                                            <label for="newPassword">New Password</label>
                                                            <input type="password" class="form-control" id="newPassword" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="confirmPassword">Confirm Password</label>
                                                            <input type="password" class="form-control" id="confirmPassword" name="password" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary" name="btnSubmit">Submit</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>




                        <!-- footer -->




























                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get the form and add a submit event listener
        const changePasswordForm = document.getElementById('changePasswordForm');
        changePasswordForm.addEventListener('submit', function(event) {
            // Get the new password and confirm password values
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;

            // Check if the passwords match
            if (newPassword !== confirmPassword) {
                // Passwords do not match, show an error message
                alert('Passwords do not match. Please try again.');
                // Prevent the form from being submitted
                event.preventDefault();
            }
            // If passwords match, the form will be submitted to the specified action
        });
    });
</script>




<script>
    <?php
    if (isset($_SESSION['changePass'])) {
        unset($_SESSION['changePass']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Password Changed successfully!",
        })
    ';
    }
    ?>
</script>


</html>