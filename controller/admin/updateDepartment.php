<?php
require('../../model/department.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updateDepartment"])) {
    $department_id = $_POST['department_id'];
    $departmentName = $_POST['departmentName'];
    $departmentDetails = $_POST['departmentDetails'];
    $departmentSupervisor = $_POST['departmentSupervisor'];

    $dept = new department();

    $dept->updateDepartment($department_id, $departmentName, $departmentDetails, $departmentSupervisor);

    $_SESSION['updateSuccess'] = true;
}
header('location:modifyDepartmentStaff.php');
