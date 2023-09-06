<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
    require_once 'include/config/dbcon.php';
    session_start();

    if (isset($_GET['submit'])) {
        echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Success',
                        text: 'Officer Add Successfully!',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                });
        </script>";
        // $_SESSION['success'] = "Add Officer Successfully.";
        
        header("refresh:2; url=officer-list.php");
        exit;
    }
    if ($_GET['id']) {
        $id = $_GET['id'];

        include "admin-datas/officer-db.php";
        $off = getOfficerById($id, $conn);
        
        
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logos Institute of Foreign Language </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/img/logo_logos.png">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/feather/feather.css">
    <link rel="stylesheet" href="../assets/plugins/icons/flags/flags.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/validate-form.css">

    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
</head>

<body>
    <div class="main-wrapper login-body">
        <div class="container login-wrapper">
            <div class="card bill-card">
                <div class="card-body">
                    <div class="col">
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

                        <div class="card-title d-flex justify-content-between col-12">
                            <span>Preview Officer Bill</span>
                            <button onclick="window.print();" class="btn btn-primary" id="print-btn"><i class="fas fa-print"></i></button>
                        </div>
                        <div class="row print-bill">
                            <div class="col-lg-8 bill-lelft">
                                <div class="row">
                                    <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">Officer ID:</p>
                                    <p class="col-sm-8"><?php echo $off['off_id'] ?></p>
                                </div>
                                <div class="row">
                                    <?php 
                                        if ($off['gender'] == 'Male') { ?>
                                            <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">English Name:</p>
                                            <p class="col-sm-8">Mr <?php echo $off['fname_en'] . " " . $off['lname_en'] ?></p>
                                        <?php } else { ?>
                                            <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">English Name:</p>
                                            <p class="col-sm-8">Miss <?php echo $off['fname_en'] . " " . $off['lname_en'] ?></p>
                                        <?php }
                                    ?>
                                </div>
                                <div class="row">
                                    <?php 
                                        if ($off['gender'] == 'Male') { ?>
                                            <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">Laos Name:</p>
                                            <p class="col-sm-8">ທ <?php echo $off['fname_la'] . " " . $off['lname_la'] ?></p>
                                        <?php } else { ?>
                                            <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">Laos Name:</p>
                                            <p class="col-sm-8">ນ <?php echo $off['fname_la'] . " " . $off['lname_la'] ?></p>
                                        <?php }
                                    ?>
                                </div>
                                <div class="row">
                                    <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">Tel:</p>
                                    <p class="col-sm-8"><?php echo $off['tel'] ?></p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-4 text-muted text-sm-end mb-0 mb-sm-3">E-mail:</p>
                                    <p class="col-sm-8"><?php echo $off['email'] ?></p>
                                </div>
                            </div>
                            <div class="col-lg-4 bill-right">
                                <div class="row">
                                    <img class="img-fluid-bill-qr" src="../assets/img/filter-user.png" alt="Logo">
                                </div>
                                <div class="row ms-5 ps-3 text-start">
                                    <p>Scan Me</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-title text-center col-12">
                            <form method="GET">
                                <button type="submit" name="submit" class="btn btn-success" id="print-btn">Done</button>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/js/script.js"></script>
</body>

</html>