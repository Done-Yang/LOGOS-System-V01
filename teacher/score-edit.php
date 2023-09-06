<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "teacher-datas/group-db.php";
include "teacher-datas/subject-db.php";
include "teacher-datas/student-score-db.php";
include "teacher-datas/student-db.php";

if (!isset($_SESSION['teacher_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['teacher_login'];

    include "teacher-datas/teacher-db.php";
    $teacher = getTeacherById($id, $conn);
    $user = teacherGetUserById($id, $conn);

    if (isset($_GET['group_id']) and isset($_GET['sub_id']) and isset($_GET['semester'])) {
        $t_id = $_SESSION['teacher_login'];
        $group_id = $_GET['group_id'];
        $sub_id = $_GET['sub_id'];
        $semester = $_GET['semester'];

        $timetables = $conn->prepare("SELECT * FROM timetables");
        $timetables->execute();

        $std_scores = $conn->prepare("SELECT * FROM scores WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester'");
        $std_scores->execute();

        $std_score_first = $conn->prepare("SELECT * FROM scores WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester' LIMIT 1");
        $std_score_first->execute();
        $std_score_first_row=$std_score_first->fetch();

        $rount = $conn->prepare("SELECT count(*) FROM scores WHERE group_id='$group_id' and sub_id='$sub_id' and semester='$semester'");
        $rount->execute();

        $search_by = $search_by_err = '';
        $subject = $subject_err = '';

        $groups = $conn->prepare("SELECT * FROM groups WHERE group_id=:group_id LIMIT 1");
        $groups->bindParam(':group_id', $group_id);
        $groups->execute();

        // $groups = getLastGroup($group_id, $conn);

        $timetables1 = $conn->prepare("SELECT * FROM timetables");
        $timetables1->execute();

        $timetables2 = $conn->prepare("SELECT * FROM timetables");
        $timetables1->execute();

        if (isset($_POST['submit'])) {

            $check_score_table = $conn->prepare("SELECT group_id, sub_id FROM scores WHERE group_id=:group_id and sub_id=:sub_id and group_id != :this_group_id and sub_id != :this_sub_id ");
            $check_score_table->bindParam(':group_id', $_POST['search_by']);
            $check_score_table->bindParam(':sub_id', $_POST['subject']);
            $check_score_table->bindParam(':this_group_id', $group_id);
            $check_score_table->bindParam(':this_sub_id', $sub_id);
            $check_score_table->execute();

            if ($check_score_table->rowCount() > 0) {
                $_SESSION['error'] = "The score's table is already exist! Pleas select another group or subject.";
            } else {
                try {
                    $sql = mysqli_connect("localhost", "root", "", "iater01");

                    $n = $_POST['n'];
                    for ($i = 1; $i <= $n; $i++) {
                        // $search_by = $_POST['search_by'];
                        // $subject = $_POST['subject'];
                        $behavire = $_POST[$i . 'behavire'];
                        $activities = $_POST[$i . 'activities'];
                        $midterm_ex = $_POST[$i . 'midterm_ex'];
                        $final_ex = $_POST[$i . 'final_ex'];
                        $std_id = $_POST[$i . 'std_id'];
                        mysqli_query($sql, "UPDATE scores SET  behavire='$behavire', activities='$activities', midterm_ex='$midterm_ex', final_ex='$final_ex' 
                                                        WHERE std_id='$std_id' and sub_id='$sub_id' and group_id='$group_id' and semester='$semester' ");
                    }
                    // $_SESSION['success'] = "Add Student's score successfully. <a href='score-list.php'>Click here to see the detail</a>";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Score Update Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=score-detail.php?group_id=$group_id&sub_id=$sub_id&semester=$semester");
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }
        }
        if (isset($_POST['submit_score'])) {
            try {
                $sql = mysqli_connect("localhost", "root", "", "iater01");

                $n = $_POST['n'];
                for ($i = 1; $i <= $n; $i++) {
                    $status = 'Submitted';
                    $std_id = $_POST[$i . 'std_id'];
                    mysqli_query($sql, "UPDATE scores SET status='$status' WHERE std_id='$std_id' and sub_id='$sub_id' and group_id='$group_id' and semester='$semester' ");
                }
                // $_SESSION['success'] = "Add Student's score successfully. <a href='score-list.php'>Click here to see the detail</a>";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Score Submitted Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                header("refresh:2; url=score-detail.php?group_id=$group_id&sub_id=$sub_id&semester=$semester");
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
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="student-group-form">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <select class="form-control select" name="search_by" disabled>
                                        <option><?php echo $group_id ?></option>
                                        <?php foreach ($timetables1 as $timetable) {
                                            if ($timetable['teacher1_id'] == $id or $timetable['teacher2_id'] == $id) { ?>
                                                <option><?php echo $timetable['group_id'] ?></option>
                                        <?php }
                                        } ?>
                                    </select>
                                    <div class="error"><?php echo $search_by_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary" disabled>Search</button>
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
                                    <div class="row">
                                        <div class="page-header">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <?php
                                                    foreach ($groups as $group) { ?>
                                                        <h3 class="page-title">All Students in: <?php echo $group['program'] ?> Year: <?php echo $group['year'] ?> Semester: <?php echo $semester ?> (<?php echo $group['part'] ?>) </h3>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <h5 class="text-primary">Status: <?php echo $std_score_first_row['status']?></h5>
                                        </div>

                                        <div class="form-group local-forms">
                                            <label>Please Select Subject<span class="login-danger">*</span></label>
                                            <select class="form-control select" name="subject" disabled>
                                                <option value="<?php echo $sub_id ?>"><?php
                                                                                        $sub = getSubjectById($sub_id, $conn);
                                                                                        echo $sub['name'];
                                                                                        ?></option>
                                                <?php $i = 0;
                                                foreach ($timetables as $timetable) {
                                                    $i++;
                                                    if ($timetable['teacher1_id'] == $id) {
                                                        $sub = getSubjectById($timetable['sub1_id'], $conn); ?>
                                                        <option value="<?php echo $timetable['sub1_id'] ?>"> <?php echo $sub['name'] ?> </option>
                                                    <?php }
                                                    if ($timetable['teacher2_id'] == $id) {
                                                        $sub = getSubjectById($timetable['sub2_id'], $conn); ?>
                                                        <option value="<?php echo $timetable['sub2_id'] ?>"> <?php echo $sub['name'] ?> </option>
                                                <?php }
                                                }
                                                ?>
                                                <div class="error"><?php echo $subject_err ?></div>
                                            </select>
                                            <div class="error"><?php echo $subject_err ?></div>
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
                                                        foreach ($std_scores as $std_score) {
                                                            if($std_score['status'] == "Submitted"){ ?>
                                                                <tr>
                                                                    <td><?php echo $i ?></td>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <?php
                                                                            $row = getStudentById($std_score['std_id'], $conn);
                                                                            if ($row['gender'] == 'Male') { ?>
                                                                                <p>Mr <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></p>
                                                                            <?php } else { ?>
                                                                                <p>Miss <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></p>
                                                                            <?php }
                                                                            ?>
                                                                        </h2>
                                                                    </td>
                                                                    <input class="form-control" type="hidden" name="<?php echo $i . 'std_id' ?>" value="<?php echo $std_score['std_id'] ?>" >
                                                                    <input class="form-control" type="hidden" name="n" value="<?php echo $n ?>">
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'behavire' ?>" value="<?php echo $std_score['behavire'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'activities' ?>" value="<?php echo $std_score['activities'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'attending' ?>" value="<?php echo $std_score['attending'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'midterm_ex' ?>" value="<?php echo $std_score['midterm_ex'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'final_ex' ?>" value="<?php echo $std_score['final_ex'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="hidden" name="<?php echo $i . 'season' ?>" value="<?php echo $season ?>">
                                                                    </td>
                                                                </tr>
                                                            <?php }else{ ?>
                                                                <tr>
                                                                    <td><?php echo $i ?></td>
                                                                    <td>
                                                                        <h2 class="table-avatar">
                                                                            <?php
                                                                            $row = getStudentById($std_score['std_id'], $conn);
                                                                            if ($row['gender'] == 'Male') { ?>
                                                                                <p>Mr <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></p>
                                                                            <?php } else { ?>
                                                                                <p>Miss <?php echo $row['fname_en'] . " " . $row['lname_en'] ?></p>
                                                                            <?php }
                                                                            ?>
                                                                        </h2>
                                                                    </td>
                                                                    <input class="form-control" type="hidden" name="<?php echo $i . 'std_id' ?>" value="<?php echo $std_score['std_id'] ?>" >
                                                                    <input class="form-control" type="hidden" name="n" value="<?php echo $n ?>">
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'behavire' ?>" value="<?php echo $std_score['behavire'] ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'activities' ?>" value="<?php echo $std_score['activities'] ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'attending' ?>" value="<?php echo $std_score['attending'] ?>" disabled>
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'midterm_ex' ?>" value="<?php echo $std_score['midterm_ex'] ?>" >
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="text" name="<?php echo $i . 'final_ex' ?>" value="<?php echo $std_score['final_ex'] ?>" >
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" type="hidden" name="<?php echo $i . 'season' ?>" value="<?php echo $season ?>">
                                                                    </td>
                                                                </tr>
                                                            <?php }?>       
                                                        <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php if($std_score_first_row['status'] == 'Submitted'){?>
                                            <div class="col-6">
                                                <div class="student-submit">
                                                    <button type="submit" name="submit" class="btn btn-primary mt-2" disabled>Update</button>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end float-end text-white">
                                                <button type="submit" name="submit_score" class="btn btn-success mt-2" onclick="return confirm('Are you sure to submit these score?\nIt will be not able to edit after submit!')" disabled>Submit Score</button>
                                            </div>
                                        <?php }else{?>
                                            <div class="col-6">
                                                <div class="student-submit">
                                                    <button type="submit" name="submit" class="btn btn-primary mt-2">Update</button>
                                                </div>
                                            </div>
                                            <div class="col-6 text-end float-end text-white">
                                                <button type="submit" name="submit_score" class="btn btn-success mt-2" onclick="return confirm('Are you sure to submit these score?\nIt will be not able to edit after submit!')">Submit Score</button>
                                            </div>
                                        <?php } ?>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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