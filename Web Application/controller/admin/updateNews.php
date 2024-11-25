<?php
require('../../model/newsfeed.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updateNews"])) {
    $news_id = $_POST['news_id'];
    $content = $_POST['content'];
    $title = $_POST['title'];


    $news = new newsfeed();

    $news->updateNews($news_id, $title, $content);

    $_SESSION['updateSuccess'] = true;
}
header('location:informationDashboard.php');
