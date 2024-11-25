<?php
require('../../model/attendance.php');
session_start();
$database = new DBHandler();

if (isset($_POST["timeInSubmit"])) {
    $emp_id =  $_POST['emp_id'];
    $time_in =  $_POST['time_in'];
    $dateArr =  $_POST['date'];

    // Separate the date into day, month, and year
    list($year, $month, $day) = explode("-", $dateArr);






    $task = new attendance();
    $task->time_in($emp_id, $day, $month, $year, $time_in);

    $_SESSION['timeInSuccess'] = true;
}
header('location:../../view/employee/attendanceDashboard.php');
