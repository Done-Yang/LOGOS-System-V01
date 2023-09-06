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

    $std_scores = $conn->prepare("SELECT * FROM scores WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester'");
    $std_scores->execute();
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
                                    <li class="breadcrumb-item"><a href="score-list.php">Score</a></li>
                                    <li class="breadcrumb-item active">Student Scores</li>
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
                                    <h5 class="page-title">Score of Student in Group:
                                        <?php
                                        $subject = $conn->prepare("SELECT * FROM subjects WHERE sub_id='$sub_id'");
                                        $subject->execute();
                                        
                                        $sub = $subject->fetch(PDO::FETCH_ASSOC);
                                        echo $group_id . ', Subject: ' . $sub['name'].', Semester: '.$semester;
                                        ?>
                                    </h5>
                                </div>
                                <div class="col-6 text-end float-end">
                                    <button onclick="window.print();" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-print"></i></button>
                                    <a href="score-edit.php?group_id=<?= $_GET['group_id'] ?>&sub_id=<?= $_GET['sub_id'] ?>&semester=<?= $_GET['semester'] ?>" class="btn btn-primary ms-5" id="print-btn"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>BH</th>
                                            <th>HW</th>
                                            <th>ATT</th>
                                            <th>Mid</th>
                                            <th>Fin</th>
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
                                            $student = getStudentById($std_score['std_id'], $conn);
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
                                                $meaning = 'Fairly Good';
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
                                                <td><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></td>
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