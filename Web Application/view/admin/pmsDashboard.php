<?php include '../../controller/admin/view_pms_dashboard.php'; ?>
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
                                    <h2>Performance Management System Dashboard</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- Dashboard Notifications Panel-->
                            <div class="row column1">
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 red_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-plus-circle"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">Pending at Employee</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 yellow_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-check-circle"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count2; ?></p>
                                                <p class="head_couter">Pending at Supervisor</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 brown_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa-solid fa-box-archive"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count3; ?></p>
                                                <p class="head_couter">Pending with HR</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 blue1_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle"></i>
                                            </div>
                                        </div>

                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count4; ?></p>
                                                <p class="head_couter">Completed</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <!-- List of NewsFeed on Systems-->
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2>List of Employee eligible for Performance Management</h2>
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
                                                        <th>PMS Status</th>
                                                        <th>Manage PMS</th>



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
                                                                $getPMS = new pms();
                                                                $getStatusPMS = $getPMS->getStatusPMS($emp_id);

                                                                if (!empty($getStatusPMS) && isset($getStatusPMS[0]['pms_status'])) {
                                                                    switch ($getStatusPMS[0]['pms_status']) {
                                                                        case 'Pending':
                                                                            echo "<span class='badge bg-secondary text-white'>Pending with Management</span>";
                                                                            break;
                                                                        case 'n+1':
                                                                            echo "<span class='badge bg-warning text-white'>Pending at Employee</span>";
                                                                            break;
                                                                        case 'n+2':
                                                                            echo "<span class='badge bg-info text-white'>Pending at Supervisor</span>";
                                                                            break;
                                                                        case 'Completed':
                                                                            echo "<span class='badge bg-success text-white'>Completed</span>";
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
                                                                <a class="btn btn-primary" href="../../controller/admin/manage_pms_emp.php?action=update&emp_id=<?= $row['emp_id'] ?>">
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
    if (isset($_SESSION['updateSuccess'])) {
        unset($_SESSION['updateSuccess']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Created successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "pmsDashboard.php";
            }
        });
        ';
    } else {
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['updatePMS'])) {
        unset($_SESSION['updatePMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Updated successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
            }
        });
        ';
    } else {
    }
    ?>
</script>

<script>
    <?php
    if (isset($_SESSION['modifyPMS'])) {
        unset($_SESSION['modifyPMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Modified successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
            }
        });
    ';
    } else {
    }
    ?>
</script>
<script>
    <?php
    if (isset($_SESSION['addScorePMS'])) {
        unset($_SESSION['addScorePMS']);
        echo '
        Swal.fire({
            icon: "success",
            title: "Operation Success!",
            text: "Employee PMS Score Added successfully!",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../admin/pmsDashboard.php";
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