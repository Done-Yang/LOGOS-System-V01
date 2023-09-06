<?php
require_once 'include/config/dbcon.php';
session_start();
if (!isset($_SESSION['student_login'])) {
    header('location: ../index.php');
} else {
    if (isset($_SESSION['student_login'])) {
        $id = $_SESSION['student_login'];
        include "student-datas/student-db.php";
        $student = getStudentById($id, $conn);
        $user = studentGetUserById($id, $conn);

        $old_pass = $new_pass = $re_new_pass = '';
        $old_pass_err = $new_pass_err = $re_new_pass_err = '';
        $old_pass_red_border = $new_pass_red_border = $re_new_pass_red_border = '';

        $active_password = $password_page = '';
        $active_about = 'active';
        $about_page = 'show active';

        if (isset($_REQUEST['change_pass'])) {

            $active_password = 'active';
            $password_page = 'show active';

            $active_about = $about_page = '';

            if (empty($_REQUEST['old_pass'])) {
                $old_pass_err = 'Old Password is required!';
                $old_pass_red_border = 'red_border';
            } else {
                $old_pass = $_REQUEST['old_pass'];
            }
            if (empty($_REQUEST['new_pass'])) {
                $new_pass_err = 'New Password is required!';
                $new_pass_red_border = 'red_border';
            } else {
                $new_pass = $_REQUEST['new_pass'];
            }
            if (empty($_REQUEST['re_new_pass'])) {
                $re_new_pass_err = 'Old Password is required!';
                $re_new_pass_red_border = 'red_border';
            } else {
                $re_new_pass = $_REQUEST['re_new_pass'];
            }

            if (!empty($old_pass) && !empty($new_pass) && !empty($re_new_pass)) {
                try {
                    if (password_verify($old_pass, $user['u_pass'])) {
                        if ($new_pass == $re_new_pass) {
                            $passwordHash = password_hash($new_pass, PASSWORD_DEFAULT);
                            // Add User
                            $sql1 = "UPDATE users SET u_pass=:u_pass WHERE u_id = :u_id";
                            $stmt1 = $conn->prepare($sql1);
                            $stmt1->bindParam(':u_id', $id);
                            $stmt1->bindParam(':u_pass', $passwordHash);
                            $stmt1->execute();

                            $_SESSION['success'] = "Change password successfully!";
                            header('location: student-profile.php');
                            exit;
                        } else {
                            $new_pass_red_border = 'red_border';
                            $re_new_pass_err = 'Passwords are not match!';
                            $re_new_pass_red_border = 'red_border';
                        }
                    } else {
                        $old_pass_err = 'Wrong password!';
                        $old_pass_red_border = 'red_border';
                    }
                } catch (Exception $e) {
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

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

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
                        <div class="col">
                            <h3 class="page-title">Profile</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="student-home.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Profile</li>

                            </ul>
                        </div>
                    </div>
                </div>

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
                    <div class="col-md-12">
                        <div class="profile-header">
                            <div class="row align-items-center">
                                <div class="col-auto profile-image">
                                    <a href="#">

                                        <?php $student_image = $student['image'];
                                        if ($student_image == '') { ?>
                                            <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>" alt="User Image">
                                        <?php } else { ?>
                                            <img class="rounded-circle" src="<?php echo "../admin/upload/student_profile/$student_image" ?>" width="31" alt="User Image">
                                        <?php } ?>
                                    </a>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0"><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></h4>
                                    <h6 class="text-muted"><?php echo $user['status'] ?></h6>
                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i> <?php echo $student['village_birth'] . ', ' . $student['district_birth'] . ', ' . $student['province_birth'] ?></div>

                                </div>
                            </div>
                        </div>
                        <div class="profile-menu">
                            <ul class="nav nav-tabs nav-tabs-solid">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $active_about ?>" data-bs-toggle="tab" href="#per_details_tab">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo $active_password ?>" data-bs-toggle="tab" href="#password_tab">Password</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content profile-tab-cont">

                            <div class="tab-pane fade <?php echo $about_page ?>" id="per_details_tab">

                                <div class="row">
                                    <div class="col-lg-9">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Personal Details</span>
                                                    <a class="edit-link" data-bs-toggle="modal" href="#edit_personal_details"><i class="far fa-edit me-1"></i>Edit</a>
                                                </h5>
                                                <div class="row">
                                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Name</p>
                                                    <p class="col-sm-9"><?php echo $student['fname_en'] . ' ' . $student['lname_en'] ?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth</p>
                                                    <p class="col-sm-9"><?php echo $student['dob'] ?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Email ID</p>
                                                    <p class="col-sm-9"><?php echo $student['email'] ?></a></p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Tel</p>
                                                    <p class="col-sm-9"><?php echo $student['tel'] ?></p>
                                                </div>
                                                <div class="row">
                                                    <p class="col-sm-3 text-muted text-sm-end mb-0">Address</p>
                                                    <p class="col-sm-9 mb-0"><?php echo $student['village_birth'] . ', ' . $student['district_birth'] . ', ' . $student['province_birth'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title d-flex justify-content-between">
                                                    <span>Skills </span>
                                                    <a class="edit-link" href="#"><i class="far fa-edit me-1"></i> Edit</a>
                                                </h5>
                                                <div class="skill-tags">
                                                    <span>Html5</span>
                                                    <span>CSS3</span>
                                                    <span>WordPress</span>
                                                    <span>Javascript</span>
                                                    <span>Android</span>
                                                    <span>iOS</span>
                                                    <span>Angular</span>
                                                    <span>PHP</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div id="password_tab" class="tab-pane fade <?php echo $password_page ?>">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Change Password</h5>
                                        <div class="row">
                                            <div class="col-md-10 col-lg-6">
                                                <form>
                                                    <div class="form-group">
                                                        <label>Old Password</label>
                                                        <input type="password" class="form-control <?php echo $old_pass_red_border ?>" name="old_pass" value="<?php echo $old_pass ?>">
                                                        <div class="error"><?php echo $old_pass_err ?></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>New Password</label>
                                                        <input type="password" class="form-control <?php echo $new_pass_red_border ?>" name="new_pass" value="<?php echo $new_pass ?>">
                                                        <div class="error"><?php echo $new_pass_err ?></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Confirm Password</label>
                                                        <input type="password" class="form-control <?php echo $re_new_pass_red_border ?>" name="re_new_pass" value="<?php echo $re_new_pass ?>">
                                                        <div class="error"><?php echo $re_new_pass_err ?></div>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit" name="change_pass">Save Changes</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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


    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>