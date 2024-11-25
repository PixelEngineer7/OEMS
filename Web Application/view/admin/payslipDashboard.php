<?php
session_start();
require('../../model/database.php');
require('../../model/department.php');
require('../../model/pay.php');
require('../../model/user.php');


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
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = "oems";
$conn = $database->connectToDatabase();
if (!$conn) {
    die('Could not Connect My Sql:' . mysqli_connect_error());
}

$limit = 15;
if (isset($_GET["page"])) {
    $page  = $_GET["page"];
} else {
    $page = 1;
};
$start_from = ($page - 1) * $limit;
$allowedRoles = ['Supervisor', 'Employee'];

$result = mysqli_query($conn, "SELECT *
    FROM tbl_user u
    LEFT JOIN tbl_employee e ON u.user_id = e.user_id
    WHERE u.role IN ('" . implode("','", $allowedRoles) . "') AND e.user_id IS NOT NULL
    ORDER BY emp_id ASC
    LIMIT $start_from, $limit");


$result_db = mysqli_query($conn, "SELECT COUNT(emp_id)
FROM tbl_employee");
$row_db = mysqli_fetch_row($result_db);
$total_records = $row_db[0];
$total_pages = ceil($total_records / $limit);


// Your SQL statement to fetch pay data
$sqlPay = "SELECT * FROM tbl_pay";
$resultPay = $conn->query($sqlPay);

// Check if the query for pay data was successful
if ($resultPay) {
    $payData = [];
    while ($row = $resultPay->fetch_assoc()) {
        $netPay = is_numeric($row['net_pay']) ? $row['net_pay'] : 0;
        $payData[] = [
            'emp_id' => $row['emp_id'],
            'month' => $row['month'],
            'year' => $row['year'],
            'net_pay' => $netPay
            // Add more fields as needed
        ];
    }

    // Free the result set
    $resultPay->free();
} else {
    // Handle query error for pay data
    echo "Error: " . $sqlPay . "<br>" . $conn->error;
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
                                    <h2>Payroll Dashboard</h2>
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
                                            <h2>Employee Monthly Net Pay Trends</h2>
                                        </div>
                                    </div>
                                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                                    <div class="chart_section padding_infor_info">
                                        <canvas id="netPayLineChart"></canvas>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Assuming you have a PHP array named $payData containing the pay information
                                            const payData = <?php echo json_encode($payData); ?>;

                                            // Extract unique months from the pay data
                                            const uniqueMonths = [...new Set(payData.map(entry => entry.month))];

                                            // Create an array with all 12 months
                                            const allMonths = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

                                            // Ensure all 12 months are in the labels array
                                            const labels = allMonths.map(month => uniqueMonths.includes(month) ? month : '');

                                            const ctxNetPayLineChart = document.getElementById('netPayLineChart').getContext('2d');
                                            if (ctxNetPayLineChart) {
                                                new Chart(ctxNetPayLineChart, {
                                                    type: 'line', // Use 'line' for line chart
                                                    data: {
                                                        labels: labels,
                                                        datasets: payData.map(entry => ({
                                                            label: `Employee ${entry.emp_id}`,
                                                            data: allMonths.map(month => {
                                                                const empData = payData.find(e => e.emp_id === entry.emp_id && e.month === month);
                                                                return empData ? empData.net_pay : 0;
                                                            }),
                                                            borderColor: getRandomColor(), // Custom function to generate random colors
                                                            fill: false
                                                        }))
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        maintainAspectRatio: false,
                                                        title: {
                                                            display: true,
                                                            text: 'Net Pay Overview'
                                                        },
                                                        scales: {
                                                            x: {
                                                                title: {
                                                                    display: true,
                                                                    text: 'Month'
                                                                }
                                                            },
                                                            y: {
                                                                title: {
                                                                    display: true,
                                                                    text: 'Net Pay ($)'
                                                                },
                                                                beginAtZero: true
                                                            }
                                                        }
                                                    }
                                                });
                                            } else {
                                                console.error("Canvas element with ID 'netPayLineChart' not found.");
                                            }

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




                            <!-- List of NewsFeed on Systems-->
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>List of Employees eligible for Payslip</h2>
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
                                                        <th># Employee No</th>
                                                        <th onclick="sortTable(1)" scope="col">Name<i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Surname</th>
                                                        <th>Department</th>
                                                        <th>Grade</th>
                                                        <th>Payroll Created</th>
                                                        <th>Manage Payroll</th>



                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                        <tr>

                                                            <td><?php echo $row['emp_id']; ?></td>
                                                            <td><?php echo $row['name']; ?></td>
                                                            <td><?php echo $row['surname']; ?></td>
                                                            <td> <?php
                                                                    $getName = new department();
                                                                    $depCode = $row['department'];
                                                                    $deptNameArray = $getName->getDepartmentName($depCode);

                                                                    if (!empty($deptNameArray)) {
                                                                        $deptName = $deptNameArray[0]['departmentName'];
                                                                        $deptSupervisor = $deptNameArray[0]['departmentSupervisor'];
                                                                        echo $deptName;
                                                                    }
                                                                    ?></td>

                                                            <td><?php echo $row['position']; ?> </td>

                                                            <td>
                                                                <?php
                                                                $emp_id = $row['emp_id'];
                                                                $getPay = new pay();
                                                                $getStatusPay = $getPay->getStatusPay($emp_id);

                                                                if (!empty($getStatusPay) && isset($getStatusPay[0]['pay_status'])) {
                                                                    switch ($getStatusPay[0]['pay_status']) {

                                                                        case 'Complete':
                                                                            echo "<span class='badge bg-success text-white'>Payroll Created</span>";
                                                                            break;
                                                                        default:
                                                                            echo "<span class='badge bg-danger text-white'>Not Created</span>";
                                                                            break;
                                                                    }
                                                                } else {
                                                                    echo "<span class='badge bg-danger text-white'>Status Not Available</span>";
                                                                }
                                                                ?>
                                                            </td>


                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <a class="btn btn-primary" href="../../controller/admin/manage_pay_emp.php?action=update&emp_id=<?= $row['emp_id'] ?>">
                                                                    <i class="fa fa-plus" aria-hidden="true"></i> Manage
                                                                </a>
                                                            </td>

                                                        </tr>
                                                        <!-- Add more rows dynamically using PHP/JavaScript -->

                                                    <?php } ?>
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
                        </div>











                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
</body>
<script>
    <?php
    if (isset($_SESSION['createPaySlip'])) {
        unset($_SESSION['createPaySlip']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PaySlip Created successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/payslipDashboard.php";
            }
        });
    ';
    } else {
    }
    ?>
</script>
<!-- JavaScript function to print modal content -->
<script>
    document.getElementById("btnPrint").onclick = function() {
        printElement(document.getElementById("printThis"));
    }

    function printElement(elem) {
        var domClone = elem.cloneNode(true);

        var $printSection = document.getElementById("printSection");

        if (!$printSection) {
            var $printSection = document.createElement("div");
            $printSection.id = "printSection";
            document.body.appendChild($printSection);
        }

        $printSection.innerHTML = "";
        $printSection.appendChild(domClone);
        window.print();
    }
</script>





<script>
    $(function() {
        $("#monthPicker").datepicker({
            dateFormat: 'mm/yy',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            onClose: function(dateText, inst) {
                $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
            }
        });
    });
</script>
<style>
    /* Your regular styles here */
    @media screen {
        #printSection {
            display: none;
        }
    }

    @media print {
        body * {
            visibility: hidden;
        }

        #printSection,
        #printSection * {
            visibility: visible;
        }

        #printSection {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
</style>

</html>