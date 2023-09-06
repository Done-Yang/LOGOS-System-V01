<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['student_login'])) {
    header('location: ../index.php');
    exit;
} else {
    if(isset($_GET['group_id'])){
        //for header and side bar detail
        include "student-datas/subject-db.php";
        include "student-datas/student-db.php";
        $std_id = $_SESSION['student_login'];
        $student = getStudentById($std_id, $conn);
        $user = studentGetUserById($std_id, $conn);

        $group_id = $_GET['group_id'];
        $semester = $_GET['semester'];


        $std_scores = $conn->prepare("SELECT * FROM scores WHERE group_id='$group_id' and std_id='$std_id' and semester='$semester'");
        $std_scores->execute();

        $groups = $conn->prepare("SELECT * FROM groups WHERE group_id='$group_id' LIMIT 1");
        $groups->execute();
        $group = $groups->fetch(PDO::FETCH_ASSOC);
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
                                <h3 class="page-title">Student Scores</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="score-list.php">Scores</a></li>
                                    <li class="breadcrumb-item active">Scores Detail</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                            <h5>Score in group: <?php echo $group_id ?>,  Year: <?php echo $group['year'] ?>, Semester: <?php echo $semester?>, Season: <?php echo $group['season'] ?></h5>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Subject</th>
                                            <th>Behavire</th>
                                            <th>Homework</th>
                                            <th>Attending</th>
                                            <th>MidTerm EX</th>
                                            <th>Final EX</th>
                                            <th>Total</th>
                                            <th>Grade</th>
                                            <th>GPA</th>
                                            <th id="print-btn">Meaning</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($std_scores as $std_score) {
                                            $i++;
                                            $subject = getSubjectById($std_score['sub_id'], $conn);
                                            $sum_score = $std_score['attending'] + $std_score['behavire'] + $std_score['activities'] + $std_score['midterm_ex'] + $std_score['final_ex'];
                                            if ($sum_score < 50) {
                                                $grade = 'F';
                                                $gpa = "0.00";
                                                $meaning = 'Fail';
                                            } elseif ($sum_score < 55) {
                                                $grade = 'D';
                                                $gpa = "1.00";
                                                $meaning = 'Very Poor';
                                            } elseif ($sum_score < 60) {
                                                $grade = 'D+';
                                                $gpa = "1.50";
                                                $meaning = 'Poor';
                                            } elseif ($sum_score < 65) {
                                                $grade = 'C';
                                                $gpa = "2.00";
                                                $meaning = 'Fair';
                                            } elseif ($sum_score < 70) {
                                                $grade = 'C+';
                                                $gpa = "2.50";
                                                $meaning = 'Fail Good';
                                            } elseif ($sum_score <= 80) {
                                                $grade = 'B';
                                                $gpa = "3.00";
                                                $meaning = 'Good';
                                            } elseif ($sum_score <= 90) {
                                                $grade = 'B+';
                                                $gpa = " 3.50";
                                                $meaning = 'Very Good';
                                            } elseif ($sum_score <= 100) {
                                                $grade = 'A';
                                                $gpa = "4.00";
                                                $meaning = 'Excellent';
                                            } else {
                                                $grade = 'No Given!';
                                                $gpa = 'No Given!';
                                                $meaning = 'No Given!';
                                            } ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $subject['name'] ?></td>
                                                <td><?php echo $std_score['behavire'] ?></td>
                                                <td><?php echo $std_score['activities'] ?></td>
                                                <td><?php echo $std_score['attending'] ?></td>
                                                <td><?php echo $std_score['midterm_ex'] ?></td>
                                                <td><?php echo $std_score['final_ex'] ?></td>
                                                <td><?php echo $sum_score ?></td>
                                                <td><?php echo $grade ?></td>
                                                <td><?php echo $gpa ?></td>
                                                <td id="print-btn"><?php echo $meaning ?></td>

                                            </tr>
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