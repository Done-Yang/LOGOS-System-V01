<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['teacher_login'];

    // $db = new PDO('mysql:host=localhost;dbname=iater01', 'root', '');

    include "teacher-datas/subject-db.php";
    include "teacher-datas/teacher-db.php";
    include "teacher-datas/student-db.php";

    $teacher = getTeacherById($id, $conn);
    $user = teacherGetUserById($id, $conn);

    // to count the teacher subject
    $sql = "SELECT teachers.t_id, COUNT(DISTINCT subjects.sub_id) num_subjects
            FROM teachers
            JOIN timetables ON teachers.t_id = timetables.teacher1_id OR teachers.t_id = timetables.teacher2_id
            JOIN subjects ON timetables.sub1_id = subjects.sub_id OR timetables.sub2_id = subjects.sub_id
            WHERE teachers.u_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //student star
    $start_students = $conn->prepare("SELECT * FROM star_students ORDER BY id DESC, total_score DESC");
    $start_students->execute();
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
    <link rel="stylesheet" href="../assets/plugins/simple-calendar/simple-calendar.css">
    <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">
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
                                <h3 class="page-title">Welcome Teacher!</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="teacher-home.php">Home</a></li>
                                    <li class="breadcrumb-item active">Teacher</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>All Subjects</h6>
                                        <h3><?php foreach ($results as $row) { echo $row['num_subjects'];} ?></h3>
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
                                        <h6>All Homework</h6>
                                        <h3>40</h3>
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
                                        <h3>30/50</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/test-attended.png" alt="Dashboard Icon" width=50>
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
                                        <h3>15/20</h3>
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
                    <div class="col-12 col-lg-12 col-xl-8">

                        <div class="card flex-fill student-space comman-shadow">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="card-title">Star Students</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table star-student table-hover table-center table-borderless datatable table-striped">
                                        <thead class="thead-light student-thread">
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th class="text-center">Grade</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-end">Season Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($start_students as $st_std){?>
                                                <tr>
                                                    <td class="text-nowrap">
                                                        <div><?php echo $st_std['std_id']?></div>
                                                    </td>
                                                    <td class="text-nowrap">
                                                        <a href="profile.html">
                                                            <img class="rounded-circle"
                                                                src="../admin/upload/profile.png" width="25"
                                                                alt="Star Students"> 
                                                                <?php
                                                            $std_name = getStudentById($st_std['std_id'], $conn);
                                                            echo $std_name['fname_en'].' '.$std_name['lname_en'] ?>
                                                        </a>
                                                    </td>
                                                    <td class="text-center"><?php echo $st_std['grade'] ?></td>
                                                    <td class="text-center"><?php echo $st_std['total_score'] ?></td>
                                                    <td class="text-end">
                                                        <div><?php echo $st_std['season'] ?></div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
                                        <h2>Upcoming Events</h2>
                                        <span><a href="javascript:;"><i class="feather-plus"></i></a></span>
                                    </div>
                                    <!-- <div class="upcome-event-date">
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
                                    <div class="upcome-event-date">
                                        <h3>10 Jan</h3>
                                        <span><i class="fas fa-ellipsis-h"></i></span>
                                    </div>
                                    <div class="calendar-details">
                                        <p>08:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>English</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>08:00 - 09:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>09:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>Mathematics </h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>09:00 - 10:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>10:00 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>History</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>10:00 - 11:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>11:00 am</p>
                                        <div class="calendar-box break-bg">
                                            <div class="calandar-event-name">
                                                <h4>Break</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>11:00 - 12:00 am</span>
                                        </div>
                                    </div>
                                    <div class="calendar-details">
                                        <p>11:30 am</p>
                                        <div class="calendar-box normal-bg">
                                            <div class="calandar-event-name">
                                                <h4>History</h4>
                                                <h5>Lorem ipsum sit amet</h5>
                                            </div>
                                            <span>11:30 - 12:00 am</span>
                                        </div>
                                    </div> -->
                                </div>
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
    <script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="../assets/plugins/apexchart/chart-data.js"></script>
    <script src="../assets/plugins/simple-calendar/jquery.simple-calendar.js"></script>
    <script src="../assets/plugins/datatables/datatables.min.js"></script>
    <script src="../assets/js/calander.js"></script>
    <script src="../assets/js/script.js"></script>


</body>

</html>