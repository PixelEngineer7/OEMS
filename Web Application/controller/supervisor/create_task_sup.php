<?php
require('../../model/task.php');
session_start();
$database = new DBHandler();

if (isset($_POST["taskSubmit"])) {
    $emp_id =  $_POST['emp_id'];
    $supervisor_id =  $_POST['supervisor_id'];
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $deadline_date = $_POST['deadline_date'];
    $status = "Pending";
    $progress = 0;

    $task = new task();

    $task->create_task($emp_id, $supervisor_id, $task_name, $task_description, $deadline_date, $status, $progress);

    $_SESSION['createTask'] = true;
    //unset($_SESSION['pms_id']);
}

header('location:../../view/supervisor/taskDashboard.php');
