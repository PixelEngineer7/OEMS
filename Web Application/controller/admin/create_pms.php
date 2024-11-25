<?php
require('../../model/pms.php');
require('../../model/employee.php');
session_start();
$database = new DBHandler();
$check_emp = new employee();

if (isset($_POST["create_pms"])) {
    $emp_id = $_POST['emp_id'];
    $supervisor_id = $_POST['supervisor_id'];
    $quarter_array = $_POST['period_array'];
    $kpi_array = $_POST['kpi_array'];
    $kpa_array = $_POST['kpa_array'];
    $objective_array = $_POST['obj_array'];


    $check_emp_uID = $check_emp->getEmpSupID($supervisor_id);

    if ($supervisor_id != $check_emp_uID) {
        $pms_status = "n+1";
    } else {
        $pms_status = "n+2";
    }

    $management_status = "OB";




    $pms = new pms();

    $pms->createPMS($emp_id, $quarter_array, $kpa_array, $kpi_array, $objective_array, $supervisor_id, $management_status, $pms_status);

    $_SESSION['updateSuccess'] = true;
}
header('location:../admin/pmsDashboard.php');
