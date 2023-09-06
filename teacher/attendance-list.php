<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['teacher_login'];

    include "teacher-datas/teacher-db.php";
    $teacher = getTeacherById($id, $conn);
    $user = teacherGetUserById($id, $conn);

    include "teacher-datas/group-db.php";
    include "teacher-datas/subject-db.php";

    $timetables1 = $conn->prepare("SELECT * FROM timetables");
    $timetables1->execute();
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

    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/validate-form.css">
</head>

<body>

    <div class="main-wrapper">
        <?php
            include "include/header.php";
            include "include/sidebar.php";
        ?>

        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Student Attendance</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="attendance-list.php">Attendancs</a></li>
                                    <li class="breadcrumb-item active">Student Attendances</li>
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
                                    <input type="text" class="form-control" placeholder="Search here ..." name="search_by">
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
                                            <h3 class="page-title">Subjects</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="score-add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th>Group</th>
                                                <th>Subject</th>
                                                <th>Part</th>
                                                <th>Year</th>
                                                <th>Semester</th>
                                                <th>Season Year</th>
                                                <th>Program</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            $sub_check = array();
                                            $group_check = array();
                                            foreach ($timetables1 as $timetable) {  
                                                if ($timetable['teacher1_id'] == $id and !in_array($timetable['sub1_id'].$timetable['semester'].$timetable['group_id'], $sub_check) and !in_array($timetable['group_id'].$timetable['semester'].'1', $group_check) ) {
                                                    array_push($sub_check, $timetable['sub1_id'].$timetable['semester'].$timetable['group_id'] );
                                                    array_push($group_check, $timetable['group_id'].$timetable['semester'].'1');
                                                    $i++;
                                                    $subject = getSubjectById($timetable['sub1_id'], $conn);?>
                                                    <tr>
                                                        <!-- <?php echo $timetable['sub1_id'].$timetable['semester'] ?> -->
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $timetable['group_id'] ?></td>
                                                        <td><?php echo $subject['name'] ?></td>
                                                        <td><?php echo $timetable['part'] ?></td>
                                                        <td><?php echo $timetable['year'] ?></td>
                                                        <td><?php echo $timetable['semester'] ?></td>
                                                        <td><?php echo $timetable['season'] ?></td>
                                                        <td><?php echo $timetable['program'] ?></td>
                                                        <td class="text-end">
                                                            <div class="actions ">
                                                                <a href="attendance-detail.php?group_id=<?= $timetable['group_id'] ?>&sub_id=<?= $subject['sub_id'] ?>&semester=<?= $timetable['semester'] ?>" class="btn btn-sm bg-success-light me-2 ">
                                                                    <i class="feather-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                                if ($timetable['teacher2_id'] == $id and !in_array($timetable['sub2_id'].$timetable['semester'].$timetable['group_id'], $sub_check) and !in_array($timetable['group_id'].$timetable['semester'].'2', $group_check)) {
                                                    array_push($sub_check, $timetable['sub2_id'].$timetable['semester'].$timetable['group_id']);
                                                    array_push($group_check, $timetable['group_id'].$timetable['semester'].'2');
                                                    $i++;
                                                    $subject = getSubjectById($timetable['sub2_id'], $conn); ?>
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $timetable['group_id'] ?></td>
                                                        <td><?php echo $subject['name'] ?></td>
                                                        <td><?php echo $timetable['part'] ?></td>
                                                        <td><?php echo $timetable['year'] ?></td>
                                                        <td><?php echo $timetable['semester'] ?></td>
                                                        <td><?php echo $timetable['season'] ?></td>
                                                        <td><?php echo $timetable['program'] ?></td>
                                                        <td class="text-end">
                                                            <div class="actions ">
                                                                <a href="attendance-detail.php?group_id=<?= $timetable['group_id'] ?>&sub_id=<?= $subject['sub_id'] ?>&semester=<?= $timetable['semester'] ?>" class="btn btn-sm bg-success-light me-2 ">
                                                                    <i class="feather-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                <?php } ?>

                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>