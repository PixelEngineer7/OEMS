<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class Employee for connection(PDO) with Database and PHP
require_once('database.php');

class employee
{

	//Create Employee on tbl_employee
	public function createEmployee($user_id, $position, $nic, $mobile_number, $phone_number, $address, $emergency_contact_name, $emergency_contact_number, $date_joined, $qualification, $department,  $profile_img, $basic_salary)
	{
		$database = new DBHandler();
		//prepared statement
		$database->query('INSERT INTO tbl_employee (user_id,position,nic,mobile_number,phone_number,address,emergency_contact_name,emergency_contact_number,date_joined,qualification,department,profile_img,basic_salary) VALUES(:user_id,:position,:nic , :mobile_number , :phone_number , :address , :emergency_contact_name , :emergency_contact_number , :date_joined , :qualification , :department , :profile_img,:basic_salary)');

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
		$database->bind(':basic_salary', $basic_salary);

		//execute prepared statement
		$database->execute();
	}

	//Function to get Employee Details from Database and same post to PHP
	public function getEmpDetails($user_id)
	{
		$database = new DBHandler();
		$database->query('SELECT u.role,u.name, u.surname, e.profile_img ,e.emp_id ,e.department FROM tbl_user u INNER JOIN tbl_employee e ON u.user_id = e.user_id WHERE u.user_id = :user_id');
		$database->bind(':user_id', $user_id);
		return $row = $database->resultset();
	}
	// Get Names from Employee Table
	public function getEmpName($emp_id)
	{
		$database = new DBHandler();
		$database->query('SELECT u.name, u.surname FROM tbl_user u INNER JOIN tbl_employee e ON u.user_id = e.user_id WHERE e.emp_id = :emp_id');
		$database->bind(':emp_id', $emp_id);

		// Execute the query
		$result = $database->resultset();

		// Check if there is a result
		if (!empty($result)) {
			// Return the first row's name and surname
			return $result[0];
		} else {
			// Return null if no result is found
			return null;
		}
	}


	// Get All Details from Employee Table
	public function getEmpFullDetails($emp_id)
	{
		$database = new DBHandler();
		$database->query('SELECT * FROM tbl_user u INNER JOIN tbl_employee e ON u.user_id = e.user_id WHERE e.emp_id = :emp_id');
		$database->bind(':emp_id', $emp_id);

		// Execute the query
		$result = $database->resultset();

		// Check if there is a result
		if (!empty($result)) {
			// Return the first row's name and surname
			return $result[0];
		} else {
			// Return null if no result is found
			return null;
		}
	}

	// Get All Details from Employee Table
	public function getAllEmployees($database)
	{
		$database->query('SELECT *
		FROM tbl_employee e
		LEFT JOIN tbl_user u ON u.user_id = e.user_id
		WHERE u.role != "Administrator"');

		// Execute the query
		$row = $database->resultset();
		return $row;
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
		$database->query("SELECT COUNT(*) AS total
		FROM tbl_user
		WHERE role IN ('Employee', 'Supervisor')
		  AND user_id NOT IN (SELECT user_id FROM tbl_employee WHERE user_id IS NOT NULL);");
		return $row = $database->resultset();
	}

	public function countRequireAttention($database)
	{
		$database = new DBHandler();
		$database->query('SELECT count(*) AS total FROM tbl_user WHERE isActive = 0');
		return $row = $database->resultset();
	}

	public function countSupervisor($database)
	{
		$database = new DBHandler();
		$database->query('SELECT count(*) AS total FROM tbl_user WHERE role = "Supervisor"');
		return $row = $database->resultset();
	}

	public function countEmp($database)
	{
		$database = new DBHandler();
		$database->query('SELECT count(*) AS total FROM tbl_user WHERE role = "Employee"');
		return $row = $database->resultset();
	}

	// Get All Details from Employee Table
	public function getEmpSupID($user_id)
	{
		$database = new DBHandler();
		$database->query('SELECT emp_id FROM tbl_employee WHERE user_id = :user_id');
		$database->bind(':user_id', $user_id);

		// Execute the query
		$result = $database->resultset();

		// Check if there is a result
		if (!empty($result)) {
			// Return the first row's name and surname
			return $result[0];
		} else {
			// Return null if no result is found
			return null;
		}
	}

	//Wildcard function for role
	public function getEmployeesByRole($database, $roleWildcard)
	{
		$database = new DBHandler();
		$database->query('SELECT *
                     FROM tbl_employee e
                     LEFT JOIN tbl_user u ON u.user_id = e.user_id
                     WHERE u.role LIKE :role');

		// Bind the parameter
		$database->bind(':role', $roleWildcard);

		// Execute the query
		$row = $database->resultset();
		return $row;
	}
}
