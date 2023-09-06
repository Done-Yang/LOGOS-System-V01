<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "director-datas/program-db.php";


$prog_id = $prog_id_err = $prog_id_red_border = '';
$program = $program_err = $program_red_border = '';
$total_year = $total_year_err = $total_year_red_border = '';

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
        $program = getProgramByID($id, $conn);
        if (isset($_REQUEST['submit'])) {

            if (empty($_REQUEST['program'])) {
                $program_err = 'Program is required!';
                $program_red_border = 'red_border';
            } else {
                $program = $_REQUEST['program'];
            }

            if (empty($_REQUEST['total_year'])) {
                $total_year_err = 'Total year is required!';
                $total_year_red_border = 'red_border';
            } else {
                $total_year = $_REQUEST['total_year'];
            }

            if (!empty($program) and !empty($total_year)) {
                try {

                    $sql = "UPDATE programs SET program=:program, total_year=:total_year  WHERE id=:id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':program', $program);
                    $stmt->bindParam(':total_year', $total_year);
                    $stmt->execute();
                    // $_SESSION['success'] = "Successfully Updated Programd!";
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Program Updated Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                    header("refresh:2; url=program-list.php");
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
                                <h3 class="page-title">Edit Program</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="program-list.php">Program</a></li>
                                    <li class="breadcrumb-item active">Edit Programs</li>
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
                                    <?php if (isset($_SESSION['error'])) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php
                                            echo $_SESSION['error'];
                                            unset($_SESSION['error']);
                                            ?>
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

                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="form-title student-info">Program Information <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Program<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $program_red_border ?>" type="text" name="program" value="<?php echo $program['program'] ?>">
                                                <div class="error"><?php echo $program_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Total Year<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $total_year_red_border ?>" type="text" name="total_year" value="<?php echo $program['total_year'] ?>">
                                                <div class="error"><?php echo $total_year_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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