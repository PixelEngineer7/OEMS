<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 08.01.2024
//SCOPE: Creating a Class Leave for connection(PDO) with Database and PHP
require_once('database.php');

class leave
{

    //Create Employee on tbl_leave
    public function createLeaveEmp($emp_id, $supervisor_id, $leave_type, $leave_reason, $start_date, $end_date, $leave_total, $approval_status, $absence_status)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_leave (emp_id,supervisor_id,leave_type,leave_reason,start_date,end_date,leave_total,approval_status,absence_status) VALUES(:emp_id , :supervisor_id , :leave_type  , :leave_reason , :start_date , :end_date , :leave_total , :approval_status , :absence_status)');

        //call bind method in database class
        $database->bind(':emp_id', $emp_id);
        $database->bind(':supervisor_id', $supervisor_id);
        $database->bind(':leave_type', $leave_type);
        $database->bind(':leave_reason', $leave_reason);
        $database->bind(':start_date', $start_date);
        $database->bind(':end_date', $end_date);
        $database->bind(':leave_total', $leave_total);
        $database->bind(':approval_status', $approval_status);
        $database->bind(':absence_status', $absence_status);

        //execute prepared statement
        $database->execute();
    }

    // Function to deduct sick leave balance in Database
    public function update_approval_status_admin($leave_id, $approval_status)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_leave SET approval_status = :approval_status WHERE leave_id = :leave_id');

        // Bind parameters
        $database->bind(':leave_id', $leave_id);
        $database->bind(':approval_status', $approval_status);
        // Execute prepared statement
        $database->execute();
    }

    public function count_leave_emp_rejected($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_leave WHERE approval_status="Rejected" AND emp_id=:emp_id');
            $database->bind(':emp_id', $emp_id);
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_leave_emp_leave($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_leave WHERE approval_status="Approved" AND emp_id=:emp_id');
            $database->bind(':emp_id', $emp_id);
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_leave_n_plus_one()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_leave WHERE approval_status="Pending N+1"');
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_leave_n_plus_two()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_leave WHERE approval_status="Pending N+2"');
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_leave_attention()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT COUNT(*) AS total 
            FROM tbl_leave 
            WHERE approval_status = "Pending N+2" 
              OR approval_status = "Pending N+1"');
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_leave()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_leave');
            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0; // No rows found or 'total' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }
}
