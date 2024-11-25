<?php
//Name:RAMLOCHUND Gitendrajeet 
//Project: OEMS
//Scope: Export to CSV Script 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = mysqli_connect($servername, $username, $password, "$dbname");
if (!$conn) {
    die('Could not Connect MySql Server:');
}

// get users list
$query = "SELECT * FROM tbl_leave";
if (!$result = mysqli_query($conn, $query)) {
    exit(mysqli_error($con));
}

$users = array();
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=listOfAllEmployeeLeaves.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Leave ID', 'Employee ID', 'Supervisor ID', 'Leave Type', 'Leave Reason', 'Start Date', 'End Date', 'Duration', 'Approval Status', 'Abscence Status'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
