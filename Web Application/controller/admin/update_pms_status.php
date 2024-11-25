<?php
require('../../model/pms.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updatePMStatus"])) {
    $pms_id = $_POST['pms_id'];
    $pms_status = $_POST['pms_status'];

    switch ($pms_status) {
        case "Completed":
            $management_status = "SU";
            break; // Add break statement to exit the switch after this case
        case "Pending":
            $management_status = "MU";
            break; // Add break statement to exit the switch after this case
        case "n+1":
            $management_status = "OB";
            break; // Add break statement to exit the switch after this case
        default:
            // Handle the case where $pms_status does not match any of the specified cases
            break;
    }





    $pms = new pms();

    $pms->updatePmsAdmin($pms_id, $pms_status, $management_status);

    $_SESSION['updatePMS'] = true;
}
header('location:../../view/admin/pmsDashboard.php');
