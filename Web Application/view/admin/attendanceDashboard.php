<?php
require('../../controller/admin/admin_info_getDetails.php');
require('../../model/employee.php');


// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Administrator' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Administrator' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT

// Your database connection logic
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'oems';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Your SQL statement
$sql = "SELECT * FROM tbl_attendance";

// Execute the query
$result = $conn->query($sql);

// Check if the query was successful
if ($result) {
    // Fetch the result as an associative array
    $attendanceData = [];
    while ($row = $result->fetch_assoc()) {
        $hoursCovered = is_numeric($row['hours_covered']) ? $row['hours_covered'] : 0;
        $attendanceData[] = [
            'emp_id' => $row['emp_id'],
            'month' => $row['month'],
            'day' => $row['date'],
            'hours_covered' => $row['hours_covered']
            // Add more fields as needed
        ];
    }

    // Free the result set
    $result->free();
} else {
    // Handle query error
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$limit = 10;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;


$resultA = mysqli_query($conn, "SELECT * FROM tbl_attendance ORDER BY attendance_id ASC LIMIT $start_from, $limit");
// Check if the query was successful
if (!$result) {
    die('Error in SQL query: ' . mysqli_error($conn));
}


$result_db = mysqli_query($conn, "SELECT COUNT(attendance_id) FROM tbl_attendance");
if (!$result_db) {
    die('Error in SQL query: ' . mysqli_error($conn));
}

$row_db = mysqli_fetch_row($result_db);

if ($row_db) {
    // Rows found
    $total_records = $row_db[0];
    $total_pages = ceil($total_records / $limit);
} else {
    // No rows found
    $total_records = 0;
    $total_pages = 0;
}





?>

<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/navbar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/topbar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Employee Daily Attendance Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="col-lg-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Employee Monthly Trends</h2>
                                        </div>
                                    </div>
                                    <div class="chart_section padding_infor_info">
                                        <canvas id="monthlyTrends"></canvas>

                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                // Now you can use the $attendanceData array in your JavaScript code
                                                const attendanceData = <?php echo json_encode($attendanceData); ?>;

                                                // Separate data by employee ID
                                                const datasets = {};
                                                attendanceData.forEach(entry => {
                                                    if (!datasets[entry.emp_id]) {
                                                        datasets[entry.emp_id] = {
                                                            label: `Employee ${entry.emp_id}`,
                                                            data: Array.from({
                                                                length: 31
                                                            }, (_, i) => 0),
                                                            borderColor: getRandomColor(),
                                                            borderWidth: 2,
                                                            fill: false,
                                                        };
                                                    }
                                                    datasets[entry.emp_id].data[entry.day - 1] = entry.hours_covered;
                                                });

                                                const ctxMonthlyTrends = document.getElementById('monthlyTrends');
                                                if (ctxMonthlyTrends) {
                                                    new Chart(ctxMonthlyTrends, {
                                                        type: 'line',
                                                        data: {
                                                            labels: Array.from({
                                                                length: 31
                                                            }, (_, i) => i + 1),
                                                            datasets: Object.values(datasets),
                                                        },
                                                        options: {
                                                            responsive: true,
                                                            maintainAspectRatio: false,
                                                            title: {
                                                                display: true,
                                                                text: 'Monthly Trends - Hours Covered by Employee'
                                                            },
                                                            scales: {
                                                                x: {
                                                                    title: {
                                                                        display: true,
                                                                        text: 'Day'
                                                                    }
                                                                },
                                                                y: {
                                                                    title: {
                                                                        display: true,
                                                                        text: 'Hours Covered'
                                                                    },
                                                                    beginAtZero: true,
                                                                    max: 24,
                                                                    min: 0,
                                                                    stepSize: 2,
                                                                    callback: function(value, index, values) {
                                                                        if (value % 2 === 0) {
                                                                            return value;
                                                                        }
                                                                        return '';
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    });
                                                } else {
                                                    console.error("Canvas element with ID 'monthlyTrends' not found.");
                                                }

                                                function getRandomColor() {
                                                    const letters = '0123456789ABCDEF';
                                                    let color = '#';
                                                    for (let i = 0; i < 6; i++) {
                                                        color += letters[Math.floor(Math.random() * 16)];
                                                    }
                                                    return color;
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>



                            <div class="white_shd full margin_bottom_30">
                                <div class="full graph_head">
                                    <div class="heading1 margin_0">
                                        <div>
                                            <h2>List of All Employees Attendance</h2>
                                        </div>
                                    </div>
                                    <div class="table_section padding_infor_info">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="search-addon"><i class="fa fa-search" aria-hidden="true"></i></span>
                                            <input id="myInput" type="text" onkeyup="mySearch()" class="form-control" placeholder="Search.." aria-label="Search" aria-describedby="search-addon">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-sm" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th># Att No</th>
                                                        <th>Employee Name</th>
                                                        <th>Day</th>
                                                        <th onclick="sortTable(0)" scope="col">Month <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Year</th>
                                                        <th>Time In</th>
                                                        <th>Time Out</th>
                                                        <th>Hours Covered</th>
                                                        <th>Status</th>




                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (mysqli_num_rows($resultA) > 0) {
                                                        while ($row = mysqli_fetch_array($resultA)) {
                                                    ?>

                                                            <tr>
                                                                <td><?php echo $row['attendance_id']; ?></td>
                                                                <td><?php
                                                                    $getName = new employee();
                                                                    $usr_id = $row['emp_id'];
                                                                    $empNameArr = $getName->getEmpName($usr_id);





                                                                    if (!empty($empNameArr)) {
                                                                        $empName = $empNameArr['name'] . " " . $empNameArr['surname'];

                                                                        echo $empName;
                                                                    } ?></td>
                                                                <td><?php echo $row['date']; ?></td>
                                                                <td><?php $numericMonth = $row['month'];

                                                                    echo $textualMonth = date("F", strtotime("2000-$numericMonth-01"));


                                                                    ?></td>
                                                                <td><?php echo $row['year']; ?></td>
                                                                <td><?php echo $row['time_in']; ?></td>
                                                                <td><?php echo $row['time_out']; ?></td>
                                                                <td><?php
                                                                    if ($row['hours_covered'] < 0) {
                                                                        echo 'Less than 1 Hour';
                                                                    } else {
                                                                        echo $row['hours_covered'] . " " . "Hours";
                                                                    }

                                                                    ?>
                                                                </td>
                                                                <td><?php
                                                                    if ($row['hours_covered'] < 0) {
                                                                        echo '<span class="badge bg-warning text-white">Hours of Work Not Met</span>';
                                                                    } else {

                                                                        echo '<span class="badge bg-success text-white">Hours of Work Met</span>';
                                                                    }
                                                                    ?>
                                                                </td>

                                                            </tr>

                                                        <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <tr id="noResultsMessage">
                                                            <td colspan="8">No results found.</td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <nav aria-label="Page navigation">
                                            <ul class="pagination justify-content-center">
                                                <?php
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    if ($i === (int)$page) {
                                                        // Highlight the active page link with the "active" class
                                                        echo '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    } else {
                                                        echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <?php include '../../components/footer.php'; ?>
</body>
<script>
    <?php
    if (isset($_SESSION['updateSuccess'])) {
        unset($_SESSION['updateSuccess']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Infromations Updated successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "informationDashboard.php";
            }
        });
        ';
    }
    ?>
</script>


</html>