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
    
    $program = $season = $part = $group_id = $teacher = $year = $amount = '';
    $program_err = $season_err = $part_err = $group_id_err = $teacher_err = $year_err = $amount_err = '';
    $program_red_border = $season_red_border = $part_red_border = $group_id_red_border = $teacher_red_border = $year_red_border = $amount_red_border = '';

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


        if (!empty($program) and !empty($season) and !empty($part)) {

            include "admin-datas/studentgroup-db.php";
            $students = getStudentGroupByPPSY($program, $part, $season, $conn);

            

            // echo $students_amount;

            

            include "admin-datas/group-db.php";
            $groups = getAllGroupByPPS($program, $part, $season, $conn);
            // $groups = getAllGroups($conn);

            include "admin-datas/teacher-db.php";
            $teachers = getAllTeachers($conn);
        }
    }

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
        if (empty($_REQUEST['part'])) {
            $part_err = 'Part is required!';
            $part_red_border = 'red_border';
        } else {
            $part = $_REQUEST['part'];
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
        if (empty($_REQUEST['amount'])) {
            $amount_err = 'amount is required!';
            $amount_red_border = 'red_border';
        } else {
            $amount = $_REQUEST['amount'];
        }

        // Count students
        $count_std = $conn->prepare("SELECT COUNT(*) AS count FROM studentgroups WHERE group_id=:group_id");
        $count_std->bindParam(":group_id", $group_id);
        $count_std->execute();
        while ($row = $count_std->fetch(PDO::FETCH_ASSOC)) {
            $count_std_resault = $row['count'];
        };



        if (!empty($group_id) and !empty($teacher) and !empty($year)) {
            // if(and $students_amount > 0){
                if ($count_std_resault <= 60) {
                    try {
                        // $sql = mysqli_connect("localhost", "iater01", "iATER2024", "iater01");

                        $student_amount_query = $conn->prepare("SELECT COUNT(*) as count FROM students WHERE program=:program and part=:part and season_curent=:season");
                        $student_amount_query->bindParam(':program', $program);
                        $student_amount_query->bindParam(':part', $part);
                        $student_amount_query->bindParam(':season', $season);
                        $student_amount_query->execute();
                        $students_amount = $student_amount_query->fetch(PDO::FETCH_ASSOC)['count'];
                        for ($i = 1; $i <= $students_amount; $i++) {
                            $checked = $_REQUEST['check'.$i];
                            if(isset($checked)){
                                $studentID = $_REQUEST[$i . 'studentID'];
                                $check_u_id = $conn->prepare("SELECT std_id FROM studentgroups WHERE std_id = :std_id");
                                $check_u_id->bindParam(":std_id", $studentID);
                                $check_u_id->execute();
                                try{
                                    if($check_u_id->rowCount() > 0){
                                        // For Group student's class
                                        $stmt1 = $conn->prepare("UPDATE studentgroups SET group_id='$group_id', t_id='$teacher',  program='$program', season='$season', year='$year', part='$part' WHERE std_id='$studentID'");
                                        $stmt1->execute();
                
                                        // For Student group's status
                                        $stmt2 = $conn->prepare("UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                                        $stmt2->execute();
                                    }else{
                                        // For Group student's class
                                        $stmt1 = $conn->prepare("INSERT INTO studentgroups (group_id, t_id, std_id, program, season, year, part)
                                                    VALUES ('$group_id', '$teacher', '$studentID', '$program', '$season', '$year', '$part')");
                                        $stmt1->execute();
                
                                        // For Student group's status
                                        $stmt2 = $conn->prepare("UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                                        $stmt2->execute();
                                    }
                                }catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                            }
                        }
                        // $_SESSION['success'] = 'Success!' . $season . $program . $part . $group_id . $teacher . $year . $amount;
                        echo "<script>
                            $(document).ready(function() {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Student Group Add Successfully!',
                                    icon: 'success',
                                    timer: 5000,
                                    showConfirmButton: false
                                });
                            });
                        </script>";
                        header("refresh:2; url=studentgroup-detail.php?id=$group_id");
                        exit;
                    } catch (PDOException $e) {
                        $e->getMessage();
                    }
                } else {
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Fail..!',
                                text: 'Student Was Full, Pleas Chose Another Group!',
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:3");
                    exit;
                }
            // }else{
            //     $_SESSION['error'] = "Stundent not found!";
            // }
        } else {
            $_SESSION['error'] = "Exist empty cell, Pleas check your data again!";
        }
    }

    if (isset($_GET['std_g_id'])) {
        include "admin-datas/studentgroup-db.php";
        include "admin-datas/group-db.php";

        $std_g_id = $_GET['std_g_id'];

        $std_groups = getStudentGroupByID($std_g_id, $conn);
        $group_by_id = getGroupByID($std_g_id, $conn);

        $program = $group_by_id['program'];
        $part = $group_by_id['part'];
        $season = $group_by_id['season'];

        $students = getStudentGroupByPPSY($program, $part, $season, $conn);
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

    <link rel="stylesheet" href="../assets/plugins/twitter-bootstrap-wizard/form-wizard.css">

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
                                <h3 class="page-title">Group</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="studentgroup-list.php">Groups</a></li>
                                    <li class="breadcrumb-item active">All Groups</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="student-group-form">

                        <!-- Student group add student -->
                        <?php if (isset($_GET["std_g_id"])) { ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Season <span class="login-danger">*</span></label>
                                    <input class="form-control select <?php echo $season_red_border ?>" type="text"
                                        name="season" value="<?php echo $std_groups['season'] ?>" readonly>
                                    <div class="error"><?php echo $season_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Program <span class="login-danger">*</span></label>
                                    <input class="form-control select <?php echo $program_red_border ?>" type="text"
                                        name="program" value="<?php echo $std_groups['program'] ?>" readonly>
                                    <div class="error"><?php echo $program_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Part <span class="login-danger">*</span></label>
                                    <input class="form-control select <?php echo $part_red_border ?>" type="text"
                                        name="part" value="<?php echo $group_by_id['part'] ?>" readonly>
                                    <div class="error"><?php echo $part_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button name="search" class="btn btn-primary" disabled>Search</button>
                                </div>
                            </div>
                        </div>
                        <?php } else { ?>
                        <!-- Normal student group add -->
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Season <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $season_red_border ?>" name="season">
                                        <option><?php echo $season ?></option>
                                        <?php $i = 0;
                                            foreach ($seasons as $season) {
                                                $i++; ?>
                                                <option value="<?php echo $season['season'] ?>"> <?php echo $season['season'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error"><?php echo $season_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Program <span class="login-danger">*</span></label>
                                    <select class="form-control select <?php echo $program_red_border ?>"
                                        name="program">
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
                            <div class="col-lg-4 col-md-6">
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
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                        <?php }  ?>
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



                                    <div class="page-header">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h3 class="page-title">All Students</h3>
                                            </div>
                                            <div class="col-auto text-end float-end ms-auto download-grp">
                                                <!-- <a href="student-add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a> -->
                                            </div>
                                        </div>
                                    </div>

                                    <?php if (isset($_POST['search'])) {
                                        if (!empty($program) and !empty($season) and !empty($part)) { ?>

                                    <div class="student-group-form">

                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="form-title student-info">Group Informations:</h5>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Group ID <span class="login-danger">*</span></label>
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
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Teacher <span class="login-danger">*</span></label>
                                                    <select
                                                        class="form-control select <?php echo $teacher_red_border ?>"
                                                        name="teacher">
                                                        <option><?php echo $teacher ?></option>
                                                        <?php $i = 0;
                                                                foreach ($teachers as $teacher) {
                                                                    $i++; ?>
                                                        <option value="<?php echo $teacher['t_id'] ?>">
                                                            <?php echo $teacher['fname_en'] ?> </option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="error"><?php echo $teacher_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <!-- New element -->
                                                <div class="form-group local-forms">
                                                    <label>Year <span class="login-danger">*</span></label>
                                                    <select class="form-control select <?php echo $year_red_border ?>"
                                                        name="year">
                                                        <option><?php echo $year ?></option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                    </select>
                                                    <div class="error"><?php echo $year_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Amount<span class="login-danger">*</span></label>
                                                    <input class="form-control select <?php echo $amount_red_border ?>"
                                                        type="text" name="amount" id="checkedCount" readonly>
                                                    <div class="error"><?php echo $amount_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="search-student-btn">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary">Group</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                            <thead class="student-thread">
                                                <tr>
                                                    <th>Select</th>
                                                    <th>No</th>
                                                    <th>Student ID</th>
                                                    <th>Full Name</th>
                                                    <th>Study Program</th>
                                                    <th>Part</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                        if ($students == "No Student!") {  ?>
                                                <tr>
                                                    <td>No Student!</td>
                                                </tr>
                                                <?php } else {
                                                            foreach ($students as $student) {
                                                                    $i++; ?>

                                                <tr>
                                                    <td><input type="checkbox" name="<?php echo 'check'.$i ?>" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $student['std_id'] ?></td>
                                                    <input type="hidden" name="<?php echo $i . 'studentID' ?>"
                                                        value="<?php echo $student['std_id'] ?>">
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <?php
                                                                                $student_image = $student['image'];

                                                                                if ($student_image == '') { ?>
                                                            <a href="student-detail.php?$id=<? $student['id'] ?>"
                                                                class="avatar avatar-sm me-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="<?php echo "upload/profile.png" ?>"
                                                                    alt="User Image"></a>
                                                            <?php } else { ?>
                                                            <a href="student-detail.php?$id=<? $student['id'] ?>"
                                                                class="avatar avatar-sm me-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="<?php echo "upload/student_profile/$student_image" ?>"
                                                                    alt="User Image"></a>
                                                            <?php } ?>



                                                            <?php
                                                                                if ($student['gender'] == 'Male') { ?>
                                                            <a>Mr
                                                                <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                            <?php } else { ?>
                                                            <a>Miss
                                                                <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                            <?php } ?>
                                                        </h2>
                                                    </td>
                                                    <td><?php echo $student['program'] ?></td>
                                                    <td><?php echo $student['part'] ?></td>
                                                </tr>
                                                <?php  
                                                            }
                                                        } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                    <!-- When you edd member by cliked in group will process here -->
                                    <?php } elseif (isset($_GET['std_g_id'])) { ?>
                                    <div class="student-group-form">

                                        <div class="row">
                                            <div class="col-12">
                                                <h5 class="form-title student-info">Group Informations:</h5>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Group ID <span class="login-danger">*</span></label>
                                                    <input
                                                        class="form-control select <?php echo $group_id_red_border ?>"
                                                        type="text" name="group_id"
                                                        value="<?php echo $std_groups['group_id'] ?>" readonly>
                                                    <div class="error"><?php echo $group_id_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Teacher ID<span class="login-danger">*</span></label>
                                                    <input class="form-control select <?php echo $teacher_red_border ?>"
                                                        type="text" name="teacher"
                                                        value="<?php echo $std_groups['t_id'] ?>" readonly>
                                                    <div class="error"><?php echo $teacher_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Year <span class="login-danger">*</span></label>
                                                    <input class="form-control select <?php echo $year_red_border ?>"
                                                        type="text" name="year"
                                                        value="<?php echo $std_groups['year'] ?>" readonly>
                                                    <div class="error"><?php echo $year_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6">
                                                <div class="form-group local-forms">
                                                    <label>Amount<span class="login-danger">*</span></label>
                                                    <input class="form-control select <?php echo $amount_red_border ?>"
                                                        type="text" name="amount" id="checkedCount" readonly>
                                                    <div class="error"><?php echo $amount_err ?></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="search-student-btn">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-primary">Group</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="table-responsive">
                                        <table
                                            class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                            <thead class="student-thread">
                                                <tr>
                                                    <th>Select</th>
                                                    <th>No</th>
                                                    <th>Student ID</th>
                                                    <th>Full Name</th>
                                                    <th>Study Program</th>
                                                    <th>Part</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 0;
                                                    if ($students == "No Student!") {  ?>
                                                <tr>
                                                    <td>No Student!</td>
                                                </tr>

                                                <?php } else {
                                                        foreach ($students as $student) {
                                                                $i++; ?>

                                                <tr>
                                                    <td><input type="checkbox" name="<?php echo 'check'.$i ?>" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $student['std_id'] ?></td>
                                                    <input type="hidden" name="<?php echo $i . 'studentID' ?>"
                                                        value="<?php echo $student['std_id'] ?>">
                                                    <td>
                                                        <h2 class="table-avatar">
                                                            <?php
                                                                            $student_image = $student['image'];

                                                                            if ($student_image == '') { ?>
                                                            <a href="student-detail.php?$id=<? $student['id'] ?>"
                                                                class="avatar avatar-sm me-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="<?php echo "upload/profile.png" ?>"
                                                                    alt="User Image"></a>
                                                            <?php } else { ?>
                                                            <a href="student-detail.php?$id=<? $student['id'] ?>"
                                                                class="avatar avatar-sm me-2"><img
                                                                    class="avatar-img rounded-circle"
                                                                    src="<?php echo "upload/student_profile/$student_image" ?>"
                                                                    alt="User Image"></a>
                                                            <?php } ?>



                                                            <?php
                                                                            if ($student['gender'] == 'Male') { ?>
                                                            <a>Mr
                                                                <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                            <?php } else { ?>
                                                            <a>Miss
                                                                <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                            <?php }
                                                                            ?>
                                                        </h2>
                                                    </td>
                                                    <td><?php echo $student['program'] ?></td>
                                                    <td><?php echo $student['part'] ?></td>
                                                </tr>
                                                <?php } ?>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <footer>
                <p>Copyright © Logos Institute of Foreign Language.</p>
            </footer>
        </div>
    </div>


    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../assets/js/script.js"></script>
    <script>
        function updateCheckedCount() {
            var checkboxes = document.querySelectorAll('.checkbox');
            var checkedCount = 0;

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            document.getElementById("checkedCount").value = checkedCount;
        }
    </script>


</body>

</html>