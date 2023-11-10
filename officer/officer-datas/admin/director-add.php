<?php
session_start();
require_once 'include/config/dbcon.php';
require_once 'include/config/language.php';



$u_id = $fname_en = $lname_en = $gender = $fname_la = $lname_la = $tel = $email = '';

$u_id_err = $fname_en_err = $lname_en_err = $gender_err = $fname_la_err = $lname_la_err = $tel_err = $email_err = '';

$u_id_red_border = $fname_en_red_border = $lname_en_red_border = $gender_red_border = $fname_la_red_border = $lname_la_red_border = $tel_red_border = $email_red_border = '';

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    // Select The E-mail in Database For Check
    $check_u_id = $conn->prepare("SELECT u_id FROM users WHERE u_id = :u_id");
    $check_u_id->bindParam(":u_id", $_REQUEST['u_id']);
    $check_u_id->execute();

    $check_u_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
    $check_u_email->bindParam(":email", $_REQUEST['email']);
    $check_u_email->execute();


    // Select Directors data in Database For Check
    $check_tel = $conn->prepare("SELECT tel FROM users WHERE tel = :tel");
    $check_tel->bindParam(":tel", $_REQUEST['tel']);
    $check_tel->execute();

    if (isset($_REQUEST['submit'])) {
        try {
            if (empty($_REQUEST['u_id'])) {
                $u_id_err = 'User ID is required!';
                $u_id_red_border = 'red_border';
            } elseif ($check_u_id->rowCount() > 0) {
                $u_id_err = 'This User ID is already exsist!';
                $u_id_red_border = 'red_border';
                $u_id = $_REQUEST['u_id'];
            } else {
                $u_id = $_REQUEST['u_id'];
            }

            if (empty($_REQUEST['fname_en'])) {
                $fname_en_err = 'First name in English is required!';
                $fname_en_red_border = 'red_border';
            } else {
                $fname_en = $_REQUEST['fname_en'];
            }

            if (empty($_REQUEST['lname_en'])) {
                $lname_en_err = 'Last name in English is required!';
                $lname_en_red_border = 'red_border';
            } else {
                $lname_en = $_REQUEST['lname_en'];
            }

            if (empty($_REQUEST['gender'])) {
                $gender_err = 'Gender is required!';
                $gender_red_border = 'red_border';
            } else {
                $gender = $_REQUEST['gender'];
            }

            if (empty($_REQUEST['fname_la'])) {
                $fname_la_err = 'First name in Laos is required!';
                $fname_la_red_border = 'red_border';
            } else {
                $fname_la = $_REQUEST['fname_la'];
            }

            if (empty($_REQUEST['lname_la'])) {
                $lname_la_err = 'Last name in Laos is required!';
                $lname_la_red_border = 'red_border';
            } else {
                $lname_la = $_REQUEST['lname_la'];
            }

            if (empty($_REQUEST['tel'])) {
                $tel_err = 'Tel is required!';
                $tel_red_border = 'red_border';
            } elseif ($check_tel->rowCount() > 0) {
                $tel_err = 'This Tel is already exsist!';
                $tel_red_border = 'red_border';
                $tel = $_REQUEST['tel'];
            } else {
                $tel = $_REQUEST['tel'];
            }

            if (empty($_REQUEST['email'])) {
                $email_err = 'E-mail is required!';
                $email_red_border = 'red_border';
            } elseif ($check_u_email->rowCount() > 0) {
                $email_err = 'This E-mail is already exist!';
                $email_red_border = 'red_border';
                $email = $_REQUEST['email'];
            } elseif (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format!";
                $email_red_border = 'red_border';
                $email = $_REQUEST['email'];
            } else {
                $email = $_REQUEST['email'];
            }

            $status = 'Director';

            if (
                !empty($u_id) and !empty($fname_en) and !empty($lname_en) and !empty($gender) and !empty($fname_la) and
                !empty($lname_la) and !empty($tel) and !empty($email)
            ) {

                $passwordHash = password_hash($u_id, PASSWORD_DEFAULT);
                // Add User
                $stmt1 = $conn->prepare('INSERT INTO users(u_id, email, tel, u_pass, status) 
                                                            VALUES (:u_id, :email, :tel, :u_pass, :status)');
                $stmt1->bindParam(':u_id', $u_id);
                $stmt1->bindParam(':email', $email);
                $stmt1->bindParam(':tel', $tel);
                $stmt1->bindParam(':u_pass', $passwordHash);
                $stmt1->bindParam(':status', $status);

                // Add Director
                $stmt2 = $conn->prepare('INSERT INTO directors(dir_id, u_id, fname_en, lname_en, fname_la, lname_la, gender, tel, email) 
                                    VALUES(:dir_id, :u_id, :fname_en, :lname_en, :fname_la, :lname_la, :gender, :tel, :email)');

                $stmt2->bindParam(':dir_id', $u_id);
                $stmt2->bindParam(':u_id', $u_id);
                $stmt2->bindParam(':fname_en', $fname_en);
                $stmt2->bindParam(':lname_en', $lname_en);
                $stmt2->bindParam(':fname_la', $fname_la);
                $stmt2->bindParam(':lname_la', $lname_la);
                $stmt2->bindParam(':gender', $gender);
                $stmt2->bindParam(':tel', $tel);
                $stmt2->bindParam(':email', $email);

                $stmt1->execute();
                $stmt2->execute();

                header("location: director-bill-preview.php?id=$u_id");
                exit;
            } else {
                $_SESSION['error'] = "Something went wrong with any cell, Please check your data again!";
            }
        } catch (PDOException $e) {
            $e->getMessage();
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
                                <h3 class="page-title"><?php echo $lang['add_dir'] ?></h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="director-list.php"><?php echo $lang['director'] ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $lang['add_dir'] ?></li>
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
                                            <h5 class="form-title student-info"><?php echo $lang['dir_info'] ?> <span><a
                                                        href="javascript:;"><i
                                                            class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['u_id'] ?> <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $u_id_red_border ?>" type="text"
                                                    name="u_id" value="<?php echo $u_id ?>">
                                                <div class="error"><?php echo $u_id_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['firstName'] ?> <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $fname_en_red_border ?>"
                                                    type="text" name="fname_en" value="<?php echo $fname_en ?>">
                                                <div class="error"><?php echo $fname_en_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['lastName'] ?> <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $lname_en_red_border ?>"
                                                    type="text" name="lname_en" value="<?php echo $lname_en ?>">
                                                <div class="error"><?php echo $lname_en_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['gender'] ?> <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $gender_red_border ?>"
                                                    name="gender">
                                                    <option><?php echo $gender ?></option>
                                                    <option><?php echo $lang['male'] ?></option>
                                                    <option><?php echo $lang['female'] ?></option>
                                                </select>
                                                <div class="error"><?php echo $gender_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['firstName01'] ?> <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $fname_la_red_border ?>"
                                                    type="text" name="fname_la" value="<?php echo $fname_la ?>">
                                                <div class="error"><?php echo $fname_la_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['lastName01'] ?><span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $lname_la_red_border ?>"
                                                    type="text" name="lname_la" value="<?php echo $lname_la ?>">
                                                <div class="error"><?php echo $lname_la_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['phone'] ?> <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $tel_red_border ?>" type="text"
                                                    name="tel" value="<?php echo $tel ?>">
                                                <div class="error"><?php echo $tel_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label><?php echo $lang['email'] ?> <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $email_red_border ?>" type="text"
                                                    name="email" value="<?php echo $email ?>">
                                                <div class="error"><?php echo $email_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary"><?php echo $lang['submit'] ?></button>
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