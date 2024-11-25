<?php
require('../../model/pms.php');
session_start();
$database = new DBHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pms_id = $_POST['pms_id'];
    $kpi_array = $_POST['kpi'];
    $kpa_array = $_POST['kpa'];
    $objective_array = $_POST['objective'];




    $pms = new pms();

    $pms->updateKPAsKPIsObjectives($pms_id, $kpa_array, $kpi_array, $objective_array);

    $_SESSION['modifyPMS'] = true;
}
header('location:../admin/pmsDashboard.php');
