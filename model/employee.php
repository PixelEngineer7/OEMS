<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class Employee for connection(PDO) with Database and PHP
require_once('database.php');

class employee
{

	//Create Employee on tbl_employee
	public function createEmployee($user_id, $position, $nic, $mobile_number, $phone_number, $address, $emergency_contact_name, $emergency_contact_number, $date_joined, $qualification, $department,  $profile_img)
	{
		$database = new DBHandler();
		//prepared statement
		$database->query('INSERT INTO tbl_employee (user_id,position,nic,mobile_number,phone_number,address,emergency_contact_name,emergency_contact_number,date_joined,qualification,department,profile_img) VALUES(:user_id,:position,:nic , :mobile_number , :phone_number , :address , :emergency_contact_name , :emergency_contact_number , :date_joined , :qualification , :department , :profile_img)');

		//call bind method in database class
		$database->bind(':user_id', $user_id);
		$database->bind(':position', $position);
		$database->bind(':nic', $nic);
		$database->bind(':mobile_number', $mobile_number);
		$database->bind(':phone_number', $phone_number);
		$database->bind(':address', $address);
		$database->bind(':emergency_contact_name', $emergency_contact_name);
		$database->bind(':emergency_contact_number', $emergency_contact_number);
		$database->bind(':date_joined', $date_joined);
		$database->bind(':qualification', $qualification);
		$database->bind(':department', $department);
		$database->bind(':profile_img', $profile_img);

		//execute prepared statement
		$database->execute();
	}

	//Function to get Employee Details from Database and same post to PHP
	public function getEmpDetails($user_id)
	{
		$database = new DBHandler();
		$database->query('SELECT u.name, u.surname, e.profile_img FROM tbl_user u INNER JOIN tbl_employee e ON u.user_id = e.user_id WHERE u.user_id = :user_id');
		$database->bind(':user_id', $user_id);
		return $row = $database->resultset();
	}

	//Function to update Employee Details in Database
	public function updateEmployee($user_id, $position, $department, $mobile_number)
	{
		$database = new DBHandler();
		//prepared statement
		$database->query('UPDATE tbl_employee SET position=:position , department=:department, mobile_number=:mobile_number WHERE user_id=:user_id');

		//call bind method in database class
		$database->bind(':user_id', $user_id);
		$database->bind(':position', $position);
		$database->bind(':department', $department);
		$database->bind(':mobile_number', $mobile_number);
		//execute prepared statement
		$database->execute();
	}


	// Function to calculate Years of Service
	public function calculateYearsOfService($date_joined)
	{
		$current_date = new DateTime();
		$service_date = new DateTime($date_joined);

		$interval = $current_date->diff($service_date);
		$years = $interval->y;
		$months = $interval->m;

		if ($months >= 6) {
			$years += 1; // Increment years if months >= 6
		}

		if ($years === 0) {
			return $months . ' months';
		} elseif ($months === 0) {
			return $years . ' years';
		} else {
			return $years . '.' . $months . ' years';
		}
	}

	public function countEmployee($database)
	{
		$database = new DBHandler();
		$database->query('SELECT COUNT(u.user_id) as total 
        FROM tbl_user u
        LEFT JOIN tbl_employee e ON u.user_id = e.user_id
        WHERE u.role = "Employee" AND e.user_id IS NULL;');
		return $row = $database->resultset();
	}

	public function countRequireAttention($database)
	{
		$database = new DBHandler();
		$database->query('SELECT count(*) AS total FROM tbl_user WHERE isActive = 0');
		return $row = $database->resultset();
	}
}
