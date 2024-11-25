<?php
require('../../model/user.php');
session_start();
$database = new DBHandler();

if (isset($_POST["changeCat"])) {
    $user_id = $_POST['user_id'];
    $category = $_POST['category_user'];


    $usr = new user();

    $usr->updateCAT($user_id, $category);

    //$_SESSION['updateCat'] = true;
}
header('location:../../view/admin/userCreationDashboard.php');
