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
            <?php include '../../components/warning.php'; ?>


            <!-- footer -->
            <?php include '../../components/footer.php'; ?>
</body>

</html>