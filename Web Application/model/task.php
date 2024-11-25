<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 08.01.2024
//SCOPE: Creating a Class Leave for connection(PDO) with Database and PHP
require_once('database.php');

class task
{

    //Create Employee on tbl_leave_bal
    public function create_task($emp_id, $supervisor_id, $task_name, $description, $deadline, $status, $progress)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_task (emp_id , supervisor_id , task_name , description , deadline , status ,progress ) VALUES(:emp_id , :supervisor_id , :task_name , :description , :deadline ,:status,:progress)');

        //call bind method in database class

        $database->bind(':emp_id', $emp_id);
        $database->bind(':supervisor_id', $supervisor_id);
        $database->bind(':task_name', $task_name);
        $database->bind(':description', $description);
        $database->bind(':deadline', $deadline);
        $database->bind(':status', $status);
        $database->bind(':progress', $progress);
        //execute prepared statement
        $database->execute();
    }

    // Function to start task
    public function start_task($task_id, $status, $progress)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_task SET status = :status , progress = :progress WHERE task_id = :task_id');

        // Bind parameters
        $database->bind(':task_id', $task_id);
        $database->bind(':status', $status);
        $database->bind(':progress', $progress);

        // Execute prepared statement
        $database->execute();
    }

    // Function to start task
    public function close_task($task_id, $status, $progress, $feedback)
    {
        $database = new DBHandler();

        // Prepared statement
        $database->query('UPDATE tbl_task SET status = :status , progress = :progress , feedback = :feedback WHERE task_id = :task_id');

        // Bind parameters
        $database->bind(':task_id', $task_id);
        $database->bind(':status', $status);
        $database->bind(':progress', $progress);
        $database->bind(':feedback', $feedback);

        // Execute prepared statement
        $database->execute();
    }

    public function count_task_emp_pending($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Pending" AND supervisor_id=:supervisor_id');
            $database->bind(':supervisor_id', $supervisor_id);
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_emp_progress($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="In Progress" AND supervisor_id=:supervisor_id');
            $database->bind(':supervisor_id', $supervisor_id);
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_emp_OCOM($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Completed" AND supervisor_id=:supervisor_id');
            $database->bind(':supervisor_id', $supervisor_id);
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_emp_NCOM($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Not Completed" AND supervisor_id=:supervisor_id');
            $database->bind(':supervisor_id', $supervisor_id);
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_employee_pending($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Pending" AND emp_id=:emp_id');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_employee_progress($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="In Progress" AND emp_id=:emp_id');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_employee_OCOM($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Completed" AND emp_id=:emp_id');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_employee_NCOM($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Not Completed" AND emp_id=:emp_id');
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
            return 0; // Return a default value or handle the error as needed
        }
    }





    public function count_task_pending()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Pending"');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_progress()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="In Progress"');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_OCOM()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Completed"');
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
            return 0; // Return a default value or handle the error as needed
        }
    }

    public function count_task_NCOM()
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_task WHERE status="Not Completed"');
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
            return 0; // Return a default value or handle the error as needed
        }
    }
}
