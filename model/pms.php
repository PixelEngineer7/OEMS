<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 31.07.2023
//SCOPE: Creating a Class PMS for connection(PDO) with Database and PHP
require_once('database.php');

class pms
{
    public function createPMS($emp_id, $quarter_array, $kpa_array, $kpi_array, $objective_array,  $supervisor_id, $management_status, $pms_status)
    {
        $database = new DBHandler();
        // Serialize arrays to JSON
        $quarter_json = json_encode($quarter_array);
        $kpa_json = json_encode($kpa_array);
        $kpi_json = json_encode($kpi_array);
        $obj_json = json_encode($objective_array);

        //prepared statement
        $database->query('INSERT INTO tbl_pms (emp_id,quarter_array,kpa_array,kpi_array,objective_array,supervisor_id,management_status,pms_status) VALUES(:emp_id,:quarter_json,:kpa_json ,:kpi_json, :obj_json  , :supervisor_id , :management_status , :pms_status )');

        //call bind method in database class
        $database->bind(':emp_id', $emp_id);
        $database->bind(':quarter_json', $quarter_json);
        $database->bind(':kpa_json', $kpa_json);
        $database->bind(':kpi_json', $kpi_json);
        $database->bind(':obj_json', $obj_json);
        $database->bind(':supervisor_id', $supervisor_id);
        $database->bind(':management_status', $management_status);
        $database->bind(':pms_status', $pms_status);


        //execute prepared statement
        $database->execute();
    }

    public function updatePMSEmployee($emp_id, $actual_values, $supervisor_status, $management_status, $remarks, $pms_status)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_pms 
                          SET actual_values = :actual_values, 
                              supervisor_status = :supervisor_status, 
                              management_status = :management_status, 
                              remarks = :remarks, 
                              pms_status = :pms_status 
                          WHERE emp_id = :emp_id');

        // Bind parameters
        $database->bind(':emp_id', $emp_id);
        $database->bind(':actual_values', $actual_values);
        $database->bind(':remarks', $remarks);
        $database->bind(':supervisor_status', $supervisor_status);
        $database->bind(':management_status', $management_status);
        $database->bind(':pms_status', $pms_status);

        // Execute prepared statement
        $database->execute();
    }


    //Function to get Employee Details from Database and same post to PHP
    public function getStatusPMS($emp_id)
    {
        $database = new DBHandler();
        $database->query('SELECT pms_status FROM tbl_pms WHERE emp_id = :emp_id');
        $database->bind(':emp_id', $emp_id);
        return $row = $database->resultset();
    }

    //Function to get Employee Details from Database and same post to PHP
    public function getPMS($database)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_pms');
        return $row = $database->resultset();
    }

    //Function to get Employee Details from Database and same post to PHP
    public function getPMSEmployee($emp_id)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_pms WHERE emp_id = :emp_id');
        $database->bind(':emp_id', $emp_id);
        return $row = $database->resultset();
    }
}
