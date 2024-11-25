<?php


require('../../controller/admin/admin_info_getDetails.php');



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
                                    <h2>Information Management Dashboard</h2>
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
                                                <p class="total_no"><?php echo $countNewsPublished; ?></p>
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
                                                <p class="total_no"><?php echo $countActiveNews; ?></p>
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
                                                <p class="total_no"><?php echo $countArchieveNews ?></p>
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
                                                <p class="total_no"><?php echo $countRequireAttention; ?></p>
                                                <p class="head_couter">Require Attention</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Buttons Cards Panel-->
                            <div class="col-md-12 margin_bottom_30">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div style=" box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                                            <div class="card-body">
                                                <h5 class="card-title">Create NewsFeed</h5>
                                                <p class="card-text">News Creation which will dynamically be updated on the Newsfeed page to every users.</p>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-info" onclick="javascript:window.location='../../controller/admin/createNews.php';"> <i class="fa-solid fa-square-plus"></i> Create</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                <!-- List of NewsFeed on Systems-->
                                <div class="col-md-12">
                                    <div class="white_shd full margin_bottom_30">
                                        <div class="full graph_head">
                                            <div class="heading1 margin_0">
                                                <h2>NewsFeed on System</h2>
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
                                                            <th># NewsFeed No</th>
                                                            <th onclick="sortTable(1)" scope="col">Newsfeed Title <i class="fa-solid fa-arrow-up-a-z"></i> </th>
                                                            <th>Current Status</th>
                                                            <th>Date Posted</th>
                                                            <th>Live View</th>
                                                            <th>Update Status</th>
                                                            <th>Modify Details</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php while ($row = mysqli_fetch_array($result)) { ?>

                                                            <tr>

                                                                <td><?php echo $row['news_id']; ?></td>
                                                                <td><?php echo $row['title']; ?></td>

                                                                <td><?php if ((int)$row['isActive'] == 1)
                                                                        echo "<span class='badge bg-success text-white'>Active</span>";
                                                                    else
                                                                        echo "<span class='badge bg-danger text-white'>Archived
                                                                    </span>"; ?></td>
                                                                <td><?php echo $row['date_posted']; ?></td>

                                                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsModal<?php echo $row['news_id']; ?>">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                                    </button></td>

                                                                <!-- News Modal -->
                                                                <div class="modal fade" id="newsModal<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="newsModalLabel<?php echo $row['news_id']; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog modal-lg" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title center" id="newsModalLabel<?php echo $row['news_id']; ?>"><?php echo $row['title']; ?></h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php if (!empty($row['video_link'])) { ?>
                                                                                    <div class="video-container" style="position: relative; padding-bottom: 56.25%; overflow: hidden;">
                                                                                        <iframe style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; height: 100%;" frameborder="0" src="<?php echo $row['video_link']; ?>" allowfullscreen></iframe>
                                                                                    </div>
                                                                                <?php } ?>

                                                                                <?php if (!empty($row['image'])) { ?>
                                                                                    <img class="card-img-top img-fluid" src="../../assets/newsfeed/<?php echo $row['image']; ?>" alt="News Image">
                                                                                <?php } ?>
                                                                                <p><?php echo $row['content']; ?></p>


                                                                                <h5>Status: <?php if ((int)$row['isActive'] == 1)
                                                                                                echo "<span class='badge bg-success text-white'>Active</span>";
                                                                                            else
                                                                                                echo "<span class='badge bg-danger text-white'>Archived
                                                                    </span>"; ?></h5>
                                                                            </div>
                                                                            <div class="card-footer">
                                                                                <small class="text-muted">Posted on: <?php echo $row['date_posted']; ?></small>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>




                                                                <!-- Add an "Edit" button that triggers the modal -->
                                                                <td>
                                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal<?php echo $row['news_id']; ?>">
                                                                        <i class="fa fa-refresh" aria-hidden="true"></i> Update
                                                                    </button>
                                                                </td>

                                                                <!-- Modify News Status Modal -->
                                                                <div class="modal fade" id="editModal<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel<?php echo $row['news_id']; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
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
                                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#editNews<?php echo $row['news_id']; ?>">
                                                                        <i class="fa-solid fa-pen-to-square"></i> Modify
                                                                    </button>
                                                                </td>

                                                                <!-- Modify News Status Modal -->
                                                                <div class="modal fade" id="editNews<?php echo $row['news_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editNewsLabel<?php echo $row['news_id']; ?>" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="editNewsLabel<?php echo $row['news_id']; ?>">Modify NewsFeed </h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <!-- Form to update NewsFeed Status -->
                                                                                <form method="post" action="updateNews.php">
                                                                                    <!-- Populate form fields with current employee data -->
                                                                                    <input type="hidden" name="news_id" value="<?php echo $row['news_id']; ?>">

                                                                                    <div class="form-group">
                                                                                        <div class="form-group">
                                                                                            <label for="title">Title</label>
                                                                                            <input name="title" type="text" class="form-control" value="<?php echo $row['title']; ?>" required>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="content">Content</label>
                                                                                            <textarea name="content" class="form-control" rows="5" required><?php echo $row['content']; ?></textarea>
                                                                                        </div>

                                                                                    </div>


                                                                                    <div class="modal-footer">
                                                                                        <button type="submit" class="btn btn-success" name="updateNews">Save Changes</button>
                                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </tr>
                                                            <!-- Displays the No Result found message to user -->
                                                            <tr id="noResultsMessage" style="display: none;">
                                                                <td colspan="7">No results found.</td>
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