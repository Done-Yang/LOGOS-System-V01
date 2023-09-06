<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
session_start();
require_once 'include/config/dbcon.php';
if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $dir_id = $_SESSION['director_login'];
        include "director-datas/director-db.php";
        $user = directorGetUserById($dir_id, $conn);
        $director = getDirectorById($dir_id, $conn);

        try {
            $timetables1 = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id");
            $timetables1->bindParam(':group_id', $id);
            $timetables1->execute();

            // For get the first row in timetables
            $datas = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id LIMIT 1");
            $datas->bindParam(':group_id', $id);
            $datas->execute();

            include "director-datas/subject-db.php";
            include "director-datas/teacher-db.php";
            include "director-datas/program-db.php";
            include "director-datas/season-db.php";
            include "director-datas/group-db.php";
            include "director-datas/classroom-db.php";

            $programs = getAllPrograms($conn);
            $seasons = getLastSeason($conn);

            $teachers = getAllTeachers($conn);

            $classrooms = getAllClassrooms($conn);
        } catch (PDOException $e) {
            $e->getMessage();
        }

        if (isset($_POST['submit'])) {

            try {
                $sql = mysqli_connect("localhost", "root", "", "iater01");
                
                $i = 1;
                foreach($timetables1 as $timetable){
                    
                    $p = $timetable['part'];
                    $pg = $timetable['program'];
                    $ss = $timetable['season'];

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
                    $semester = $_REQUEST['semester'];
                    $days = $_REQUEST[$i . 'days'];
                    mysqli_query($sql, "UPDATE timetables SET sub1_id='$subject1', sub2_id='$subject2', book1='$book1', book2='$book2', teacher1_id='$teacher1', teacher2_id='$teacher2', class1='$classroom1', class2='$classroom2',
                                                              times1= '$times1', times2='$times2', semester='$semester' WHERE group_id='$id' and days='$days' ");
                    $i++;
                    
                }
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Update time table sucessfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                // $_SESSION['success'] = "Add Timetable successfuly. <a href='timetable-list.php'> Click here to details </a>";
                header("refresh:2; url=timetable-detail.php?id=$id");
                exit;
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

    <?php
    include_once("include/header.php");
    include_once("include/sidebar.php");
    ?>

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title">Edit Time Table</h3>

                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="timetable-list.php">Time Tables</a></li>
                                <li class="breadcrumb-item active">Edit Time Table</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php foreach($datas as $data){
                $pg = $data['program'];
                $p = $data['part'];
                $ss = $data['season'];
                $y = $data['year'];
                $groups = getAllGroupByPPSY($pg, $p, $ss, $y, $conn);
                $subjects = getSubBySP($ss, $pg, $conn);?>
                
                <div class="student-group-form">
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group local-forms">
                                <label>Season <span class="login-danger">*</span></label>
                                <select class="form-control select" name="season" disabled>
                                    <option><?php echo $data['season'] ?></option>
                                    <?php $i = 0;
                                    foreach ($seasons as $season) {
                                        $i++; 
                                        if($season['season'] != $data['season']){?>
                                            <option value="<?php echo $season['season'] ?>"> <?php echo $season['season'] ?> </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group local-forms">
                                <label>Program <span class="login-danger">*</span></label>
                                <select class="form-control select" name="program" disabled>
                                    <option><?php echo $data['program'] ?></option>
                                    <?php $i = 0;
                                    foreach ($programs as $program) {
                                        $i++; 
                                        if($data['program'] != $program['program']){?>
                                            <option> <?php echo $program['program'] ?> </option>
                                        <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group local-forms">
                                <label>Part <span class="login-danger">*</span></label>
                                <select class="form-control select" name="part" disabled>
                                    <?php if($data['part'] == 'Morning'){?>
                                        <option><?php echo $data['part'] ?></option>
                                        <option>Evening</option>
                                        <option>Afternoon</option>
                                    <?php }elseif ($data['part'] == 'Evening') {?>
                                        <option><?php echo $data['part'] ?></option>
                                        <option>Morning</option>
                                        <option>Afternoon</option>
                                    <?php }elseif ($data['part'] == 'Afternoon') {?>
                                        <option><?php echo $data['part'] ?></option>
                                        <option>Morning</option>
                                        <option>Evening</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group local-forms">
                                <label>Year <span class="login-danger">*</span></label>
                                <select class="form-control select" name="year" disabled>
                                    <option><?php echo $data['year']?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="search-student-btn">
                                <button type="submit" name="search" class="btn btn-primary" disabled>Set</button>
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
                                                <h5 class="form-title student-info">Time Tebles Information: <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group local-forms">
                                                    <label>Student Group ID <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="group_id" disabled>
                                                        <option><?php echo $data['group_id']?></option>
                                                        <?php $i = 0;
                                                        foreach ($groups as $group) {
                                                            $i++; 
                                                            if($group['group_id'] != $data['group_id']){?>
                                                                <option value="<?php echo $group['group_id'] ?>"> <?php echo $group['group_id'] ?></option>
                                                            <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-3">
                                                <div class="form-group local-forms">
                                                    <label>Semester <span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="semester">
                                                        <option><?php echo $data['semester'] ?></option>
                                                        <?php $semester = array(1,2);
                                                        foreach($semester as $smt){
                                                            if($smt != $data['semester'] ){?>
                                                                <option><?php echo $smt ?></option>
                                                            <?php }
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <div class="search-student-btn">
                                                    <button type="submit" name="submit" class="btn btn-primary" onclick="$comfirm_submit_alert">Update</button>
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
                                                            <th>Book ID</th>
                                                            <th>Teacher</th>
                                                            <th>Time</th>
                                                            <th>Class</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <?php 
                                                            $addLoop = 1;
                                                            foreach($timetables1 as $timetable){
                                                                $sub1 = getSubjectById($timetable['sub1_id'], $conn);
                                                                $sub2 = getSubjectById($timetable['sub2_id'], $conn);
                                                                $t1 = getTeacherById($timetable['teacher1_id'], $conn);
                                                                $t2 = getTeacherById($timetable['teacher2_id'], $conn);
                                                            ?>
                                                            <tr>
                                                                <td rowspan="2">
                                                                    <?php echo $timetable['days'] ?>
                                                                    <input type="hidden" name="<?php echo $addLoop . 'days' ?>" value="<?php echo $timetable['days'] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'subject1' ?>">                    
                                                                        <?php if($timetable["sub1_id"] != ''){?>
                                                                            <option value="<?php echo $sub1['sub_id'] ?>"><?php echo $sub1['name']?></option>
                                                                        <?php }else{?>
                                                                            <option></option>
                                                                        <?php } ?>
                                                                            <option></option>
                                                                        <?php $k = 0; // For loop subjects
                                                                        foreach ($subjects as $subject) {
                                                                            // if ($subject['season'] == $_REQUEST['season'] && $subject['semester'] == $_REQUEST['semester']) {
                                                                            if ($subject['season'] == $timetable['season']) {
                                                                                $k++; ?>
                                                                                <option value="<?php echo $subject['sub_id'] ?>"> <?php echo $subject['name'] ?> </option>
                                                                        <?php }
                                                                        } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="<?php echo $addLoop . 'book1' ?>" value="<?php echo $timetable['book1'] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'teacher1' ?>">
                                                                        <?php if($timetable["teacher1_id"] != ''){?>
                                                                            <option value="<?php echo $t1['t_id'] ?>"><?php echo $t1['fname_en'].' '.$t1['lname_en']?></option>
                                                                        <?php }else{?>
                                                                            <option></option>
                                                                        <?php } ?>
                                                                            <option></option>
                                                                        <?php $i = 0;
                                                                        foreach ($teachers as $teacher) {
                                                                            $i++; ?>
                                                                            <option value="<?php echo $teacher['t_id'] ?>"><?php echo $teacher['fname_en'] . ' ' . $teacher['lname_en'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td>
                                                                    <input class="form-control" type="text" name="<?php echo $addLoop . 'times1' ?>" value="<?php echo $timetable['times1'] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'classroom1' ?>">
                                                                        <option><?php echo $timetable['class1'] ?></option>
                                                                        <option></option>
                                                                        <?php $i = 0;
                                                                        foreach ($classrooms as $classroom) {
                                                                            $i++; ?>
                                                                            <option value="<?php echo $classroom['classroom'] ?>"> <?php echo $classroom['classroom'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>

                                                            <!-- for subject 2 -->
                                                            <tr>
                                                                <td class="col-12 col-sm-2">
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'subject2' ?>">
                                                                    <?php if($timetable["sub2_id"] != ''){?>
                                                                            <option value="<?php echo $sub2['sub_id'] ?>"><?php echo $sub2['name']?></option>
                                                                        <?php }else{?>
                                                                            <option></option>
                                                                        <?php }?>
                                                                            <option></option>
                                                                        <?php
                                                                        $k = 0; // For loop subjects
                                                                        foreach ($subjects as $subject) {
                                                                            
                                                                            // if ($subject['season'] == $_REQUEST['season'] && $subject['semester'] == $_REQUEST['semester']) {
                                                                            if ($subject['season'] == $timetable['season']) {
                                                                                $k++; ?>
                                                                                <option value="<?php echo $subject['sub_id'] ?>"> <?php echo $subject['name'] ?> </option>
                                                                        <?php }
                                                                        } ?>
                                                                    </select>
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <input class="form-control" type="text" name="<?php echo $addLoop . 'book2' ?>" value="<?php echo $timetable['book2'] ?>">
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'teacher2' ?>">
                                                                        <?php if($timetable["teacher2_id"] != ''){?>
                                                                            <option value="<?php echo $t2['t_id'] ?>"><?php echo $t2['fname_en'].' '.$t2['lname_en']?></option>
                                                                        <?php }else{?>
                                                                            <option></option>
                                                                        <?php } ?>
                                                                            <option></option>
                                                                        <?php
                                                                        $i = 0;
                                                                        foreach ($teachers as $teacher) {
                                                                            $i++; ?>
                                                                            <option value="<?php echo $teacher['t_id'] ?>"><?php echo $teacher['fname_en'] . ' ' . $teacher['lname_en'] ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                                <td class="col-12 col-sm-2">
                                                                    <input class="form-control" type="text" name="<?php echo $addLoop . 'times2' ?>" value="<?php echo $timetable['times2'] ?>">
                                                                </td>
                                                                <td>
                                                                    <select class="form-control select" name="<?php echo $addLoop . 'classroom2' ?>">
                                                                        <option><?php echo $timetable['class2'] ?></option>
                                                                        <option></option>
                                                                        <?php $i = 0;
                                                                        foreach ($classrooms as $classroom) {
                                                                            $i++; ?>
                                                                            <option value="<?php echo $classroom['classroom'] ?>"> <?php echo $classroom['classroom'] ?> </option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <?php $addLoop++ ?>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                    

                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
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