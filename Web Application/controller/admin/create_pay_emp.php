<?php
require('../../model/pay.php');
session_start();
$database = new DBHandler();


if (isset($_POST["create_pay"])) {
    $emp_id = $_POST['emp_id'];
    $month = $_POST['month'];
    $year = $_POST['year'];
    $basic_salary = $_POST['basic_salary'];
    $overtime = $_POST['overtime'];
    $bus_fare = $_POST['bus_fare'];
    $csg_contri = $_POST['csg_contri'];
    $nsf_contri = $_POST['nsf_contri'];
    $medical_contri = $_POST['medical_contri'];
    $net_pay = $_POST['net_pay'];
    $deductions = $_POST['deduction'];
    $gross_pay = $_POST['gross_pay'];
    $pay_status = "Complete";

    $pay = new pay();

    $pay->createPayslipAdmin($emp_id, $month, $year, $basic_salary, $deductions, $net_pay, $csg_contri, $overtime, $medical_contri, $nsf_contri, $bus_fare, $pay_status);

    $_SESSION['createPaySlip'] = true;
}
header('location:../../controller/admin/payslipDashboard.php');
