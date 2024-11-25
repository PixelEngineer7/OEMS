<?php
//AUTHOR: Gitendrajeet RAMLOCHUND
//DATE: 08.01.2024
//SCOPE: Creating a Class attendance for connection(PDO) with Database and PHP
require_once('database.php');

class attendance
{

    //Create Employee create attendance and time in
    public function time_in($emp_id, $date, $month, $year, $time_in)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('INSERT INTO tbl_attendance (emp_id , date , month , year,time_in) VALUES(:emp_id , :date , :month , :year,:time_in )');

        //call bind method in database class

        $database->bind(':emp_id', $emp_id);
        $database->bind(':date', $date);
        $database->bind(':month', $month);
        $database->bind(':year', $year);
        $database->bind(':time_in', $time_in);
        //execute prepared statement
        $database->execute();
    }

    //Function to time out
    public function time_out($attendance_id, $time_out, $hours_covered)
    {
        $database = new DBHandler();
        //prepared statement
        $database->query('UPDATE tbl_attendance SET time_out =:time_out , hours_covered =:hours_covered  WHERE attendance_id = :attendance_id');

        //call bind method in database class
        $database->bind(':attendance_id', $attendance_id);
        $database->bind(':time_out', $time_out);
        $database->bind(':hours_covered', $hours_covered);
        //execute prepared statement
        $database->execute();
    }
}
