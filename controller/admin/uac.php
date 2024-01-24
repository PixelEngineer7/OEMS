<?php
require('../../model/user.php');
session_start();
$database = new DBHandler();

if (isset($_POST["updateUAC"])) {
    $user_id = $_POST['user_id'];
    $isActive = $_POST['uac'];


    $usr = new user();

    $usr->updateUAC($user_id, $isActive);

    $_SESSION['updateSuccess'] = true;
}
header('location:../../view/admin/userCreationDashboard.php');
