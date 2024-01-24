<?php
require('../../model/user.php');
require('../../model/employee.php');
session_start();
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
                                                            <ul class="list-unstyled">
                                                                <li class="list-group-item"><i class="fa-solid fa-sitemap"></i> Department : <?php echo $department; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-calendar-days"></i> Date Joined Company : <?php echo $date_joined; ?></li>

                                                                <li class="list-group-item"><i class="fa fa-envelope-o"></i> Email Address : <?php echo $email; ?></li>
                                                                <li class="list-group-item"><i class="fa fa-phone"></i> Work Phone Number : <?php echo $phoneNumber; ?></li>
                                                                <li class="list-group-item"><i class="fa fa-mobile"></i> Mobile Number : <?php echo $mobileNumber; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-id-card"></i> National Identity Card Number: <?php echo $nic; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-map-location-dot"></i> Residential Address : <?php echo $address; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-address-book"></i></i> Emergency Contact Person : <?php echo $emergency_contact_name; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-phone-volume"></i> Emergency Contact Number : <?php echo $emergency_contact_number; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-phone-volume"></i> Emergency Contact Number : <?php echo $emergency_contact_number; ?></li>
                                                                <li class="list-group-item"><i class="fa-solid fa-user-graduate"></i> Highest Eduactional Qualification : <?php echo $qualification; ?></li>
                                                            </ul>
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
                    </div>
                    <!-- footer -->




























                    <!-- footer -->
                    <?php include '../../components/footer.php'; ?>
</body>

</html>