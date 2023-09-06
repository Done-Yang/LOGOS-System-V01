<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "director-datas/teacher-db.php";

// For Student Details
$u_id = $fname_en = $lname_en = $fname_la = $lname_la = $fname_ch = $lname_ch = $gender = $dob = $village_birth = $district_birth = $province_birth = $emergency_tel = $emergency_name = $edu_level1 = $edu_branch1 = $univ_name1 = $edu_district1 = $edu_province1 = $edu_level2 = $edu_branch2 = $univ_name2 = $edu_district2 = $edu_province2 = $status = '';
$tel = $whatsapp = $email = $village_current = $district_current = $province_current = $t_type = $ethnicity = $nation = $religion = $house_unit = $house_no = $image_file = '';
$highschool = $edu_season1 = $edu_season2 = '';
$employment_history = $talent = $language_proficiency = $familymatters = $plansforthefuture = '';


$u_id_err = $fname_en_err = $lname_en_err = $fname_la_err = $lname_la_err = $fname_ch_err = $lname_ch_err = $gender_err = $dob_err = $village_birth_err = $district_birth_err = $province_birth_err = $emergency_tel_err = $emergency_name_err = $edu_level1_err = $edu_branch1_err = $univ_name1_err = $edu_district1_err = $edu_province1_err = $status_err = '';
$tel_err = $whatsapp_err = $email_err = $village_current_err = $district_current_err = $province_current_err = $t_type_err = $ethnicity_err = $nation_err = $religion_err = $house_unit_err = $house_no_err = $image_file_err = '';
$highschool_err = $edu_season1_err = '';


$u_id_red_border = $fname_en_red_border = $lname_en_red_border = $fname_la_red_border = $lname_la_red_border = $fname_ch_red_border = $lname_ch_red_border = $gender_red_border = $dob_red_border = $village_birth_red_border = $district_birth_red_border = '';
$province_birth_red_border = $emergency_tel_red_border = $emergency_name_red_border = $edu_level1_red_border = $edu_branch1_red_border = $univ_name1_red_border = $edu_district1_red_border = $edu_province1_red_border = $status_red_border = $tel_red_border = $whatsapp_red_border = $email_red_border = $village_current_red_border = $district_current_red_border = $province_current_red_border = '';
$t_type_red_border = $ethnicity_red_border = $nation_red_border = $religion_red_border = $house_unit_red_border = $house_no_red_border = $image_file_red_border = '';
$highschool_red_border = $edu_season1_red_border = '';



