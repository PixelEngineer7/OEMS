<?php
require('../../model/leave.php');
require('../../model/balance.php');
session_start();
$database = new DBHandler();

if (isset($_POST["approveLeave"])) {
    $leave_id =  $_POST['leave_id'];
    $emp_id = $_POST['emp_id'];
    $leave_type = $_POST['leave_type'];
    $leave_total = $_POST['leave_total'];
    $approval_status = $_POST['approval_status'];

    if ($approval_status == "Approved") {
        $leave = new leave();
        $bal = new balance();
        // Execute different functions based on the leave type
        switch ($leave_type) {
            case 'vacation':
                // Execute the function for vacation leave
                $bal->deduct_vacation($emp_id, $leave_total);
                $leave->update_approval_status_admin($leave_id, $approval_status);
                $_SESSION['approvedSuccess'] = true;
                header('location:../../view/supervisor/leaveDashboard.php');

                break;

            case 'sick':
                // Execute the function for sick leave
                $bal->deduct_sick($emp_id, $leave_total);
                $leave->update_approval_status_admin($leave_id, $approval_status);
                $_SESSION['approvedSuccess'] = true;
                header('location:../../view/supervisor/leaveDashboard.php');
                break;

            case 'wellness':
                // Execute the function for wellness leave
                $bal->deduct_wellness($emp_id, $leave_total);
                $leave->update_approval_status_admin($leave_id, $approval_status);
                $_SESSION['approvedSuccess'] = true;
                header('location:../../view/supervisor/leaveDashboard.php');
                break;

            default:
                // Handle any other leave type

                break;
        }
    } else {
        $leave = new leave();
        $leave->update_approval_status_admin($leave_id, $approval_status);

        $_SESSION['approvedSuccess'] = true;
        //unset($_SESSION['pms_id']);

    }
}

header('location:../../view/supervisor/leaveDashboard.php');
