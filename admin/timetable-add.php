<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
session_start();
require_once 'include/config/dbcon.php';
if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    $program = $season = $part = $group_id = $year = $semester = $amount = '';
    $program_err = $season_err = $part_err = $group_id_err = $year_err = $semester_err = $amount_err = '';
    $program_red_border = $season_red_border = $part_red_border = $group_id_red_border = $year_red_border = $semester_red_border = $amount_red_border = '';


    include "admin-datas/student-db.php";
    include "admin-datas/program-db.php";
    include "admin-datas/season-db.php";
    $programs = getAllPrograms($conn);
    $seasons = getAllSeasons($conn);

    if (isset($_POST['search'])) {
        if (empty($_REQUEST['program'])) {
            $program_err = 'Program is required!';
            $program_red_border = 'red_border';
        } else {
            $program = $_REQUEST['program'];
        }
        if (empty($_REQUEST['season'])) {
            $season_err = 'Season ID is required!';
            $season_red_border = 'red_border';
        } else {
            $season = $_REQUEST['season'];
        }
        if (empty($_REQUEST['part'])) {
            $part_err = 'Part is required!';
            $part_red_border = 'red_border';
        } else {
            $part = $_REQUEST['part'];
        }
        if (empty($_REQUEST['year'])) {
            $year_err = 'Year is required!';
            $year_red_border = 'red_border';
        } else {
            $year = $_REQUEST['year'];
        }

        if (!empty($program) and !empty($season) and !empty($part) and !empty($year)) {

            include "admin-datas/studentgroup-db.php";
            $students = getStudentGroupByPPSY($program, $part, $season, $conn);

            include "admin-datas/group-db.php";
            $groups = getAllGroupByPPSY($program, $part, $season, $year, $conn);

            include "admin-datas/subject-db.php";
            $subjects = getSubBySP($season, $program, $conn);

            include "admin-datas/teacher-db.php";
            $teachers = getAllTeachers($conn);

            include "admin-datas/classroom-db.php";
            $classrooms = getAllClassrooms($conn);
        }
    }

    if (isset($_POST['submit'])) {
        $check_group_if_exist = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id");
        $check_group_if_exist->bindParam(':group_id', $_REQUEST['group_id']);
        $check_group_if_exist->execute();

        $program = $_REQUEST['program'];
        $season = $_REQUEST['season'];
        $part = $_REQUEST['part'];
        $year = $_REQUEST['year'];

        if (empty($_REQUEST['semester'])) {
            $semester_err = 'semester is required!';
            $semester_red_border = 'red_border';
        } else {
            $semester = $_REQUEST['semester'];
        }
        if (empty($_REQUEST['group_id'])) {
            $group_id_err = 'Classgroup ID is required!';
            $group_id_red_border = 'red_border';
        }elseif($check_group_if_exist->rowCount() > 0){
            $g_id = $_REQUEST['group_id'];
            $_SESSION['error'] = "The time table in this group ID is already exist! <a href='timetable-edit.php?id=$g_id'>Click here for update</a>";
            header('location: timetable-add.php');
            exit;
        } else {
            $group_id = $_REQUEST['group_id'];
        }

        if (!empty($program) and !empty($season) and !empty($part) and !empty($year) and !empty($group_id) and !empty($semester)) {

            try {

                for ($i = 1; $i <= 5; $i++) {
                    $subject1 = $_REQUEST[$i . 'subject1'];
                    $subject2 = $_REQUEST[$i . 'subject2'];
                    $book1 = $_REQUEST[$i . 'book1'];
                    $book2 = $_REQUEST[$i . 'book2'];
                    $teacher1 = $_REQUEST[$i . 'teacher1'];
                    $teacher2 = $_REQUEST[$i . 'teacher2'];
                    $times1 = $_REQUEST[$i . 'times1'];
                    $times2 = $_REQUEST[$i . 'times2'];
                    $classroom1 = $_REQUEST[$i . 'classroom1'];
                    $classroom2 = $_REQUEST[$i . 'classroom2'];
                    $days = $_REQUEST[$i . 'days'];
                    $stmt = $conn->prepare("INSERT INTO timetables (sub1_id, sub2_id, book1, book2, teacher1_id, teacher2_id, group_id, class1, class2, season, times1, times2, program, part, year, semester, days)
                                VALUES('$subject1', '$subject2', '$book1', '$book2', '$teacher1', '$teacher2', '$group_id', '$classroom1', '$classroom2', '$season', '$times1', '$times2', '$program', '$part', '$year', '$semester', '$days')");
                    $stmt->execute();
                }
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Time Table Add Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                // $_SESSION['success'] = "Add Timetable successfuly. <a href='timetable-list.php'> Click here to details </a>";
                header("refresh:2; url=timetable-detail.php?id=$group_id");
                exit;
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }else{
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Fail..!',
                        text: 'Pleas fill Group ID and Semester!',
                        icon: 'error',
                        timer: 5000,
                        showConfirmButton: false
                    });
                });
            </script>";
            header('refresh:3; url=timetable-add.php');
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
                                <h3 class="page-title">Add Time Table</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="timetable-list.php">Time Tables</a></li>
                                    <li class="breadcrumb-item active">Add Time Table</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="student-group-form">

                        <div class="row">
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Season <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $season_red_border ?>" name="season">
                                        <option value="<?php echo $season ?>"><?php echo $season ?></option>
                                        <?php $i = 0;
                                        foreach ($seasons as $season) {
                                            $i++; ?>
                                        <option value="<?php echo $season['season'] ?>"> <?php echo $season['season'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                    <div class="error"><?php echo $season_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Program <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $program_red_border ?>" name="program">
                                        <option><?php echo $program ?></option>
                                        <?php $i = 0;
                                        foreach ($programs as $program) {
                                            $i++; ?>
                                        <option> <?php echo $program['program'] ?> </option>
                                        <?php } ?>
                                    </select>
                                    <div class="error"><?php echo $program_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Part <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $part_red_border ?>" name="part">
                                        <option><?php echo $part ?></option>
                                        <option>Morning</option>
                                        <option>Afternoon</option>
                                        <option>Evening</option>
                                    </select>
                                    <div class="error"><?php echo $part_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-6">
                                <!-- New element -->
                                <div class="form-group local-forms">
                                    <label>Year <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $year_red_border ?>" name="year">
                                        <option><?php echo $year ?></option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <div class="error"><?php echo $year_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Set</button>
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
                                    <?php }elseif(isset($_SESSION['error'])) {?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php
                                                echo $_SESSION['error'];
                                                unset($_SESSION['error']);
                                                ?>
                                    </div>
                                    <?php } ?>

                                    <?php if (isset($_POST['search'])) {
                                        if (!empty($program) and !empty($season) and !empty($part) and !empty($year)) { ?>

                                    <div class="card-body">
                                        <form method="post" action="" enctype="multipart/form-data">

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

                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="form-title student-info">Time Tebles Information: <span><a
                                                                href="javascript:;"><i
                                                                    class="feather-more-vertical"></i></a></span></h5>
                                                </div>
                                                <div class="col-12 col-sm-3">
                                                    <div class="form-group local-forms">
                                                        <label>Student Group ID <span class="login-danger">*</span></label>
                                                        <select
                                                            class="form-control select <?php echo $group_id_red_border ?>"
                                                            name="group_id">
                                                            <option><?php echo $group_id ?></option>
                                                            <?php $i = 0;
                                                                    foreach ($groups as $group) {
                                                                        $i++; ?>
                                                            <option value="<?php echo $group['group_id'] ?>">
                                                                <?php echo $group['group_id'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="error"><?php echo $group_id_err ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-3">
                                                    <!-- New element -->
                                                    <div class="form-group local-forms">
                                                        <label>Semester <span class="login-danger">*</span></label>
                                                        <select
                                                            class="form-control select <?php echo $semester_red_border ?>"
                                                            name="semester">
                                                            <option><?php echo $semester ?></option>
                                                            <option>1</option>
                                                            <option>2</option>
                                                        </select>
                                                        <div class="error"><?php echo $semester_err ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-2">
                                                    <div class="search-student-btn">
                                                        <button type="submit" name="submit" class="btn btn-primary"
                                                            onclick="$comfirm_submit_alert">Submit</button>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead class="student-thread">
                                                            <tr>
                                                                <th>Day</th>
                                                                <th>Subject</th>
                                                                <th>Book ID</th> <!-- New element -->
                                                                <th>Teacher</th>
                                                                <th>Time</th> <!-- New element -->
                                                                <th>Class</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                                    $j = 0; // For loop arrays
                                                                    $addLoop = 1; // For loop add subjects
                                                                    $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday");
                                                                    while ($j <= 4) { ?>
                                                            <tr>
                                                                <td  rowspan="2">
                                                                    <?php echo $days[$j] ?>
                                                                    <input type="hidden" name="<?php echo $addLoop . 'days' ?>" value="<?php echo $days[$j] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'subject1' ?>">
                                                                        <option value="<?php echo $subject1 ?>"></option>
                                                                        <?php
                                                                                    $k = 0; // For loop subjects
                                                                                    foreach ($subjects as $subject) {
                                                                                        // if ($subject['season'] == $_REQUEST['season'] && $subject['semester'] == $_REQUEST['semester']) {
                                                                                        if ($subject['season'] == $_REQUEST['season']) {
                                                                                            $k++; ?>
                                                                        <option value="<?php echo $subject['sub_id'] ?>">
                                                                            <?php echo $subject['name'] ?> </option>
                                                                        <?php }
                                                                                    } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <!-- New element -->
                                                                    <input class="form-control" type="text"
                                                                        name="<?php echo $addLoop . 'book1' ?>"
                                                                        value="<?php $book1 ?>">
                                                                </td>
                                                                <td>
                                                                    <!-- New element -->
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'teacher1' ?>">
                                                                        <option><?php $teacher1 ?></option>
                                                                        <?php
                                                                                    $i = 0;
                                                                                    foreach ($teachers as $teacher) {
                                                                                        $i++; ?>
                                                                        <option value="<?php echo $teacher['t_id'] ?>">
                                                                            <?php echo $teacher['fname_en'] . ' ' . $teacher['lname_en'] ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <!-- New element -->
                                                                    <input class="form-control" type="text"
                                                                        name="<?php echo $addLoop . 'times1' ?>"
                                                                        value="<?php $times1 ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'classroom1' ?>">
                                                                        <option><?php $classroom1 ?></option>
                                                                        <?php $i = 0;
                                                                                    foreach ($classrooms as $classroom) {
                                                                                        $i++; ?>
                                                                        <option
                                                                            value="<?php echo $classroom['classroom'] ?>">
                                                                            <?php echo $classroom['classroom'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <!-- for subject 2 -->
                                                            <!-- New element -->
                                                            <tr>
                                                                <td class="col-12 col-sm-2">
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'subject2' ?>">
                                                                        <option><?php $subject2 ?></option>
                                                                        <?php
                                                                                    $k = 0; // For loop subjects
                                                                                    foreach ($subjects as $subject) {
                                                                                        // if ($subject['season'] == $_REQUEST['season'] && $subject['semester'] == $_REQUEST['semester']) {
                                                                                        if ($subject['season'] == $_REQUEST['season']) {
                                                                                            $k++; ?>
                                                                        <option value="<?php echo $subject['sub_id'] ?>">
                                                                            <?php echo $subject['name'] ?> </option>
                                                                        <?php }
                                                                                    } ?>
                                                                    </select>
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <!-- New element -->
                                                                    <input class="form-control" type="text"
                                                                        name="<?php echo $addLoop . 'book2' ?>"
                                                                        value="<?php $book2 ?>">
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'teacher2' ?>">
                                                                        <option><?php $teacher2 ?></option>
                                                                        <?php
                                                                                    $i = 0;
                                                                                    foreach ($teachers as $teacher) {
                                                                                        $i++; ?>
                                                                        <option value="<?php echo $teacher['t_id'] ?>">
                                                                            <?php echo $teacher['fname_en'] . ' ' . $teacher['lname_en'] ?>
                                                                        </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <input class="form-control" type="text"
                                                                        name="<?php echo $addLoop . 'times2' ?>"
                                                                        value="<?php $times2 ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select"
                                                                        name="<?php echo $addLoop . 'classroom2' ?>">
                                                                        <option><?php $classroom2 ?></option>
                                                                        <?php $i = 0;
                                                                                    foreach ($classrooms as $classroom) {
                                                                                        $i++; ?>
                                                                        <option
                                                                            value="<?php echo $classroom['classroom'] ?>">
                                                                            <?php echo $classroom['classroom'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <?php $j++;
                                                                        $addLoop++;
                                                                    } ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                    </div>


                </form>
            </div>
            <?php }
                                    }  ?>
        </div>
        </div>
        </div>
        </div>
        </form>
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

    <script src="../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../assets/js/script.js"></script>

</body>

</html>