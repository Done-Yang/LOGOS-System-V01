<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span><?php echo $lang['main_menu'] ?></span>
                </li>
                <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "director-home.php") {
                                    echo "active";
                                } ?>"><a href="../director/director-home.php"> <i class="feather-grid"></i>
                        <span><?php echo $lang['dashboard'] ?></span></a></li>

                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "director-list.php" || basename($_SERVER['PHP_SELF']) == "director-add.php" || basename($_SERVER['PHP_SELF']) == "director-edit.php" || basename($_SERVER['PHP_SELF']) == "director-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-university"></i> <span> <?php echo $lang['directors'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/director-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['director_list'] ?></a></li>
                        <li><a href="../director/director-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['director_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "admin-list.php" || basename($_SERVER['PHP_SELF']) == "admin-add.php" || basename($_SERVER['PHP_SELF']) == "admin-edit.php" || basename($_SERVER['PHP_SELF']) == "admin-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-star"></i> <span> <?php echo $lang['admin'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/admin-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "admin-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['admin_list'] ?></a></li>
                        <li><a href="../director/admin-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "admin-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['admin_add'] ?></a></li>
                    </ul>
                </li>

                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php" || basename($_SERVER['PHP_SELF']) == "officer-add.php" || basename($_SERVER['PHP_SELF']) == "officer-edit.php" || basename($_SERVER['PHP_SELF']) == "officer-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-female"></i> <span> <?php echo $lang['officers'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/officer-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['officer_list'] ?></a></li>
                        <li><a href="../director/officer-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['officer_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php" || basename($_SERVER['PHP_SELF']) == "teacher-add.php" || basename($_SERVER['PHP_SELF']) == "teacher-edit.php" || basename($_SERVER['PHP_SELF']) == "teacher-detail.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> <?php echo $lang['professors'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/teacher-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['professor_list'] ?></a></li>
                        <li><a href="../director/teacher-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['professor_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-list.php" || basename($_SERVER['PHP_SELF']) == "student-add.php" || basename($_SERVER['PHP_SELF']) == "student-detail.php" || basename($_SERVER['PHP_SELF']) == "student-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-graduation-cap"></i> <span> <?php echo $lang['students'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/student-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['student_list'] ?></a></li>
                        <li><a href="../director/student-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['student_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-add.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-edit.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-detail.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-card-preview.php" ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-users"></i> <span><?php echo $lang['student_groups'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/studentgroup-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php") {
                                                                                    echo "active";
                                                                                } ?>"><?php echo $lang['student_group_list'] ?></a></li>
                        <li><a href="../director/studentgroup-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                                                    echo "active";
                                                                                } ?> "><?php echo $lang['student_group_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-score-list.php" || basename($_SERVER['PHP_SELF']) == "student-score-detail.php"  ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-book"></i> <span><?php echo $lang['student_scores'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/student-score-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-score-list.php") {
                                                                                    echo "active";
                                                                                } ?>"><?php echo $lang['student_score_list'] ?></a></li>
                        <!-- <li><a href="../director/studentgroup-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Student Group Add</a></li> -->
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php" || basename($_SERVER['PHP_SELF']) == "subject-add.php" || basename($_SERVER['PHP_SELF']) == "subject-edit.php" ) {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-book-reader"></i> <span> <?php echo $lang['subjects'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/subject-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['subject_list'] ?></a></li>
                        <li><a href="../director/subject-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-add.php") {
                                                                                echo "active";
                                                                            } ?> "><?php echo $lang['subject_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php" || basename($_SERVER['PHP_SELF']) == "classroom-add.php" || basename($_SERVER['PHP_SELF']) == "classroom-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-fax"></i> <span><?php echo $lang['classroom'] ?></span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/classroom-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php") {
                                                                                    echo "active";
                                                                                } ?>"><?php echo $lang['classroom_list'] ?></a></li>
                        <li><a href="../director/classroom-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-add.php") {
                                                                                echo "active";
                                                                            } ?> "><?php echo $lang['classroom_list'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php" || basename($_SERVER['PHP_SELF']) == "timetable-add.php" || basename($_SERVER['PHP_SELF']) == "timetable-detail.php" || basename($_SERVER['PHP_SELF']) == "timetable-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-table"></i> <span><?php echo $lang['time_tables'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/timetable-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php") {
                                                                                    echo "active";
                                                                                } ?>"><?php echo $lang['time_table_list'] ?></a></li>
                        <li><a href="../director/timetable-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-add.php") {
                                                                                echo "active";
                                                                            } ?> "><?php echo $lang['time_table_add'] ?></a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span><?php echo $lang['management'] ?></span>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "program-list.php" || basename($_SERVER['PHP_SELF']) == "program-add.php" || basename($_SERVER['PHP_SELF']) == "program-edit.php")  {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-sitemap"></i> <span><?php echo $lang['programs'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/program-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['programs'] ?></a></li>
                        <li><a href="../director/program-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['program_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "season-list.php" || basename($_SERVER['PHP_SELF']) == "season-add.php" || basename($_SERVER['PHP_SELF']) == "season-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-tasks"></i> <span><?php echo $lang['seasons'] ?></span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/season-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['season_list'] ?></a></li>
                        <li><a href="../director/season-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-add.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['season_add'] ?></a></li>
                    </ul>
                </li>
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "group-list.php" || basename($_SERVER['PHP_SELF']) == "group-add.php" || basename($_SERVER['PHP_SELF']) == "group-edit.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-building"></i> <span> <?php echo $lang['groups'] ?></span> <span
                            class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/group-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-list.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['group_list'] ?></a></li>
                        <li><a href="../director/group-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-add.php") {
                                                                            echo "active";
                                                                        } ?>"><?php echo $lang['group_add'] ?></a></li>
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
                <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "director-profile.php" || basename($_SERVER['PHP_SELF']) == "languages.php") {
                                            echo "active";
                                        } ?>">
                    <a href="#"><i class="fas fa-cog"></i> <span><?php echo $lang['setting'] ?></span> <span class="menu-arrow"></span></a>
                    <ul>
                        <li><a href="../director/director-profile.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-profile.php") {
                                                                                echo "active";
                                                                            } ?>"><?php echo $lang['profile'] ?></a></li>
                        <li><a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == "languages.php") {
                                                                            echo "active";
                                                                        } ?>"><?php echo $lang['language'] ?></a></li>
                        <li>
                            <a class="dropdown-item" href="../logout.php"><?php echo $lang['logout'] ?></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>