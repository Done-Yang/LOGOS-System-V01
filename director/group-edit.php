<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/officer-db.php";
    include "director-datas/director-db.php";
    $user = directorGetUserById($id, $conn);
    $director = getDirectorById($id, $conn);
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $program = $season = $part = $group_id = $year = '';
        $program_err = $season_err = $part_err = $group_id_err = $year_err = '';
        $program_red_border = $season_red_border = $part_red_border = $group_id_red_border = $year_red_border = '';

        include "director-datas/student-db.php";
        include "director-datas/program-db.php";
        include "director-datas/season-db.php";
        include "director-datas/group-db.php";
        $programs = getAllPrograms($conn);
        $seasons = getLastSeason($conn);
        $group = getGroupByID($id, $conn);

        #Check group id is exist or not
        $check_group = $conn->prepare("SELECT group_id FROM groups WHERE group_id = :group_id and group_id != :this_group_id");
        $check_group->bindParam(":group_id", $_REQUEST['group_id']);
        $check_group->bindParam(":this_group_id", $group['group_id']);
        $check_group->execute();


        if (isset($_POST['submit'])) {

            if (empty($_REQUEST['group_id'])) {
                $group_id_err = 'Group ID is required!';
                $group_id_red_border = 'red_border';
            } elseif ($check_group->rowCount() > 0) {
                $group_id_err = 'The Group ID is writen already exist!';
                $group_id_red_border = 'red_border';
            } else {
                $group_id = $_REQUEST['group_id'];
            }
            if (empty($_REQUEST['program'])) {
                $program_err = 'Program is required!';
                $program_red_border = 'red_border';
            } else {
                $program = $_REQUEST['program'];
            }
            if (empty($_REQUEST['part'])) {
                $part_err = 'Part is required!';
                $part_red_border = 'red_border';
            } else {
                $part = $_REQUEST['part'];
            }
            if (empty($_REQUEST['season'])) {
                $season_err = 'Season ID is required!';
                $season_red_border = 'red_border';
            } else {
                $season = $_REQUEST['season'];
            }
            if (empty($_REQUEST['year'])) {
                $year_err = 'Year is required!';
                $year_red_border = 'red_border';
            } else {
                $year = $_REQUEST['year'];
            }

            if (!empty($season) and !empty($program) and !empty($part) and !empty($group_id) and !empty($year) and empty($group_id_err)) {

                try {

                    // For Group student's class
                    $stmt = $conn->prepare("UPDATE groups SET program=:program, part=:part, season=:season, year=:year WHERE group_id = :group_id");
                    $stmt->bindParam(":program", $program);
                    $stmt->bindParam(":part", $part);
                    $stmt->bindParam(":season", $season);
                    $stmt->bindParam(":year", $year);
                    $stmt->bindParam(":group_id", $group_id);

                    $stmt->execute();

                    // $_SESSION['success'] = "Update group successfuly.";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Group Update Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header('refresh:2; url=group-list.php');
                    exit;
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            } else {
                $_SESSION['error'] = "Something went wrong with any cell, Pleas check your data again!";
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
                                <h3 class="page-title">Update Group</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="group-list.php">Groups</a></li>
                                    <li class="breadcrumb-item active">Update Group</li>
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
                                            <h5 class="form-title student-info">Group Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Group ID<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $group_id_red_border ?>" type="text" name="group_id" value="<?php echo $group['group_id'] ?>" readonly>
                                                <div class="error"><?php echo $group_id_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Season <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $season_red_border ?>" name="season">
                                                    <option><?php echo $group['season'] ?></option>
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
                                                    <option><?php echo $group['program'] ?></option>
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
                                                <label>Part <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $part_red_border ?>" name="part">
                                                    <option><?php echo $group['part'] ?></option>
                                                    <option>Morning</option>
                                                    <option>Afternoon</option>
                                                    <option>Evening</option>
                                                </select>
                                                <div class="error"><?php echo $part_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Year <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $year_red_border ?>" name="year">
                                                    <option><?php echo $group['year'] ?></option>
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