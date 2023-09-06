<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "guardian-home.php") {echo "active";} ?>">
                    <a href="../guardian/guardian-home.php"> <i class="feather-grid"></i> <span>Dashboard</span></a>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "timetable.php") {echo "active";} ?>">
                    <a href="timetable.php"><i class="fas fa-table"></i> <span>Time Table</span></a>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "score-list.php" || basename($_SERVER['PHP_SELF']) == "score-detail.php") {echo "active";} ?>">
                    <a href="score-list.php"><i class="fas fa-book"></i> <span>Score</span></a>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "attendance-list.php" || basename($_SERVER['PHP_SELF']) == "attendance-detail.php") {echo "active";} ?>">
                    <a href="attendance-list.php"><i class="fas fa-sticky-note"></i> <span>Attendance</span></a>
                </li>
                <li
                    class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-profile.php") {echo "active";} ?>">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <!-- <li><a href="../student-profile.php"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "student-profile.php") {echo "active";} ?>">Profile</a>
                        </li> -->
                        <li><a href="#"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "#") {echo "active";} ?>">Language</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>