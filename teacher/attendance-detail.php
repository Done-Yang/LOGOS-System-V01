<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $t_id = $_SESSION['teacher_login'];

    include "teacher-datas/teacher-db.php";
    $teacher = getTeacherById($t_id, $conn);
    $user = teacherGetUserById($t_id, $conn);

    $group_id = $_GET['group_id'];
    $sub_id = $_GET['sub_id'];
    $semester = $_GET['semester'];
    include "teacher-datas/group-db.php";
    include "teacher-datas/subject-db.php";
    include "teacher-datas/student-db.php";

    $timetables = $conn->prepare("SELECT * FROM timetables");
    $timetables->execute();

    $group = getGroupByID($group_id, $conn);

    $std_attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester'");
    $std_attendances->execute();
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
    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
    <style>
        table td:nth-child(2){
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 1;
        }
        table thead th:nth-child(2){
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 3;
        }
        .thead {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #f8f9fa;
        }
        .table-responsive{
            max-height: 35em;
            overflow-y: scroll;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="main-wrapper">

        <div id="print-btn">
            <?php
                include "include/header.php";
                include "include/sidebar.php";
            ?>
        </div>
        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header" id="print-btn">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Student Attendance</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="score-list.php">Attendances</a></li>
                                    <li class="breadcrumb-item active">Student Attendance</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="student-group-form" id="print-btn">
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

                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6 ">
                                    <h5 class="page-title">All Student in Group:
                                        <?php
                                        $subject = $conn->prepare("SELECT * FROM subjects WHERE sub_id='$sub_id'");
                                        $subject->execute();
                                        $sub = $subject->fetch(PDO::FETCH_ASSOC);
                                        echo $group_id . ', Subject: ' . $sub['name'].', Program: '.$group['program'].', Year: '.$group['year']. ', Semester: '.$semester. ', Season: '.$group['season'];
                                        ?>
                                    </h5>
                                </div>
                                <div class="col-6 text-end float-end">
                                    <button onclick="window.print();" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-print"></i></button>
                                    <a href="attendance-edit.php?group_id=<?= $_GET['group_id'] ?>&sub_id=<?= $_GET['sub_id'] ?>&semester=<?= $_GET['semester'] ?>" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <?php 
                                    // $sub_credit = $conn->prepare("SELECT * FROM subjects WHERE sub_id='$sub_id'");
                                    // $sub_credit->execute();
                                    // $credit = $sub_credit->fetch(PDO::FETCH_ASSOC);
                                    $credit = $sub['credit']; 
                                    if($credit == 1){?>
                                        <thead>
                                            <tr class="thead">
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th>Week1</th>
                                                <th>Week2</th>
                                                <th>Week3</th>
                                                <th>Week4</th>
                                                <th>Week5</th>
                                                <th>Week6</th>
                                                <th>Week7</th>
                                                <th>Week8</th>
                                                <th>Week9</th>
                                                <th>Week10</th>
                                                <th>Week11</th>
                                                <th>Week12</th>
                                                <th>Week13</th>
                                                <th>Week14</th>
                                                <th>Week15</th>
                                                <th>Week16</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($std_attendances as $std_attendance) {
                                                $i++;
                                                $student = getStudentById($std_attendance['std_id'], $conn);?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
                                                    <td><input type="checkbox" name="w1-1" disabled <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w2-1" disabled <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w3-1" disabled <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w4-1" disabled <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w5-2" disabled <?php if($std_attendance['w5_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w6-1" disabled <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w7-1" disabled <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w8-1" disabled <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w9-1" disabled <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w10-1" disabled <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w11-1" disabled <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w12-1" disabled <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w13-1" disabled <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w14-1" disabled <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w15-1" disabled <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w16-1" disabled <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><textarea class="border border-light" disabled style="height: 20px" ><?php echo $std_attendance['note']?></textarea></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php }elseif($credit == 2){?>
                                        <thead>
                                            <tr class="thead">
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th colspan="2">Week1</th>
                                                <th colspan="2">Week2</th>
                                                <th colspan="2">Week3</th>
                                                <th colspan="2">Week4</th>
                                                <th colspan="2">Week5</th>
                                                <th colspan="2">Week6</th>
                                                <th colspan="2">Week7</th>
                                                <th colspan="2">Week8</th>
                                                <th colspan="2">Week9</th>
                                                <th colspan="2">Week10</th>
                                                <th colspan="2">Week11</th>
                                                <th colspan="2">Week12</th>
                                                <th colspan="2">Week13</th>
                                                <th colspan="2">Week14</th>
                                                <th colspan="2">Week15</th>
                                                <th colspan="2">Week16</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($std_attendances as $std_attendance) {
                                                $i++;
                                                $student = getStudentById($std_attendance['std_id'], $conn);?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
                                                    <td><input type="checkbox" name="w1-1" disabled <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w1-2" disabled <?php if($std_attendance['w1_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w2-1" disabled <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w2-2" disabled <?php if($std_attendance['w2_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w3-1" disabled <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w3-2" disabled <?php if($std_attendance['w3_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w4-1" disabled <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w4-2" disabled <?php if($std_attendance['w4_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w5-2" disabled <?php if($std_attendance['w5_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w5-2" disabled <?php if($std_attendance['w5_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w6-1" disabled <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w6-2" disabled <?php if($std_attendance['w6_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w7-1" disabled <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w7-2" disabled <?php if($std_attendance['w7_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w8-1" disabled <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w8-2" disabled <?php if($std_attendance['w8_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w9-1" disabled <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w9-2" disabled <?php if($std_attendance['w9_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w10-1" disabled <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w10-2" disabled <?php if($std_attendance['w10_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w11-1" disabled <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w11-2" disabled <?php if($std_attendance['w11_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w12-1" disabled <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w12-2" disabled <?php if($std_attendance['w12_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w13-1" disabled <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w13-2" disabled <?php if($std_attendance['w13_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w14-1" disabled <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w14-2" disabled <?php if($std_attendance['w14_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w15-1" disabled <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w15-2" disabled <?php if($std_attendance['w15_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w16-1" disabled <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" name="w16-2" disabled <?php if($std_attendance['w16_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><textarea class="border border-light" disabled style="height: 20px" ><?php echo $std_attendance['note']?></textarea></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    <?php }elseif($credit == 3){?>
                                        <thead>
                                            <tr class="thead">
                                                <th>#</th>
                                                <th>Full Name</th>
                                                <th colspan="3">Week1</th>
                                                <th colspan="3">Week2</th>
                                                <th colspan="3">Week3</th>
                                                <th colspan="3">Week4</th>
                                                <th colspan="3">Week5</th>
                                                <th colspan="3">Week6</th>
                                                <th colspan="3">Week7</th>
                                                <th colspan="3">Week8</th>
                                                <th colspan="3">Week9</th>
                                                <th colspan="3">Week10</th>
                                                <th colspan="3">Week11</th>
                                                <th colspan="3">Week12</th>
                                                <th colspan="3">Week13</th>
                                                <th colspan="3">Week14</th>
                                                <th colspan="3">Week15</th>
                                                <th colspan="3">Week16</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 0;
                                            foreach ($std_attendances as $std_attendance) {
                                                $i++;
                                                $student = getStudentById($std_attendance['std_id'], $conn)?>
                                                
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <input type="hidden" name='<?php echo $i . 'std_id'?>' value="<?php echo $std_attendance['std_id'] ?>">
                                                    <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w1_1' ?>" <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w1_2' ?>" <?php if($std_attendance['w1_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w1_3' ?>" <?php if($std_attendance['w1_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w2_1' ?>" <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w2_2' ?>" <?php if($std_attendance['w2_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w2_3' ?>" <?php if($std_attendance['w2_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w3_1' ?>" <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w3_2' ?>" <?php if($std_attendance['w3_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w3_3' ?>" <?php if($std_attendance['w3_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w4_1' ?>" <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w4_2' ?>" <?php if($std_attendance['w4_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w4_3' ?>" <?php if($std_attendance['w4_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w5_1' ?>" <?php if($std_attendance['w5_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w5_2' ?>" <?php if($std_attendance['w5_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w5_3' ?>" <?php if($std_attendance['w5_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w6_1' ?>" <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w6_2' ?>" <?php if($std_attendance['w6_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w6_3' ?>" <?php if($std_attendance['w6_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w7_1' ?>" <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w7_2' ?>" <?php if($std_attendance['w7_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w7_3' ?>" <?php if($std_attendance['w7_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w8_1' ?>" <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w8_2' ?>" <?php if($std_attendance['w8_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w8_3' ?>" <?php if($std_attendance['w8_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w9_1' ?>" <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w9_2' ?>" <?php if($std_attendance['w9_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w9_3' ?>" <?php if($std_attendance['w9_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w10_1' ?>" <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w10_2' ?>" <?php if($std_attendance['w10_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w10_3' ?>" <?php if($std_attendance['w10_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w11_1' ?>" <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w11_2' ?>" <?php if($std_attendance['w11_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w11_3' ?>" <?php if($std_attendance['w11_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w12_1' ?>" <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w12_2' ?>" <?php if($std_attendance['w12_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w12_3' ?>" <?php if($std_attendance['w12_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w13_1' ?>" <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w13_2' ?>" <?php if($std_attendance['w13_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w13_3' ?>" <?php if($std_attendance['w13_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w14_1' ?>" <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w14_2' ?>" <?php if($std_attendance['w14_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w14_3' ?>" <?php if($std_attendance['w14_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w15_1' ?>" <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w15_2' ?>" <?php if($std_attendance['w15_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w15_3' ?>" <?php if($std_attendance['w15_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w16_1' ?>" <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w16_2' ?>" <?php if($std_attendance['w16_2'] > 0){ echo 'checked'; }?>></td>
                                                    <td><input type="checkbox" value="1" disabled name="<?php echo $i . 'w16_3' ?>" <?php if($std_attendance['w16_3'] > 0){ echo 'checked'; }?>></td>
                                                    <td><textarea class="border border-light" disabled style="height: 20px" ><?php echo $std_attendance['note']?></textarea></td>
                                                </tr>
                                            <?php } ?>
                                            <input type="hidden" name="sub_credit" value="<?php echo $credit ?>">
                                        </tbody>
                                    <?php } ?>
                                </table>
                                
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