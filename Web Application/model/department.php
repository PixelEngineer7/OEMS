<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class User for connection(PDO) with Database and PHP
require_once('database.php');

class department
{

    //Create Employee on tbl_employee
    public function createDepartment($departmentName, $departmentDetails, $departmentSupervisor)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_department ( departmentName , departmentDetails , departmentSupervisor) VALUES( :departmentName , :departmentDetails , :departmentSupervisor)');

        //call bind method in database class
        $database->bind(':departmentName', $departmentName);
        $database->bind(':departmentDetails', $departmentDetails);
        $database->bind(':departmentSupervisor', $departmentSupervisor);

        //execute prepared statement
        $database->execute();
    }

    public function getDepartmentDetails($departmentID)
    {
        $database = new DBHandler();
        //prepared statement to fetch department details by departmentID
        $database->query('SELECT * FROM tbl_department');
        $result = $database->resultset();
        return $result;
    }

    public function getDepartmentStaffList($departmentID)
    {
        $database = new DBHandler();
        //prepared statement to fetch staff assigned to the department by departmentID
        $database->query('SELECT * FROM tbl_employee WHERE departmentID = :departmentID');
        $database->bind(':departmentID', $departmentID);
        $result = $database->resultset();

        // Return the result as an array of staff
        return $result;
    }

    // Function to get Department Name from Department Code
    public function getDepartmentName($department_id)
    {
        $database = new DBHandler();
        $database->query('SELECT departmentName , departmentSupervisor FROM tbl_department WHERE department_id = :department_id');
        $database->bind(':department_id', $department_id);
        $result = $database->resultset();
        return $result;
    }

    // Function to get Department Name from Department Code
    public function getDeptName($department_id)
    {
        $database = new DBHandler();
        $database->query('SELECT departmentName FROM tbl_department WHERE department_id = :department_id');
        $database->bind(':department_id', $department_id);
        $result = $database->resultset();
        return $result;
    }

    public function countDepartment($database)
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_department');
        return $row = $database->resultset();
    }

    //Function to update Employee Details in Database
    public function updateDepartment($department_id, $departmentName, $departmentDetails, $departmentSupervisor)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_department SET departmentName=:departmentName , departmentDetails=:departmentDetails,departmentSupervisor=:departmentSupervisor WHERE department_id=:department_id');

        //call bind method in database class
        $database->bind(':department_id', $department_id);
        $database->bind(':departmentName', $departmentName);
        $database->bind(':departmentDetails', $departmentDetails);
        $database->bind(':departmentSupervisor', $departmentSupervisor);
        //execute prepared statement
        $database->execute();
    }
}
