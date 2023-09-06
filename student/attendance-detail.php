<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['student_login'])) {
    header('location: ../index.php');
} else {
    if(isset($_GET['group_id']) and isset($_GET['semester']) and isset($_GET['std_id'])){
        include "student-datas/subject-db.php";
        include "student-datas/student-db.php";
        include "student-datas/group-db.php";

        // for header and sidebar info
        $group_id = $_GET['group_id'];
        $semester = $_GET['semester'];
        $group = getGroupByID($group_id, $conn);
        $std_id = $_GET['std_id'];
        $id = $_SESSION['student_login'];
        $student = getStudentById($id, $conn);
        $user = studentGetUserById($id, $conn);

        $attendances = $conn->prepare("SELECT * FROM attendances WHERE group_id='$group_id' and semester='$semester' and std_id='$std_id'  " );
        $attendances->execute();
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

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
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
                <div class="page-header">
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
                                    <div class="col-6">
                                        <h3 class="page-title">Attendances in Group: <?php echo $group_id ?>, Program: <?php echo $group['program']?>, Year: <?php echo $group['year'] ?>, Season: <?php echo $group['season'] ?>, Semaster: <?php echo $semester ?>,</h3>
                                    </div>
                                    <div class="col-6 text-end float-end">
                                        <button onclick="window.print();" class="btn btn-primary ms-5" id="print-btn"><i
                                                class="fas fa-print"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table
                                    class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Absent</th>
                                            <th>Note</th>
                                            <th>Absent Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i = 0;
                                        foreach($attendances as $attendance){
                                            $i++;
                                            $sub = getSubjectById($attendance['sub_id'], $conn);
                                            $sum_atted = $attendance['w1_1'] + $attendance['w1_2'] + $attendance['w1_3'] + $attendance['w2_1'] + $attendance['w2_2'] + $attendance['w2_3'] + $attendance['w3_1'] + $attendance['w3_2'] + $attendance['w3_3'] + $attendance['w4_1'] + $attendance['w4_2'] + $attendance['w4_3'] + $attendance['w5_1'] + $attendance['w5_2'] + $attendance['w5_3'] + 
                                                         $attendance['w6_1'] + $attendance['w6_2'] + $attendance['w6_3'] + $attendance['w7_1'] + $attendance['w7_2'] + $attendance['w7_3'] + $attendance['w8_1'] + $attendance['w8_2'] + $attendance['w8_3'] + $attendance['w9_1'] + $attendance['w9_2'] + $attendance['w9_3'] + $attendance['w10_1'] + $attendance['w10_2'] + $attendance['w10_3'] +
                                                         $attendance['w11_1'] + $attendance['w11_2'] + $attendance['w11_3'] + $attendance['w12_1'] + $attendance['w12_2'] + $attendance['w12_3'] + $attendance['w13_1'] + $attendance['w13_2'] + $attendance['w13_3'] + $attendance['w14_1'] + $attendance['w14_2'] + $attendance['w14_3'] + $attendance['w15_1'] + $attendance['w15_2'] + $attendance['w15_3'] + $attendance['w16_1'] + $attendance['w16_2'] + $attendance['w16_3'];
                                            $absent = 0;
                                            if($sub['credit'] == 1){
                                                if($sum_atted == 5){
                                                    $absent = 1;
                                                }elseif($sum_atted == 10){
                                                    $absent = 2;
                                                }elseif($sum_atted == 15){
                                                    $absent = '<span class="text-warning">3</span>';
                                                }elseif($sum_atted >= 20){
                                                    $absent = '<span class="color-danger">4 Unable Exam!</span>';
                                                }else{
                                                    $absent = 0;
                                                }
                                            }elseif($sub['credit'] == 2){
                                                if($sum_atted == 2.5){
                                                    $absent = 1;
                                                }elseif($sum_atted == 5){
                                                    $absent = 2;
                                                }elseif($sum_atted == 7.5){
                                                    $absent = 3;
                                                }elseif($sum_atted == 10){
                                                    $absent = 4;
                                                }elseif($sum_atted == 12.5){
                                                    $absent = 5;
                                                }elseif($sum_atted == 15){
                                                    $absent = '<span class="text-warning">6</span>';
                                                }elseif($sum_atted == 17.5){
                                                    $absent = '<span class="text-warning">7</span>';
                                                }elseif($sum_atted >= 20){
                                                    $absent = '<span class="text-danger">8 \'Unable Exam!\'</span>';
                                                }else{
                                                    $absent = 0;
                                                }
                                            }elseif($sub['credit'] == 3){
                                                if($sum_atted == 1.7){
                                                    $absent = 1;
                                                }elseif($sum_atted == 3.4){
                                                    $absent = 2;
                                                }elseif($sum_atted == 5.1){
                                                    $absent = 3;
                                                }elseif($sum_atted == 6.8){
                                                    $absent = 4;
                                                }elseif($sum_atted == 8.5){
                                                    $absent = 5;
                                                }elseif($sum_atted == 10.2){
                                                    $absent = 6;
                                                }elseif($sum_atted == 11.9){
                                                    $absent = 7;
                                                }elseif($sum_atted == 13.6){
                                                    $absent = 8;
                                                }elseif($sum_atted == 15.3){
                                                    $absent = 9;
                                                }elseif($sum_atted == 17){
                                                    $absent = '<span class="text-warning">10</span>';
                                                }elseif($sum_atted == 18.7){
                                                    $absent = '<span class="text-warning">11</span>';
                                                }elseif($sum_atted >= 20){
                                                    $absent = '<span class="color-danger">12 \'Unable Exam!\'</span>';
                                                }else{
                                                    $absent = 0;
                                                }
                                            }?>
                                            
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $sub['name'] ?></td>
                                                <td><?php echo $absent ?></td>
                                                <td><textarea disabled><?php echo $attendance['note'] ?></textarea></td>
                                                <?php if($sub['credit'] == 1){?>
                                                    <td>4</td>
                                                <?php }elseif($sub['credit'] == 2){?>
                                                    <td>8</td>
                                                <?php }elseif($sub['credit'] == 3){?>
                                                    <td>12</td>
                                                <?php }?>
                                            <tr>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
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