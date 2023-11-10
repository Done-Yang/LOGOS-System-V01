<?php
session_start();
require_once 'include/config/dbcon.php';
require_once 'include/config/language.php';


if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);
    
    if ($_GET['id']) {
        $id = $_GET['id'];

        $off = getOfficerById($id, $conn);
        $user = officerGetUserById($id, $conn);
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
                            <h3 class="page-title"><?php echo $lang['officer_detail'] ?></h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="officer-list.php"><?php echo $lang['officers'] ?></a></li>
                                <li class="breadcrumb-item active"><?php echo $lang['officer_detail'] ?></li>

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
                                    $officer_image = $off['image'];

                                    if ($officer_image == '') { ?>
                                        <img class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image">
                                    <?php } else { ?>
                                        <img class="avatar-img rounded-circle" src="<?php echo "upload/officer_profile/$officer_image" ?>" alt="User Image">
                                    <?php } ?>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0">
                                        <?php 
                                            if ($off['gender'] == 'Male') { ?>
                                                <p class="col-sm-8"><?php echo $lang['mr'] ?><?php echo $off['fname_en'] . " " . $off['lname_en'] ?></p>
                                            <?php } else { ?>
                                                <p class="col-sm-8"><?php echo $lang['miss'] ?><?php echo $off['fname_en'] . " " . $off['lname_en'] ?></p>
                                            <?php }
                                        ?>
                                    </h4>
                                    <h6 class="text-muted"><?php echo $users['status'] ?></h6>
                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i> <?php echo $off['village_current'].', '.$off['district_current'].', '.$off['province_current'] ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span><?php echo $lang['personal_Details'] ?></span>
                                            <a class="edit-link" href="officer-edit.php?id=<?= $off['off_id'] ?>"><i class="far fa-edit me-1"></i><?php echo $lang['edit'] ?></a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['u_id'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['off_id'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['firstName0001'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['fname_en'] . ' ' . $off['lname_en'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['firstName00001'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['fname_la'] . ' ' . $off['lname_la'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['firstName002'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['fname_ch'] . ' ' . $off['lname_ch'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['date_B'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['dob'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['tell'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['email'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['email'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['whatsapp'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['whatsapp'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['nation'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['nation'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['religion'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['religion'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['ethnicity'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['ethnicity'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['villageE'] ?></p>
                                            <div class="col-sm-9"><?php echo $off['village_birth'].', '.$off['district_birth'].', '.$off['province_birth'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['currentV'] ?></p>
                                            <div class="col-sm-9"><?php echo $off['village_current'].', '.$off['district_current'].', '.$off['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['houseU'] ?></p>
                                            <div class="col-sm-9"><?php echo $off['house_unit'].', '.$off['district_current'].', '.$off['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['house'] ?></p>
                                            <div class="col-sm-9"><?php echo $off['house_no'].', '.$off['district_current'].', '.$off['province_current'] ?></div>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['emergency'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['emergency_tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['emergencyN'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['emergency_name'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['education'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_level1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['graduation'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_branch1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityN'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['univ_name1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityD'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_district1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityP'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_province1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['graduateS'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_season1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['otherE'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_level2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['graduation'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_branch2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityN'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['univ_name2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityD'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_district2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['universityP'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_province2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['graduateS'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['edu_season2'] ?></a></p>
                                        </div>
                                        <!-- <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Employment History:</p>
                                            <p class="col-sm-9"><?php echo $off['employment_history'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Language Proficiency:</p>
                                            <p class="col-sm-9"><?php echo $off['language_proficiency'] ?></a></p>
                                        </div> -->
                                        <!-- <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Talent:</p>
                                            <p class="col-sm-9"><?php echo $off['talent'] ?></a></p>
                                        </div> -->
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['familyM'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['familymatters'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['plans'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['plansforthefuture'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['createAt'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['created_at'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3"><?php echo $lang['updateAt'] ?></p>
                                            <p class="col-sm-9"><?php echo $off['updated_at'] ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span><?php echo $lang['skill'] ?> </span>
                                        </h5>
                                        <div class="skill-tags">
                                            <span><?php echo $off['talent'] ?></span>
                                            <span><?php echo $off['language_proficiency'] ?></span>
                                            <span><?php echo $off['employment_history'] ?></span>
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