<?php
require_once 'admin/include/config/dbcon.php';
session_start();
include "admin/admin-datas/director-db.php";


$u_id = $fname_en = $lname_en = $fname_la = $lname_la = $fname_ch = $lname_ch = $gender = $dob = $village = $district = $province = '';
$tel = $whatsapp = $email = $ethnicity = $nation = $deploma_amount = $deploma_college = $undergraduate_amount = $religion = '';
$undergraduate_university = $master_university = $doctorate_university = $graduation_year = '';
$employment_history = $language_proficiency = $password = '';

$u_id_err = $fname_en_err = $lname_en_err = $fname_la_err = $lname_la_err = $fname_ch_err = $lname_ch_err = $gender_err = $dob_err = $village_err = $district_err = $province_err = '';
$tel_err = $whatsapp_err = $email_err = $ethnicity_err = $nation_err = $deploma_amount_err = $deploma_college_err = $undergraduate_amount_err = $religion_err = '';
$undergraduate_university_err = $master_university_err = $doctorate_university_err = $graduation_year_err = '';
$employment_history_err = $language_proficiency_err = '';

$u_id_red_border= $fname_en_red_border= $lname_en_red_border= $fname_la_red_border= $lname_la_red_border= $fname_ch_red_border= $lname_ch_red_border= $gender_red_border= $dob_red_border= $village_red_border= $district_red_border= $province_red_border= '';
$tel_red_border= $whatsapp_red_border= $email_red_border= $ethnicity_red_border= $nation_red_border= $deploma_amount_red_border= $deploma_college_red_border= $undergraduate_amount_red_border= $religion_red_border= '';
$undergraduate_university_red_border= $master_university_red_border= $doctorate_university_red_border= $graduation_year_red_border= '';
$employment_history_red_border= $language_proficiency_red_border= '';


