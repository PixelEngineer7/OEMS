<?php
//Name:RAMLOCHUND Gitendrajeet 
//Project: Infinity Networks Login Page
//Scope: Index Page / Login Authenticator for OEMS

session_start();
//Requires 2 class for it to be able to work correctly Class Database and Class user
require 'model/database.php';
require 'model/user.php';

$conn = mysqli_connect('localhost', 'root', '', 'oems');
//Getting Input value
if (isset($_POST['btnLogin'])) {
	// Escape special characters, if any
	$username = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['pwd']);

	if (empty($username) && empty($password)) {
		$error = '<span style=color:yellow>Please Fill out Username and Password Field!!!</span> ';
	} else {
		//Creating new objects from class user and call function to pass 2 parameters to object user
		$user = new user();
		$role = $user->getRole($username, $password);
		if ($role == 'unidentifiedrole') {
			$error = '<span style=color:Lime>INVALID!!! Username and Password</span>';
		} else {
			//Redirecting User Based on category obtained from database UDM table tblusers
			switch ($role) {
				case 'Employee':
					$_SESSION["email"] = $username;
					header('location:view/employee/dashboard.php');
					break;
				case 'Administrator':
					$_SESSION["username"] = $username;
					header('location:view/admin/dashboard.php');
					break;
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="" />
	<title>Infinity Networks Employee Management System | Welcome Page</title>
	<link rel="icon" type="image/x-icon" href="assets/icons/favicon.ico">
	<link rel="stylesheet" href="css/style_login.css">
	<link rel="stylesheet" href="css/font-login.css">
	<style type="text/css">
		.alert {
			padding: 10px;
			border: 1px solid transparent;
			border-radius: 5px;
			width: 250px;
			margin: 0px auto 10px auto;
		}

		.alert-danger {
			color: #dd4f43;
			background-color: #f0f0f0;
			border-color: #dd4f43;
			font-size: 16px;
			font-weight: bold
		}
	</style>
</head>

<body>
	<div class="wrapper">
		<div class="container">
			<h1><img src="assets/images/header.png" /></h1>
			<h2 class="text-center">Employee Management System</h2>
			<form class="form_login" method="post">
				<input type="text" placeholder="E-mail" name="email" required />
				<input type="password" placeholder="Password" name="pwd" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required />

				<button type="submit" style="background-color:#4CAF50; color:#fff; margin:10px;" name="btnLogin">Login</button>
				<br>
				<?php if (isset($error)) {
					echo $error;
				} ?>
				<br>
			</form>
			<div class="copyright" style="font-size:14px; margin-top:10px;">
				<p>Infinity Networks Copyright © 2024 . All rights reserved.
				</p>
			</div>


			<ul class="bg-bubbles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"> </script>
</body>

</html>