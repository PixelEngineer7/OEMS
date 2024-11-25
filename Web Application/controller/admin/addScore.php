<?php
require('../../model/pms.php');
session_start();
$database = new DBHandler();

if (isset($_POST["scoreSubmit"])) {
    $pms_id =  $_POST['pms_id'];
    $score_array = $_POST['score_array'];

    $pms = new pms();

    $pms->adminAddScore($pms_id, $score_array);

    $_SESSION['addScorePMS'] = true;
    //unset($_SESSION['pms_id']);
}

header('location:../admin/pmsDashboard.php');
