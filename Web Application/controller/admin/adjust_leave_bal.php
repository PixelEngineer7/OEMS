<?php
require('../../model/balance.php');
session_start();
$database = new DBHandler();

try {
    if (isset($_POST["adjustLeaveBal"])) {
        $emp_id = $_POST['emp_id'];
        $bal_wellness = $_POST['wellness_leave'];
        $bal_sick_leave = $_POST['sick_leave'];
        $bal_vacation = $_POST['vacation_leave'];

        $bal = new balance();

        $bal->updateLeaveBalance($emp_id, $bal_wellness, $bal_vacation, $bal_sick_leave);
        header('location:../../view/admin/leaveDashboard.php');
    }
} catch (Exception $e) {
    $_SESSION['failure'] = true;
}
