<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class User for connection(PDO) with Database and PHP
require_once('database.php');

class user
{

    //Create Employee on tbl_employee
    public function createUser($email, $password, $role, $name, $surname)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_user ( email , password , role,name,surname) VALUES( :email , :password , :role ,:name,:surname )');

        //call bind method in database class
        $database->bind(':email', $email);
        $database->bind(':password', $password);
        $database->bind(':role', $role);
        $database->bind(':name', $name);
        $database->bind(':surname', $surname);
        //execute prepared statement
        $database->execute();
    }

    //Function that verifies if User Role is matching the category it returns the category and same is ued with a switch case to proceed
    public function getRole($email, $password)
    {
        $database = new DBHandler();
        $database->query('SELECT role FROM tbl_user WHERE email=:email AND password=:password');
        $database->bind(':email', $email);
        $database->bind(':password', $password);
        $row = $database->resultset();
        $count = count($row);

        if ($count == 1) {

            $role = $row[0]['role'];
        } else {
            $role = "unidentifiedrole";
        }

        return $role;
    }
    public function getEmployees($database)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_user WHERE role="Employee"');
        return $row = $database->resultset();
    }

    public function getEmp($database)
    {
        // Assuming $database is already an instance of DBHandler
        $database->query('SELECT u.*
                     FROM tbl_user u
                     LEFT JOIN tbl_employee e ON u.user_id = e.user_id
                     WHERE u.role = "Employee" AND e.user_id IS NULL;');

        // Execute the query and fetch the results
        $result = $database->resultset();

        return $result; // Return the array of employees
    }

    public function getEmpList($database)
    {
        // Assuming $database is already an instance of DBHandler
        $database->query('SELECT *
                     FROM tbl_user u
                     LEFT JOIN tbl_employee e ON u.user_id = e.user_id
                     WHERE u.role = "Employee" AND e.user_id IS NOT NULL;');

        // Execute the query and fetch the results
        $result = $database->resultset();

        return $result; // Return the array of employees
    }





    public function getEmployeeID($email)
    {
        $database = new DBHandler();
        $database->query('SELECT user_id FROM tbl_user WHERE email = :email');
        $database->bind(':email', $email);
        $result = $database->resultset();

        if ($result) {
            return $result;
        } else {
            // Add error handling here, e.g., log the error or return a specific value for no match.
            return false;
        }
    }


    // Function to get Department Name from Department Code
    public function getEmpName($user_id)
    {
        $database = new DBHandler();
        $database->query('SELECT name,surname FROM tbl_user WHERE user_id = :user_id');
        $database->bind(':user_id', $user_id);
        $result = $database->resultset();
        return $result;
    }

    public function getEmpDetails($user_id)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_user LEFT JOIN tbl_employee ON tbl_user.user_id = tbl_employee.user_id WHERE tbl_user.user_id = :user_id');
        $database->bind(':user_id', $user_id);
        $result = $database->resultset();
        return $result;
    }




    //Function to update Employee Details in Database
    public function updateUAC($user_id, $isActive)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_user SET isActive=:isActive WHERE user_id=:user_id');

        //call bind method in database class
        $database->bind(':user_id', $user_id);
        $database->bind(':isActive', $isActive);
        //execute prepared statement
        $database->execute();
    }

    public function countUser($database)
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_user');
        return $row = $database->resultset();
    }
}
