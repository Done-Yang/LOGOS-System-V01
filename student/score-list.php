<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['student_login'])) {
    header('location: ../index.php');
    exit;
} else {
    include "student-datas/subject-db.php";
    include "student-datas/student-db.php";
    include "student-datas/group-db.php";

    // for header and sidebar info
    $id = $_SESSION['student_login'];
    $student = getStudentById($id, $conn);
    $user = studentGetUserById($id, $conn);

    //select group of student study in
    $std_groups = $conn->prepare("SELECT * FROM scores where std_id='$id' ");
    $std_groups->execute();
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
                                <h3 class="page-title">Student Scores</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="score-list.php">Scores</a></li>
                                    <li class="breadcrumb-item active">Student Scores</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="student-group-form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search here ..." name="search_by">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div> -->

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
                                            <h3 class="page-title">Groups</h3>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th>Group</th>
                                                <th>Program</th>
                                                <th>Year</th>
                                                <th>Semester</th>
                                                <th>Season Year</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            $group_check = array();
                                            foreach ($std_groups as $std_group) {
                                                if ($std_group['std_id'] == $id and !in_array($std_group['group_id'].$std_group['semester'], $group_check)) {
                                                    array_push($group_check, $std_group['group_id'].$std_group['semester']);
                                                    $i++;
                                                    $group = getGroupByID($std_group['group_id'], $conn);?>
                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $std_group['group_id'] ?></td>
                                                        <td><?php echo $group['program'] ?></td>
                                                        <td><?php echo $group['year'] ?></td>
                                                        <td><?php echo $std_group['semester'] ?></td>
                                                        <td><?php echo $std_group['season'] ?></td>
                                                        <td class="text-end">
                                                            <div class="actions ">
                                                                <a href="score-detail.php?group_id=<?= $std_group['group_id'] ?>&semester=<?= $std_group['semester'] ?>" class="btn btn-sm bg-success-light me-2 ">
                                                                    <i class="feather-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php } ?>

                                            <?php } ?>

                                        </tbody>
                                    </table>
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

    <script src="../assets/plugins/select2/js/select2.min.js"></script>

    <script src="../assets/plugins/moment/moment.min.js"></script>
    <script src="../assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>