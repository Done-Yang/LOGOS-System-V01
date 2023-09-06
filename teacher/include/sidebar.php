<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "teacher-home.php") {echo "active";} ?>">
                    <a href="../teacher/teacher-home.php"> <i class="feather-grid"></i> <span>Dashboard</span></a>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "timetables.php") {echo "active";} ?>">
                    <a href="../teacher/timetables.php"><i class="fas fa-table"></i> <span>Time Table</span></a>
                </li>
                <li
                    class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "score-list.php" || basename($_SERVER['PHP_SELF']) == "score-add.php" || basename($_SERVER['PHP_SELF']) == "score-detail.php") {echo "active";} ?>">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> Score</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../teacher/score-list.php"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "score-list.php") {echo "active";} ?>">Score
                                List</a></li>
                        <li><a href="../teacher/score-add.php"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "score-add.php") {echo "active";} ?>">Score
                                Add</a></li>
                    </ul>
                </li>
                
                <li  class=" <?php if (basename($_SERVER['PHP_SELF']) == "attendance-list.php" || basename($_SERVER['PHP_SELF']) == "attendance-detail.php" || basename($_SERVER['PHP_SELF']) == "attendance-edit.php") {echo "active";} ?>"> 
                    <a href="../teacher/attendance-list.php"> <span><i class="fas fa-sticky-note"></i>Attendance</span></a>
                </li>
                <li
                    class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "teacher-profile.php") {echo "active";} ?>">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../teacher/teacher-profile.php"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "teacher-profile.php") {echo "active";} ?>">Profile</a>
                        </li>
                        <li><a href="#"
                                class=" <?php if (basename($_SERVER['PHP_SELF']) == "#") {echo "active";} ?>">Score
                                Add</a></li>
                        <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>