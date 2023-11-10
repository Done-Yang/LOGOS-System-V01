<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "admin-datas/classroom-db.php";


$classroom = $classroom_err = $classroom_red_border = '';

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $classroomID = getclassroomByID($id, $conn);
        if (isset($_REQUEST['submit'])) {

            $check_classroom = $conn->prepare("SELECT classroom FROM classrooms WHERE classroom = :classroom AND classroom != :classroomID_classroom");
            $check_classroom->bindParam(":classroomID_classroom", $classroomID['classroom']);
            $check_classroom->bindParam(":classroom", $_REQUEST['classroom']);
            $check_classroom->execute();

            if (empty($_REQUEST['classroom'])) {
                $classroom_err = 'classroom is required!';
                $classroom_red_border = 'red_border';
            } elseif ($check_classroom->rowCount() > 0) {
                $classroom_err = 'This classroom is already exsist!';
                $classroom_red_border = 'red_border';
                $classroom = $_REQUEST['classroom'];
            } else {
                $classroom = $_REQUEST['classroom'];
            }

            try {
                if (!empty($classroom)) {
                    try {
                        $sql = "UPDATE classrooms SET classroom=:classroom  WHERE id=:id";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':classroom', $classroom);
                        $stmt->bindParam(':id', $id);
                        $stmt->execute();
                        echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Class Room Update Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";
                        // $_SESSION['success'] = "Successfully Updated classroom year!";
                        header("refresh:2; url=classroom-list.php");
                        exit;
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    $_SESSION['error'] = "Exist empty cell, Pleas check your data again!";
                }
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
                    <div class="row align-items-center">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title"><?php echo $lang['editClassroom'] ?></h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="classroom-list.php"><?php echo $lang['classroom'] ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $lang['editClassroom'] ?></li>
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
                                            <h5 class="form-title student-info"><?php echo $lang['classroomInfo'] ?> <span><a
                                                        href="javascript:;"><i
                                                            class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['classroom'] ?><span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $classroom_red_border ?>"
                                                    type="text" value="<?php echo $classroomID['classroom'] ?>"
                                                    name="classroom">
                                                <div class="error"><?php echo $classroom_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary"><?php echo $lang['update'] ?></button>
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