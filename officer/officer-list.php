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
    
    $officers = getAllOfficers($conn);
    $search_by = '';

    if (isset($_REQUEST['search'])) {
        try {
            $search_by = $_REQUEST['search_by'];
            if (!empty($search_by)) {

                $officers = $conn->prepare("SELECT * FROM officers WHERE off_id=:off_id OR fname_en=:fname_en OR lname_en=:lname_en");
                $officers->bindParam(':off_id', $search_by);
                $officers->bindParam(':fname_en', $search_by);
                $officers->bindParam(':lname_en', $search_by);
                $officers->execute();
            }
        } catch (PDOException $e) {
            $e->getMessage();
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
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Officer</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="officer-list.php">Officer</a></li>
                                    <li class="breadcrumb-item active">All Officers</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-group-form">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-3 col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search here ..."
                                        name="search_by" value="<?php echo $search_by ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="search-student-btn">
                                    <button type="submit" name="search" class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card card-table comman-shadow">
                            <div class="card-body">

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
                                        <div class="col">
                                            <h3 class="page-title">Officer</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <!-- <a href="officer-add.php" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table
                                        class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th>Officer ID</th>
                                                <th>Full Name</th>
                                                <th>Tel</th>
                                                <th>Email Address</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            if ($officers == "No Officer!") {  ?>
                                            <tr>
                                                <td>No Officer!</td>
                                            </tr>
                                            <?php } else {
                                                foreach ($officers as $officer) {
                                                    $i++; ?>

                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $officer['off_id'] ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <?php $officer_image = $officer['image'];
                                                                if ($officer_image == '') { ?>
                                                        <a href="officer-detail.php?id=<?= $officer['off_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "../admin/upload/profile.png" ?>"
                                                                alt="User Image"></a>
                                                        <?php } else { ?>
                                                        <a href="officer-detail.php?id=<?= $officer['off_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "../admin/upload/officer_profile/$officer_image" ?>"
                                                                alt="User Image"></a>
                                                        <?php } ?>

                                                        <?php
                                                                if ($officer['gender'] == 'Male') { ?>
                                                        <a>Mr
                                                            <?php echo $officer['fname_en'] . " " . $officer['lname_en'] ?></a>
                                                        <?php } else { ?>
                                                        <a>Miss
                                                            <?php echo $officer['fname_en'] . " " . $officer['lname_en'] ?></a>
                                                        <?php }
                                                                ?>
                                                    </h2>
                                                </td>
                                                <td><?php echo $officer['tel'] ?></td>
                                                <td><?php echo $officer['email'] ?></td>
                                                <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="officer-detail.php?id=<?= $officer['off_id'] ?>"
                                                            class="btn btn-sm bg-success-light me-2 ">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <!-- <a href="officer-edit.php?id=<?= $officer['off_id'] ?>"
                                                            class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a> -->
                                                        <!-- <a href="officer-delete.php?id=<?= $officer['off_id'] ?>"
                                                            class="btn btn-sm bg-danger-light"
                                                            onclick="return confirm('Do you want to delete this item?')">
                                                            <i class="feather-delete"></i>
                                                        </a> -->
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php  }
                                            } ?>
                                        </tbody>
                                    </table>
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


    <script src="../assets/js/jquery-3.6.0.min.js"></script>

    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/js/feather.min.js"></script>

    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="../assets/plugins/datatables/datatables.min.js"></script>

    <script src="../assets/js/script.js"></script>

</body>

</html>