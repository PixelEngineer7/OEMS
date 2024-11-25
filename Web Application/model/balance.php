<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 08.01.2024
//SCOPE: Creating a Class Leave for connection(PDO) with Database and PHP
require_once('database.php');

class balance
{

    //Create Employee on tbl_leave_bal
    public function createLeaveBalance($emp_id, $bal_wellness, $bal_vacation, $bal_sick_leave)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_leave_bal (emp_id , bal_wellness , bal_vacation , bal_sick_leave) VALUES(:emp_id , :bal_wellness , :bal_vacation , :bal_sick_leave )');

        //call bind method in database class

        $database->bind(':emp_id', $emp_id);
        $database->bind(':bal_wellness', $bal_wellness);
        $database->bind(':bal_vacation', $bal_vacation);
        $database->bind(':bal_sick_leave', $bal_sick_leave);
        //execute prepared statement
        $database->execute();
    }

    //Function to deducted_wellness Balance  in Database
    public function deduct_wellness($emp_id, $deducted_wellness)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_leave_bal SET bal_wellness = bal_wellness - :deducted_wellness  WHERE emp_id = :emp_id');

        //call bind method in database class
        $database->bind(':emp_id', $emp_id);
        $database->bind(':deducted_wellness', $deducted_wellness);
        //execute prepared statement
        $database->execute();
    }

    // Function to deduct sick leave balance in Database
    public function deduct_sick($emp_id, $deducted_sick)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_leave_bal SET bal_sick_leave = bal_sick_leave - :deducted_sick  WHERE emp_id = :emp_id');

        // Bind parameters
        $database->bind(':emp_id', $emp_id);
        $database->bind(':deducted_sick', $deducted_sick);  // Corrected parameter name
        // Execute prepared statement
        $database->execute();
    }

    //Function to deduct_vacation Balance  in Database
    public function deduct_vacation($emp_id, $deduct_vacation)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_leave_bal SET bal_vacation = bal_vacation - :deduct_vacation  WHERE emp_id = :emp_id');

        //call bind method in database class
        $database->bind(':emp_id', $emp_id);
        $database->bind(':deduct_vacation', $deduct_vacation);
        //execute prepared statement
        $database->execute();
    }

    // Function to check if emp_id exists in tbl_leave_bal
    public function checkEmpExist($emp_id)
    {
        $database = new DBHandler();

        // Prepared statement to check if emp_id exists
        $database->query('SELECT bal_id FROM tbl_leave_bal WHERE emp_id = :emp_id');
        $database->bind(':emp_id', $emp_id);


        $row = $database->resultset();
        if ($row != NULL)
            return true;
        else
            return false;
    }


    public function count_bal_well($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT bal_wellness FROM tbl_leave_bal WHERE emp_id=:emp_id');
            $database->bind(':emp_id', $emp_id);
            $result = $database->resultset();

            // Check if there is at least one row and the 'bal_wellness' index exists
            if (!empty($result) && isset($result[0]['bal_wellness'])) {
                $row = $result[0];
                return $row['bal_wellness']; // Return the bal_wellness count
            } else {
                return 0; // No rows found or 'bal_wellness' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    public function count_bal_sick($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT bal_sick_leave FROM tbl_leave_bal WHERE emp_id=:emp_id');
            $database->bind(':emp_id', $emp_id);
            $result = $database->resultset();

            // Check if there is at least one row and the 'bal_wellness' index exists
            if (!empty($result) && isset($result[0]['bal_sick_leave'])) {
                $row = $result[0];
                return $row['bal_sick_leave']; // Return the bal_wellness count
            } else {
                return 0; // No rows found or 'bal_wellness' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }
    public function count_bal_vacation($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT bal_vacation FROM tbl_leave_bal WHERE emp_id=:emp_id');
            $database->bind(':emp_id', $emp_id);
            $result = $database->resultset();

            // Check if there is at least one row and the 'bal_wellness' index exists
            if (!empty($result) && isset($result[0]['bal_vacation'])) {
                $row = $result[0];
                return $row['bal_vacation']; // Return the bal_wellness count
            } else {
                return 0; // No rows found or 'bal_wellness' index is not set, return a default value
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }

    //Function to deducted_wellness Balance  in Database
    public function updateLeaveBalance($emp_id, $bal_wellness, $bal_vacation, $bal_sick_leave)
    {
        try {
            $database = new DBHandler();
            //prepared statement
            $database->query('UPDATE tbl_leave_bal SET bal_wellness = :bal_wellness ,bal_vacation = :bal_vacation,bal_sick_leave = :bal_sick_leave WHERE emp_id = :emp_id');

            //call bind method in database class
            $database->bind(':emp_id', $emp_id);
            $database->bind(':bal_wellness', $bal_wellness);
            $database->bind(':bal_vacation', $bal_vacation);
            $database->bind(':bal_sick_leave', $bal_sick_leave);
            //execute prepared statement
            $database->execute();
            $_SESSION['adjust'] = true;
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
            $_SESSION['failure'] = true;
        }
    }

    //Function to deducted_wellness Balance  in Database
    public function getEmpBalance($emp_id)
    {
        $database = new DBHandler();
        // Prepared statement
        $database->query('SELECT * FROM tbl_leave_bal WHERE emp_id=:emp_id');
        $database->bind(':emp_id', $emp_id);

        // Fetch and return the result
        return $database->resultset();
    }
}
