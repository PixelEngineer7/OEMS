<?php
require('../../model/attendance.php');
session_start();
$database = new DBHandler();

if (isset($_POST["timeOutSubmit"])) {
    $attendance_id =  $_POST['attendance_id'];
    $time_in =  $_POST['time_in'];
    $time_out =  $_POST['time_out'];

    $h_covered = (((float)$time_out - (float)($time_in)));
    $hours_covered = number_format(($h_covered - 1), 1);







    $task = new attendance();
    $task->time_out($attendance_id, $time_out, $hours_covered);

    $_SESSION['timeOutSuccess'] = true;
}
header('location:../../view/employee/attendanceDashboard.php');
