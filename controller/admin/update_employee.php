<?php
require('../../model/employee.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updateEmployee"])) {
    $user_id = $_POST['user_id'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $mobile_number = $_POST['mobile_number'];

    $emp = new employee();

    $emp->updateEmployee($user_id, $position, $department, $mobile_number);

    $_SESSION['updateSuccess'] = true;
}
header('location:editEmpDetails.php');
