<?php
require_once 'include/config/dbcon.php';
session_start();
include "student-datas/season-db.php";
include "student-datas/subject-db.php";
include "student-datas/timetable-db.php";
include "student-datas/teacher-db.php";
include "student-datas/student-db.php";

$seasons = getAllSeasons($conn);
$subjects = getAllSubjects($conn);


if (!isset($_SESSION['student_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['student_login'];
    $student = getStudentById($id, $conn);
    $user = studentGetUserById($id, $conn);

    $group_id = $student['group_status'];
    $part = $student['part'];

    // $timetables = getTimetableByGroupId($group_id, $conn);

    $timetables1 = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id AND part=:part");
    $timetables1->bindParam(':group_id', $group_id);
    $timetables1->bindParam(':part', $part);
    $timetables1->execute();

    $timetables2 = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id AND part=:part");
    $timetables2->bindParam(':group_id', $group_id);
    $timetables2->bindParam(':part', $part);
    $timetables2->execute();

    // For get the first row in timetables
    $datas = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id AND part=:part LIMIT 1");
    $datas->bindParam(':group_id', $group_id);
    $datas->bindParam(':part', $part);
    $datas->execute();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Logos Institute of Foreign Language</title>

    <link rel="shortcut icon" href="assets/img/favicon.png">

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
                                <h3 class="page-title">My Time Teble</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="student-home.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">My Time Teble</li>
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
                                            <a href="timetable-edit.php" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="timetable-add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>


                                <?php
                                foreach ($datas as $data) { ?>
                                    <div class="table-responsive">
                                        <div class="container">
                                            <p class="text-center"><b><?php echo $data['program'] ?>'s Learning Schedule (<?php echo $data['part'] ?>)</b></p>
                                            <p class="text-center">For class: <?php echo $data['group_id'] ?>, <?php echo $data['year'] ?>st Semester, in Academic year <?php echo $data['season'] ?></p>
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-center">
                                                    <thead>
                                                        <tr class="bg-light-gray">
                                                            <th class="text-uppercase">Time</th>
                                                            <th class="text-uppercase">Monday</th>
                                                            <th class="text-uppercase">Tuesday</th>
                                                            <th class="text-uppercase">Wednesday</th>
                                                            <th class="text-uppercase">Thursday</th>
                                                            <th class="text-uppercase">Friday</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <tr>

                                                            <td class="align-middle">
                                                                <?php echo $data['times1'] ?>
                                                            </td>

                                                            <?php foreach ($timetables1 as $timetable) {

                                                                $subject1 = getSubjectById($timetable['sub1_id'], $conn);
                                                                $teacher1 = getTeacherById($timetable['teacher1_id'], $conn);
                                                                if ($timetable['days'] == 'Monday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject1['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book1'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class1'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher1['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Tuesday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject1['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book1'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class1'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher1['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Wednesday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject1['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book1'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class1'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher1['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Thursday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject1['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book1'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class1'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher1['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Friday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject1['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book1'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class1'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher1['fname_en'] ?> )</div>
                                                                    </td>
                                                            <?php }
                                                            } ?>
                                                        </tr>

                                                        <tr>
                                                            <td class="align-middle">
                                                                <?php echo $data['times2'] ?>
                                                            </td>

                                                            <?php foreach ($timetables2 as $timetable) {
                                                                $subject2 = getSubjectById($timetable['sub2_id'], $conn);
                                                                $teacher2 = getTeacherById($timetable['teacher2_id'], $conn);
                                                                if ($timetable['days'] == 'Monday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject2['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book2'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class2'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher2['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Tuesday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject2['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book2'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class2'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher2['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Wednesday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject2['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book2'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class2'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher2['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Thursday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject2['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book2'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class2'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher2['fname_en'] ?> )</div>
                                                                    </td>
                                                                <?php }
                                                                if ($timetable['days'] == 'Friday') { ?>
                                                                    <td>
                                                                        <span><?php echo $subject2['name'] ?></span>
                                                                        <div class="small text-secondary">(Book id: <?php echo $timetable['book2'] ?>)</div>
                                                                        <div class="small text-secondary">(Room: <?php echo $timetable['class2'] ?>)</div>
                                                                        <div class="small text-secondary">(Prf: <?php echo $teacher2['fname_en'] ?> )</div>
                                                                    </td>
                                                            <?php }
                                                            } ?>
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
                                <?php
                                }
                                ?>

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

    <script src="../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>