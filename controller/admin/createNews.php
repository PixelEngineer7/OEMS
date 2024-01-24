<?php
require('../../model/user.php');
require('../../model/newsfeed.php');
session_start();
$database = new DBHandler();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $video_link = $_POST['video_link'];
    $isActive = $_POST['is_active'];

    $news = new newsfeed(); // Create an instance of your News class
    $news->createNews($title, $content, $image, $video_link, $isActive);

    // Validate and process file upload
    if (isset($image) && !empty($image)) {
        $uploaddir = '../../assets/newsfeed/';
        $uploadfile = $uploaddir . basename($image);

        if (move_uploaded_file($image_temp, $uploadfile)) {
            // File uploaded successfully
            echo "File is valid, and was successfully uploaded.";
        } else {
            // File upload failed
            echo "Upload failed.";
        }
    }

    $_SESSION['newsCreationSuccess'] = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Header  -->
<?php include '../../components/header.php'; ?>
<!-- End of Header  -->

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
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Create News</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- news creation section -->
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2><i class="fa fa-newspaper"></i> News Creation</h2>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <form class="forms-sample padding_infor_info" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="title">Title</label>
                                                <input name="title" type="text" class="form-control" placeholder="News Title" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="content">Content</label>
                                                <textarea name="content" class="form-control" rows="5" placeholder="News Content" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Image</label>&nbsp;&nbsp;
                                                <input type="file" name="image" class="btn btn-secondary" accept="image/*" onchange="preview()" />
                                                &nbsp;<img id="frame" src="" width="100px" height="100px" alt="Image Preview" />
                                            </div>
                                            <div class="form-group">
                                                <label for="video_link">Video Link</label>
                                                <input name="video_link" type="text" class="form-control" placeholder="Video Link">
                                            </div>
                                            <div class="form-group">
                                                <label for="is_active">Is Active</label>
                                                <select class="form-control" name="is_active">
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-primary mr-2" name="btnSubmit">Submit</button>
                                            <button type="cancel" class="btn btn-light" onclick="javascript:window.location='../../view/admin/informationDashboard.php';">Cancel</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    <?php
    if (isset($_SESSION['newsCreationSuccess'])) {
        unset($_SESSION['newsCreationSuccess']);
        echo '
      Swal.fire({
         icon: "success",
         title: "Success",
         text: "News created successfully!",
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