if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/officer-db.php";
    include "director-datas/director-db.php";
    $user = directorGetUserById($id, $conn);
    $director = getDirectorById($id, $conn);
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $teacher = getTeacherById($id, $conn);
        $t_row = getTeacherById($id, $conn);
        $u = teacherGetUserById($id, $conn);

        if (isset($_REQUEST['submit'])) {
            try {
                // Select The E-mail in Database For Check
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email AND email != :this_email");
                $check_email->bindParam(":this_email", $user['email']);
                $check_email->bindParam(":email", $_REQUEST['email']);
                $check_email->execute();


                // Select Teacher data in Database For Check
                $check_tel = $conn->prepare("SELECT tel FROM users WHERE tel = :tel AND tel != :this_tel");
                $check_tel->bindParam(":this_tel", $user['tel']);
                $check_tel->bindParam(":tel", $_REQUEST['tel']);
                $check_tel->execute();

                $check_whatsapp = $conn->prepare("SELECT whatsapp FROM teachers WHERE whatsapp = :whatsapp AND whatsapp != :this_whatsapp");
                $check_whatsapp->bindParam(":this_whatsapp", $teacher['whatsapp']);
                $check_whatsapp->bindParam(":whatsapp", $_REQUEST['whatsapp']);
                $check_whatsapp->execute();

                if (empty($_REQUEST["u_id"])) {
                    $u_id_err = 'User ID is required!';
                    $u_id_red_border = 'red_border';
                } else {
                    $u_id = $_REQUEST['u_id'];
                }

                if (empty($_REQUEST["fname_en"])) {
                    $fname_en_err = 'First name in English is required!';
                    $fname_en_red_border = 'red_border';
                } else {
                    $fname_en = $_REQUEST['fname_en'];
                }

                if (empty($_REQUEST["lname_en"])) {
                    $lname_en_err = 'Last name in English is required!';
                    $lname_en_red_border = 'red_border';
                } else {
                    $lname_en = $_REQUEST['lname_en'];
                }

                if (empty($_REQUEST["gender"])) {
                    $gender_err = 'Gender is required!';
                    $gender_red_border = 'red_border';
                } else {
                    $gender = $_REQUEST['gender'];
                }

                if (empty($_REQUEST["fname_la"])) {
                    $fname_la_err = 'First name in Laos is required!';
                    $fname_la_red_border = 'red_border';
                } else {
                    $fname_la = $_REQUEST['fname_la'];
                }

                if (empty($_REQUEST["lname_la"])) {
                    $lname_la_err = 'Last name in Laos is required!';
                    $lname_la_red_border = 'red_border';
                } else {
                    $lname_la = $_REQUEST['lname_la'];
                }

                if (empty($_REQUEST["t_type"])) {
                    $t_type_err = 'Program of studying is required!';
                    $t_type_red_border = 't_type';
                } else {
                    $t_type = $_REQUEST['t_type'];
                }

                if (empty($_REQUEST["fname_ch"])) {
                    $fname_ch_err = 'First name in Chiness is required!';
                    $fname_ch_red_border = 'red_border';
                } else {
                    $fname_ch = $_REQUEST['fname_ch'];
                }

                if (empty($_REQUEST["lname_ch"])) {
                    $lname_ch_err = 'Last asrname in Chiness is required!';
                    $lname_ch_red_border = 'red_border';
                } else {
                    $lname_ch = $_REQUEST['lname_ch'];
                }

                if (empty($_REQUEST["dob"])) {
                    $dob_err = 'Date of birth is required!';
                    $dob_red_border = 'red_border';
                } else {
                    $dob = $_REQUEST['dob'];
                }

                if (empty($_REQUEST["nation"])) {
                    $nation_err = 'Nation is required!';
                    $nation_red_border = 'red_border';
                } else {
                    $nation = $_REQUEST['nation'];
                }

                if (empty($_REQUEST["religion"])) {
                    $religion_err = 'Religion is required!';
                    $religion_red_border = 'red_border';
                } else {
                    $religion = $_REQUEST['religion'];
                }

                if (empty($_REQUEST["ethnicity"])) {
                    $ethnicity_err = 'Ethnicity is required!';
                    $ethnicity_red_border = 'red_border';
                } else {
                    $ethnicity = $_REQUEST['ethnicity'];
                }

                if (empty($_REQUEST["tel"])) {
                    $tel_err = 'Phone number is required!';
                    $tel_red_border = 'red_border';
                } elseif ($check_tel->rowCount() > 0) {
                    $whatsapp_err = 'Phone number is writen already exist!';
                    $whatsapp_red_border = 'red_border';
                } else {
                    $tel = $_REQUEST['tel'];
                }

                if (empty($_REQUEST["whatsapp"])) {
                    $whatsapp_err = 'Whatsapp namber is required!';
                    $whatsapp_red_border = 'red_border';
                } elseif ($check_whatsapp->rowCount() > 0) {
                    $whatsapp_err = 'Whatsapp namber is writen already exist!';
                    $whatsapp_red_border = 'red_border';
                } else {
                    $whatsapp = $_REQUEST['whatsapp'];
                }

                if (empty($_REQUEST["email"])) {
                    $email_err = 'E-mail is required!';
                    $email_red_border = 'red_border';
                } elseif (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                    $email_err = "Invalid email format, please add @!";
                    $email_red_border = 'red_border';
                    $email = $_REQUEST['email'];
                } elseif ($check_email->rowCount() > 0) {
                    $whatsapp_err = 'E-mail is writen already exist!';
                    $whatsapp_red_border = 'red_border';
                } else {
                    $email = $_REQUEST['email'];
                }

                if (empty($_REQUEST["emergency_tel"])) {
                    $emergency_tel_err = "Emergency contact number is required!";
                    $emergency_tel_red_border = 'red_border';
                } else {
                    $emergency_tel = $_REQUEST['emergency_tel'];
                }

                if (empty($_REQUEST["emergency_name"])) {
                    $emergency_name_err = "Emergency contact name is required!";
                    $emergency_name_red_border = 'red_border';
                } else {
                    $emergency_name = $_REQUEST['emergency_name'];
                }

                if (empty($_REQUEST["village_birth"])) {
                    $village_birth_err = 'Village of birth is required!';
                    $village_birth_red_border = 'red_border';
                } else {
                    $village_birth = $_REQUEST['village_birth'];
                }

                if (empty($_REQUEST["district_birth"])) {
                    $district_birth_err = 'District of birth is required!';
                    $district_birth_red_border = 'red_border';
                } else {
                    $district_birth = $_REQUEST['district_birth'];
                }

                if (empty($_REQUEST["province_birth"])) {
                    $province_birth_err = 'Province of birth is required!';
                    $province_birth_red_border = 'red_border';
                } else {
                    $province_birth = $_REQUEST['province_birth'];
                }

                if (empty($_REQUEST["village_current"])) {
                    $village_current_err = 'Current village is required!';
                    $village_current_red_border = 'red_border';
                } else {
                    $village_current = $_REQUEST['village_current'];
                }

                if (empty($_REQUEST["district_current"])) {
                    $district_current_err = 'Current district is required!';
                    $district_current_red_border = 'red_border';
                } else {
                    $district_current = $_REQUEST['district_current'];
                }

                if (empty($_REQUEST["province_current"])) {
                    $province_current_err = 'Current province is required!';
                    $province_current_red_border = 'red_border';
                } else {
                    $province_current = $_REQUEST['province_current'];
                }

                // For Education 1
                if (empty($_REQUEST["edu_level1"])) {
                    $edu_level1_err = 'Education level is required!';
                    $edu_level1_red_border = 'red_border';
                } else {
                    $edu_level1 = $_REQUEST['edu_level1'];
                }
                if (empty($_REQUEST["edu_branch1"])) {
                    $edu_branch1_err = 'Education branch is required!';
                    $edu_branch1_red_border = 'red_border';
                } else {
                    $edu_branch1 = $_REQUEST['edu_branch1'];
                }
                if (empty($_REQUEST["univ_name1"])) {
                    $univ_name1_err = 'University is required!';
                    $univ_name1_red_border = 'red_border';
                } else {
                    $univ_name1 = $_REQUEST['univ_name1'];
                }
                if (empty($_REQUEST["edu_district1"])) {
                    $edu_district1_err = 'University district is required!';
                    $edu_district1_red_border = 'red_border';
                } else {
                    $edu_district1 = $_REQUEST['edu_district1'];
                }
                if (empty($_REQUEST["edu_province1"])) {
                    $edu_province1_err = 'University province is required!';
                    $edu_province1_red_border = 'red_border';
                } else {
                    $edu_province1 = $_REQUEST['edu_province1'];
                }
                if (empty($_REQUEST["edu_season1"])) {
                    $edu_season1_err = 'High school season is required!';
                    $edu_season1_red_border = 'red_border';
                } else {
                    $edu_season1 = $_REQUEST['edu_season1'];
                }

                // For other Educations
                $edu_level2 = $_REQUEST['edu_level2'];
                $edu_branch2 = $_REQUEST['edu_branch2'];
                $univ_name2 = $_REQUEST['univ_name2'];
                $edu_district2 = $_REQUEST['edu_district2'];
                $edu_province2 = $_REQUEST['edu_province2'];
                $edu_season2 = $_REQUEST['edu_season2'];

                $house_no = $_REQUEST['house_no'];
                $house_unit = $_REQUEST['house_unit'];
                $employment_history = $_REQUEST['employment_history'];
                $language_proficiency = $_REQUEST['language_proficiency'];
                $talent = $_REQUEST['talent'];
                $familymatters = $_REQUEST['familymatters'];
                $plansforthefuture = $_REQUEST['plansforthefuture'];

                $image_file = $_FILES['txt_file']['name'];
                $type = $_FILES['txt_file']['type'];
                $size = $_FILES['txt_file']['size'];
                $temp = $_FILES['txt_file']['tmp_name'];

                if (
                    !empty($u_id) and !empty($fname_en) and !empty($lname_en) and !empty($gender) and !empty($fname_la) and !empty($lname_la) and !empty($t_type) and !empty($fname_ch) and
                    !empty($lname_ch) and !empty($dob) and !empty($nation) and !empty($religion) and !empty($ethnicity) and !empty($tel) and !empty($whatsapp) and !empty($email) and
                    !empty($emergency_tel) and !empty($emergency_name) and !empty($village_birth) and !empty($district_birth) and !empty($province_birth) and !empty($village_current) and !empty($district_current) and
                    !empty($province_current) and !empty($edu_level1) and !empty($edu_branch1) and !empty($univ_name1) and !empty($edu_district1) and !empty($edu_province1) and !empty($edu_season1)
                ) {

                    $path = "upload/teacher_profile/" . $image_file; // set upload folder path
                    move_uploaded_file($temp, 'upload/teacher_profile/' . $image_file); // move upload file temperory directory to your upload folder

                    $password = $_REQUEST['password'];
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                    // Add User
                    $sql1 = "UPDATE users SET email=:email, u_pass=:u_pass WHERE u_id=:u_id";
                    $stmt1 = $conn->prepare($sql1);
                    $stmt1->bindParam(':u_id', $u_id);
                    $stmt1->bindParam(':email', $email);
                    if (empty($password)) {
                        $stmt1->bindParam(':u_pass', $u['u_pass']);
                    } else {
                        $stmt1->bindParam(':u_pass', $passwordHash);
                    }

                    // Update Teacher
                    $sql2 = "UPDATE teachers SET fname_en=:fname_en, lname_en=:lname_en, gender=:gender, fname_la=:fname_la, lname_la=:lname_la, t_type=:t_type, fname_ch=:fname_ch, lname_ch=:lname_ch, 
                    dob=:dob, nation=:nation, religion=:religion, ethnicity=:ethnicity, tel=:tel, whatsapp=:whatsapp, email=:email, emergency_tel=:emergency_tel, emergency_name=:emergency_name, village_birth=:village_birth, 
                    district_birth=:district_birth, province_birth=:province_birth, village_current=:village_current, district_current=:district_current, province_current=:province_current, house_unit=:house_unit, 
                    house_no=:house_no, edu_level1=:edu_level1, edu_branch1=:edu_branch1, univ_name1=:univ_name1, edu_district1=:edu_district1, edu_province1=:edu_province1, edu_season1=:edu_season1, edu_level2=:edu_level2, 
                    edu_branch2=:edu_branch2, univ_name2=:univ_name2, edu_district2=:edu_district2, edu_province2=:edu_province2, edu_season2=:edu_season2, employment_history=:employment_history, 
                    language_proficiency=:language_proficiency, talent=:talent, familymatters=:familymatters, plansforthefuture=:plansforthefuture, image=:image WHERE t_id=:t_id";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bindParam(':t_id', $id);
                    $stmt2->bindParam(':fname_en', $fname_en);
                    $stmt2->bindParam(':lname_en', $lname_en);
                    $stmt2->bindParam(':gender', $gender);
                    $stmt2->bindParam(':fname_la', $fname_la);
                    $stmt2->bindParam(':lname_la', $lname_la);
                    $stmt2->bindParam(':t_type', $t_type);
                    $stmt2->bindParam(':fname_ch', $fname_ch);
                    $stmt2->bindParam(':lname_ch', $lname_ch);
                    $stmt2->bindParam(':dob', $dob);
                    $stmt2->bindParam(':nation', $nation);
                    $stmt2->bindParam(':religion', $religion);
                    $stmt2->bindParam(':ethnicity', $ethnicity);
                    $stmt2->bindParam(':tel', $tel);
                    $stmt2->bindParam(':whatsapp', $whatsapp);
                    $stmt2->bindParam(':email', $email);
                    $stmt2->bindParam(':emergency_tel', $emergency_tel);
                    $stmt2->bindParam(':emergency_name', $emergency_name);
                    $stmt2->bindParam(':village_birth', $village_birth);
                    $stmt2->bindParam(':district_birth', $district_birth);
                    $stmt2->bindParam(':province_birth', $province_birth);
                    $stmt2->bindParam(':village_current', $village_current);
                    $stmt2->bindParam(':district_current', $district_current);
                    $stmt2->bindParam(':province_current', $province_current);
                    $stmt2->bindParam(':house_unit', $house_unit);
                    $stmt2->bindParam(':house_no', $house_no);
                    $stmt2->bindParam(':edu_level1', $edu_level1);
                    $stmt2->bindParam(':edu_branch1', $edu_branch1);
                    $stmt2->bindParam(':univ_name1', $univ_name1);
                    $stmt2->bindParam(':edu_district1', $edu_district1);
                    $stmt2->bindParam(':edu_province1', $edu_province1);
                    $stmt2->bindParam(':edu_season1', $edu_season1);
                    $stmt2->bindParam(':edu_level2', $edu_level2);
                    $stmt2->bindParam(':edu_branch2', $edu_branch2);
                    $stmt2->bindParam(':univ_name2', $univ_name2);
                    $stmt2->bindParam(':edu_district2', $edu_district2);
                    $stmt2->bindParam(':edu_province2', $edu_province2);
                    $stmt2->bindParam(':edu_season2', $edu_season2);
                    $stmt2->bindParam(':employment_history', $employment_history);
                    $stmt2->bindParam(':language_proficiency', $language_proficiency);
                    $stmt2->bindParam(':talent', $talent);
                    $stmt2->bindParam(':familymatters', $familymatters);
                    $stmt2->bindParam(':plansforthefuture', $plansforthefuture);
                    if (empty($image_file)) {
                        $stmt2->bindParam(':image', $teacher['image']);
                    } else {
                        $stmt2->bindParam(':image', $image_file);
                    }

                    $stmt1->execute();
                    $stmt2->execute();
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Teacher Update Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";

                    // $_SESSION['success'] = "Update Teacher successfully.";
                    header('refresh:2; url=teacher-list.php');
                    exit;
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

    <link rel="stylesheet" href="../assets/plugins/twitter-bootstrap-wizard/form-wizard.css">

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
                                <h3 class="page-title">Edit Teacher</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="teacher-list.php">Teachers</a></li>
                                    <li class="breadcrumb-item active">Edit Teacher</li>
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
                                            <h5 class="form-title student-info">Teacher Information <span><a
                                                        href="javascript:;"><i
                                                            class="feather-more-vertical"></i></a></span></h5>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>User ID <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $u_id_red_border ?>" type="text"
                                                    name="u_id" value="<?php echo $t_row['u_id'] ?>" readonly>
                                                <div class="error"><?php echo $u_id_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>First Name(English) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $fname_en_red_border ?>"
                                                    type="text" name="fname_en"
                                                    value="<?php echo $t_row['fname_en'] ?>">
                                                <div class="error"><?php echo $fname_en_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Last Name(English) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $lname_en_red_border ?>"
                                                    type="text" name="lname_en"
                                                    value="<?php echo $t_row['lname_en'] ?>">
                                                <div class="error"><?php echo $lname_en_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Gender <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $gender_red_border ?>"
                                                    name="gender">
                                                    <option><?php echo $t_row['gender'] ?></option>
                                                    <option>Female</option>
                                                    <option>Male</option>
                                                </select>
                                                <div class="error"><?php echo $gender_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>First Name(Lao) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $fname_la_red_border ?>"
                                                    type="text" name="fname_la"
                                                    value="<?php echo $t_row['fname_la'] ?>">
                                                <div class="error"><?php echo $fname_la_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Last Name(Lao) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $lname_la_red_border ?>"
                                                    type="text" name="lname_la"
                                                    value="<?php echo $t_row['lname_la'] ?>">
                                                <div class="error"><?php echo $lname_la_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--  New element -->
                                            <div class="form-group local-forms">
                                                <label>Teacher Type <span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $t_type_red_border ?>"
                                                    name="t_type">
                                                    <option><?php echo $t_row['t_type'] ?></option>
                                                    <option>Regular Teacher</option>
                                                    <option>Invited Teacher</option>
                                                </select>
                                                <div class="error"><?php echo $t_type_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>First Name(Chines) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $fname_ch_red_border ?>"
                                                    type="text" name="fname_ch"
                                                    value="<?php echo $t_row['fname_ch'] ?>">
                                                <div class="error"><?php echo $fname_ch_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Last Name(Chines) <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $lname_ch_red_border ?>"
                                                    type="text" name="lname_ch"
                                                    value="<?php echo $t_row['lname_ch'] ?>">
                                                <div class="error"><?php echo $lname_ch_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms calendar-icon">
                                                <label>Date Of Birth <span class="login-danger">*</span></label>
                                                <input class="form-control datetimepicker <?php echo $dob_red_border ?>"
                                                    type="text" name="dob" value="<?php echo $t_row['dob'] ?>">
                                                <div class="error position-absolute"><?php echo $dob_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Nation <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $nation_red_border ?>" type="text"
                                                    name="nation" value="<?php echo $t_row['nation'] ?>">
                                                <div class="error"><?php echo $nation_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Religion<span class="login-danger">*</span></label>
                                                <select class="form-control select <?php echo $religion_red_border ?>"
                                                    name="religion">
                                                    <option><?php echo $t_row['religion'] ?></option>
                                                    <option>Buddhism</option>
                                                    <option>Christianity</option>
                                                    <option>Islam</option>
                                                    <option>Others</option>
                                                </select>
                                                <div class="error"><?php echo $religion_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Ethnicity <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $ethnicity_red_border ?>"
                                                    type="text" name="ethnicity"
                                                    value="<?php echo $t_row['ethnicity'] ?>">
                                                <div class="error"><?php echo $ethnicity_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Tel<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $tel_red_border ?>" type="text"
                                                    name="tel" value="<?php echo $t_row['tel'] ?>">
                                                <div class="error"><?php echo $tel_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>WhatsApp <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $whatsapp_red_border ?>"
                                                    type="text" name="whatsapp"
                                                    value="<?php echo $t_row['whatsapp'] ?>">
                                                <div class="error"><?php echo $whatsapp_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>E-Mail <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $email_red_border ?>" type="text"
                                                    name="email" value="<?php echo $t_row['email'] ?>">
                                                <div class="error"><?php echo $email_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Emergency contact Number </label>
                                                <input class="form-control <?php echo $emergency_tel_red_border ?>"
                                                    type="text" name="emergency_tel"
                                                    value="<?php echo $t_row['emergency_tel'] ?>">
                                                <div class="error"><?php echo $emergency_tel_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Emergency contact Name </label>
                                                <input class="form-control <?php echo $emergency_name_red_border ?>"
                                                    type="text" name="emergency_name"
                                                    value="<?php echo $t_row['emergency_name'] ?>">
                                                <div class="error"><?php echo $emergency_name_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Village Of Birth <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $village_birth_red_border ?>"
                                                    type="text" name="village_birth"
                                                    value="<?php echo $t_row['village_birth'] ?>">
                                                <div class="error"><?php echo $village_birth_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>District Of Birth <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $district_birth_red_border ?>"
                                                    type="text" name="district_birth"
                                                    value="<?php echo $t_row['district_birth'] ?>">
                                                <div class="error"><?php echo $district_birth_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Province Of Birth <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $province_birth_red_border ?>"
                                                    type="text" name="province_birth"
                                                    value="<?php echo $t_row['province_birth'] ?>">
                                                <div class="error"><?php echo $province_birth_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Current Village <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $village_current_red_border ?>"
                                                    type="text" name="village_current"
                                                    value="<?php echo $t_row['village_current'] ?>">
                                                <div class="error"><?php echo $village_current_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Current District <span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $district_current_red_border ?>"
                                                    type="text" name="district_current"
                                                    value="<?php echo $t_row['district_current'] ?>">
                                                <div class="error"><?php echo $district_current_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Current Province <span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $province_current_red_border ?>"
                                                    type="text" name="province_current"
                                                    value="<?php echo $t_row['province_current'] ?>">
                                                <div class="error"><?php echo $province_current_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>House Unit </label>
                                                <input class="form-control <?php echo $house_unit_red_border ?>"
                                                    type="text" name="house_unit"
                                                    value="<?php echo $t_row['house_unit'] ?>">
                                                <div class="error"><?php echo $house_unit_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>House No </label>
                                                <input class="form-control <?php echo $house_no_red_border ?>"
                                                    type="text" name="house_no"
                                                    value="<?php echo $t_row['house_no'] ?>">
                                                <div class="error"><?php echo $house_no_err ?></div>
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Education Level<span class="login-danger">*</span> </label>
                                                <select class="form-control select <?php echo $edu_level1_red_border ?>"
                                                    name="edu_level1">
                                                    <option><?php echo $t_row['edu_level1'] ?></option>
                                                    <option>Deploma College</option>
                                                    <option>Master Univercity</option>
                                                </select>
                                                <div class="error"><?php echo $edu_level1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Gratuation Branch<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $edu_branch1_red_border ?>"
                                                    type="text" name="edu_branch1"
                                                    value="<?php echo $t_row['edu_branch1'] ?>">
                                                <div class="error"><?php echo $edu_branch1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University Name<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $univ_name1_red_border ?>"
                                                    type="text" name="univ_name1"
                                                    value="<?php echo $t_row['univ_name1'] ?>">
                                                <div class="error"><?php echo $univ_name1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University District<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $edu_district1_red_border ?>"
                                                    type="text" name="edu_district1"
                                                    value="<?php echo $t_row['edu_district1'] ?>">
                                                <div class="error"><?php echo $edu_district1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University Province<span class="login-danger">*</span> </label>
                                                <input class="form-control <?php echo $edu_province1_red_border ?>"
                                                    type="text" name="edu_province1"
                                                    value="<?php echo $t_row['edu_province1'] ?>">
                                                <div class="error"><?php echo $edu_province1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Graduation Season<span class="login-danger">*</span></label>
                                                <input class="form-control <?php echo $edu_season1_red_border ?>"
                                                    type="text" name="edu_season1"
                                                    value="<?php echo $t_row['edu_season1'] ?>">
                                                <div class="error"><?php echo $edu_season1_err ?></div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Other Education Level</label>
                                                <select class="form-control select" name="edu_level2">
                                                    <option><?php echo $t_row['edu_level2'] ?></option>
                                                    <option>Deploma College</option>
                                                    <option>Master Univercity</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Gratuation Branch</label>
                                                <input class="form-control" type="text" name="edu_branch2"
                                                    value="<?php echo $t_row['edu_branch2'] ?>">

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University Name</label>
                                                <input class="form-control" type="text" name="univ_name2"
                                                    value="<?php echo $t_row['univ_name2'] ?>">

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University District</label>
                                                <input class="form-control" type="text" name="edu_district2"
                                                    value="<?php echo $t_row['edu_district2'] ?>">

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>University Province</label>
                                                <input class="form-control" type="text" name="edu_province2"
                                                    value="<?php echo $t_row['edu_province2'] ?>">

                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Graduation Season</label>
                                                <input class="form-control" type="text" name="edu_season2"
                                                    value="<?php echo $t_row['edu_season2'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Employment History</label>
                                                <input class="form-control" type="text" name="employment_history"
                                                    value="<?php echo $t_row['employment_history'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Language Proficiency </label>
                                                <input class="form-control" type="text" name="language_proficiency"
                                                    value="<?php echo $t_row['language_proficiency'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <!--New element -->
                                            <div class="form-group local-forms">
                                                <label>Talent </label>
                                                <input class="form-control" type="text" name="talent"
                                                    value="<?php echo $t_row['talent'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Family Matters </label>
                                                <input class="form-control" type="text" name="familymatters"
                                                    value="<?php echo $t_row['familymatters'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Plans For Future </label>
                                                <input class="form-control" type="text" name="plansforthefuture"
                                                    value="<?php echo $t_row['plansforthefuture'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group local-forms">
                                                <label>Password </label>
                                                <input class="form-control" type="text" name="password"
                                                    placeholder="*************">
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-4">
                                            <div class="form-group students-up-files">
                                                <label>Image Profile 3x4cm (<?php echo $t_row['image'] ?>) <span
                                                        class="login-danger">*</span> </label>

                                                <?php
                                                $teacherImage_file = $t_row['image'];

                                                if ($teacherImage_file == '') { ?>
                                                <img src="<?php echo "../admin/upload/profile.png" ?>" alt="Logo" width="150px">
                                                <?php } else { ?>
                                                <img src="<?php echo "../admin/upload/teacher_profile/$teacherImage_file" ?>"
                                                    alt="Logo" width="150px">
                                                <?php } ?>


                                                <label class="file-upload image-upbtn mb-0 ml-2">
                                                    Choose File <input type="file" name="txt_file"
                                                        value="<?php echo $t_row['image'] ?>">
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="student-submit">
                                                <button type="submit" name="submit"
                                                    class="btn btn-primary">Submit</button>
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