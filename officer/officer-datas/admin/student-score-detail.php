<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    if (isset($_GET['id'])) {

        $admin_id = $_SESSION['admin_login'];
        include "admin-datas/officer-db.php";
        $user = officerGetUserById($admin_id, $conn);
        $officer = getOfficerById($admin_id, $conn);
        include "admin-datas/group-db.php";
        include "admin-datas/studentgroup-db.php";
        include "admin-datas/student-score-db.php";
        include "admin-datas/student-db.php";
        include "admin-datas/subject-db.php";
        include "admin-datas/score-db.php";

        $id = $_GET['id'];
        $students = getAllStudents($conn);
        $search_by = '';

        $std_group = getGroupByID($id, $conn);

        // Count students
        $count_std = $conn->prepare("SELECT COUNT(*) AS count FROM studentgroups WHERE group_id=:group_id");
        $count_std->bindParam(":group_id", $id);
        $count_std->execute();
        while ($row = $count_std->fetch(PDO::FETCH_ASSOC)) {
            $count_std_resault = $row['count'];
        };

        //Select Subject in Score
        $score_subs = getSubjectDistinct($id, $conn);


        //Select Scores 
        $scores = $conn->prepare("SELECT DISTINCT std_id FROM scores WHERE group_id='$id'");
        $scores->execute();



        if (isset($_REQUEST['search'])) {
            try {
                $search_by = $_REQUEST['search_by'];
                if (!empty($search_by)) {

                    // $students = $conn->prepare("SELECT * FROM students WHERE std_id=:std_id OR program=:program OR season_start=:season_start OR part=:part OR fname_en=:fname_en OR lname_en=:lname_en");
                    // $students->bindParam(':std_id', $search_by);
                    // $students->bindParam(':program', $search_by);
                    // $students->bindParam(':season_start', $search_by);
                    // $students->bindParam(':part', $search_by);
                    // $students->bindParam(':fname_en', $search_by);
                    // $students->bindParam(':lname_en', $search_by);
                    // $students->execute();
                }
            } catch (PDOException $e) {
                $e->getMessage();
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
    <style>
        table td:nth-child(2){
            position: sticky;
            left: 0;
            background-color: white;
            z-index: 1;
        }
        table thead .th1 th:nth-child(2){
            position: sticky;
            left: 0;
            background-color: #f8f9fa;
            z-index: 3;
        }
        .student-thread {
            position: sticky;
            top: 0;
            z-index: 2;
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
                <div class="page-header">
                    <div class="student-group-form" id="print-btn">
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Search here ..."
                                            name="search_by" value="<?php echo $search_by ?>">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="search-student-btn">
                                        <button type="submit" name="search" class="btn btn-primary"><?php echo $lang['search'] ?></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
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
                                        <h3 class="page-title">Entire Student: <?php echo $count_std_resault ?>,
                                            Program: <?php echo $std_group['program'] ?>, Year:
                                            <?php echo $std_group['year'] ?>, Part: <?php echo $std_group['part'] ?>,
                                            Class: <?php echo $std_group['group_id'] ?> </h3>
                                    </div>
                                    <div class="col-6 text-end float-end">
                                        <button onclick="window.print();" class="btn btn-primary ms-5" id="print-btn"><i
                                                class="fas fa-print"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive text-center">
                                <table
                                    class="table table-bordered star-student table-hover table-center mb-0 ">
                                    <thead class="student-thread">
                                        <tr class="th1">
                                            <th rowspan="2">No</th>
                                            <th id="print-btn" rowspan="2" >Student ID</th>
                                            <th rowspan="2">Full Name</th>
                                            <?php foreach ($score_subs as $score_sub) {
                                                $sub = getSubjectById($score_sub['sub_id'], $conn); ?>
                                                <th colspan="3"><?php echo $sub['name'] ?></th>
                                            <?php } ?>
                                            <th rowspan="2">CGPA</th>
                                            <th rowspan="2">Grade</th>
                                            <th rowspan="2">Total</th>
                                        </tr>
                                        <tr class="th2">
                                            <?php foreach ($score_subs as $score_sub) {?>
                                                <th>Point</th>
                                                <th>GPA</th>
                                                <th>Grade</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0;
                                        if ($scores == "No Student!") {  ?>
                                        <tr>
                                            <td>No Student!</td>
                                        </tr>
                                        <?php } else {
                                            foreach ($scores as $score) {
                                                $i++; ?>
                                        <tr>
                                            <td ><?php echo $i ?></td>
                                            <td id="print-btn"><?php echo $score['std_id'] ?></td>
                                            <td>Demo Name</td>
                                            <!-- <td>
                                                <h2 class="table-avatar">
                                                    <?php
                                                            $student = getStudentById($score['std_id'], $conn);
                                                            if ($student['gender'] == 'Male') { ?>
                                                    <a>Mr
                                                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                    <?php } else { ?>
                                                    <a>Miss
                                                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                    <?php }
                                                            ?>
                                                </h2>
                                            </td> -->
                                            <?php 
                                            $cmg = 0;
                                            $total = 0;
                                            $sub_credit = 0;
                                            foreach ($score_subs as $score_sub) {
                                                $total_score = getToltalScoreOfEachSubject($_GET['id'], $score_sub['sub_id'], $score['std_id'], $conn);
                                                $sub = getSubjectById($score_sub['sub_id'], $conn);
                                                if ($total_score < 50) {
                                                    $grade = 'F';
                                                    $gpa = "0.00";
                                                } elseif ($total_score < 55) {
                                                    $grade = 'D';
                                                    $gpa = "1.00";
                                                } elseif ($total_score < 60) {
                                                    $grade = 'D+';
                                                    $gpa = "1.50";
                                                } elseif ($total_score < 65) {
                                                    $grade = 'C';
                                                    $gpa = "2.00";
                                                } elseif ($total_score < 70) {
                                                    $grade = 'C+';
                                                    $gpa = "2.50";
                                                } elseif ($total_score <= 80) {
                                                    $grade = 'B';
                                                    $gpa = "3.00";
                                                } elseif ($total_score <= 90) {
                                                    $grade = 'B+';
                                                    $gpa = " 3.50";
                                                } elseif ($total_score <= 100) {
                                                    $grade = 'A';
                                                    $gpa = "4.00";
                                                } else {
                                                    $grade = 'No Given!';
                                                    $gpa = 'No Given!';
                                                };
                                                $prepare_cmg = $gpa * $sub['credit'];
                                                $cmg = $cmg + $prepare_cmg;
                                                $sub_credit = $sub_credit + $sub['credit'];
                                                $total = $total + $total_score;
                                                ?>

                                                <td><?php echo $total_score ?></td>
                                                <td><?php echo $gpa ?></td>
                                                <td><?php echo $grade ?></td>
                                            <?php } 
                                                $cgpa = $cmg / $sub_credit;
                                                if ($cgpa >= 4) {
                                                    $grade = 'A';
                                                } elseif ($cgpa >= 3.5) {
                                                    $grade = 'B+';
                                                } elseif ($cgpa >= 3) {
                                                    $grade = 'B';
                                                } elseif ($cgpa >= 2.5) {
                                                    $grade = 'C+';
                                                } elseif ($cgpa >= 2) {
                                                    $grade = 'C';
                                                } elseif ($cgpa >= 1.5 ) {
                                                    $grade = 'D+';
                                                } elseif ($cgpa >= 1) {
                                                    $grade = 'D';
                                                } elseif ($cgpa < 1) {
                                                    $grade = 'F';
                                                };
                                            ?>
                                            <td><?php echo round($cgpa, 2) ?></td>
                                            <td><?php echo $grade ?></td>
                                            <td><?php echo $total ?></td>
                                        </tr>
                                        <?php  }
                                        } ?>
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