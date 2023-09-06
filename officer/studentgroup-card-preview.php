<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
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

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // $students = $conn->prepare("SELECT group_id, students.std_id, fname_en, lname_en, image FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id");
        $students = $conn->prepare("SELECT * FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id WHERE group_id=:group_id");
        $students->bindParam(':group_id', $id);
        $students->execute();

        include "officer-datas/group-db.php";
        include "officer-datas/studentgroup-db.php";
        $std_group = getGroupByID($id, $conn);

        if (isset($_REQUEST['submit'])) {
            try {
                $delete_id = $_REQUEST['std_id'];
                $group_id = $_REQUEST['group_status'];

                if (removeStudent($delete_id, $conn)) {
                    echo "<script>
                        $(document).ready(function() {
                            Swal.fire({
                                title: 'Success',
                                text: 'Delete Student From Student Group Successfully!',
                                icon: 'success',
                                timer: 5000,
                                showConfirmButton: false
                            });
                        });
                    </script>";

                    // $_SESSION['success'] = "Successfully deleted student from student group!";
                    header("refresh:2; url=studentgroup-detail.php?id=$group_id");
                    exit;
                } else {
                    $_SESSION['error'] = "Delete Fail, Please try again!";
                    header("refresh:2; url=studentgroup-detail.php?id=$group_id");
                    exit;
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

    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">

    <link rel="stylesheet" href="../assets/plugins/datatables/datatables.min.css">

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
    <link  href="print.css" type="text/css" rel="stylesheet" media="print"/>
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
                <div class="page-header">
                    <div class="card ">
                        <div class="card-body ">

                            <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                    ?>
                            </div>
                            <?php } ?>

                            <div class="page-header">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <p class="page-title">Program: <?php echo $std_group['program'] ?> <br> Year:
                                            <?php echo $std_group['year'] ?> <br> Part: <?php echo $std_group['part'] ?>
                                            <br> Class: <?php echo $std_group['group_id'] ?> </p>
                                    </div>
                                    <?php if ($students->rowCount() > 0) { ?>
                                    <div class="col-4 text-end float-end" id="print-btn">
                                        <a href="studentgroup-detail.php?id=<?= $std_group['group_id'] ?>">>> Preview
                                            Student's Infomation <<</a>
                                                <button onclick="window.print();" class="btn mb-2 btn-primary ms-5"><i
                                                        class="fas fa-print"></i></button>
                                                <!-- <a href="studentgroup-add.php?std_g_id=<?= $std_group['group_id'] ?>"
                                                    class="btn btn-primary ms-5 mb-2"><i class="fas fa-plus "></i></a> -->
                                    </div>
                                    <?php } else { ?>
                                    <div class="col-6 text-end float-end ms-auto download-grp">
                                        <a href="studentgroup-add.php?" class="btn btn-primary"><i
                                                class="fas fa-plus"></i></a>
                                    </div>
                                    <?php } ?>    
                                </div>
                            </div>
                               
                                    <div class="row text-center">
                                        <?php foreach ($students as $student) { ?>
                                        <table class="table-bordered small mb-3 ms-5 col-lg-5 col-5">
                                            <tr>
                                                <td rowspan="7" class="col-lg-4 w-25  col-14 text-center border border-dark">
                                                    <p>photo</p>
                                                    <p>3 X 4</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-1 col-4  border border-dark"><?php echo $student['std_id'] ?></td>
                                                <td class="p-1 col-4 border border-dark"><?php echo $student['dob'] ?></td>
                                            </tr>
                                            <tr >
                                                <td class="p-1 border border-dark"><?php echo $student['fname_la'] ?></td>
                                                <td class="p-1 col-4 border border-dark"><?php echo $student['lname_la'] ?></td>
                                            </tr>
                                            <tr >
                                                <td class="p-1 border border-dark"><?php echo $student['fname_en'] ?></td>
                                                <td class="p-1 border border-dark"><?php echo $student['lname_en'] ?></td>
                                            </tr >
                                            <tr>
                                                <td class="p-1 border border-dark"><?php echo $student['fname_ch'] ?> h</td>
                                                <td class="p-1 border border-dark"><?php echo $student['lname_ch'] ?></td>
                                            </tr>
                                            <tr >
                                                <td class="p-1 border border-dark"><?php echo $student['tel'] ?></td>
                                                <td class="p-1 border border-dark"> <?php echo $student['province_birth'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" class="p-1 border text-center border-dark"><?php echo $student['email'] ?></td>
                                            </tr>
                                        </table>

                                        <?php } ?>

                                    </div>
                                <style>
                               
                                @page {
                                margin: 20pt 50pt 20pt;
                                size: auto;
                                }
                               
                                
                                table, figure {
                                page-break-inside: avoid;
                                
                                }
                                
                                h1, h2, h3, h4, h5 {
                                page-break-after: avoid;
                                }

                                </style>
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

    <script src="../assets/plugins/datatables/datatables.min.js"></script>

    <script src="../assets/js/script.js"></script>

</body>

</html>