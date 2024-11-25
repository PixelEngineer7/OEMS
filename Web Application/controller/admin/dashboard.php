<?php
//Name:RAMLOCHUND Gitendrajeet 
//Project: OEMS
//Scope: Administrator Dashboard
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<!-- Components Header  -->
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
            <?php include '../../components/warning.php'; ?>

            <!-- footer -->
            <?php include '../../components/footer.php'; ?>
</body>

</html>