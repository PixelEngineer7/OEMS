<?php
require('../../model/leave.php');
require('../../model/balance.php');
session_start();
$database = new DBHandler();

if (isset($_POST["leaveSubmit"])) {
    $emp_id =  $_POST['emp_id'];
    $supervisor_id = $_POST['supervisor_id'];
    $leave_type = $_POST['leave_type'];
    $leave_reason = $_POST['leave_reason'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $leave_total = $_POST['leave_duration'];

    $approval_status = "Pending N+2";
    $absence_status = "Confirmed";


    $leave = new leave();
    $leave->createLeaveEmp($emp_id, $supervisor_id, $leave_type, $leave_reason, $start_date, $end_date, $leave_total, $approval_status, $absence_status);
    $bal = new balance();
    // Execute different functions based on the leave type
    switch ($leave_type) {
        case 'vacation':
            // Execute the function for vacation leave
            $bal->deduct_vacation($emp_id, $leave_total);
            $_SESSION['createLeave'] = true;
            header('location:../../view/supervisor/leaveDashboard.php');

            break;

        case 'sick':
            // Execute the function for sick leave
            $bal->deduct_sick($emp_id, $leave_total);
            $_SESSION['createLeave'] = true;
            header('location:../../view/supervisor/leaveDashboard.php');
            break;

        case 'wellness':
            // Execute the function for wellness leave
            $bal->deduct_wellness($emp_id, $leave_total);
            $_SESSION['createLeave'] = true;
            header('location:../../view/supervisor/leaveDashboard.php');

            break;

        default:
            // Handle any other leave type

            break;
    }
}