$id = $_SESSION['directorInfo'];
$director = getDirectorById($id, $conn);
$director_row = getDirectorById($id, $conn);
$user = directorGetUserById($id, $conn);

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

        $check_whatsapp = $conn->prepare("SELECT whatsapp FROM directors WHERE whatsapp = :whatsapp AND whatsapp != :this_whatsapp");
        $check_whatsapp->bindParam(":this_whatsapp", $director['whatsapp']);
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

        if (empty($_REQUEST["whatsapp"])) {
            $whatsapp_err = 'Whatsapp namber is required!';
            $whatsapp_red_border = 'red_border';
        }elseif($check_whatsapp->rowCount() > 0){
            $whatsapp_err = 'Whatsapp namber is writen already exsit!';
            $whatsapp_red_border = 'red_border';
        } else {
            $whatsapp = $_REQUEST['whatsapp'];
        }

        if (empty($_REQUEST["email"])) {
            $email_err = 'E-mail is required!';
            $email_red_border = 'red_border';
        } elseif (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format!";
            $email_red_border = 'red_border';
            $email = $_REQUEST['email'];
        }elseif($check_email->rowCount() > 0){
            $email_err = 'E-mail is writen already exsit!';
            $email_red_border = 'red_border';
        } else {
            $email = $_REQUEST['email'];
        }

        if (empty($_REQUEST["village"])) {
            $village_err = 'Village is required!';
            $village_red_border = 'red_border';
        } else {
            $village = $_REQUEST['village'];
        }

        if (empty($_REQUEST["district"])) {
            $district_err = 'District is required!';
            $district_red_border = 'red_border';
        } else {
            $district = $_REQUEST['district'];
        }

        if (empty($_REQUEST["province"])) {
            $province_err = 'Province is required!';
            $province_red_border = 'red_border';
        } else {
            $province = $_REQUEST['province'];
        }

        if(empty($_REQUEST['deploma_amount'])){
           $deploma_amount_err = 'Deproma amount is required!';
           $deploma_amount_red_border = 'red_border';
        }else{
            $deploma_amount =$_REQUEST['deploma_amount'];
        } 
        if(empty($_REQUEST['tel'])){
           $tel_err = 'Phone number is required!';
           $tel_red_border = 'red_border';
        } elseif ($check_tel->rowCount() > 0) {
           $tel_err = 'Phone number is writen already exist!';
           $tel_red_border = 'red_border';
        }else{
            $tel =$_REQUEST['tel'];
        } 
        if(empty($_REQUEST['deploma_college'])){
           $deploma_college_err = 'Deproma college is required!';
           $deploma_college_red_border = 'red_border';
        }else{
            $deploma_college =$_REQUEST['deploma_college'];
        } 
        if(empty($_REQUEST['undergraduate_amount'])){
           $undergraduate_amount_err = 'Undergraduate amount is required!';
           $undergraduate_amount_red_border = 'red_border';
        }else{
            $undergraduate_amount =$_REQUEST['undergraduate_amount'];
        } 
        if(empty($_REQUEST['undergraduate_university'])){
           $undergraduate_university_err = 'Undergraduate university is required!';
           $undergraduate_university_red_border = 'red_border';
        }else{
            $undergraduate_university =$_REQUEST['undergraduate_university'];
        } 
        if(empty($_REQUEST['master_university'])){
           $master_university_err = 'Master university is required!';
           $master_university_red_border = 'red_border';
        }else{
            $master_university =$_REQUEST['master_university'];
        } 
        if(empty($_REQUEST['doctorate_university'])){
           $doctorate_university_err = 'Doctorate university is required!';
           $doctorate_university_red_border = 'red_border';
        }else{
            $doctorate_university =$_REQUEST['doctorate_university'];
        }

        if(empty($_REQUEST['graduation_year'])){
           $graduation_year_err = 'Gratuation year is required!';
           $graduation_year_red_border = 'red_border';
        }else{
            $graduation_year =$_REQUEST['graduation_year'];
        } 

        if(!empty($_REQUEST['employment_history'])){
            $employment_history = $_REQUEST['employment_history'];
        }else{
            $employment_history = '';
        }
        if(!empty($_REQUEST['language_proficiency'])){
            $language_proficiency = $_REQUEST['language_proficiency'];
        }else{
            $language_proficiency = '';
        }
        if(!empty($_REQUEST['password'])){
            $password = $_REQUEST['password'];
        }
        
        if(
            !empty($u_id) and !empty($fname_en) and !empty($lname_en) and !empty($gender) and !empty($fname_la) and !empty($lname_la) and !empty($fname_ch) and
            !empty($lname_ch) and !empty($dob) and !empty($nation) and !empty($religion) and !empty($ethnicity) and !empty($tel) and !empty($whatsapp) and !empty($email) and
            !empty($village) and !empty($district) and !empty($province) and !empty($deploma_amount) and !empty($deploma_college) and !empty($undergraduate_amount) and
            !empty($undergraduate_university) and !empty($master_university) and !empty($doctorate_university) and !empty($graduation_year)
        ) {
            
            try{
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    
                // Add User
                $stmt1 = $conn->prepare("UPDATE users SET email=:email, u_pass=:u_pass, tel=:tel WHERE u_id=:u_id");
                $stmt1->bindParam(':u_id', $u_id);
                $stmt1->bindParam(':email', $email);
                $stmt1->bindParam(':tel', $tel);
                if (empty($password)) {
                    $stmt1->bindParam(':u_pass', $user['u_pass']);
                } else {
                    $stmt1->bindParam(':u_pass', $passwordHash);
                }
    
                // Add Director
                $stmt2 = $conn->prepare("UPDATE directors SET fname_en=:fname_en, lname_en=:lname_en, gender=:gender, fname_la=:fname_la, lname_la=:lname_la, fname_ch=:fname_ch, lname_ch=:lname_ch, dob=:dob, nation=:nation, religion=:religion, 
                ethnicity=:ethnicity, tel=:tel, whatsapp=:whatsapp, email=:email, village=:village, district=:district, province=:province, deploma_amount =:deploma_amount, deploma_college =:deploma_college, 
                undergraduate_amount =:undergraduate_amount, undergraduate_university =:undergraduate_university, master_university=:master_university, doctorate_university=:doctorate_university, graduation_year=:graduation_year,
                employment_history=:employment_history, language_proficiency=:language_proficiency WHERE director_id=:director_id");

                $stmt2->bindParam(':director_id', $id);
                $stmt2->bindParam(':fname_en', $fname_en);
                $stmt2->bindParam(':lname_en', $lname_en);
                $stmt2->bindParam(':gender', $gender);
                $stmt2->bindParam(':fname_la', $fname_la);
                $stmt2->bindParam(':lname_la', $lname_la);
                $stmt2->bindParam(':fname_ch', $fname_ch);
                $stmt2->bindParam(':lname_ch', $lname_ch);
                $stmt2->bindParam(':dob', $dob);
                $stmt2->bindParam(':nation', $nation);
                $stmt2->bindParam(':religion', $religion);
                $stmt2->bindParam(':ethnicity', $ethnicity);
                $stmt2->bindParam(':tel', $tel);
                $stmt2->bindParam(':whatsapp', $whatsapp);
                $stmt2->bindParam(':email', $email);
                $stmt2->bindParam(':village', $village);
                $stmt2->bindParam(':district', $district);
                $stmt2->bindParam(':province', $province);
                $stmt2->bindParam(':deploma_amount', $deploma_amount);
                $stmt2->bindParam(':deploma_college', $deploma_college);
                $stmt2->bindParam(':undergraduate_amount', $undergraduate_amount);
                $stmt2->bindParam(':undergraduate_university', $undergraduate_university);
                $stmt2->bindParam(':master_university', $master_university);
                $stmt2->bindParam(':doctorate_university', $doctorate_university);
                $stmt2->bindParam(':graduation_year', $graduation_year);
                $stmt2->bindParam(':employment_history', $employment_history);
                $stmt2->bindParam(':language_proficiency', $language_proficiency);

                $stmt1->execute();
                $stmt2->execute();

                $_SESSION['success'] = "Register Successfully. <a href='index.php'> Click here to login </a>";
                header('location: directorInfo-add.php');
                exit;
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }else{
            $_SESSION['error'] = 'Some thing when wrong with any cell, Please chech your data again!';
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Logos Institute of Foreign Language</title>

    <link rel="shortcut icon" href="assets/img/logo_logos.png">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="assets/plugins/icons/flags/flags.css">

    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="assets/css/validate-form.css">
</head>

<body>

    <div class="main-wrapper">
        <div class="content container-fluid">

            <div class="page-header">

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
                                        <h5 class="form-title student-info">Director Register <span><a href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>User ID <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $u_id_red_border ?>" type="text" name="u_id" value="<?php echo $director_row['director_id'] ?>" readonly>
                                            <div class="error"><?php echo $u_id_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name(English) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $fname_en_red_border ?>" type="text" name="fname_en" value="<?php echo $director_row['fname_en'] ?>">
                                            <div class="error"><?php echo $fname_en_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name(English) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $lname_en_red_border ?>" type="text" name="lname_en" value="<?php echo $director_row['lname_en'] ?>">
                                            <div class="error"><?php echo $lname_en_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Gender <span class="login-danger">*</span></label>
                                            <select class="form-control select <?php echo $gender_red_border ?>" name="gender">
                                                <option><?php echo $director_row['gender'] ?></option>
                                                <option>Female</option>
                                                <option>Male</option>
                                            </select>
                                            <div class="error"><?php echo $gender_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name(Lao) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $fname_la_red_border ?>" type="text" name="fname_la" value="<?php echo $director_row['fname_la'] ?>">
                                            <div class="error"><?php echo $fname_la_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name(Lao) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $lname_la_red_border ?>" type="text" name="lname_la" value="<?php echo $director_row['lname_la'] ?>">
                                            <div class="error"><?php echo $lname_la_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms calendar-icon">
                                            <label>Date Of Birth <span class="login-danger">*</span></label>
                                            <input class="form-control datetimepicker <?php echo $dob_red_border ?>" type="text" name="dob" value="<?php echo $dob ?>">
                                            <div class="error position-absolute"><?php echo $dob_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>First Name(Chines) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $fname_ch_red_border ?>" type="text" name="fname_ch" value="<?php echo $fname_ch ?>">
                                            <div class="error"><?php echo $fname_ch_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Last Name(Chines) <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $lname_ch_red_border ?>" type="text" name="lname_ch" value="<?php echo $lname_ch ?>">
                                            <div class="error"><?php echo $lname_ch_err ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Nation <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $nation_red_border ?>" type="text" name="nation" value="<?php echo $nation ?>">
                                            <div class="error"><?php echo $nation_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Religion<span class="login-danger">*</span></label>
                                            <select class="form-control select <?php echo $religion_red_border ?>" name="religion">
                                                <option><?php echo $religion ?></option>
                                                <option>Buddhism</option>
                                                <option>Christianity</option>
                                                <option>Islam</option>
                                                <option>Others</option>
                                            </select>
                                            <div class="error"><?php echo $religion_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4"> <!--New element -->
                                        <div class="form-group local-forms">
                                            <label>Ethnicity <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $ethnicity_red_border ?>" type="text" name="ethnicity" value="<?php echo $ethnicity ?>">
                                            <div class="error"><?php echo $ethnicity_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4"> <!--New element -->
                                        <div class="form-group local-forms">
                                            <label>Village <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $village_red_border ?>" type="text" name="village" value="<?php echo $village ?>">
                                            <div class="error"><?php echo $village_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4"> <!--New element -->
                                        <div class="form-group local-forms">
                                            <label>District <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $district_red_border ?>" type="text" name="district" value="<?php echo $district ?>">
                                            <div class="error"><?php echo $district_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4"> <!--New element -->
                                        <div class="form-group local-forms">
                                            <label>Province <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $province_red_border ?>" type="text" name="province" value="<?php echo $province ?>">
                                            <div class="error"><?php echo $province_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Tel<span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $tel_red_border ?>" type="text" name="tel" value="<?php echo $user['tel'] ?>">
                                            <div class="error"><?php echo $tel_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>WhatsApp <span class="login-danger">*</span> </label>
                                            <input class="form-control <?php echo $whatsapp_red_border ?>" type="text" name="whatsapp" value="<?php echo $whatsapp ?>">
                                            <div class="error"><?php echo $whatsapp_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>E-Mail <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $email_red_border ?>" type="text" name="email" value="<?php echo $user['email'] ?>">
                                            <div class="error"><?php echo $email_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Deploma Amount <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $deploma_amount_red_border ?>" type="number" name="deploma_amount" value="<?php echo $deploma_amount ?>">
                                            <div class="error"><?php echo $deploma_amount_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Deploma College <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $deploma_college_red_border ?>" type="text" name="deploma_college" value="<?php echo $deploma_college ?>">
                                            <div class="error"><?php echo $deploma_college_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Undergraduate Amount <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $undergraduate_amount_red_border ?>" type="number" name="undergraduate_amount" value="<?php echo $undergraduate_amount ?>">
                                            <div class="error"><?php echo $undergraduate_amount_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Undergraduate University <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $undergraduate_university_red_border ?>" type="text" name="undergraduate_university" value="<?php echo $undergraduate_university ?>">
                                            <div class="error"><?php echo $undergraduate_university_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Master University <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $master_university_red_border ?>" type="text" name="master_university" value="<?php echo $master_university ?>">
                                            <div class="error"><?php echo $master_university_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Doctorate University <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $doctorate_university_red_border ?>" type="text" name="doctorate_university" value="<?php echo $doctorate_university ?>">
                                            <div class="error"><?php echo $doctorate_university_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Graduation Year <span class="login-danger">*</span></label>
                                            <input class="form-control <?php echo $graduation_year_red_border ?>" type="text" name="graduation_year" value="<?php echo $graduation_year ?>">
                                            <div class="error"><?php echo $graduation_year_err ?></div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Employment History</label>
                                            <input class="form-control" type="text" name="employment_history" value="<?php echo $employment_history ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Language Proficiency </label>
                                            <input class="form-control" type="text" name="language_proficiency" value="<?php echo $language_proficiency ?>">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4">
                                        <div class="form-group local-forms">
                                            <label>Password </label>
                                            <input class="form-control" type="text" name="password" placeholder="*************" value="<?php echo $password ?>">
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

    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>

    <script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/feather.min.js"></script>

    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="assets/plugins/select2/js/select2.min.js"></script>

    <script src="assets/plugins/moment/moment.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>

    <script src="assets/js/script.js"></script>
</body>

</html>