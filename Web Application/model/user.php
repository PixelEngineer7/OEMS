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
        $database->query('SELECT * FROM tbl_user WHERE role="Supervisor"');
        return $row = $database->resultset();
    }

    //Function to get all employees include the supervisor also for creation of user
    public function getEmp($database)
    {
        // Assuming $database is already an instance of DBHandler
        $database->query(
            "SELECT *
        FROM tbl_user
        WHERE role IN ('Employee', 'Supervisor')
          AND user_id NOT IN (SELECT user_id FROM tbl_employee WHERE user_id IS NOT NULL);"
        );

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

    public function getEmployeeEmail($user_id)
    {
        $database = new DBHandler();
        $database->query('SELECT email FROM tbl_user WHERE user_id = :user_id');
        $database->bind(':user_id', $user_id);
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
        $database->query('SELECT name,surname ,email FROM tbl_user WHERE user_id = :user_id');
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
    public function updateCAT($user_id, $role)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_user SET role=:role WHERE user_id=:user_id');

        //call bind method in database class
        $database->bind(':user_id', $user_id);
        $database->bind(':role', $role);
        //execute prepared statement
        $database->execute();
        $_SESSION['updateCat'] = true;
    }

    //Function to update UAC in Database
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
    //Function to update Employee Details in Database
    public function isActive($email)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('SELECT isActive FROM tbl_user where email=:email');

        //call bind method in database class
        $database->bind(':email', $email);
        $result = $database->resultset();
        if ($result) {
            return $result;
        } else {
            // Add error handling here, e.g., log the error or return a specific value for no match.
            return false;
        }
    }

    // Function to Change Password
    public function changePassword($user_id, $password)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_user SET password = :password WHERE user_id = :user_id');

        // Bind parameters
        $database->bind(':user_id', $user_id);
        $database->bind(':password', $password);

        // Execute prepared statement
        $database->execute();
    }

    //Automated Function acts like an AI for verification if user is supposed to be logged , if NO, it immediately logs user out.
    public function securityCheck($email)
    {
        $database = new DBHandler();
        $database->query('SELECT role FROM tbl_user WHERE email=:email');
        $database->bind(':email', $email);
        return $row = $database->resultset();
    }
}
