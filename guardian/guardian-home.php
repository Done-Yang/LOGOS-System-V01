<?php
require_once 'include/config/dbcon.php';
session_start();

include "guardian-datas/season-db.php";
include "guardian-datas/classroom-db.php";
include "guardian-datas/subject-db.php";
include "guardian-datas/timetable-db.php";
include "guardian-datas/teacher-db.php";

$seasons = getAllSeasons($conn);
$subjects = getAllSubjects($conn);
$classrooms = getAllclassrooms($conn);
// $timetables = getTimetables($conn);


if (!isset($_SESSION['guardian_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['guardian_login'];

    include "guardian-datas/guardian-db.php";
    include "guardian-datas/student-db.php";
    // $guardian = getGuardianById($id, $conn);
    $user = guardianGetUserById($id, $conn);

    $gd = $_SESSION['guardian_login'];
    $std = $conn->query("SELECT * FROM students WHERE guardian_tel='$gd'");
    $guardian_std = $std->fetch(PDO::FETCH_ASSOC);
    $gd_std = $guardian_std['std_id'];

    $student = getStudentById($gd_std, $conn);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logos Institute of Foreign Language</title>

    <link rel="shortcut icon" href="../assets/img/logo_logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/feather/feather.css">
    <link rel="stylesheet" href="../assets/plugins/icons/flags/flags.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">

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
                                <h3 class="page-title">Hello Guadian! Your Child Name Is: <?php echo $student['fname_en'].' '.$student['lname_en'] ?></h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="guardian-home.php">Home</a></li>
                                    <li class="breadcrumb-item active">Guardian</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <h2>You will have a home view soon!</h2>
                </div>


                <!-- <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>All Subject</h6>
                                        <h3>0</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/subject.png" alt="Dashboard Icon" width=50>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>All Projects</h6>
                                        <h3>0</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/project.png" alt="Dashboard Icon" width=50>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Test Attended</h6>
                                        <h3>0</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/test-attanded.png" alt="Dashboard Icon" width=50>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Test Passed</h6>
                                        <h3>0</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/test-passed.png" alt="Dashboard Icon" width=50>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-12 col-xl-8 d-flex">
                        <div class="card flex-fill comman-shadow">
                            <div class="card-header">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <h5 class="card-title">Time Table</h5>
                                    </div>
                                    <div class="col-6">
                                        <ul class="chart-list-out">
                                            <li class="star-menus"><a href="javascript:;"><i class="fas fa-ellipsis-v"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="dash-circle">
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Days</th>
                                                    <th>Times</th>
                                                    <th>Subjects And Teachers</th>
                                                    <th>Classroom</th>
                                                </tr>
                                            </thead>

                                            <?php
                                            $season = $student['season_start'];
                                            $times = $student['part'];
                                            try {
                                                foreach ($timetables as $timetable) {
                                                    if ($timetable['season'] == $season && !empty($times)) {
                                                        $subject1 = getSubjectById($timetable['subject1_id'], $conn);
                                                        $subject2 = getSubjectById($timetable['subject2_id'], $conn);
                                                        $teacher1 = getTeacherById($subject1['teacher_id'], $conn);
                                                        $teacher2 = getTeacherById($subject2['teacher_id'], $conn);
                                            ?>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php echo $timetable['days'] ?></td>

                                                                <?php
                                                                if ($times == 'Morning') { ?>
                                                                    <td>
                                                                        08:00-09:30 <br>
                                                                        10:00-11:30
                                                                    </td>
                                                                <?php } else if ($times == 'Afternoon') { ?>
                                                                    <td>
                                                                        13:00-14:30 <br>
                                                                        15:00-16:30
                                                                    </td>
                                                                <?php } else { ?>
                                                                    <td>
                                                                        17:30-16:45 <br>
                                                                        19:00-20:30
                                                                    </td>
                                                                <?php } ?>


                                                                <td>
                                                                    <?php echo $subject1['name'] . ' (Prof: ' . $teacher1['fname_en'] . ' ' . $teacher1['lname_en'] . ')' ?> <br>
                                                                    <?php echo $subject2['name'] . ' (Prof: ' . $teacher2['fname_en'] . ' ' . $teacher2['lname_en'] . ')' ?>
                                                                </td>
                                                                <td><?php echo $timetable['classroom'] ?></td>

                                                            </tr>
                                                        </tbody>
                                            <?php }
                                                }
                                            } catch (PDOException $e) {
                                                $e->getMessage();
                                            }  ?>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-12 col-xl-4 d-flex">
                        <div class="card flex-fill comman-shadow">
                            <div class="card-body">
                                <div id="calendar-doctor" class="calendar-container"></div>
                                <div class="calendar-info calendar-info1">
                                    <div class="up-come-header">
                                        <h2>News</h2>
                                    </div>
                                    <div class="upcome-event-date">
                                        <h3>10 Jan</h3>
                                        <span><i class="fas fa-ellipsis-h"></i></span>
                                    </div>
                                    <div class="calendar-details">
                                        <p>08:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>Botony</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>08:00 - 09:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>09:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>Botony</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>09:00 - 10:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>10:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>Botony</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>10:00 - 11:00 am</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>

           

        </div>

    </div> 
    <footer>
        <p>Copyright © Logos Institute of Foreign Language.</p>
    </footer>

    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/feather.min.js"></script>
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="../assets/plugins/apexchart/chart-data.js"></script>
    <script src="../assets/js/script.js"></script>


</body>

</html>