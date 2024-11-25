<?php
session_start();
require('../../model/Database.php');
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


require('../../model/newsfeed.php');
$database = new DBHandler();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}

$limit = 10;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$result = mysqli_query($conn, "SELECT * FROM tbl_newsfeed ORDER BY news_id ASC LIMIT $start_from, $limit");

$result_db = mysqli_query($conn, "SELECT COUNT(news_id) FROM tbl_newsfeed");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);


$database = new DBHandler();
$feed = new newsfeed();
$RU = $feed->countAllNews($database);
foreach ($RU as $rowA)
    $countNewsPublished = (int)$rowA['total'];


$feed2 = new newsfeed();
$AD = $feed2->countNewsActive($database);
foreach ($AD as $rowB)
    $countActiveNews = (int)$rowB['total'];

$feed3 = new newsfeed();
$AE = $feed3->countNewsArchive($database);
foreach ($AE as $rowC)
    $countArchieveNews = (int)$rowC['total'];

$countRequireAttention = 0;
