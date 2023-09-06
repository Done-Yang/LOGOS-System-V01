<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>Main Menu</span>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "officer-home.php") {
                                    echo "active";
                                } ?>"><a href="../officer/officer-home.php"> <i class="feather-grid"></i>
                        <span>Dashboard</span></a></li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "director-list.php" || basename($_SERVER['PHP_SELF']) == "director-add.php" || basename($_SERVER['PHP_SELF']) == "director-edit.php" || basename($_SERVER['PHP_SELF']) == "director-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-university"></i> <span> Directors</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/director-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-list.php") {
                                                                                echo "active";
                                                                            } ?>">Director List</a></li>
                        <!-- <li><a href="../officer/director-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-add.php") {
                                                                                echo "active";
                                                                            } ?>">Director Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php" || basename($_SERVER['PHP_SELF']) == "officer-add.php" || basename($_SERVER['PHP_SELF']) == "officer-edit.php" || basename($_SERVER['PHP_SELF']) == "officer-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-female"></i> <span> Officers</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/officer-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php") {
                                                                                echo "active";
                                                                            } ?>">Officer List</a></li>
                        <!-- <li><a href="../officer/officer-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-add.php") {
                                                                                echo "active";
                                                                            } ?>">Officer Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php" || basename($_SERVER['PHP_SELF']) == "teacher-add.php" || basename($_SERVER['PHP_SELF']) == "teacher-edit.php" || basename($_SERVER['PHP_SELF']) == "teacher-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> Professors</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/teacher-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php") {
                                                                                echo "active";
                                                                            } ?>">Professor List</a></li>
                        <!-- <li><a href="../officer/teacher-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-add.php") {
                                                                                echo "active";
                                                                            } ?>">Professor Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-list.php" || basename($_SERVER['PHP_SELF']) == "student-add.php" || basename($_SERVER['PHP_SELF']) == "student-detail.php" || basename($_SERVER['PHP_SELF']) == "student-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> Students</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/student-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-list.php") {
                                                                                echo "active";
                                                                            } ?>">Student List</a></li>
                        <!-- <li><a href="../officer/student-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-add.php") {
                                                                                echo "active";
                                                                            } ?>">Student Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-add.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-edit.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-detail.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-card-preview.php" ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-users"></i> <span>Student Groups</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/studentgroup-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Student Group List</a></li>
                        <!-- <li><a href="../officer/studentgroup-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Student Group Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-score-list.php" || basename($_SERVER['PHP_SELF']) == "student-score-detail.php"  ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-book"></i> <span>Students's Score</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/student-score-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-score-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Students Score List</a></li>
                        <!-- <li><a href="../officer/studentgroup-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Student Group Add</a></li> -->
                    </ul>
                </li>
                
                
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php" || basename($_SERVER['PHP_SELF']) == "timetable-add.php" || basename($_SERVER['PHP_SELF']) == "timetable-detail.php" || basename($_SERVER['PHP_SELF']) == "timetable-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-table"></i> <span> Time Tables</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/timetable-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Time Table List</a></li>
                        <!-- <li><a href="../officer/timetable-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-add.php") {
                                                                                echo "active";
                                                                            } ?> ">Time Table Add</a></li> -->
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Management</span>
                </li>
                

                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "season-list.php" || basename($_SERVER['PHP_SELF']) == "season-add.php" || basename($_SERVER['PHP_SELF']) == "season-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-tasks"></i> <span> Seasons</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/season-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-list.php") {
                                                                                echo "active";
                                                                            } ?>">Season List</a></li>
                        <!-- <li><a href="../officer/season-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-add.php") {
                                                                                echo "active";
                                                                            } ?>">Season Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php" || basename($_SERVER['PHP_SELF']) == "subject-add.php" || basename($_SERVER['PHP_SELF']) == "subject-edit.php" ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-book-reader"></i> <span> Subjects</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/subject-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php") {
                                                                                echo "active";
                                                                            } ?>">Subject List</a></li>
                        <!-- <li><a href="../officer/subject-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-add.php") {
                                                                                echo "active";
                                                                            } ?> ">Subject Add</a></li> -->
                    </ul>
                </li>                                                           
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "group-list.php" || basename($_SERVER['PHP_SELF']) == "group-add.php" || basename($_SERVER['PHP_SELF']) == "group-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-building"></i> <span> Groups</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/group-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-list.php") {
                                                                                echo "active";
                                                                            } ?>">group List</a></li>
                        <!-- <li><a href="../officer/group-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-add.php") {
                                                                            echo "active";
                                                                        } ?>">group Add</a></li> -->
                    </ul>
                </li>

                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php" || basename($_SERVER['PHP_SELF']) == "classroom-add.php" || basename($_SERVER['PHP_SELF']) == "classroom-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-fax"></i> <span>Class Rooms</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/classroom-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Class Room List</a></li>
                        <!-- <li><a href="../officer/classroom-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-add.php") {
                                                                                echo "active";
                                                                            } ?> ">Class Room Add</a></li> -->
                    </ul>
                </li>

                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "program-list.php" || basename($_SERVER['PHP_SELF']) == "program-add.php" || basename($_SERVER['PHP_SELF']) == "program-edit.php")  {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-sitemap"></i> <span> Programs</span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/program-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-list.php") {
                                                                                echo "active";
                                                                            } ?>">Programs List</a></li>
                        <!-- <li><a href="../officer/program-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-add.php") {
                                                                                echo "active";
                                                                            } ?>">Programs Add</a></li> -->
                    </ul>
                </li>
                <!-- <li class="submenu">
                        <a href="#"><i class="fa fa-newspaper"></i> <span> Blogs</span>
                            <span class="menu-arrow"></span>
                        </a>
                        <ul>
                            <li><a href="#">All Blogs</a></li>
                            <li><a href="#">Add Blog</a></li>
                            <li><a href="#">Edit Blog</a></li>
                        </ul>
                    </li> -->
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "officer-profile.php" || basename($_SERVER['PHP_SELF']) == "languages.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../officer/officer-profile.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-profile.php") {
                                                                                echo "active";
                                                                            } ?>">Profile</a></li>
                        <li><a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == "languages.php") {
                                                                            echo "active";
                                                                        } ?>">Language</a></li>
                        <li>
                            <a class="dropdown-item" href="../logout.php">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>