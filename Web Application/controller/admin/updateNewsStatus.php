<?php
require('../../model/newsfeed.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updateNewsStatus"])) {
    $news_id = $_POST['news_id'];
    $isActive = $_POST['isActive'];


    $news = new newsfeed();

    $news->updateNewsStatus($news_id, $isActive);

    $_SESSION['updateSuccess'] = true;
}
header('location:informationDashboard.php');
