<?php
require('../../model/balance.php');
session_start();
$database = new DBHandler();

if (isset($_POST["createLeaveBal"])) {
    $emp_id = $_POST['emp_id'];
    $bal_wellness = $_POST['wellness_leave'];
    $bal_sick_leave = $_POST['sick_leave'];
    $bal_vacation = $_POST['vacation_leave'];


    $bal = new balance();

    $bal->createLeaveBalance($emp_id, $bal_wellness, $bal_vacation, $bal_sick_leave);

    $_SESSION['updateSuccess'] = true;
}
header('location:../../view/admin/leaveDashboard.php');
