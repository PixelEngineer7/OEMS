<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pms.php');

require('../../model/user.php');


// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Administrator' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Administrator' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT



$database = new DBHandler();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}

$limit = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$allowedRoles = ['Supervisor', 'Employee'];

$result = mysqli_query($conn, "SELECT *
    FROM tbl_user u
    LEFT JOIN tbl_employee e ON u.user_id = e.user_id
    WHERE u.role IN ('" . implode("','", $allowedRoles) . "') AND e.user_id IS NOT NULL
    ORDER BY emp_id ASC
    LIMIT $start_from, $limit");


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id)
FROM tbl_employee");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);





$pms_count1 = new pms();
$count1 = $pms_count1->count_plus_one();
$count2 = $pms_count1->count_plus_two();
$count3 = $pms_count1->count_pms_pendingHR();
$count4 = $pms_count1->count__pms_completed();
