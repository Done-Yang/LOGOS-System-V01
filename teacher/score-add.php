<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "teacher-datas/group-db.php";
include "teacher-datas/subject-db.php";
include "teacher-datas/teacher-db.php";
include "teacher-datas/student-score-db.php";

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['teacher_login'];
    $teacher = getTeacherById($id, $conn);
    $user = teacherGetUserById($id, $conn);

    $search_by = $search_by_err = '';
    $subject = $subject_err = '';

    $timetables2 = $conn->prepare("SELECT * FROM timetables");
    $timetables2->execute();

    if (isset($_POST['search'])) {
        if (empty($_POST['search_by'])) {
            $search_by_err = 'Please select group id!';
        } else {
            $search_by = $_POST['search_by'];

            $groups = $conn->prepare("SELECT * FROM groups WHERE group_id=:group_id LIMIT 1");
            $groups->bindParam(':group_id', $search_by);
            $groups->execute();

            $timetables1 = $conn->prepare("SELECT * FROM timetables");
            $timetables1->execute();
        }
    } else {
        $search_by = '';
    }

    if (isset($_POST['submit'])) {
        if (empty($_POST['search_by'])) {
            $search_by_err = 'Please select group id!';
        } else {
            $search_by = $_POST['search_by'];
        }

        if (empty($_POST['subject'])) {
            $subject_err = 'Please select any subject!';
        } else {
            $subject = $_POST['subject'];
        }
        $semester = $_POST['semester'];

        $check_score_table = $conn->prepare("SELECT * FROM scores WHERE group_id=:group_id and sub_id=:sub_id and semester=:semester");
        $check_score_table->bindParam(':group_id', $search_by);
        $check_score_table->bindParam(':sub_id', $subject);
        $check_score_table->bindParam(':semester', $semester);
        $check_score_table->execute();

        if ($check_score_table->rowCount() > 0) {
            $season = $_POST['season'];
            $_SESSION['error'] = "The score table is already exist! <a href='score-edit.php?group_id=$search_by&sub_id=$subject&season=$season'>Click here for update</a>";
            header('location: score-add.php');
            exit;
        } else {
            if (!empty($_POST['search_by']) and !empty($_POST['subject'])) {
                try {
                    $sql = mysqli_connect("localhost", "root", "", "iater01");
                    $n = $_POST['n'];
                    for ($i = 1; $i <= $n; $i++) {
                        $std_id = $_POST[$i . 'std_id'];
                        $subject = $_POST['subject'];
                        $search_by = $_POST['search_by'];
                        $attending = $_POST[$i . 'attending'];
                        $behavire = $_POST[$i . 'behavire'];
                        $activities = $_POST[$i . 'activities'];
                        $midterm_ex = $_POST[$i . 'midterm_ex'];
                        $final_ex = $_POST[$i . 'final_ex'];
                        $season = $_POST['season'];
                        $semester = $_POST['semester'];
                        $status = 'Not Submitted';
                        mysqli_query($sql, "INSERT INTO scores (std_id, group_id, sub_id, attending, behavire, activities, midterm_ex, final_ex, season, semester, status) 
                                                            VALUES ('$std_id', '$search_by', '$subject', '$attending', '$behavire', '$activities', '$midterm_ex', '$final_ex', '$season', '$semester', '$status')");
                        $add_att = $conn->prepare("INSERT INTO attendances (std_id, group_id, semester, sub_id) VALUES ('$std_id', '$search_by', '$semester', '$subject')");
                        $add_att->execute();
                        // mysqli_query($sql, "INSERT INTO attendances (std_id, group_id, sub_id) 
                        //                                     VALUES ('$std_id', '$search_by', '$subject')");
                        // mysqli_query($sql, "INSERT INTO student_scores (student_name, subject, season, part) VALUES ('$student_name', '$subject', '$season', '$part')");
                    }
                    // $_SESSION['success'] = "Add Student's score successfully. <a href='score-list.php'>Click here to see the detail</a>";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Score Add Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header('refresh:2; url=score-list.php');
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
                                <h3 class="page-title">Add Score</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="score-list.php">Score</a></li>
                                    <li class="breadcrumb-item active">Add Score</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-group-form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <select class="form-control select" name="search_by">
                                        <option><?php echo $search_by ?></option>
                                        <?php 
                                        $group_check = array();
                                        foreach ($timetables2 as $timetable) {
                                            if ($timetable['teacher1_id'] == $id or $timetable['teacher2_id'] == $id) {
                                                array_push($group_check, $timetable['group_id']);?>
                                        <?php }
                                        }
                                        $grs = array_unique($group_check); 
                                        foreach($grs as $gr){?>
                                            <option><?php echo $gr ?></option> 
                                        <?php }?>
                                    </select>
                                    <div class="error"><?php echo $search_by_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>

                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card comman-shadow">
                            <div class="card-body">

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
                                <?php
                                $sql = mysqli_connect("localhost", "root", "", "logos_v001_db_test1");
                                if (isset($_POST['search'])) {
                                    $group_id = $_REQUEST['search_by'];
                                    if (!empty($_POST['search_by'])) { ?>
                                        <div class="row">
                                            <div class="page-header">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <?php
                                                        foreach ($groups as $group) { ?>
                                                            <h3 class="page-title">All Students in <?php echo $group['program'] ?> Year <?php echo $group['year'] ?> (<?php echo $group['part'] ?>) </h3>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group local-forms col-6">
                                                    <label>Please Select Subject<span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="subject">
                                                        <option></option>
                                                        <?php $i = 0;
                                                        $sub_check = array();
                                                        foreach ($timetables1 as $timetable) {
                                                            $i++;
                                                            if ($timetable['teacher1_id'] == $id and !in_array($timetable['sub1_id'], $sub_check)) {
                                                                array_push($sub_check, $timetable['sub1_id']);
                                                                $sub = getSubjectById($timetable['sub1_id'], $conn); ?>
                                                                <option value="<?php echo $timetable['sub1_id'] ?>"> <?php echo $sub['name'] ?> </option>
                                                            <?php }
                                                            if ($timetable['teacher2_id'] == $id and !in_array($timetable['sub2_id'], $sub_check)) {
                                                                array_push($sub_check, $timetable['sub2_id']);
                                                                $sub = getSubjectById($timetable['sub2_id'], $conn); ?>
                                                                <option value="<?php echo $timetable['sub2_id'] ?>"> <?php echo $sub['name'] ?> </option>
                                                        <?php }
                                                        }
                                                        ?>
                                                        <div class="error"><?php echo $subject_err ?></div>
                                                    </select>
                                                    <div class="error"><?php echo $subject_err ?></div>
                                                </div>
                                                <div class="form-group local-forms col-6">
                                                    <label>Please Select Semester<span class="login-danger">*</span></label>
                                                    <select class="form-control select" name="semester">
                                                        <option>1</option>
                                                        <option>2</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                                    <thead class="student-thread">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Full Name</th>
                                                            <th>Behavire 10%</th>
                                                            <th>HomeWork 10%</th>
                                                            <th>Attending 20%</th>
                                                            <th>MidTerm EX 20%</th>
                                                            <th>Final EX 40%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        $connection = mysqli_connect("localhost", "root", "", "iater01");
                                                        $query = "SELECT * FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id WHERE group_id='$group_id' ";
                                                        $query_run = mysqli_query($connection, $query);

                                                        if (mysqli_num_rows($query_run) > 0) {
                                                            $n = mysqli_num_rows($query_run);
                                                            $i = 1;
                                                            while ($row = mysqli_fetch_assoc($query_run)) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?php echo $i ?>
                                                                    </td>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <?php
                                                                            if ($row['gender'] == 'Male') { ?>
                                                                                <a>Mr <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></a>
                                                                            <?php } else { ?>
                                                                                <a>Miss <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></a>
                                                                            <?php }
                                                                            ?>
                                                                        </h2>
                                                                    </td>
                                                                    <input class="form-control" type="hidden" name="<?php echo $i . 'std_id' ?>" value="<?php echo $row['std_id'] ?>">
                                                                    <input class="form-control" type="hidden" name="n" value="<?php echo $n ?>">
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'behavire' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'activities' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'attending' ?>" readonly>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'midterm_ex' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'final_ex' ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="hidden" name="season" value="<?php echo $row['season'] ?>">
                                                                    </td>
                                                                </tr>

                                                    <?php $i++;
                                                            }
                                                        }
                                                    } ?>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                                <!-- onclick="return confirm('Do you want to add these items?'") -->
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                    </form>
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