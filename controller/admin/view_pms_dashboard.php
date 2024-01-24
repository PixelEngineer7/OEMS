<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pms.php');

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
$result = mysqli_query($conn, "SELECT *
FROM tbl_user u
LEFT JOIN tbl_employee e ON u.user_id = e.user_id
WHERE u.role = 'Employee' AND e.user_id IS NOT NULL ORDER BY emp_id ASC LIMIT $start_from, $limit");


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id)
FROM tbl_employee");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);






$count1 = 0;
$count2 = 0;
$count3 = 0;
$count4 = 0;
