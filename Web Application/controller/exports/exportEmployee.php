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
$query = "SELECT e.emp_id,u.name , u.surname ,u.role,e.position,e.nic,e.mobile_number,e.address,e.date_joined
FROM tbl_employee e
LEFT JOIN tbl_user u ON u.user_id = e.user_id";
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
header('Content-Disposition: attachment; filename=listOfAllEmployee.csv');
$output = fopen('php://output', 'w');
fputcsv($output, array('Employee ID', 'Name', 'Surname', 'Type', 'Position', 'NIC', 'Mobile Number', 'Address', 'Date Joined'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}
