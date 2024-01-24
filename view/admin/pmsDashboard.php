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
                                    <div class="full counter_section margin_bottom_30 purple_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-newspaper"></i>
                                            </div>
                                        </div>
                                        <div class="counter_no">
                                            <div>
                                                <p class="total_no"><?php echo $count1; ?></p>
                                                <p class="head_couter">News Published</p>
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
                                                <p class="head_couter">Active News</p>
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
                                                <p class="head_couter">Archived News</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-3">
                                    <div class="full counter_section margin_bottom_30 green_bg">
                                        <div class="couter_icon">
                                            <div>
                                                <i class="fa fa-exclamation-circle"></i>
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
                                            <input id="myInput" type="text" class="form-control" placeholder="Search.." aria-label="Search" aria-describedby="search-addon">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th># Employee No</th>
                                                        <th onclick="sortTable(1)" scope="col">Name<i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                        <th>Surname</th>
                                                        <th>Department</th>
                                                        <th>Grade</th>
                                                        <th>PMS Status</th>
                                                        <th>Create PMS</th>
                                                        <th>Modify PMS</th>
                                                        <th>View PMS</th>


                                                    </tr>
                                                </thead>
                                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                                    <tbody>
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

                                                            <td><?php echo $row['position']; ?></td>

                                                            <td>
                                                                <?php
                                                                $emp_id = $row['emp_id'];
                                                                $getPMS = new pms();
                                                                $getStatusPMS = $getPMS->getStatusPMS($emp_id);

                                                                if (!empty($getStatusPMS) && isset($getStatusPMS[0]['pms_status'])) {
                                                                    switch ($getStatusPMS[0]['pms_status']) {
                                                                        case '':
                                                                            echo "<span class='badge bg-danger text-white'>Not Created</span>";
                                                                            break;
                                                                        case 'Pending':
                                                                            echo "<span class='badge bg-warning text-white'>Pending</span>";
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
                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createPMSModal<?php echo $row['emp_id']; ?>">
                                                                    <i class="fa-solid fa-square-plus"></i> Create
                                                                </button>
                                                            </td>



                                                            <!-- Create PMS Modal -->
                                                            <div class="modal fade" id="createPMSModal<?php echo $row['emp_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="createPMSModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['emp_id'] ?>">Create PMS for Employee </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to Create PMS details -->
                                                                            <form method="post" action="../../controller/admin/create_pms.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                                                                                <input type="hidden" name="supervisor_id" value="<?php echo $deptSupervisor; ?>">

                                                                                <label for="content"><b><u>PMS Period</u></b></label>
                                                                                <div class="form-group row">
                                                                                    <div class="col">
                                                                                        <label for="period">Period</label>
                                                                                        <select class="form-control" name="period_array[]">
                                                                                            <option value="Quarter 1">Quarter 1</option>
                                                                                            <option value="Quarter 2">Quarter 2</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="month">Month and Year</label>
                                                                                        <input type="date" id="dateMonth" name="period_array[]" class="form-control" required>
                                                                                    </div>

                                                                                </div>




                                                                                <label for="content"><b><u>Key Performance Areas</u></b></label>
                                                                                <div class="form-group row">
                                                                                    <div class="col">
                                                                                        <label for="kpa1">KPA 1</label>
                                                                                        <input type="text" class="form-control" name="kpa_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpa2">KPA 2</label>
                                                                                        <input type="text" class="form-control" name="kpa_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpa3">KPA 3</label>
                                                                                        <input type="text" class="form-control" name="kpa_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpa4">KPA 4</label>
                                                                                        <input type="text" class="form-control" name="kpa_array[]" required>
                                                                                    </div>
                                                                                </div>

                                                                                <label for="content"><b><u>Ojectives Set</u></b></label>
                                                                                <div class="form-group row">
                                                                                    <div class="col">
                                                                                        <label for="obj1">KPA 1</label>
                                                                                        <input type="text" class="form-control" name="obj_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="obj2">KPA 2</label>
                                                                                        <input type="text" class="form-control" name="obj_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="obj3">KPA 3</label>
                                                                                        <input type="text" class="form-control" name="obj_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="obj4">KPA 4</label>
                                                                                        <input type="text" class="form-control" name="obj_array[]" required>
                                                                                    </div>
                                                                                </div>

                                                                                <label for="content"><b><u>Key Performance Indicators</u></b></label>
                                                                                <div class="form-group row">
                                                                                    <div class="col">
                                                                                        <label for="kpi1">KPI 1</label>
                                                                                        <input type="text" class="form-control" name="kpi_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpi2">KPI 2</label>
                                                                                        <input type="text" class="form-control" name="kpi_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpi3">KPI 3</label>
                                                                                        <input type="text" class="form-control" name="kpi_array[]" required>
                                                                                    </div>
                                                                                    <div class="col">
                                                                                        <label for="kpi4">KPI 4</label>
                                                                                        <input type="text" class="form-control" name="kpi_array[]" required>
                                                                                    </div>
                                                                                </div>




                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="create_pms">Save Changes</button>
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>














                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['news_id']; ?>">
                                                                    <i class="fa-solid fa-pen-to-square"></i> Update
                                                                </button>
                                                            </td>

                                                            <!-- Modify News Status Modal -->
                                                            <div class="modal fade" id="editModal<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['news_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="editModalLabel<?php echo $row['news_id']; ?>">Update NewsFeed Status </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form method="post" action="updateNewsStatus.php">
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="news_id" value="<?php echo $row['news_id']; ?>">

                                                                                <div class="form-group">
                                                                                    <label for="user_access">Update Newsfeed Status</label>
                                                                                    <select class="form-control" name="isActive">
                                                                                        <option value="0">Archive</option>
                                                                                        <option value="1">Active</option>
                                                                                    </select>
                                                                                </div>


                                                                                <div class="modal-footer">
                                                                                    <button type="submit" class="btn btn-success" name="updateNewsStatus">Save Changes</button>
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <!-- Add an "Edit" button that triggers the modal -->
                                                            <td>
                                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#viewModal<?php echo $row['emp_id']; ?>">
                                                                    <i class="fa-solid fa-eye"></i> View
                                                                </button>
                                                            </td>

                                                            <!-- Modify News Status Modal -->
                                                            <div class="modal fade" id="viewModal<?php echo $row['emp_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel<?php echo $row['emp_id']; ?>" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="viewModalLabel<?php echo $row['emp_id']; ?>">View Employee Performance Sheet</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <!-- Form to update NewsFeed Status -->
                                                                            <form>
                                                                                <!-- Populate form fields with current employee data -->
                                                                                <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                                                                                <?php
                                                                                $getPMS = new pms();
                                                                                $getEMP = $getPMS->getPMSEmployee($row['emp_id']);

                                                                                foreach ($getEMP as $innerArray) {
                                                                                    // Decode JSON arrays
                                                                                    $quarterArray = json_decode($innerArray['quarter_array'], true);
                                                                                    $kpaArray = json_decode($innerArray['kpa_array'], true);
                                                                                    $kpiArray = json_decode($innerArray['kpi_array'], true);
                                                                                    $objectiveArray = json_decode($innerArray['objective_array'], true);
                                                                                ?>

                                                                                    <label for="content"><b><u>PMS Period</u></b></label>
                                                                                    <div class="form-group row">
                                                                                        <div class="col">
                                                                                            <label for="period">Period: </label> <?php echo $quarterArray[0]; ?>
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <label for="month">Month and Year: </label> <?php echo $quarterArray[1]; ?>
                                                                                        </div>
                                                                                    </div>

                                                                                    <label for="content"><b><u>Key Performance Areas</u></b></label>
                                                                                    <div class="form-group row">
                                                                                        <?php
                                                                                        foreach ($kpaArray as $kpa) {
                                                                                            echo '<div class="col">';
                                                                                            echo '<label for="kpa">' . $kpa . '</label>';
                                                                                            echo '</div>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>

                                                                                    <label for="content"><b><u>Objectives Set</u></b></label>
                                                                                    <div class="form-group row">
                                                                                        <?php
                                                                                        foreach ($objectiveArray as $objective) {
                                                                                            echo '<div class="col">';
                                                                                            echo '<label for="objective">' . $objective . '</label>';
                                                                                            echo '</div>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>

                                                                                    <label for="content"><b><u>Key Performance Indicators</u></b></label>
                                                                                    <div class="form-group row">
                                                                                        <?php
                                                                                        foreach ($kpiArray as $kpi) {
                                                                                            echo '<div class="col">';
                                                                                            echo '<label for="kpi">' . $kpi . '</label>';
                                                                                            echo '</div>';
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>











                                                        </tr>
                                                        <!-- Add more rows dynamically using PHP/JavaScript -->
                                                    </tbody>
                                                <?php } ?>
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
    }
    ?>
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

</html>