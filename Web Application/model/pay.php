<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 01.02.2024
//SCOPE: Creating a Class Pay for connection(PDO) with Database and PHP
require_once('database.php');

class pay
{

    //Create Employee on tbl_leave_bal
    public function createPayslipAdmin($emp_id, $month, $year, $basic_salary, $deductions, $net_pay, $csg_contri, $overtime, $medical_contri, $nsf_contri, $bus_fare, $pay_status)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_pay (emp_id , month , year , basic_salary , deductions , net_pay , csg_contri , overtime , medical_contri , nsf_contri , bus_fare,pay_status) VALUES(:emp_id , :month , :year , :basic_salary , :deductions, :net_pay , :csg_contri , :overtime , :medical_contri , :nsf_contri ,:bus_fare,:pay_status )');

        //call bind method in database class

        $database->bind(':emp_id', $emp_id);
        $database->bind(':month', $month);
        $database->bind(':year', $year);
        $database->bind(':basic_salary', $basic_salary);
        $database->bind(':deductions', $deductions);
        $database->bind(':net_pay', $net_pay);
        $database->bind(':csg_contri', $csg_contri);
        $database->bind(':overtime', $overtime);
        $database->bind(':medical_contri', $medical_contri);
        $database->bind(':nsf_contri', $nsf_contri);
        $database->bind(':bus_fare', $bus_fare);
        $database->bind(':pay_status', $pay_status);


        //execute prepared statement
        $database->execute();
    }

    public function getPaySlipEmp($pay_id)
    {
        $database = new DBHandler();
        $database->query('SELECT * FROM tbl_pay  WHERE pay_id = :pay_id');
        $database->bind(':pay_id', $pay_id);
        $result = $database->resultset();
        return $result;
    }

    //Function to get Employee Details from Database and same post to PHP
    public function getStatusPay($emp_id)
    {
        $database = new DBHandler();
        $database->query('SELECT pay_status FROM tbl_pay WHERE emp_id = :emp_id');
        $database->bind(':emp_id', $emp_id);
        return $row = $database->resultset();
    }

    public function count_earnings_emp($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query("SELECT SUM(basic_salary + bus_fare + overtime) AS total FROM tbl_pay WHERE emp_id = '$emp_id'");

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

    public function count_deductions_emp($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query("SELECT SUM(deductions) AS total FROM tbl_pay WHERE emp_id = '$emp_id'");

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

    public function count_netPay_emp($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query("SELECT SUM(net_pay) AS total FROM tbl_pay WHERE emp_id = '$emp_id'");

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

    public function count_csg_emp($emp_id)
    {
        try {
            $database = new DBHandler();
            $database->query("SELECT SUM(csg_contri) AS total FROM tbl_pay WHERE emp_id = '$emp_id'");

            $database->bind(':emp_id', $emp_id);

            $result = $database->resultset();

            // Check if there is at least one row and the 'total' index exists
            if (!empty($result) && isset($result[0]['total'])) {
                $row = $result[0];
                return $row['total']; // Return the total count
            } else {
                return 0;
            }
        } catch (Exception $e) {
            // Log or handle the exception
            return 0;
        }
    }
}
