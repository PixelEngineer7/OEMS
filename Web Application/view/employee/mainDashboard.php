<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pms.php');
require('../../model/employee.php');
require('../../model/balance.php');
require('../../model/leave.php');
require('../../model/user.php');
require('../../model/task.php');

// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Employee' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Employee' && $isActive == 1) {
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



$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];
$emp_id = $row['emp_id'];

//Retrieves all Details for the Employee using the emp_id
$database = new DBHandler();
$getEmpFull = new employee();
$empFull = $getEmpFull->getEmpFullDetails($emp_id);

$empName = $empFull["name"];
$empSurname = $empFull["surname"];




$leave_bal = new balance();
$require_attention = new leave();
$count1 = $leave_bal->count_bal_well($emp_id);
$count2 = $leave_bal->count_bal_sick($emp_id);
$count3 = $leave_bal->count_bal_vacation($emp_id);
$count4 = $require_attention->count_leave_emp_rejected($emp_id);




$getTask = new task();
$getTask->count_task_emp_pending($user_id);

$countTsk1 = $getTask->count_task_employee_pending($emp_id);
$countTsk2 = $getTask->count_task_employee_progress($emp_id);
$countTsk3 = $getTask->count_task_employee_OCOM($emp_id);
$countTsk4 = $getTask->count_task_employee_NCOM($emp_id);


$pms_count1 = new pms();
$countPms1 = $pms_count1->count_pms_emp_active($emp_id);
$countPms2 = $pms_count1->count_pms_emp_pending($emp_id);
$countPms3 = $pms_count1->count_pms_emp_n_2($emp_id);
$countPms4 = $pms_count1->count_pms_emp_completed($emp_id);






$database = new DBHandler();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}
// Your SQL statement
$sql = "SELECT * FROM tbl_attendance WHERE emp_id='$emp_id'";

// Execute the query
$resultA = $conn->query($sql);



