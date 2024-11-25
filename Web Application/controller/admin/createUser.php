<?php
require('../../model/user.php');
session_start();


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


if (isset($_POST["btnSubmit"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];


    $user = new user();
    try {
        $user->createUser($email, $password, $role, $name, $surname);
        $_SESSION['createUserSuccess'] = true;
        header('location:../../view/admin/userCreationDashboard.php');
    } catch (PDOException $e) {
        $error = "Infinity Networks ALERT: User already exist on System";
    }
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
                <!-- dashboard inner -->
                <div class="midde_cont">
                    <div class="container-fluid">
                        <div class="row column_title">
                            <div class="col-md-12">
                                <div class="page_title">
                                    <h2>Create user on System</h2>
                                </div>
                            </div>
                        </div>
                        <!-- row -->
                        <div class="row">
                            <!-- invoice section -->
                            <div class="col-md-12">
                                <div class="white_shd full margin_bottom_30">
                                    <div class="full graph_head">
                                        <div class="heading1 margin_0">
                                            <h2><i class="fa fa-user"></i> User Creation onto Infinity Networks System
                                            </h2>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <form class="forms-sample padding_infor_info" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="email">Email address</label>
                                                <input name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required title="Please enter a valid email address (e.g., user@mailhost.com)." type="email" class="form-control" placeholder="Email">

                                            </div>
                                            <div class="form-group">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" placeholder="Password" required name="password" minlength="8" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$">


                                            </div>
                                            <div class="form-group">
                                                <label for="Category">Category</label>
                                                <select class="form-control" name="role">
                                                    <option value="Administrator">Administrator</option>
                                                    <option value="Employee">Employee</option>
                                                    <option value="Supervisor">Supervisor</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="name">Name</label>
                                                <input name="name" type="text" class="form-control" placeholder="Eg. Erling" pattern="[A-Za-z '-]+" title="Please enter text only" required>


                                            </div>

                                            <div class="form-group">
                                                <label for="surname">Surname</label>
                                                <input name="surname" type="text" class="form-control" placeholder="Eg. Halaand" pattern="[A-Za-z]+" title="Please enter text only" required>

                                            </div>
                                            <?php if (isset($_POST["btnSubmit"])) { ?>
                                                <div class="alert alert-info" role="alert">
                                                    <strong><?php echo $error; ?></strong>
                                                </div>
                                            <?php } ?>

                                            <button type="submit" class="btn btn-primary mr-2" name="btnSubmit">Submit</button>
                                            <button type="cancel" class="btn btn-light" onclick="javascript:window.location='../../view/admin/userCreationDashboard.php';">Cancel</button>
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <!-- footer -->
                        <?php include '../../components/footer.php'; ?>
</body>

</html>