<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        include "admin-datas/teacher-db.php";
        include "admin-datas/group-db.php";
        include "admin-datas/student-db.php";
        include "admin-datas/program-db.php";
        include "admin-datas/season-db.php";
        include "admin-datas/studentgroup-db.php";
        $teachers = getAllTeachers($conn);
        $groups = getAllGroups($conn);
        $programs = getAllPrograms($conn);
        $seasons = getLastSeason($conn);
        $student_group = getStudentGroupByID($id, $conn);
        $t_id = $student_group['t_id'];

        $teacher_name = getTeacherById($t_id, $conn);


        $program = $season = $part = $group_id = $teacher = $year = $amount = '';
        $program_err = $season_err = $part_err = $group_id_err = $teacher_err = $year_err = $amount_err = '';
        $program_red_border = $season_red_border = $part_red_border = $group_id_red_border = $teacher_red_border = $year_red_border = $amount_red_border = '';


        if (isset($_POST['submit'])) {

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

            if (empty($_REQUEST['group_id'])) {
                $group_id_err = 'Classgroup ID is required!';
                $group_id_red_border = 'red_border';
            } else {
                $group_id = $_REQUEST['group_id'];
            }
            if (empty($_REQUEST['teacher'])) {
                $teacher_err = 'Teacher is required!';
                $teacher_red_border = 'red_border';
            } else {
                $teacher = $_REQUEST['teacher'];
            }
            if (empty($_REQUEST['year'])) {
                $year_err = 'Year is required!';
                $year_red_border = 'red_border';
            } else {
                $year = $_REQUEST['year'];
            }

            if (empty($group_id_err) and !empty($teacher) and !empty($year) and !empty($season) and !empty($program)) {

                try {
                    $sql = mysqli_connect("localhost", "iater01", "iATER2024", "iater01");

                    for ($i = 1; $i <= $amount; $i++) {

                        $studentID = $_REQUEST[$i . 'studentID'];

                        // For Group student's class
                        mysqli_query($sql, "UPDATE studentgroups SET group_id='$group_id', t_id='$teacher', std_id='$studentID', program='$program',
                                                                     season='$season', year='$year' WHERE group_id='$group_id'");

                        // For Student group's status
                        mysqli_query($sql, "UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                    }
                    // $_SESSION['success'] = 'Success!' . $season . $program . $part . $group_id . $teacher . $year . $amount;
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Student Group Update Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    // $_SESSION['success'] = 'Update group student successfuly!';
                    header('refresh:2; url=studentgroup-list.php');
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Exist empty cell, Pleas check your data again!";
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

    <div class="main-wrapper">

        <?php
            include "include/header.php";
            include "include/sidebar.php";
        ?>


        <div class="page-wrapper">
            <div class="content container-fluid">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Update Student Group</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="studentgroup-list.php">Student Groups</a></li>
                                    <li class="breadcrumb-item active">Update Student Group</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card comman-shadow">
                            <div class="card-body">
                                <form method="post" action="" enctype="multipart/form-data">
                                    <?php
                                    if (isset($errorMsg)) {
                                    ?>
                                        <div class="alert alert-danger">
                                            <strong><?php echo $errorMsg; ?></strong>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (isset($successMsg)) {
                                    ?>
                                        <div class="alert alert-success">
                                            <strong><?php echo $successMsg; ?></strong>
                                        </div>
                                    <?php } ?>
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
                                            <h5 class="form-title student-info">Student Group Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Group ID <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $group_id_red_border ?>" name="group_id">
                                                    <option value="<?php echo $student_group['group_id'] ?>"><?php echo $student_group['group_id'] ?></option>
                                                    <?php $i = 0;
                                                    foreach ($groups as $group) {
                                                        $i++; ?>
                                                        <option value="<?php echo $group['group_id'] ?>"><?php echo $group['group_id'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="error"><?php echo $group_id_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Teacher <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $teacher_red_border ?>" name="teacher">
                                                    <option value="<?php echo $teacher_name['t_id'] ?>"><?php echo $teacher_name['fname_en'] ?></option>
                                                    <?php $i = 0;
                                                    foreach ($teachers as $teacher) {
                                                        $i++; ?>
                                                        <option value="<?php echo $teacher['t_id'] ?>"><?php echo $teacher['fname_en'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="error"><?php echo $teacher_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Season <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $season_red_border ?>" name="season">
                                                    <option><?php echo $student_group['season'] ?></option>
                                                    <?php $i = 0;
                                                    foreach ($seasons as $season) {
                                                        $i++; ?>
                                                        <option> <?php echo $season['season'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="error"><?php echo $season_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Program <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $program_red_border ?>" name="program">
                                                    <option><?php echo $student_group['program'] ?></option>
                                                    <?php $i = 0;
                                                    foreach ($programs as $program) {
                                                        $i++; ?>
                                                        <option> <?php echo $program['program'] ?> </option>
                                                    <?php } ?>
                                                </select>
                                                <div class="error"><?php echo $program_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Year <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $year_red_border ?>" name="year">
                                                    <option><?php echo $student_group['year'] ?></option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                                <div class="error"><?php echo $year_err ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="student-submit">
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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