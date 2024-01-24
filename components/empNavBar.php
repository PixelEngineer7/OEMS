<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="empdashboard.php"><img class="logo_icon img-responsive" src="../../assets/logo/logo_icon.png" alt="#" /></a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img">

                    <?php echo '<img class="img-responsive" src="../../assets/images/' . $profile_img . '">'; ?>



                </div>
                <div class="user_info">
                    <h6><?php echo $name, ' ' . $surname ?></h6>
                    <p><span class="online_animation"></span> Online</p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        <h4 style="text-align:center">Infinity Networks Employee Management System</h4>
        <ul class="list-unstyled components">
            <li> <a href="newsFeed.php"><i class="fa-solid fa-newspaper blue1_color"></i> <span>News Feed</span></a></li>
            <li><a href="myInformation.php"><i class="fa-solid fa-circle-info orange_color"></i> <span>Personal Information</span></a></li>
            <li><a href="settings.html"><i class="fa fa-check-circle yellow_color"></i> <span>Daily Attendance</span></a></li>
            <li><a href="map.html"><i class="fa fa-tasks purple_color2"></i> <span>Task Management</span></a></li>
            <li><a href="map.html"><i class="fa fa-calendar-times-o red_color"></i> <span>Absence Management</span></a></li>
            <li><a href="charts.html"><i class="fa fa-bar-chart-o green_color"></i> <span>Performance Management</span></a></li>

        </ul>
    </div>
</nav>