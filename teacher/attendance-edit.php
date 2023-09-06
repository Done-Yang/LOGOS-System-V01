<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();
ob_start();

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {
    if(isset($_REQUEST['group_id']) and isset($_REQUEST['sub_id'])){
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

        $subject = $conn->prepare("SELECT * FROM subjects WHERE sub_id='$sub_id'");
        $subject->execute();
        $sub = $subject->fetch(PDO::FETCH_ASSOC);
        $credit = $sub['credit'];

        $std_attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester'");
        $std_attendances->execute();

        if(isset($_POST['save'])){
            $sub_credit = $_POST['sub_credit'];
            if($sub_credit == 1){
                try{
                    $addLoop = 1;
                    foreach($std_attendances as $std_attendance){
                        $std_id = $_POST[$addLoop . 'std_id'];
                        $w1_1 = $_POST[$addLoop . 'w1_1'];
                        $w2_1 = $_POST[$addLoop . 'w2_1'];
                        $w3_1 = $_POST[$addLoop . 'w3_1'];
                        $w4_1 = $_POST[$addLoop . 'w4_1'];
                        $w5_1 = $_POST[$addLoop . 'w5_1'];
                        $w6_1 = $_POST[$addLoop . 'w6_1'];
                        $w7_1 = $_POST[$addLoop . 'w7_1'];
                        $w8_1 = $_POST[$addLoop . 'w8_1'];
                        $w9_1 = $_POST[$addLoop . 'w9_1'];
                        $w10_1 = $_POST[$addLoop . 'w10_1'];
                        $w11_1 = $_POST[$addLoop . 'w11_1'];
                        $w12_1 = $_POST[$addLoop . 'w12_1'];
                        $w13_1 = $_POST[$addLoop . 'w13_1'];
                        $w14_1 = $_POST[$addLoop . 'w14_1'];
                        $w15_1 = $_POST[$addLoop . 'w15_1'];
                        $w16_1 = $_POST[$addLoop . 'w16_1'];
                        $note = $_POST[$addLoop . 'note'];

                        $std_att_edit = $conn->prepare("UPDATE attendances SET w1_1='$w1_1', w2_1='$w2_1', w3_1='$w3_1', w4_1='$w4_1', w5_1='$w5_1', w6_1='$w6_1', 
                                                                                w7_1='$w7_1', w8_1='$w8_1', w9_1='$w9_1', w10_1='$w10_1', w11_1='$w11_1', w12_1='$w12_1',
                                                                                w13_1='$w13_1', w14_1='$w14_1', w15_1='$w15_1', w16_1='$w16_1', note='$note'
                                                                            WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester' ");
                        $std_att_edit->execute();
                        $attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester' ");
                        $attendances->execute();

                        foreach($attendances as $attendance){
                            $sum = $attendance['w1_1'] + $attendance['w1_2'] + $attendance['w1_3'] + $attendance['w2_1'] + $attendance['w2_2'] + $attendance['w2_3'] + $attendance['w3_1'] + $attendance['w3_2'] + $attendance['w3_3'] + $attendance['w4_1'] + $attendance['w4_2'] + $attendance['w4_3'] + $attendance['w5_1'] + $attendance['w5_2'] + $attendance['w5_3'] + 
                               $attendance['w6_1'] + $attendance['w6_2'] + $attendance['w6_3'] + $attendance['w7_1'] + $attendance['w7_2'] + $attendance['w7_3'] + $attendance['w8_1'] + $attendance['w8_2'] + $attendance['w8_3'] + $attendance['w9_1'] + $attendance['w9_2'] + $attendance['w9_3'] + $attendance['w10_1'] + $attendance['w10_2'] + $attendance['w10_3'] + 
                               $attendance['w11_1'] + $attendance['w11_2'] + $attendance['w11_3'] + $attendance['w12_1'] + $attendance['w12_2'] + $attendance['w12_3'] + $attendance['w13_1'] + $attendance['w13_2'] + $attendance['w13_3'] + $attendance['w14_1'] + $attendance['w14_2'] + $attendance['w4_3'] + $attendance['w15_1'] + $attendance['w15_2'] + $attendance['w15_3'] + 
                               $attendance['w16_1'] + $attendance['w16_2'] + $attendance['w16_3'] ;
                            $att = 20 - $sum;
                            
                            $add_att_to_score = $conn->prepare("UPDATE scores SET attending='$att' WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id'  and semester='$semester'");
                            $add_att_to_score->execute();
                        }
                        $addLoop++;
                    }
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Update Student Attendance Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    
                    header("refresh:2; url=attendance-detail.php?group_id=$group_id&sub_id=$sub_id&semester=$semester");
                    // header('location: attendance-list.php');
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }elseif($sub_credit == 2){
                try{
                    $addLoop = 1;
                    foreach($std_attendances as $std_attendance){
                        $std_id = $_POST[$addLoop . 'std_id'];
                        $w1_1 = $_POST[$addLoop . 'w1_1'];
                        $w1_2 = $_POST[$addLoop . 'w1_2'];
                        $w2_1 = $_POST[$addLoop . 'w2_1'];
                        $w2_2 = $_POST[$addLoop . 'w2_2'];
                        $w3_1 = $_POST[$addLoop . 'w3_1'];
                        $w3_2 = $_POST[$addLoop . 'w3_2'];
                        $w4_1 = $_POST[$addLoop . 'w4_1'];
                        $w4_2 = $_POST[$addLoop . 'w4_2'];
                        $w5_1 = $_POST[$addLoop . 'w5_1'];
                        $w5_2 = $_POST[$addLoop . 'w5_2'];
                        $w6_1 = $_POST[$addLoop . 'w6_1'];
                        $w6_2 = $_POST[$addLoop . 'w6_2'];
                        $w7_1 = $_POST[$addLoop . 'w7_1'];
                        $w7_2 = $_POST[$addLoop . 'w7_2'];
                        $w8_1 = $_POST[$addLoop . 'w8_1'];
                        $w8_2 = $_POST[$addLoop . 'w8_2'];
                        $w9_1 = $_POST[$addLoop . 'w9_1'];
                        $w9_2 = $_POST[$addLoop . 'w9_2'];
                        $w10_1 = $_POST[$addLoop . 'w10_1'];
                        $w10_2 = $_POST[$addLoop . 'w10_2'];
                        $w11_1 = $_POST[$addLoop . 'w11_1'];
                        $w11_2 = $_POST[$addLoop . 'w11_2'];
                        $w12_1 = $_POST[$addLoop . 'w12_1'];
                        $w12_2 = $_POST[$addLoop . 'w12_2'];
                        $w13_1 = $_POST[$addLoop . 'w13_1'];
                        $w13_2 = $_POST[$addLoop . 'w13_2'];
                        $w14_1 = $_POST[$addLoop . 'w14_1'];
                        $w14_2 = $_POST[$addLoop . 'w14_2'];
                        $w15_1 = $_POST[$addLoop . 'w15_1'];
                        $w15_2 = $_POST[$addLoop . 'w15_2'];
                        $w16_1 = $_POST[$addLoop . 'w16_1'];
                        $w16_2 = $_POST[$addLoop . 'w16_2'];
                        $note = $_POST[$addLoop . 'note'];

                        $std_att_edit = $conn->prepare("UPDATE attendances SET w1_1='$w1_1', w1_2='$w1_2', w2_1='$w2_1', w2_2='$w2_2', w3_1='$w3_1', w3_2='$w3_2', w4_1='$w4_1', w4_2='$w4_2',
                                                                            w5_1='$w5_1', w5_2='$w5_2', w6_1='$w6_1', w6_2='$w6_2', w7_1='$w7_1', w7_2='$w7_2', w8_1='$w8_1', w8_2='$w8_2',
                                                                            w9_1='$w9_1', w9_2='$w9_2', w10_1='$w10_1', w10_2='$w10_2', w11_1='$w11_1', w11_2='$w11_2', w12_1='$w12_1', w12_2='$w12_2',
                                                                            w13_1='$w13_1', w13_2='$w13_2', w14_1='$w14_1', w14_2='$w14_2', w15_1='$w15_1', w15_2='$w15_2', w16_1='$w16_1', w16_2='$w16_2', note='$note'
                                                                            WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester' ");
                        $std_att_edit->execute();
                        $attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester'");
                        $attendances->execute();

                        foreach($attendances as $attendance){
                            $sum = $attendance['w1_1'] + $attendance['w1_2'] + $attendance['w1_3'] + $attendance['w2_1'] + $attendance['w2_2'] + $attendance['w2_3'] + $attendance['w3_1'] + $attendance['w3_2'] + $attendance['w3_3'] + $attendance['w4_1'] + $attendance['w4_2'] + $attendance['w4_3'] + $attendance['w5_1'] + $attendance['w5_2'] + $attendance['w5_3'] + 
                               $attendance['w6_1'] + $attendance['w6_2'] + $attendance['w6_3'] + $attendance['w7_1'] + $attendance['w7_2'] + $attendance['w7_3'] + $attendance['w8_1'] + $attendance['w8_2'] + $attendance['w8_3'] + $attendance['w9_1'] + $attendance['w9_2'] + $attendance['w9_3'] + $attendance['w10_1'] + $attendance['w10_2'] + $attendance['w10_3'] + 
                               $attendance['w11_1'] + $attendance['w11_2'] + $attendance['w11_3'] + $attendance['w12_1'] + $attendance['w12_2'] + $attendance['w12_3'] + $attendance['w13_1'] + $attendance['w13_2'] + $attendance['w13_3'] + $attendance['w14_1'] + $attendance['w14_2'] + $attendance['w4_3'] + $attendance['w15_1'] + $attendance['w15_2'] + $attendance['w15_3'] + 
                               $attendance['w16_1'] + $attendance['w16_2'] + $attendance['w16_3'] ;

                            $att = 20 - $sum;
                            
                            $add_att_to_score = $conn->prepare("UPDATE scores SET attending='$att' WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester'");
                            $add_att_to_score->execute();
                        }
                        $addLoop++;
                    }
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Update Student Attendance Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    
                    header("refresh:2; url=attendance-detail.php?group_id=$group_id&sub_id=$sub_id&semester=$semester");
                    // header('location: attendance-list.php');
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }elseif($sub_credit == 3){
                try{
                    $addLoop = 1;
                    foreach($std_attendances as $std_attendance){
                        $std_id = $_POST[$addLoop . 'std_id'];
                        $w1_1 = $_POST[$addLoop . 'w1_1'];
                        $w1_2 = $_POST[$addLoop . 'w1_2'];
                        $w1_3 = $_POST[$addLoop . 'w1_3'];
                        $w2_1 = $_POST[$addLoop . 'w2_1'];
                        $w2_2 = $_POST[$addLoop . 'w2_2'];
                        $w2_3 = $_POST[$addLoop . 'w2_3'];
                        $w3_1 = $_POST[$addLoop . 'w3_1'];
                        $w3_2 = $_POST[$addLoop . 'w3_2'];
                        $w3_3 = $_POST[$addLoop . 'w3_3'];
                        $w4_1 = $_POST[$addLoop . 'w4_1'];
                        $w4_2 = $_POST[$addLoop . 'w4_2'];
                        $w4_3 = $_POST[$addLoop . 'w4_3'];
                        $w5_1 = $_POST[$addLoop . 'w5_1'];
                        $w5_2 = $_POST[$addLoop . 'w5_2'];
                        $w5_3 = $_POST[$addLoop . 'w5_3'];
                        $w6_1 = $_POST[$addLoop . 'w6_1'];
                        $w6_2 = $_POST[$addLoop . 'w6_2'];
                        $w6_3 = $_POST[$addLoop . 'w6_3'];
                        $w7_1 = $_POST[$addLoop . 'w7_1'];
                        $w7_2 = $_POST[$addLoop . 'w7_2'];
                        $w7_3 = $_POST[$addLoop . 'w7_3'];
                        $w8_1 = $_POST[$addLoop . 'w8_1'];
                        $w8_2 = $_POST[$addLoop . 'w8_2'];
                        $w8_3 = $_POST[$addLoop . 'w8_3'];
                        $w9_1 = $_POST[$addLoop . 'w9_1'];
                        $w9_2 = $_POST[$addLoop . 'w9_2'];
                        $w9_3 = $_POST[$addLoop . 'w9_3'];
                        $w10_1 = $_POST[$addLoop . 'w10_1'];
                        $w10_2 = $_POST[$addLoop . 'w10_2'];
                        $w10_3 = $_POST[$addLoop . 'w10_3'];
                        $w11_1 = $_POST[$addLoop . 'w11_1'];
                        $w11_2 = $_POST[$addLoop . 'w11_2'];
                        $w11_3 = $_POST[$addLoop . 'w11_3'];
                        $w12_1 = $_POST[$addLoop . 'w12_1'];
                        $w12_2 = $_POST[$addLoop . 'w12_2'];
                        $w12_3 = $_POST[$addLoop . 'w12_3'];
                        $w13_1 = $_POST[$addLoop . 'w13_1'];
                        $w13_2 = $_POST[$addLoop . 'w13_2'];
                        $w13_3 = $_POST[$addLoop . 'w13_3'];
                        $w14_1 = $_POST[$addLoop . 'w14_1'];
                        $w14_2 = $_POST[$addLoop . 'w14_2'];
                        $w14_3 = $_POST[$addLoop . 'w14_3'];
                        $w15_1 = $_POST[$addLoop . 'w15_1'];
                        $w15_2 = $_POST[$addLoop . 'w15_2'];
                        $w15_3 = $_POST[$addLoop . 'w15_3'];
                        $w16_1 = $_POST[$addLoop . 'w16_1'];
                        $w16_2 = $_POST[$addLoop . 'w16_2'];
                        $w16_3 = $_POST[$addLoop . 'w16_3'];
                        $note = $_POST[$addLoop . 'note'];

                        $std_att_edit = $conn->prepare("UPDATE attendances SET w1_1='$w1_1', w1_2='$w1_2', w1_3='$w1_3', w2_1='$w2_1', w2_2='$w2_2', w2_3='$w2_3', w3_1='$w3_1', w3_2='$w3_2', w3_3='$w3_3', w4_1='$w4_1', w4_2='$w4_2', w4_3='$w4_3',
                                                                            w5_1='$w5_1', w5_2='$w5_2', w5_3='$w5_3', w6_1='$w6_1', w6_2='$w6_2', w6_3='$w6_3', w7_1='$w7_1', w7_2='$w7_2', w7_3='$w7_3', w8_1='$w8_1', w8_2='$w8_2', w8_3='$w8_3',
                                                                            w9_1='$w9_1', w9_2='$w9_2', w9_3='$w9_3', w10_1='$w10_1', w10_2='$w10_2', w10_3='$w10_3', w11_1='$w11_1', w11_2='$w11_2', w11_3='$w11_3', w12_1='$w12_1', w12_2='$w12_2', w12_3='$w12_3',
                                                                            w13_1='$w13_1', w13_2='$w13_2', w13_3='$w13_3', w14_1='$w14_1', w14_2='$w14_2', w14_3='$w14_3', w15_1='$w15_1', w15_2='$w15_2', w15_3='$w15_3', w16_1='$w16_1', w16_2='$w16_2', w16_3='$w16_3', note='$note'
                                                                            WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester' ");
                        $std_att_edit->execute();

                        $attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester'");
                        $attendances->execute();

                        foreach($attendances as $attendance){
                            $sum = $attendance['w1_1'] + $attendance['w1_2'] + $attendance['w1_3'] + $attendance['w2_1'] + $attendance['w2_2'] + $attendance['w2_3'] + $attendance['w3_1'] + $attendance['w3_2'] + $attendance['w3_3'] + $attendance['w4_1'] + $attendance['w4_2'] + $attendance['w4_3'] + $attendance['w5_1'] + $attendance['w5_2'] + $attendance['w5_3'] + 
                               $attendance['w6_1'] + $attendance['w6_2'] + $attendance['w6_3'] + $attendance['w7_1'] + $attendance['w7_2'] + $attendance['w7_3'] + $attendance['w8_1'] + $attendance['w8_2'] + $attendance['w8_3'] + $attendance['w9_1'] + $attendance['w9_2'] + $attendance['w9_3'] + $attendance['w10_1'] + $attendance['w10_2'] + $attendance['w10_3'] + 
                               $attendance['w11_1'] + $attendance['w11_2'] + $attendance['w11_3'] + $attendance['w12_1'] + $attendance['w12_2'] + $attendance['w12_3'] + $attendance['w13_1'] + $attendance['w13_2'] + $attendance['w13_3'] + $attendance['w14_1'] + $attendance['w14_2'] + $attendance['w4_3'] + $attendance['w15_1'] + $attendance['w15_2'] + $attendance['w15_3'] + 
                               $attendance['w16_1'] + $attendance['w16_2'] + $attendance['w16_3'] ;
                            $att = 20 - $sum;
                            
                            $add_att_to_score = $conn->prepare("UPDATE scores SET attending='$att' WHERE group_id='$group_id' and sub_id='$sub_id' and std_id='$std_id' and semester='$semester'");
                            $add_att_to_score->execute();
                        }
                        $addLoop++;
                    }
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Update Student Attendance Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=attendance-detail.php?group_id=$group_id&sub_id=$sub_id&semester=$semester");
                    // header('location: attendance-list.php');
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }

            

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

    <link rel="stylesheet" href="../assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/validate-form.css">
    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
    <style>
        table tbody td:nth-child(3){
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
        .table-responsive {
            max-height: 35em;
            overflow-y: scroll;
        }
        .table {
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
                        <form method="post">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6 ">
                                        <h5 class="page-title">All Student in Group:
                                            <?php
                                                echo $group_id . ', Subject: ' . $sub['name'].', Program: '.$group['program'].', Year: '.$group['year'].', Semester: '.$semester.', Season: '.$group['season'];
                                            ?>
                                        </h5>
                                    </div>
                                    <div class="col-6 text-end float-end">
                                        <!-- <button onclick="window.print();" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-print"></i></button> -->
                                        <!-- <a href="attendance-detail.php?group_id=<?= $_GET['group_id'] ?>&sub_id=<?= $_GET['sub_id'] ?>" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-eye"></i></a> -->
                                        <button type="submit" name="save" class="btn btn-success ms-5"> Save </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <?php 
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
                                                    $student = getStudentById($std_attendance['std_id'], $conn)?>
                                                    
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <input type="hidden" name='<?php echo $i . 'std_id'?>' value="<?php echo $std_attendance['std_id'] ?>">
                                                        <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w1_1' ?>" <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w2_1' ?>" <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w3_1' ?>" <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w4_1' ?>" <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w5_1' ?>" <?php if($std_attendance['w5_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w6_1' ?>" <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w7_1' ?>" <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w8_1' ?>" <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w9_1' ?>" <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w10_1' ?>" <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w11_1' ?>" <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w12_1' ?>" <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w13_1' ?>" <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w14_1' ?>" <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w15_1' ?>" <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="5" name="<?php echo $i . 'w16_1' ?>" <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><textarea class="border border-light" style="height: 20px" name="<?php echo $i . 'note' ?>"><?php echo $std_attendance['note']?></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                                <input type="hidden" name="sub_credit" value="<?php echo $credit ?>">
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
                                                    $student = getStudentById($std_attendance['std_id'], $conn)?>
                                                    
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <input type="hidden" name='<?php echo $i . 'std_id'?>' value="<?php echo $std_attendance['std_id'] ?>">
                                                        <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w1_1' ?>" <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w1_2' ?>" <?php if($std_attendance['w1_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w2_1' ?>" <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w2_2' ?>" <?php if($std_attendance['w2_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w3_1' ?>" <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w3_2' ?>" <?php if($std_attendance['w3_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w4_1' ?>" <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w4_2' ?>" <?php if($std_attendance['w4_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w5_1' ?>" <?php if($std_attendance['w5_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w5_2' ?>" <?php if($std_attendance['w5_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w6_1' ?>" <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w6_2' ?>" <?php if($std_attendance['w6_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w7_1' ?>" <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w7_2' ?>" <?php if($std_attendance['w7_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w8_1' ?>" <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w8_2' ?>" <?php if($std_attendance['w8_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w9_1' ?>" <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w9_2' ?>" <?php if($std_attendance['w9_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w10_1' ?>" <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w10_2' ?>" <?php if($std_attendance['w10_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w11_1' ?>" <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w11_2' ?>" <?php if($std_attendance['w11_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w12_1' ?>" <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w12_2' ?>" <?php if($std_attendance['w12_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w13_1' ?>" <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w13_2' ?>" <?php if($std_attendance['w13_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w14_1' ?>" <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w14_2' ?>" <?php if($std_attendance['w14_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w15_1' ?>" <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w15_2' ?>" <?php if($std_attendance['w15_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w16_1' ?>" <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="2.5" name="<?php echo $i . 'w16_2' ?>" <?php if($std_attendance['w16_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><textarea class="border border-light" style="height: 20px" name="<?php echo $i . 'note' ?>"><?php echo $std_attendance['note']?></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                                <input type="hidden" name="sub_credit" value="<?php echo $credit ?>">
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
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w1_1' ?>" <?php if($std_attendance['w1_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w1_2' ?>" <?php if($std_attendance['w1_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w1_3' ?>" <?php if($std_attendance['w1_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w2_1' ?>" <?php if($std_attendance['w2_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w2_2' ?>" <?php if($std_attendance['w2_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w2_3' ?>" <?php if($std_attendance['w2_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w3_1' ?>" <?php if($std_attendance['w3_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w3_2' ?>" <?php if($std_attendance['w3_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w3_3' ?>" <?php if($std_attendance['w3_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w4_1' ?>" <?php if($std_attendance['w4_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w4_2' ?>" <?php if($std_attendance['w4_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w4_3' ?>" <?php if($std_attendance['w4_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w5_1' ?>" <?php if($std_attendance['w5_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w5_2' ?>" <?php if($std_attendance['w5_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w5_3' ?>" <?php if($std_attendance['w5_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w6_1' ?>" <?php if($std_attendance['w6_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w6_2' ?>" <?php if($std_attendance['w6_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w6_3' ?>" <?php if($std_attendance['w6_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w7_1' ?>" <?php if($std_attendance['w7_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w7_2' ?>" <?php if($std_attendance['w7_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w7_3' ?>" <?php if($std_attendance['w7_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w8_1' ?>" <?php if($std_attendance['w8_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w8_2' ?>" <?php if($std_attendance['w8_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w8_3' ?>" <?php if($std_attendance['w8_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w9_1' ?>" <?php if($std_attendance['w9_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w9_2' ?>" <?php if($std_attendance['w9_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w9_3' ?>" <?php if($std_attendance['w9_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w10_1' ?>" <?php if($std_attendance['w10_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w10_2' ?>" <?php if($std_attendance['w10_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w10_3' ?>" <?php if($std_attendance['w10_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w11_1' ?>" <?php if($std_attendance['w11_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w11_2' ?>" <?php if($std_attendance['w11_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w11_3' ?>" <?php if($std_attendance['w11_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w12_1' ?>" <?php if($std_attendance['w12_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w12_2' ?>" <?php if($std_attendance['w12_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w12_3' ?>" <?php if($std_attendance['w12_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w13_1' ?>" <?php if($std_attendance['w13_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w13_2' ?>" <?php if($std_attendance['w13_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w13_3' ?>" <?php if($std_attendance['w13_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w14_1' ?>" <?php if($std_attendance['w14_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w14_2' ?>" <?php if($std_attendance['w14_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w14_3' ?>" <?php if($std_attendance['w14_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w15_1' ?>" <?php if($std_attendance['w15_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w15_2' ?>" <?php if($std_attendance['w15_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w15_3' ?>" <?php if($std_attendance['w15_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w16_1' ?>" <?php if($std_attendance['w16_1'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w16_2' ?>" <?php if($std_attendance['w16_2'] > 0){ echo 'checked'; }?>></td>
                                                        <td><input type="checkbox" value="1.7" name="<?php echo $i . 'w16_3' ?>" <?php if($std_attendance['w16_3'] > 0){ echo 'checked'; }?>></td>
                                                        <td><textarea class="border border-light" style="height: 20px" name="<?php echo $i . 'note' ?>"><?php echo $std_attendance['note']?></textarea></td>
                                                    </tr>
                                                <?php } ?>
                                                <input type="hidden" name="sub_credit" value="<?php echo $credit ?>">
                                            </tbody>
                                        <?php } ?>
                                    </table>
                                    
                                </div>
                            </div>
                        </form>
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