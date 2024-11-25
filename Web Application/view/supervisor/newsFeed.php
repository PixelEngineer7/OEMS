<?php

require('../../model/user.php');
require('../../model/employee.php');
session_start();
// Script to check UAC
$database = new DBHandler();
$verify = new user();
$security = $verify->securityCheck($_SESSION['email']);
$isActiveVerify = $verify->isActive($_SESSION['email']);

$role = $security[0]['role'];
$isActive = $isActiveVerify[0]['isActive'];


if ($role == 'Supervisor' && $isActive == 0) {
    header("location:../../components/401_unauthorized.php");
} else if ($role == 'Supervisor' && $isActive == 1) {
    // do Nothing
} else {
    header("location:../../model/logout.php");
};
// END OF SCRIPT


$user_Identification = $_SESSION['email'];

$usr = new user();
$getID = $usr->getEmployeeID($user_Identification);
$user_id = $getID[0]['user_id'];





$database = new DBHandler();
$getEmp = new employee();
$getProfileDetails = $getEmp->getEmpDetails($user_id);

foreach ($getProfileDetails as $row)
    $name = $row['name'];
$surname = $row['surname'];
$profile_img = $row['profile_img'];



require('../../model/newsfeed.php');

$database = new DBHandler();
$news = new newsfeed();

$newsList = $news->getActiveNews($database);

?>
<!DOCTYPE html>
<html lang="en">
<!-- Header  -->
<?php include '../../components/header.php'; ?>

<head>
    <style>
        /* Add this CSS to your existing styles */
        .card {
            width: 100%;
            margin: 0 auto;
            margin-bottom: 20px;
            box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;
        }

        .card img.card-img-top {
            height: auto;
            object-fit: cover;
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 0.5rem;
        }

        .card-text {
            margin-bottom: 1rem;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: none;
            text-align: right;
        }

        /* Modal Styles */
        .modal-content {
            border: none;
        }

        .modal-body img {
            max-width: 100%;
            height: auto;
        }

        @media (max-width: 576px) {
            .card {
                width: 100%;
            }
        }

        .card:hover {
            border-radius: 20px blue;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 14px;
            border: none;
            outline: none;
            background-color: yellowgreen;
            color: white;
            cursor: pointer;
            padding: 10px;
            border-radius: 20px;
        }

        #myBtn:hover {
            background-color: #555;
        }
    </style>
</head>
<!-- End of Header  -->

<body class="dashboard dashboard_2">
    <div class="full_container">
        <div class="inner_container">
            <!-- Sidebar  -->
            <?php include '../../components/supNavBar.php'; ?>
            <!-- end sidebar -->
            <!-- right content -->
            <div id="content">
                <!-- topbar -->
                <div class="topbar">
                    <?php include '../../components/supTopBar.php'; ?>
                </div>
                <!-- end topbar -->
                <!-- dashboard inner -->
                <div class="midde_cont">

                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Latest Company Newsfeed</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- news list section -->
                            <div class="col-md-12">
                                <div class="card-body">
                                    <div class="card-deck">
                                        <?php foreach ($newsList as $row) { ?>
                                            <div class="mt-1 mb-4"> <!-- Add bottom margin of 10px -->
                                                <div class="card border-2 shadow">
                                                    <div class="card-body">

                                                        <?php if (!empty($row['video_link'])) { ?>
                                                            <div class="video-container" style="position: relative; padding-bottom: 56.25%; overflow: hidden;">
                                                                <iframe style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%; height: 100%;" frameborder="0" src="<?php echo $row['video_link']; ?>" allowfullscreen></iframe>
                                                            </div>
                                                        <?php } ?>

                                                        <?php if (!empty($row['image'])) { ?>
                                                            <img class="card-img-top img-fluid" src="../../assets/newsfeed/<?php echo $row['image']; ?>" alt="News Image">
                                                        <?php } ?>
                                                        <h4 class="card-title center"><?php echo $row['title']; ?></h4>
                                                        <p class="card-text"><?php echo substr($row['content'], 0, 250) . '...'; ?></p>

                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newsModal<?php echo $row['news_id']; ?>">
                                                            Read More
                                                        </button>
                                                    </div>
                                                    <div class="card-footer">
                                                        <small class="text-muted">Posted on: <?php echo $row['date_posted']; ?></small>
                                                    </div>
                                                </div>
                                            </div>


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
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa-solid fa-arrow-up fa-beat">Top</i></button>
                </div>
                <!-- footer -->

            </div>
        </div>
    </div>


</body>
<script>
    //Get the button
    var mybutton = document.getElementById("myBtn");

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
</script>
<!-- jQuery -->
<script src="../../js/jquery.min.js"></script>
<script src="../../js/popper.min.js"></script>
<script src="../../js/bootstrap.min.js"></script>
<!-- wow animation -->
<script src="../../js/animate.js"></script>
<!-- select country -->
<script src="../../js/bootstrap-select.js"></script>
<!-- owl carousel -->
<script src="../../js/owl.carousel.js"></script>
<!-- chart js -->
<script src="../../js/Chart.min.js"></script>
<script src="../../js/Chart.bundle.min.js"></script>
<script src="../../js/utils.js"></script>
<script src="../../js/analyser.js"></script>
<!-- nice scrollbar -->
<script src="../../js/perfect-scrollbar.min.js"></script>
<script>
    var ps = new PerfectScrollbar('#sidebar');
</script>
<!-- custom js -->
<script src="../../js/custom.js"></script>
<script src="../../js/chart_custom_style2.js"></script>
<!-- Script for Image Preview -->
<script type="text/javascript">
    function preview() {
        frame.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
<!-- Include SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.all.min.js"></script>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</html>