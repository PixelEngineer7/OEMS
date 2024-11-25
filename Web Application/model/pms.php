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

    //Update PMS with Metrics and Remarks
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
    public function getPMSEmployee($pms_id)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_pms WHERE pms_id = :pms_id');
        $database->bind(':pms_id', $pms_id);
        return $row = $database->resultset();
    }

    // Function to update and Add Metrics to PMS
    public function addMetrics($emp_id, $metric_array, $pms_status)
    {
        $database = new DBHandler();

        $metric_json = json_encode($metric_array);

        // Prepared statement
        $database->query('UPDATE tbl_pms 
                      SET metric_array = :metric_array, 
                          pms_status = :pms_status 
                      WHERE emp_id = :emp_id');

        // Bind parameters
        $database->bind(':emp_id', $emp_id);
        $database->bind(':metric_array', $metric_json); // Fix parameter name
        $database->bind(':pms_status', $pms_status);

        // Execute prepared statement
        $database->execute();
    }

    // Function to update and Add Metrics to PMS
    public function addMetricsSup($pms_id, $metric_array, $pms_status, $management_status)
    {
        $database = new DBHandler();

        $metric_json = json_encode($metric_array);

        // Prepared statement
        $database->query('UPDATE tbl_pms 
                       SET metric_array = :metric_array, 
                           pms_status = :pms_status ,
                           management_status = :management_status 
                       WHERE pms_id = :pms_id');

        // Bind parameters
        $database->bind(':pms_id', $pms_id);
        $database->bind(':metric_array', $metric_json); // Fix parameter name
        $database->bind(':pms_status', $pms_status);
        $database->bind(':management_status', $management_status);

        // Execute prepared statement
        $database->execute();
    }

    // Function to update and Add Metrics to PMS
    public function addMetricsEmp($pms_id, $metric_array, $pms_status, $management_status)
    {
        $database = new DBHandler();

        $metric_json = json_encode($metric_array);

        // Prepared statement
        $database->query('UPDATE tbl_pms 
                      SET metric_array = :metric_array, 
                          pms_status = :pms_status, 
                          management_status = :management_status 
                      WHERE pms_id = :pms_id');

        // Bind parameters
        $database->bind(':pms_id', $pms_id);
        $database->bind(':metric_array', $metric_json); // Fix parameter name
        $database->bind(':pms_status', $pms_status);
        $database->bind(':management_status', $management_status);

        // Execute prepared statement
        $database->execute();
    }

    // Function to add PMS Score to Database tbl_pms
    public function addScoreSup($pms_id, $score_array, $pms_status, $management_status)
    {
        $database = new DBHandler();

        $score_json = json_encode($score_array);

        // Prepared statement
        $database->query('UPDATE tbl_pms 
                      SET score_array = :score_array, 
                          pms_status = :pms_status ,
                          management_status = :management_status 
                      WHERE pms_id = :pms_id');

        // Bind parameters
        $database->bind(':pms_id', $pms_id);
        $database->bind(':score_array', $score_json); // Fix parameter name
        $database->bind(':pms_status', $pms_status);
        $database->bind(':management_status', $management_status);

        // Execute prepared statement
        $database->execute();
    }

    //Function to update Employee Details in Database
    public function updatePms($pms_id, $pms_status)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_pms SET pms_status=:pms_status  WHERE pms_id=:pms_id');

        //call bind method in database class
        $database->bind(':pms_id', $pms_id);
        $database->bind(':pms_status', $pms_status);
        //execute prepared statement
        $database->execute();
    }

    //Function to update Employee Details in Database
    public function updatePmsAdmin($pms_id, $pms_status, $management_status)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_pms SET pms_status=:pms_status , management_status=:management_status  WHERE pms_id=:pms_id');

        //call bind method in database class
        $database->bind(':pms_id', $pms_id);
        $database->bind(':pms_status', $pms_status);
        $database->bind(':management_status', $management_status);
        //execute prepared statement
        $database->execute();
    }

    public function updateKPAsKPIsObjectives($pms_id, $kpa_array, $kpi_array, $objective_array)
    {
        $database = new DBHandler();
        // Serialize arrays to JSON
        $kpa_json = json_encode($kpa_array);
        $kpi_json = json_encode($kpi_array);
        $obj_json = json_encode($objective_array);

        // Prepared statement for updating specific fields based on emp_id
        $database->query('UPDATE tbl_pms SET kpa_array = :kpa_json, kpi_array = :kpi_json, objective_array = :obj_json WHERE pms_id = :pms_id');

        // Bind parameters
        $database->bind(':pms_id', $pms_id);
        $database->bind(':kpa_json', $kpa_json);
        $database->bind(':kpi_json', $kpi_json);
        $database->bind(':obj_json', $obj_json);

        // Execute prepared statement
        return $database->execute();
    }

    public function adminAddScore($pms_id, $score_array)
    {
        $database = new DBHandler();
        // Serialize arrays to JSON
        $score_json = json_encode($score_array);


        // Prepared statement for updating specific fields based on emp_id
        $database->query('UPDATE tbl_pms SET score_array = :score_json WHERE pms_id = :pms_id');

        // Bind parameters
        $database->bind(':pms_id', $pms_id);
        $database->bind(':score_json', $score_json);


        // Execute prepared statement
        return $database->execute();
    }



    public function count_plus_one()
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status = "n+1"');

        try {
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

    public function count__pms_completed()
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status = "Completed"');

        try {
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

    public function count_pms_pendingHR()
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status = "Pending"');

        try {
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

    public function count_plus_two()
    {
        $database = new DBHandler();
        $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status = "n+2"');

        try {
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

    public function count_pms_emp_completed($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status="Completed" AND emp_id=:emp_id');
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

    public function count_pms_emp_sup_completed($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status="Completed" AND supervisor_id=:supervisor_id');
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
    public function count_pms_emp_sup_plus2($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status="n+2" AND supervisor_id=:supervisor_id');
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

    public function count_pms_emp_active($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE management_status="OB" AND emp_id=:emp_id');
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
    public function count_pms_emp_sup_active($supervisor_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE management_status="OB" AND supervisor_id=:supervisor_id');
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

    public function count_pms_emp_pending($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE management_status="MU" AND emp_id=:emp_id');
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

    public function count_pms_emp_n_2($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query('SELECT count(*) AS total FROM tbl_pms WHERE pms_status="n+2" AND emp_id=:emp_id');
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
}
