<?php
require('../../model/task.php');
session_start();
$database = new DBHandler();

if (isset($_POST["startTaskSubmit"])) {
    $task_identifier =  $_POST['task_identifier'];
    $status = $_POST['work_status'];
    if ($status == "Completed") {
        $progress = 100;
    } else {
        $progress = 50;
    }
    $feedback = $_POST['feedback'];

    $task = new task();
    $task->close_task($task_identifier, $status, $progress, $feedback);

    $_SESSION['closeTask'] = true;
}
header('location:../../view/employee/taskDashboard.php');
