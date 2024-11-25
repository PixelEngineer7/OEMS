<?php
require('../../model/user.php');
session_start();
$database = new DBHandler();

if (isset($_POST["btnSubmit"])) {
    $user_id =  $_POST['user_id'];
    $password =  $_POST['password'];


    $user = new user();
    $user->changePassword($user_id, $password);
    $_SESSION['changePass'] = true;
}
header('location:../../view/supervisor/myinformation.php');
