<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/employee.php');
require('../../model/user.php');
require('../../model/task.php');

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

$database = new DBHandler();
$user = new user();

$user_Identification = $_SESSION['email'];

$usr = new user();
$getID = $usr->getEmployeeID($user_Identification);
$user_id = $getID[0]['user_id'];

//Connection to PhpMyadmin database
$conn = mysqli_connect("localhost", "root", "", "");
if (!empty($_FILES)) {
    // Validating SQL file type by extensions
    if (!in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql"
    ))) {
        $response = array(
            "type" => "error",
            "message" => "Invalid File Type , only SQL format is valid!"
        );
    } else {
        if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
            $response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
        }
    }
}

//Function that takes input fo .SQL file as extention to restore the database using Web based API
function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';

    if (file_exists($filePath)) {
        $lines = file($filePath);

        foreach ($lines as $line) {

            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $sql .= $line;

            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $error .= mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach

        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
        exec('rm ' . $filePath);
    } // end if file exists

    return $response;
}

$count1 = 50;
$count2 = 15;
$count3 = 25;
$count4 = 22;
$count5 = 27;




?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                                    <h2>Backup and Restore System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->




                            <div class="col-lg-6">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Task Management</h2>
                                        </div>
                                    </div>
                                    <div class="map_section padding_infor_info">
                                        <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                            </div>
                                        </div>
                                        <canvas id="myChart" style="display: block; height: 247px; width: 495px;" width="618" height="308" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-6">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Task Management</h2>
                                        </div>
                                    </div>
                                    <div class="map_section padding_infor_info">
                                        <div class="chartjs-size-monitor" style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                            <div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                            </div>
                                        </div>
                                        <canvas id="myChart2" style="display: block; height: 247px; width: 495px;" width="618" height="308" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>

                            </div>



                            <!-- <div class="col-lg-6">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Task Management</h2>
                                        </div>
                                    </div>
                                    <div class="map_section padding_infor_info">

                                        <canvas id="barChart"></canvas>

                                        <script>
                                            // Sample attendance data
                                            const attendanceData = [{
                                                    date: '17-01-2024',
                                                    hours_covered: 10.0
                                                },
                                                {
                                                    date: '18-01-2024',
                                                    hours_covered: -1.0
                                                },
                                                {
                                                    date: '25-01-2024',
                                                    hours_covered: 2.0
                                                },
                                                {
                                                    date: '25-01-2024',
                                                    hours_covered: 8.0
                                                },
                                                {
                                                    date: '25-01-2024',
                                                    hours_covered: 9.0
                                                },
                                                {
                                                    date: '25-01-2024',
                                                    hours_covered: 15.0
                                                },
                                                {
                                                    date: '25-01-2024',
                                                    hours_covered: 6.0
                                                }
                                                // Add more data as needed
                                            ];

                                            // Extract Date and Hours Covered values
                                            const dates = attendanceData.map(entry => entry.date);
                                            const hoursCovered = attendanceData.map(entry => entry.hours_covered);

                                            // Create Bar Chart
                                            const ctx = document.getElementById('barChart').getContext('2d');
                                            new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: dates,
                                                    datasets: [{
                                                        label: 'Daily Hours Covered',
                                                        data: hoursCovered,
                                                        backgroundColor: 'rgba(75, 192, 192, 0.5)', // Customize the color
                                                    }]
                                                },
                                                options: {
                                                    scales: {
                                                        x: {
                                                            title: {
                                                                display: true,
                                                                text: 'Date'
                                                            }
                                                        },
                                                        y: {
                                                            beginAtZero: true,
                                                            title: {
                                                                display: true,
                                                                text: 'Hours Covered'
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div> -->



                            <div class="col-lg-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Monthly Trends</h2>
                                        </div>
                                    </div>
                                    <div class="chart_section padding_infor_info">
                                        <canvas id="monthlyTrends"></canvas>

                                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                const attendanceData = [{
                                                        emp_id: 'EMP0001',
                                                        month: 1,
                                                        day: 17,
                                                        hours_covered: 10.0
                                                    },
                                                    {
                                                        emp_id: 'EMP0003',
                                                        month: 1,
                                                        day: 25,
                                                        hours_covered: 4.0
                                                    },
                                                    {
                                                        emp_id: 'EMP0002',
                                                        month: 1,
                                                        day: 17,
                                                        hours_covered: 8.0
                                                    },
                                                    {
                                                        emp_id: 'EMP0004',
                                                        month: 1,
                                                        day: 25,
                                                        hours_covered: 6.5
                                                    },
                                                    // Add more data as needed
                                                ];

                                                // Organize data by employee
                                                const employeeData = {};
                                                attendanceData.forEach(entry => {
                                                    if (!employeeData[entry.emp_id]) {
                                                        employeeData[entry.emp_id] = Array.from({
                                                            length: 31
                                                        }, () => 0);
                                                    }
                                                    employeeData[entry.emp_id][entry.day - 1] = entry.hours_covered;
                                                });

                                                const ctxMonthlyTrends = document.getElementById('monthlyTrends').getContext('2d');
                                                new Chart(ctxMonthlyTrends, {
                                                    type: 'line',
                                                    data: {
                                                        labels: Array.from({
                                                            length: 31
                                                        }, (_, i) => i + 1),
                                                        datasets: Object.keys(employeeData).map(empId => ({
                                                            label: `Employee ${empId}`,
                                                            data: employeeData[empId],
                                                            borderColor: getRandomColor(),
                                                            borderWidth: 2,
                                                            fill: false,
                                                        }))
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
                                                                }
                                                            }
                                                        }
                                                    }
                                                });

                                                // Function to generate a random color
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

























                            <!-- footer -->
                            <?php include '../../components/footer.php'; ?>
</body>


<script>
    <?php
    if (isset($_SESSION['createTask'])) {
        unset($_SESSION['createTask']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Task Created and assigned successfully!",
        })
    ';
    }
    ?>
</script>
<!-- JavaScript function to print modal content -->
<script>
    const xValues = ["Pending", "In Progress", "Completed", "Require Attention"];
    const yValues = [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>, <?php echo $count4; ?>];
    const barColors = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myChart", {
            type: "doughnut",
            data: {
                labels: xValues,
                datasets: [{
                    backgroundColor: barColors,
                    data: yValues
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Task Management"
                }
            }
        }


    );
</script>


<script>
    const xValues1 = ["Pending", "In Progress", "Completed", "Require Attention"];
    const yValues1 = [<?php echo $count1; ?>, <?php echo $count2; ?>, <?php echo $count3; ?>, <?php echo $count4; ?>];
    const barColors1 = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145"
    ];

    new Chart("myChart2", {
            type: "doughnut",
            data: {
                labels: xValues1,
                datasets: [{
                    backgroundColor: barColors1,
                    data: yValues1
                }]
            },
            options: {
                title: {
                    display: true,
                    text: "Task Management"
                }
            }
        }


    );
</script>

</html>