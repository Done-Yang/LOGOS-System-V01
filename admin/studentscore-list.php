<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    include "admin-datas/group-db.php";
    include "admin-datas/studentgroup-db.php";

    $student_group = getAllStudentGroup($conn);
    $groups = getAllGroups($conn);
    $search_by = '';

    if (isset($_REQUEST['search'])) {
        try {
            $search_by = $_REQUEST['search_by'];
            if (!empty($search_by)) {

                $groups = $conn->prepare("SELECT * FROM groups WHERE group_id=:group_id OR program=:program OR part=:part OR season=:season OR year=:year");
                $groups->bindParam(':group_id', $search_by);
                $groups->bindParam(':program', $search_by);
                $groups->bindParam(':part', $search_by);
                $groups->bindParam(':season', $search_by);
                $groups->bindParam(':year', $search_by);
                $groups->execute();
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Logos Institute of Foreign Language</title>

    <link rel="shortcut icon" href="../assets/img/logo_logos.png">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="../assets/plugins/icons/flags/flags.css">

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="main-wrapper">
        <div class="header">

            <div class="header-left">
                <a href="admin-home.php" class="logo">
                    <img src="../assets/img/logo_logos2.png" alt="Logo" width="37" height="37">
                </a>
                <a href="admin-home.php" class="logo logo-small">
                    <img src="../assets/img/logo_logos.png" alt="Logo" width="30" height="30">
                </a>
            </div>
            <div class="menu-toggle">
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fas fa-bars"></i>
                </a>
            </div>

            <div class="top-nav-search">
                <form>
                    <input type="text" class="form-control" placeholder="Search here">
                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
                <i class="fas fa-bars"></i>
            </a>

            <ul class="nav user-menu">
                <li class="nav-item dropdown noti-dropdown language-drop me-2">
                    <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                        <img src="../assets/img/icons/header-icon-01.svg" alt="">
                    </a>
                    <div class="dropdown-menu ">
                        <div class="noti-content">
                            <div>
                                <a class="dropdown-item" href="javascript:;"><i class="flag flag-us me-2"></i>English</a>
                                <a class="dropdown-item" href="javascript:;"><i class="flag flag-la me-2"></i>Laos</a>
                                <a class="dropdown-item" href="javascript:;"><i class="flag flag-cn me-2"></i>Chines</a>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item dropdown has-arrow new-user-menus">
                    <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                        <span class="user-img">

                            <?php $officer_image = $officer['image'];
                            if ($officer_image == '') { ?>
                                <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>" alt="User Image">
                            <?php } else { ?>
                                <img class="rounded-circle" src="<?php echo "../admin/upload/officer_profile/$officer_image" ?>" width="31" alt="User Image">
                            <?php } ?>

                            <div class="user-text">
                                <h6><?php echo $officer['fname_en'] . " " . $officer['lname_en'] ?></h6>
                                <p class="text-muted mb-0"><?php echo $user['status'] ?></p>

                            </div>
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="user-header">
                            <div class="avatar avatar-sm">
                                <?php $officer_image = $officer['image'];
                                if ($officer_image == '') { ?>
                                    <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>" alt="User Image">
                                <?php } else { ?>
                                    <img class="rounded-circle" src="<?php echo "../admin/upload/officer_profile/$officer_image" ?>" width="31" alt="User Image">
                                <?php } ?>
                            </div>
                            <div class="user-text">
                                <h6><?php echo $officer['fname_en'] . " " . $officer['lname_en'] ?></h6>
                                <p class="text-muted mb-0"><?php echo $user['status'] ?></p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="admin-profile.php">My Profile</a>
                        <a class="dropdown-item" href="../logout.php">Logout</a>
                    </div>
                </li>

            </ul>
        </div>

        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    <ul>
                        <li class="menu-title">
                            <span>Main Menu</span>
                        </li>
                        <li class=" <?php if (basename($_SERVER['PHP_SELF']) == "admin-home.php") {
                                        echo "active";
                                    } ?>"><a href="../admin/admin-home.php"> <i class="feather-grid"></i> <span>Dashboard</span></a></li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "director-list.php" || basename($_SERVER['PHP_SELF']) == "director-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-university"></i> <span> Directors</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/director-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Director List</a></li>
                                <li><a href="../admin/director-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "director-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Director Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php" || basename($_SERVER['PHP_SELF']) == "officer-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-female"></i> <span> Officers</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/officer-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Officer List</a></li>
                                <li><a href="../admin/officer-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "officer-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Officer Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php" || basename($_SERVER['PHP_SELF']) == "teacher-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-chalkboard-teacher"></i> <span> Teachers</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/teacher-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Teacher List</a></li>
                                <li><a href="../admin/teacher-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "teacher-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Teacher Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "student-list.php" || basename($_SERVER['PHP_SELF']) == "student-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-graduation-cap"></i> <span> Students</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/student-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Student List</a></li>
                                <li><a href="../admin/student-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "student-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Student Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php" || basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-users"></i> <span>Student Groups</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/studentgroup-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-list.php") {
                                                                                        echo "active";
                                                                                    } ?>">Student Group List</a></li>
                                <li><a href="../admin/studentgroup-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentgroup-add.php") {
                                                                                        echo "active";
                                                                                    } ?> ">Student Group Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "studentscore-list.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-book"></i> <span>Student Scores</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/studentscore-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "studentscore-list.php") {
                                                                                        echo "active";
                                                                                    } ?>">Student Score List</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php" || basename($_SERVER['PHP_SELF']) == "subject-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-book-reader"></i> <span> Subjects</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/subject-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Subject List</a></li>
                                <li><a href="../admin/subject-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "subject-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Subject Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php" || basename($_SERVER['PHP_SELF']) == "classroom-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-fax"></i> <span>Class Rooms</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/classroom-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-list.php") {
                                                                                        echo "active";
                                                                                    } ?>">Class Room List</a></li>
                                <li><a href="../admin/classroom-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "classroom-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Class Room Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php" || basename($_SERVER['PHP_SELF']) == "timetable-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-table"></i> <span> Time Tables</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/timetable-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-list.php") {
                                                                                        echo "active";
                                                                                    } ?>">Time Table List</a></li>
                                <li><a href="../admin/timetable-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "timetable-add.php") {
                                                                                    echo "active";
                                                                                } ?> ">Time Table Add</a></li>
                            </ul>
                        </li>
                        <li class="menu-title">
                            <span>Management</span>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "program-list.php" || basename($_SERVER['PHP_SELF']) == "program-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-sitemap"></i> <span> Programs</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/program-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Programs List</a></li>
                                <li><a href="../admin/program-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "program-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Programs Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "season-list.php" || basename($_SERVER['PHP_SELF']) == "season-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-tasks"></i> <span> Seasons</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/season-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-list.php") {
                                                                                    echo "active";
                                                                                } ?>">Season List</a></li>
                                <li><a href="../admin/season-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "season-add.php") {
                                                                                    echo "active";
                                                                                } ?>">Season Add</a></li>
                            </ul>
                        </li>
                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "group-list.php" || basename($_SERVER['PHP_SELF']) == "group-add.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-building"></i> <span> Groups</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/group-list.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-list.php") {
                                                                                    echo "active";
                                                                                } ?>">group List</a></li>
                                <li><a href="../admin/group-add.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "group-add.php") {
                                                                                echo "active";
                                                                            } ?>">group Add</a></li>
                            </ul>
                        </li>

                        <li class="submenu <?php if (basename($_SERVER['PHP_SELF']) == "admin-profile.php" || basename($_SERVER['PHP_SELF']) == "languages.php") {
                                                echo "active";
                                            } ?>">
                            <a href="#"><i class="fas fa-cog"></i> <span> Settings</span> <span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="../admin/admin-profile.php" class="<?php if (basename($_SERVER['PHP_SELF']) == "admin-profile.php") {
                                                                                    echo "active";
                                                                                } ?>">Profile</a></li>
                                <li><a href="#" class="<?php if (basename($_SERVER['PHP_SELF']) == "languages.php") {
                                                            echo "active";
                                                        } ?>">Language</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Groups</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="studentgroup-list.php">Group</a></li>
                                    <li class="breadcrumb-item active">All Groups</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-group-form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search here ..." name="search_by" value="<?php echo $search_by ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table comman-shadow">
                            <div class="card-body">

                                <?php if (isset($_SESSION['success'])) { ?>
                                    <div class="alert alert-success" role="alert">
                                        <?php
                                        echo $_SESSION['success'];
                                        unset($_SESSION['success']);
                                        ?>
                                    </div>
                                <?php } ?>

                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">group</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="studentgroup-add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <?php
                                    if (isset($errorMsg)) {
                                    ?>
                                        <div class="alert alert-danger">
                                            <strong><?php echo $errorMsg; ?></strong>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (isset($successMsg)) {
                                    ?>
                                        <div class="alert alert-success">
                                            <strong><?php echo $successMsg; ?></strong>
                                        </div>
                                    <?php } ?>
                                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th>Group</th>
                                                <th>Program</th>
                                                <th>Season</th>
                                                <th>Part</th>
                                                <th>Year</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i = 0;
                                            if ($groups == "No Groups!") { ?>
                                                <tr>
                                                    <td>No Group!</td>
                                                </tr>
                                                <?php } else {

                                                foreach ($groups as $group) {
                                                    $i++; ?>

                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td>
                                                            <a href="studentscore-detail.php?id=<?= $group['group_id'] ?>&season=<?= $group['season'] ?>">
                                                                <?php echo $group['group_id'] ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $group['program'] ?></td>
                                                        <td><?php echo $group['season'] ?></td>
                                                        <td><?php echo $group['part'] ?></td>
                                                        <td><?php echo $group['year'] ?></td>
                                                        <td class="text-end">
                                                            <div class="actions ">
                                                                <a href="studentscore-detail.php?id=<?= $group['group_id'] ?>&season=<?= $group['season'] ?>" class="btn btn-sm bg-success-light me-2 ">
                                                                    <i class="feather-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                            <?php }
                                            } ?>


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <p>Copyright © Logos Institute of Foreign Language.</p>
            </footer>
        </div>
    </div>


    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="../assets/plugins/datatables/datatables.min.js"></script>

    <script src="../assets/js/script.js"></script>

</body>

</html>