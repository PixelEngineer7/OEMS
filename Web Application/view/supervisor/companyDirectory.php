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

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];
$emp_id = $row['emp_id'];



$database = new DBHandler();
$employees = new employee();
$AllEmployee = $employees->getAllEmployees($database);


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
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Company Directory</h2>
                                </div>
                            </div>
                        </div>

                        <!-- Search bar -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="text" id="searchInput" placeholder="Search employees..." class="form-control">
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->

                            <div class="container">
                                <div class="row column1">
                                    <?php $counter = 0; ?>
                                    <?php foreach ($AllEmployee as $employee) : ?>
                                        <div class="col-md-6 col-lg-4 employee-card">
                                            <div class="full white_shd margin_bottom_30">
                                                <div class="info_people">
                                                    <div class="p_info_img">
                                                        <img src="../../assets/images/<?php echo $employee['profile_img']; ?>" alt="Employee Picture" style="width: 100px; height: 120px;">
                                                    </div>
                                                    <div class="user_info_cont">
                                                        <h4><?php echo $employee['name'] . ' ' . $employee['surname']; ?></h4>
                                                        <p><i class="fa-solid fa-envelope"> </i> <?php echo $employee['email']; ?></p>
                                                        <p><i class="fa-solid fa-phone"></i> <?php echo $employee['phone_number']; ?></p>
                                                        <p><?php $deptID = $employee['department'];

                                                            $deptName = new department();
                                                            $NameDept = $deptName->getDepartmentName($deptID);
                                                            echo $NameDept[0]['departmentName'];

                                                            ?></p>
                                                        <p class="p_status"><?php echo $employee['position']; ?></p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $counter++;
                                        if ($counter % 3 == 0) {
                                            // Start a new row after every three cards
                                            echo '</div><div class="row column1">';
                                        }
                                        ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- footer -->
                    <?php include '../../components/footer.php'; ?>


                    <!-- JavaScript for Search Functionality -->
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const searchInput = document.getElementById('searchInput');
                            const employeeCards = document.querySelectorAll('.employee-card');

                            searchInput.addEventListener('input', function() {
                                const searchTerm = searchInput.value.toLowerCase();

                                employeeCards.forEach(function(card) {
                                    const cardText = card.textContent || card.innerText;
                                    const isVisible = cardText.toLowerCase().includes(searchTerm);
                                    card.style.display = isVisible ? 'block' : 'none';
                                });
                            });
                        });
                    </script>
</body>

</html>