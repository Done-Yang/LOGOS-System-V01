<?php
require_once 'include/config/dbcon.php';
session_start();
if (!isset($_SESSION['officer_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['officer_login'];
    include "officer-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    if ($_GET['id']) {
        $id = $_GET['id'];

        include "officer-datas/director-db.php";
        $dir = getDirectorById($id, $conn);
        $u = directorGetUserById($id, $conn);
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
                            <h3 class="page-title">Director Detail</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="director-list.php">Directors</a></li>
                                <li class="breadcrumb-item active">Director Detail</li>

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
                                    $director_image = $dir['image'];

                                    if ($director_image == '') { ?>
                                    <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>"
                                        alt="User Image">
                                    <?php } else { ?>
                                    <img class="avatar-img rounded-circle"
                                        src="<?php echo "../admin/upload/officer_profile/$director_image" ?>" alt="User Image">
                                    <?php } ?>
                                </div>
                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0">
                                        <?php
                                        if ($dir['gender'] == 'Male') { ?>
                                        <p class="col-sm-8">Mr <?php echo $dir['fname_en'] . " " . $dir['lname_en'] ?>
                                        </p>
                                        <?php } else { ?>
                                        <p class="col-sm-8">Miss <?php echo $dir['fname_en'] . " " . $dir['lname_en'] ?>
                                        </p>
                                        <?php }
                                        ?>
                                    </h4>
                                    <h6 class="text-muted"><?php echo $u['status'] ?></h6>
                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i>
                                        <?php echo $dir['village_current'] . ', ' . $dir['district_current'] . ', ' . $dir['province_current'] ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <!-- <a class="edit-link" href="director-edit.php?id=<?= $dir['dir_id'] ?>"><i
                                                    class="far fa-edit me-1"></i>Edit</a> -->
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">English Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['fname_en'] . ' ' . $dir['lname_en'] ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Laos Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['fname_la'] . ' ' . $dir['lname_la'] ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Chinese Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['fname_ch'] . ' ' . $dir['lname_ch'] ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Tel:</p>
                                            <p class="col-sm-9"><?php echo $dir['tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">E-mail:</p>
                                            <p class="col-sm-9"><?php echo $dir['email'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Whatsapp:</p>
                                            <p class="col-sm-9"><?php echo $dir['whatsapp'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">National:</p>
                                            <p class="col-sm-9"><?php echo $dir['nation'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Religion:</p>
                                            <p class="col-sm-9"><?php echo $dir['religion'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Ethnicity:</p>
                                            <p class="col-sm-9"><?php echo $dir['ethnicity'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Emergency Tel:</p>
                                            <p class="col-sm-9"><?php echo $dir['emergency_tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Emergency Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['emergency_name'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education Level:</p>
                                            <p class="col-sm-9"><?php echo $dir['edu_level1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Graduation Branch:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_branch1'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['univ_name1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University District:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_district1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Province:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_province1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">University Season:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_season1'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Other Education
                                                Level:</p>
                                            <p class="col-sm-9"><?php echo $dir['edu_level2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Graduation Branch:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_branch2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Univercity Name:</p>
                                            <p class="col-sm-9"><?php echo $dir['univ_name2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education District:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_district2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Education Province:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_province2'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Gradution Season:
                                            </p>
                                            <p class="col-sm-9"><?php echo $dir['edu_season2'] ?></a></p>
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
                                            <span><?php echo $dir['talent'] ?></span>
                                            <span><?php echo $dir['language_proficiency'] ?></span>
                                            <span><?php echo $dir['employment_history'] ?></span>
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