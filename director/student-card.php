<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);
    
    if ($_GET['id']) {
        $id = $_GET['id'];

        // Student
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

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../assets/plugins/feather/feather.css">

    <link rel="stylesheet" href="../assets/plugins/icons/flags/flags.css">

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
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
            <div class="container">
                <div class="row ">
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span><b>Student Card</b></span>
                                    </div>
                                    <div class="col-auto text-end float-end ms-auto">
                                        <button onclick="window.print();" class="btn btn-primary" id="print-btn"><i class="fas fa-print"></i></button>
                                    </div>
                                </div><br>
                                <table class="table-bordered text-center small">
                                    <tr>
                                        <td rowspan="7">
                                            <?php
                                            $student_image = $std['image'];
                                            if ($student_image == '') { ?>
                                                <img class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image" width="100px">
                                            <?php } else { ?>
                                                <img class="avatar-img rounded-circle" src="<?php echo "upload/student_profile/$student_image" ?>" alt="User Image" width="100px">
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $std['std_id'] ?></td>
                                        <td><?php echo $std['dob'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $std['fname_la'] ?></td>
                                        <td><?php echo $std['lname_la'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $std['fname_en'] ?></td>
                                        <td><?php echo $std['lname_en'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $std['fname_ch'] ?></td>
                                        <td><?php echo $std['lname_ch'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $std['tel'] ?></td>
                                        <td><?php echo $std['province_birth'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?php echo $std['email'] ?></td>
                                    </tr>
                                </table>
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
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
</body>

</html>