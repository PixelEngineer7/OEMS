<?php
require('../../model/pms.php');
session_start();
$database = new DBHandler();

if (isset($_POST["create_pms"])) {
    $emp_id = $_POST['emp_id'];
    $supervisor_id = $_POST['supervisor_id'];
    $quarter_array = $_POST['period_array'];
    $kpi_array = $_POST['kpi_array'];
    $kpa_array = $_POST['kpa_array'];
    $objective_array = $_POST['obj_array'];

    $pms_status = "Pending";
    $management_status = "In Progress";




    $pms = new pms();

    $pms->createPMS($emp_id, $quarter_array, $kpa_array, $kpi_array, $objective_array, $supervisor_id, $management_status, $pms_status);

    $_SESSION['updateSuccess'] = true;
}
header('location:../view/admin/pmsDashboard.php');