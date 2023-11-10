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
    $program_err = $season_err = $part_err = $group_id_err = $teacher_err = $year_err = $amount_err = $std_id_err = '';
    $program_red_border = $season_red_border = $part_red_border = $group_id_red_border = $teacher_red_border = $year_red_border = $amount_red_border = '';

    include "admin-datas/student-db.php";
    include "admin-datas/program-db.php";
    include "admin-datas/season-db.php";
   

    if (isset($_POST['clone'])) {
        $group_id = $_REQUEST['group_id'];
        $amount = $_REQUEST['amount'];

        // Count students
        $count_std = $conn->prepare("SELECT COUNT(*) AS count FROM studentgroups WHERE group_id=:group_id");
        $count_std->bindParam(":group_id", $group_id);
        $count_std->execute();
        while ($row = $count_std->fetch(PDO::FETCH_ASSOC)) {
            $count_stds = $row['count'];
        };
        
        if ($count_stds <= 45) {
            try {
                $sql = mysqli_connect("localhost", "root", "", "iater01");
                for ($i = 1; $i <= $amount; $i++) {
                    $studentID = $_REQUEST[$i . 'studentID'];
                    $year = $_REQUEST['year'];

                    $check_duplecate = $conn->prepare("SELECT * FROM studentgroups WHERE group_id=:group_id and std_id=:std_id and year=:year");
                    $check_duplecate->bindParam(':group_id', $group_id);
                    $check_duplecate->bindParam(':std_id', $studentID);
                    $check_duplecate->bindParam(':year', $year);
                    $check_duplecate->execute();
                    
                    $season = $_REQUEST['season'];
                    $program = $_REQUEST['program'];
                    $part = $_REQUEST['part'];
                    $t_id = $_REQUEST['t_id'];
                    
                    if($check_duplecate->rowCount() > 0){
                        $std_id_err = 'Student group is already exsist!';
                    }
                    
                    if(empty($std_id_err)){
                        // For Group student's class
                        mysqli_query($sql, "INSERT INTO studentgroups (group_id, t_id, std_id, program, season, year)
                        VALUES ('$group_id', '$t_id', '$studentID', '$program', '$season', '$year')");

                        // For Student group's status
                        mysqli_query($sql, "UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                    }else{
                        $_SESSION['error'] = 'This student group is already exsist!';
                        echo "<script>
                            $(document).ready(function() {
                                Swal.fire({
                                    title: 'Fail!',
                                    text: 'This student group is exsist!',
                                    icon: 'error',
                                    timer: 5000,
                                    showConfirmButton: false
                                });
                            });
                        </script>";
                        header("refresh:2; url=studentgroup-clone.php?std_g_id=$group_id");
                        exit;   
                    }
                }
                
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Student Group Clone Successfully!',
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
    }

    if (isset($_GET['std_g_id'])) {
        include "admin-datas/studentgroup-db.php";
        include "admin-datas/group-db.php";
        include "admin-datas/teacher-db.php";

        $std_g_id = $_GET['std_g_id'];

        // $students = $conn->prepare("SELECT group_id, students.std_id, fname_en, lname_en, image FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id");
        $students = $conn->prepare("SELECT * FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id WHERE group_id=:group_id");
        $students->bindParam(':group_id', $std_g_id);
        $students->execute();


        $std_groups = getStudentGroupByID($std_g_id, $conn);
        $group_by_id = getGroupByID($std_g_id, $conn);
        $teachers = getAllTeachers($conn);
        $seasons = getAllSeasons($conn);

        $pg = $std_groups['program'];
        $p = $group_by_id['part'];
        $groups = $conn->prepare("SELECT * FROM groups WHERE program='$pg' and part='$p' ");
        $groups->execute();

        // Count students
        $count_std = $conn->prepare("SELECT COUNT(*) AS count FROM studentgroups WHERE group_id=:group_id");
        $count_std->bindParam(":group_id", $std_g_id);
        $count_std->execute();
        while ($row = $count_std->fetch(PDO::FETCH_ASSOC)) {
            $count_std_resault = $row['count'];
        };
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
                                <h3 class="page-title">Clone Students</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="studentgroup-list.php">Groups</a></li>
                                    <li class="breadcrumb-item active">Clone Students</li>
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
                                    <select class="form-control select <?php echo $season_red_border ?>" name="season">
                                        <option><?php echo $std_groups['season'] ?></option>
                                        <?php $i = 0;
                                            foreach ($seasons as $season) {
                                            $i++; ?>
                                            <option> <?php echo $season['season'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="error"><?php echo $season_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Program <span class="login-danger">*</span></label>
                                    <input class="form-control select <?php echo $program_red_border ?>" type="text" name="program" value="<?php echo $std_groups['program'] ?>" readonly>
                                    <div class="error"><?php echo $program_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group local-forms">
                                    <label>Part <span class="login-danger">*</span></label>
                                    <input class="form-control select <?php echo $part_red_border ?>" type="text" name="part" value="<?php echo $group_by_id['part'] ?>" readonly>
                                    <div class="error"><?php echo $part_err ?></div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button name="search" class="btn btn-primary" disabled>Search</button>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
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

                                    <?php if (isset($_GET['std_g_id'])) { ?>
                                        <div class="student-group-form">

                                            <div class="row">
                                                <div class="col-12">
                                                    <h5 class="form-title student-info">Group Informations:</h5>
                                                </div>
                                                <div class="col-lg-2 col-md-6">
                                                    <div class="form-group local-forms">
                                                        <label>Group ID <span class="login-danger">*</span></label>
                                                        <select class="form-control select <?php echo $group_id_red_border ?>" name="group_id">
                                                            <option><?php echo $std_groups['group_id'] ?></option>
                                                            <?php $i = 0;
                                                                foreach ($groups as $group) {
                                                                    $i++; ?>
                                                                    <option value="<?php echo $group['group_id'] ?>">
                                                                        <?php echo $group['group_id'] ?> 
                                                                    </option>
                                                                <?php } ?>
                                                        </select>
                                                        <div class="error"><?php echo $group_id_err ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-6">
                                                    <div class="form-group local-forms">
                                                        <label>Teacher <span class="login-danger">*</span></label>
                                                        <select class="form-control select>" name="t_id">
                                                            <option value="<?php echo $std_groups['t_id'] ?>">
                                                                <?php 
                                                                $th = getTeacherByID($std_groups['t_id'], $conn);
                                                                echo $th['fname_en'].' '.$th['lname_en'] ?>
                                                            </option>
                                                            <?php $i = 0;
                                                            foreach ($teachers as $teacher) {
                                                                $i++; ?>
                                                                <option value="<?php echo $teacher['t_id'] ?>"> <?php echo $teacher['fname_en'].' '.$teacher['lname_en'] ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="error"><?php echo $teacher_err ?></div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-2 col-md-6">
                                                    <div class="form-group local-forms">
                                                        <label>Year <span class="login-danger">*</span></label>
                                                        <select class="form-control select" name="year">
                                                            <option><?php echo $std_groups['year'] ?></option>
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
                                                        <input class="form-control select <?php echo $amount_red_border ?>" type="text" name="amount" value="<?php echo $count_std_resault ?>" readonly>
                                                        <div class="error"><?php echo $amount_err ?></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="search-student-btn">
                                                        <button type="submit" name="clone" class="btn btn-primary">Clone</button>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="table-responsive">
                                            <table
                                                class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                                <thead class="student-thread">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Student ID</th>
                                                        <th>Full Name</th>
                                                        <th>Study Program</th>
                                                        <th>Part</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                     $i = 0;
                                                    foreach ($students as $student) {
                                                        $i++; ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $student['std_id'] ?></td>
                                                            <input type="hidden" name="<?php echo $i . 'studentID' ?>" value="<?php echo $student['std_id'] ?>">
                                                            <td>
                                                                <h2 class="table-avatar">
                                                                    <?php $student_image = $student['image'];

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


</body>

</html>