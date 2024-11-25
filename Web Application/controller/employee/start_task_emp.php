<?php
require('../../model/task.php');
session_start();
$database = new DBHandler();

if (isset($_POST["startTaskSubmit"])) {
    $task_identifier =  $_POST['task_identifier'];
    $status = "In Progress";
    $progress = 30;
    var_dump($task_identifier);
    $task = new task();
    $task->start_task($task_identifier, $status, $progress);

    $_SESSION['startTask'] = true;
}
header('location:../../view/employee/taskDashboard.php');
