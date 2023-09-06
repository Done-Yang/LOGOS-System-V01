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
    
    if ($_GET['id']) {
        $id = $_GET['id'];

        include "director-datas/teacher-db.php";
        $t = getTeacherById($id, $conn);
        $u = teacherGetUserById($id, $conn);
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
                            <h3 class="page-title">Teacher Detail</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="teacher-list.php">Teachers</a></li>
                                <li class="breadcrumb-item active">Teacher Detail</li>

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
                                    <?php
                                    $teacher_image = $t['image'];

                                    if ($teacher_image == '') { ?>
                                        <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>" alt="User Image">
                                    <?php } else { ?>
                                        <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/teacher_profile/$teacher_image" ?>" alt="User Image">
                                    <?php } ?>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0">
                                        <?php 
                                            if ($t['gender'] == 'Male') { ?>
                                                <p class="col-sm-8">Mr <?php echo $t['fname_en'] . " " . $t['lname_en'] ?></p>
                                            <?php } else { ?>
                                                <p class="col-sm-8">Miss <?php echo $t['fname_en'] . " " . $t['lname_en'] ?></p>
                                            <?php }
                                        ?>
                                    </h4>
                                    <h6 class="text-muted"><?php echo $users['status'] ?></h6>
                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i> <?php echo $t['village_current'].', '.$t['district_current'].', '.$t['province_current'] ?></div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" href="teacher-edit.php?id=<?= $t['t_id'] ?>"><i class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Teacher ID:</p>
                                            <p class="col-sm-9"><?php echo $t['t_id'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Teacher Status:</p>
                                            <p class="col-sm-9"><?php echo $t['t_status'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">English Name:</p>
                                            <p class="col-sm-9"><?php echo $t['fname_en'] . ' ' . $t['lname_en'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Laos Name:</p>
                                            <p class="col-sm-9"><?php echo $t['fname_la'] . ' ' . $t['lname_la'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Chinese Name:</p>
                                            <p class="col-sm-9"><?php echo $t['fname_ch'] . ' ' . $t['lname_ch'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Teacher Type:</p>
                                            <p class="col-sm-9"><?php echo $t['t_type'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth:</p>
                                            <p class="col-sm-9"><?php echo $t['dob'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Tel:</p>
                                            <p class="col-sm-9"><?php echo $t['tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">E-mail:</p>
                                            <p class="col-sm-9"><?php echo $t['email'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Whatsapp:</p>
                                            <p class="col-sm-9"><?php echo $t['whatsapp'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">National:</p>
                                            <p class="col-sm-9"><?php echo $t['nation'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Religion:</p>
                                            <p class="col-sm-9"><?php echo $t['religion'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Ethnicity:</p>
                                            <p class="col-sm-9"><?php echo $t['ethnicity'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Birth Adress:</p>
                                            <div class="col-sm-9"><?php echo $t['village_birth'].', '.$t['district_birth'].', '.$t['province_birth'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Current Adress:</p>
                                            <div class="col-sm-9"><?php echo $t['village_current'].', '.$t['district_current'].', '.$t['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">House Unit:</p>
                                            <div class="col-sm-9"><?php echo $t['house_unit'].', '.$t['district_current'].', '.$t['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">House No:</p>
                                            <div class="col-sm-9"><?php echo $t['house_no'].', '.$t['district_current'].', '.$t['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Emergency Tel:</p>
                                            <p class="col-sm-9"><?php echo $t['emergency_tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Emergency Name:</p>
                                            <p class="col-sm-9"><?php echo $t['emergency_name'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education Level:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_level1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Graduation Branch:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_branch1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Name:</p>
                                            <p class="col-sm-9"><?php echo $t['univ_name1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University District:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_district1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Province:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_province1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Season:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_season1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Other Education Level:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_level2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Graduation Branch:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_branch2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Univercity Name:</p>
                                            <p class="col-sm-9"><?php echo $t['univ_name2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education District:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_district2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education Province:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_province2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Gradution Season:</p>
                                            <p class="col-sm-9"><?php echo $t['edu_season2'] ?></a></p>
                                        </div>
                                        <!-- <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Employment History:</p>
                                            <p class="col-sm-9"><?php echo $t['employment_history'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Language Proficiency:</p>
                                            <p class="col-sm-9"><?php echo $t['language_proficiency'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Talent:</p>
                                            <p class="col-sm-9"><?php echo $t['talent'] ?></a></p>
                                        </div> -->
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Family Matters:</p>
                                            <p class="col-sm-9"><?php echo $t['familymatters'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Plan In The Future:</p>
                                            <p class="col-sm-9"><?php echo $t['plansforthefuture'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Creat At:</p>
                                            <p class="col-sm-9"><?php echo $t['created_at'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Last Update:</p>
                                            <p class="col-sm-9"><?php echo $t['updated_at'] ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Skills </span>
                                            
                                        </h5>
                                        <div class="skill-tags">
                                            <span><?php echo $t['employment_history'] ?></span>
                                            <span><?php echo $t['language_proficiency'] ?></span>
                                            <span><?php echo $t['talent'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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