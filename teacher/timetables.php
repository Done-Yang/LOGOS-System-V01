<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {

    include "teacher-datas/program-db.php";
    include "teacher-datas/season-db.php";
    $programs = getAllPrograms($conn);
    $seasons = getLastSeason($conn);

    $timetables1 = '';
    $timetables2 = '';
    $t_id = '';
    try {
        $t_id = $_SESSION['teacher_login'];

        include "teacher-datas/teacher-db.php";
        $teacher = getTeacherById($t_id, $conn);
        $user = teacherGetUserById($t_id, $conn);
        // $t_id = 't001';

        if (!empty($t_id)) {
            $timetables1 = $conn->prepare("SELECT * FROM timetables WHERE teacher1_id=:teacher1_id");
            $timetables1->bindParam(':teacher1_id', $t_id);
            $timetables1->execute();

            $timetables2 = $conn->prepare("SELECT * FROM timetables WHERE teacher2_id=:teacher2_id ");
            $timetables2->bindParam(':teacher2_id', $t_id);
            $timetables2->execute();

            // For get the first row in timetables
            $datas1 = $conn->prepare("SELECT * FROM timetables WHERE teacher1_id=:teacher1_id LIMIT 1");
            $datas1->bindParam(':teacher1_id', $t_id);
            $datas1->execute();

            $datas2 = $conn->prepare("SELECT * FROM timetables WHERE  teacher2_id=:teacher2_id  LIMIT 1");
            $datas2->bindParam(':teacher2_id', $t_id);
            $datas2->execute();

            include "teacher-datas/subject-db.php";
        }
    } catch (PDOException $e) {
        $e->getMessage();
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

    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Time Teble List</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="timetable-list.php">Time Tebles</a></li>
                                    <li class="breadcrumb-item active">Time Teble List</li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
                                <?php if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                        echo $_SESSION['error'];
                                        unset($_SESSION['error']);
                                        ?>
                                </div>
                                <?php } ?>

                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Time Tables</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="timetable-edit.php" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="timetable-add.php" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <div class="container">
                                        <p class="text-center">
                                            <b><?php echo $teacher['fname_en'] . ' ' . $teacher['lname_en'] ?>'s
                                                Teaching Schedule</b></p>
                                        <p class="text-center">For Academic Year 2022-2023</p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center">

                                                <tbody>

                                                    <tr>
                                                        <?php foreach ($datas1 as $data) { ?>
                                                        <td>
                                                            <?php echo $data['times1'] ?>
                                                        </td>
                                                        <?php } ?>

                                                        <?php foreach ($timetables1 as $timetable) {

                                                            $subject1 = getSubjectById($timetable['sub1_id'], $conn);
                                                            $teacher1 = getTeacherById($timetable['teacher1_id'], $conn);
                                                        ?>
                                                        <td>
                                                            <span><?php echo $timetable['days'] ?></span>
                                                            <div><?php echo $subject1['name'] ?>
                                                                (<?php echo $timetable['sub1_id'] ?>)</div>
                                                            <div class="small text-secondary">Room:
                                                                <?php echo $timetable['class1'] ?></div>
                                                            <div class="small text-secondary">Program:
                                                                <?php echo $timetable['program'] ?></div>
                                                            <div class="small text-secondary">Year:
                                                                <?php echo $timetable['year'] ?>
                                                                (<?php echo $timetable['part'] ?>)</div>
                                                            <div class="small text-secondary">Class ID:
                                                                <?php echo $timetable['group_id'] ?> </div>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>

                                                    <tr>
                                                        <?php foreach ($datas2 as $data) { ?>
                                                            <td>
                                                                <?php echo $data['times2'] ?>
                                                            </td>
                                                        <?php } ?>
                                                        <?php foreach ($timetables2 as $timetable) {
                                                            $subject2 = getSubjectById($timetable['sub2_id'], $conn);
                                                            $teacher2 = getTeacherById($timetable['teacher2_id'], $conn); ?>
                                                        <td>
                                                            <span><?php echo $timetable['days'] ?></span>
                                                            <div><?php echo $subject2['name'] ?>
                                                                (<?php echo $timetable['sub2_id'] ?>)</div>
                                                            <div class="small text-secondary">Room:
                                                                <?php echo $timetable['class2'] ?></div>
                                                            <div class="small text-secondary">Program:
                                                                <?php echo $timetable['program'] ?></div>
                                                            <div class="small text-secondary">Year:
                                                                <?php echo $timetable['year'] ?>
                                                                (<?php echo $timetable['part'] ?>)</div>
                                                            <div class="small text-secondary">Class ID:
                                                                <?php echo $timetable['group_id'] ?> </div>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div><br><br>
                                        <p><i><b>Remark: </b></i></p>
                                        <p><i>1. Google Meet Link will be post on Google Classroom.</i></p>
                                        <p><i>2. Join your online class as scheduled everyday.</i></p>
                                        <p><i>3. Don't be LATE! Attendance will be taken!</i></p>
                                    </div>
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