<nav class="navbar navbar-expand-lg navbar-light">
    <div class="full">
        <button type="button" id="sidebarCollapse" class="sidebar_toggle"><i class="fa fa-bars"></i></button>
        <div class="logo_section">
            <a href="empdashboard.php"><img class="img-responsive" src="../../assets/logo/logo_black.png" alt="#" /></a>
        </div>
        <div class="right_topbar">
            <div class="icon_info">
                <ul>
                    <li><a href="../../model/logout.php"><i class="fa-solid fa-power-off fa-beat" style="color: #c91d59;" alt="Log Out"></i></a></li>

                </ul>
                <ul class="user_profile_dd">
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown"><?php echo '<img class="img-responsive rounded-circle" src="../../assets/images/' . $profile_img . '">'; ?><span class="name_user"><?php echo $name, ' ' . $surname ?></span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="profile.html">My Profile</a>
                            <a class="dropdown-item" href="settings.html">Settings</a>
                            <a class="dropdown-item" href="../../model/logout.php"><span>Log Out</span> <i class="fa fa-sign-out"></i></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>