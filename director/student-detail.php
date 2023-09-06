<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/director-db.php";
    $user = directorGetUserById($id, $conn);
    $director = getDirectorById($id, $conn);

    if ($_GET['id']) {
        $id = $_GET['id'];

        include "director-datas/student-db.php";
        $std = getStudentById($id, $conn);
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
    <link rel="stylesheet" href="../assets/css/print-style.css" media='print'>
</head>

<body>

    <div class="main-wrapper">

        <div id="print-btn">
            <?php
                include "include/header.php";
                include "include/sidebar.php";
            ?>
        </div>

        <div class="page-wrapper">
            <div class="content container-fluid">
                <div id="pint-btn">
                    <div class="page-header" id="print-btn">
                        <div class="row">
                            <div class="col">
                                <h3 class="page-title">Student Detail</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="student-list.php">Student</a></li>
                                    <li class="breadcrumb-item active">Student Detail</li>

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
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-header" id="print-btn">
                            <div class="row align-items-center">

                                <?php
                                $student_image = $std['image'];

                                if ($student_image == '') { ?>
                                    <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/profile.png" ?>" alt="User Image">
                                <?php } else { ?>
                                    <img class="avatar-img rounded-circle" src="<?php echo "../admin/upload/student_profile/$student_image" ?>" alt="User Image">
                                <?php } ?>

                                <div class="col ms-md-n2 profile-user-info">
                                    <h4 class="user-name mb-0"><?php echo $std['fname_en'] . ' ' . $std['lname_en'] ?></h4>
                                    <h6 class="text-muted"><?php echo $std['std_status'] ?></h6>
                                    <div class="user-Location"><i class="fas fa-map-marker-alt"></i><?php echo $std['village_birth'] . ', ' . $std['district_birth'] . ', ' . $std['province_birth'] ?></div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-7" id="print-btn">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title d-flex justify-content-between">
                                            <span>Personal Details</span>
                                            <a class="edit-link" href="student-edit.php?id=<?= $std['std_id'] ?>"><i class="far fa-edit me-1"></i>Edit</a>
                                        </h5>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Student ID:</p>
                                            <p class="col-sm-9"><?php echo $std['std_id'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Group:</p>
                                            <p class="col-sm-9"><?php echo $std['group_status'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">English Name:</p>
                                            <p class="col-sm-9"><?php echo $std['fname_en'] . ' ' . $std['lname_en'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Laos Name:</p>
                                            <p class="col-sm-9"><?php echo $std['fname_la'] . ' ' . $std['lname_la'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Chinese Name:</p>
                                            <p class="col-sm-9"><?php echo $std['fname_ch'] . ' ' . $std['lname_ch'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Program Of Study:</p>
                                            <p class="col-sm-9"><?php echo $std['program'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Season Start:</p>
                                            <p class="col-sm-9"><?php echo $std['season_start'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Date of Birth:</p>
                                            <p class="col-sm-9"><?php echo $std['dob'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Birth Adress:</p>
                                            <p class="col-sm-9"><?php echo $std['village_birth'] . ', ' . $std['district_birth'] . ', ' . $std['province_birth'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">National:</p>
                                            <p class="col-sm-9"><?php echo $std['nation'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Religion:</p>
                                            <p class="col-sm-9"><?php echo $std['religion'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Ethnicity:</p>
                                            <p class="col-sm-9"><?php echo $std['ethnicity'] ?></a></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0">Current Address:</p>
                                            <p class="col-sm-9 mb-0"><?php echo $std['village_current'] . ', ' . $std['district_current'] . ', ' . $std['province_current'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0">House unit:</p>
                                            <p class="col-sm-9 mb-0"><?php echo $std['house_unit'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0">House no:</p>
                                            <p class="col-sm-9 mb-0"><?php echo $std['house_no'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Tel:</p>
                                            <p class="col-sm-9"><?php echo $std['tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Guadian's Tel:</p>
                                            <p class="col-sm-9"><?php echo $std['guardian_tel'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">High school:</p>
                                            <p class="col-sm-9"><?php echo $std['highschool'] ?></p>
                                        </div>
                                        <!-- <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Year:</p>
                                            <p class="col-sm-9"><?php echo $std_g['year'] ?></p>
                                        </div> -->
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Part:</p>
                                            <p class="col-sm-9"><?php echo $std['part'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Emplayment History:</p>
                                            <p class="col-sm-9"><?php echo $std['employment_history'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Language Proficiency:</p>
                                            <p class="col-sm-9"><?php echo $std['language_proficiency'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Family Matters:</p>
                                            <p class="col-sm-9"><?php echo $std['familymatters'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Plans For future:</p>
                                            <p class="col-sm-9"><?php echo $std['plansforthefuture'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Guadian's Phone Number:</p>
                                            <p class="col-sm-9"><?php echo $std['ethnicity'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Creat At:</p>
                                            <p class="col-sm-9"><?php echo $std['created_at'] ?></p>
                                        </div>
                                        <div class="row">
                                            <p class="col-sm-3 text-muted text-sm-end mb-0 mb-sm-3">Last Update:</p>
                                            <p class="col-sm-9"><?php echo $std['updated_at'] ?></p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="card ">
                                    <div class="card-body ">
                                        <!-- <div class="table-responsive "> -->
                                            <div class="row">
                                                <div class="col">
                                                    <span><b>Student Card</b></span>
                                                </div>
                                                <div class="col-auto text-end float-end ms-auto">
                                                <button onclick="window.print();" class="btn btn-primary" id="print-btn"><i class="fas fa-print"></i></button>
                                                </div>
                                            </div><br>

                                            <table class="table-bordered  small mb-5 ">
                                                <tr>
                                                    <td rowspan="7" class="col-4 text-center border border-dark">

                                                        <p>photo</p>
                                                        <p>3 X 4</p>
                                                       
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td class="p-1 col-4 border border-dark"><?php echo $std['std_id'] ?></td>
                                                    <td class="p-1 border border-dark"><?php echo $std['dob'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="p-1  border border-dark"><?php echo $std['fname_la'] ?></td>
                                                    <td class="p-1 border border-dark"><?php echo $std['lname_la'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="p-1 border border-dark"><?php echo $std['fname_en'] ?></td>
                                                    <td class="p-1 border border-dark"><?php echo $std['lname_en'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="p-1 border border-dark"><?php echo $std['fname_ch'] ?></td>
                                                    <td class="p-1 border border-dark"><?php echo $std['lname_ch'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="p-1 border border-dark"><?php echo $std['tel'] ?></td>
                                                    <td class="p-1 border border-dark"><?php echo $std['province_birth'] ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center border border-dark" colspan="2"><?php echo $std['email'] ?></td>
                                                    
                                                </tr>
                                                   
                                                
                                                
                                            </table>
                                        <!-- </div> -->
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