// Check if the query was successful
if ($resultA) {
    // Fetch the result as an associative array
    $attendanceData = [];
    while ($row = $resultA->fetch_assoc()) {
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
    $resultA->free();
} else {
    // Handle query error
    echo "Error: " . $sql . "<br>" . $conn->error;
}










?>
<!DOCTYPE html>
<html lang="en">

<?php include '../../components/header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1;
        max-width: 80%;
        overflow-y: auto;
        max-height: 80vh;
    }

    .modal-content {
        text-align: left;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-container {
        text-align: center;
        margin-top: 10px;
    }
</style>

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/empNavBar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/empTopBar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Main Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">

                            <!-- Popup Modal -->
                            <div id="popupModal" class="modal">
                                <div class="modal-content">
                                    <div>
                                        <div class="col-md-12" style="margin-top:10px; text-align: center;">
                                            <img src="../../assets/images/header.png" alt="Image Description" style="max-width: 100%; height: auto;">
                                        </div>

                                        <div class="col-md-12" style="margin-top:10px;">
                                            <h4>Usage and Security Information</h4>
                                            <p>Welcome to Infinity Networks! Our online system is designed to provide you with a seamless and secure experience.
                                                Please read the following information carefully to understand how to use the system responsibly and the measures
                                                we've taken to ensure its security.</p>

                                            <h4 style="margin-top:10px;">Usage Guidelines:</h4>
                                            <ul style="list-style-type: disc; padding-left: 20px;">
                                                <li><strong>Infinity Networks' online system</strong> is exclusively intended for authorized personnel, including
                                                    employees and designated individuals.</li>
                                                <li>Users must access the system with legitimate intentions and for authorized purposes only.</li>
                                                <li>Any misuse, unauthorized access, or tampering with the system is strictly prohibited.</li>
                                            </ul>

                                            <h4 style="margin-top:10px;">Security Measures:</h4>
                                            <ul style="list-style-type: disc; padding-left: 20px;">
                                                <li>Our system employs robust security measures to protect your data and maintain the integrity of our
                                                    operations.</li>
                                                <li>Regular monitoring and audits are conducted to identify and address potential vulnerabilities.</li>
                                                <li>Confidential information and personal data are safeguarded through encryption and access controls.</li>
                                                <li>Multi-factor authentication is employed to enhance user verification and prevent unauthorized access.</li>
                                            </ul>

                                            <div class="warning">
                                                <h4 style="margin-top:10px;">Unauthorized Access and Tampering:</h4>
                                                <p>Unauthorized access, tampering, or misuse of Infinity Networks' online system is a serious offense. Such actions
                                                    may result in administrative, civil, or criminal actions being taken against the individuals involved.
                                                    Consequences may include fines, legal penalties, and loss of privileges.</p>
                                            </div>

                                            <h4>Reporting Suspicious Activity:</h4>
                                            <p>If you suspect any unauthorized activity, security breach, or unusual behavior on the system, please report it
                                                immediately. Your prompt reporting will help us maintain the security and integrity of our network.</p>

                                            <p>At Infinity Networks, we take security seriously and are committed to providing a safe and reliable platform for
                                                our users. Thank you for your cooperation and responsible use of our online system.</p>

                                            <p>For inquiries or to report any security concerns, please contact our security team at <a href="mailto:security@infinitynetworks.com">security@infinitynetworks.com</a>.</p>

                                            <div class="btn-container">
                                                <button class="btn btn-danger btn-sm" onclick="closePopup()">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Popup Modal -->


                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-spa"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">Balance Wellness </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-syringe"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count2; ?></p>
                                                <p class="head_couter">Balance Sick</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 brown_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-plane-departure"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count3; ?></p>
                                                <p class="head_couter">Balance Vacation</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 blue1_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle fa-beat fa-3x"></i>
                                            </div>
                                        </div>

                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count4; ?></p>
                                                <p class="head_couter">Require Attention</p>
                                            </div>
                                        </div>
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
                                        <canvas id="myChart" style="display: block; height: 247px; width: 495px;" width="618" height="308" class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Performance Management System Metrics</h2>
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
                        </div>


                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>Employee Attendance Monthly Trends</h2>
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
                                                            label: `<?php echo $empName . " " . $surname ?> `,
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
                        </div>


























                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
</body>

<!-- JavaScript function to print modal content -->
<script>
    const xValues = ["Pending", "In Progress", "Completed", "Require Attention"];
    const yValues = [<?php echo $countTsk1; ?>, <?php echo $countTsk2; ?>, <?php echo $countTsk3; ?>, <?php echo $countTsk4; ?>];
    const barColors = [
        "#ffa600",
        "#ff6361",
        "#bc5090",
        "#58508d",
        "#1e7145"
    ];

    new Chart("myChart", {
            type: "pie",
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
                    text: "Summary of Tasks By :  <?php echo $empSurname . " " . $empName; ?>"
                }
            }
        }


    );
</script>


<script>
    const xValues1 = ["Pending at Employee", "In Progress at N+2", "Pending with HR", "Completed"];
    const yValues1 = [<?php echo $countPms1; ?>, <?php echo $countPms2; ?>, <?php echo $countPms3; ?>, <?php echo $countPms4; ?>];
    const barColors1 = [
        "#ff595e",
        "#ffca3a",
        "#8ac926",
        "#1982c4",
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
                    text: "Summary of PMS Status"
                }
            }
        }


    );
</script>
<script>
    // Function to show the popup
    function showPopup() {
        const modal = document.getElementById('popupModal');
        modal.style.display = 'block';
    }

    // Function to close the popup
    function closePopup() {
        const modal = document.getElementById('popupModal');
        modal.style.display = 'none';
    }

    // Close the modal if the user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('popupModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Automatically show the popup on page load
    window.onload = function() {
        showPopup();
    };
</script>



</html>