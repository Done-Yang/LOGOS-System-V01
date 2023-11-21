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

    include "admin-datas/director-db.php";
    $directors = getAllDirectors($conn);
    $search_by = '';

    if (isset($_REQUEST['search'])) {
        try {
            $search_by = $_REQUEST['search_by'];
            if (!empty($search_by)) {
                $directors = $conn->prepare("SELECT * FROM directors WHERE durector_id=:durector_id OR fname_en=:fname_en OR lname_en=:lname_en");
                $directors->bindParam(':dir_id', $search_by);
                $directors->bindParam(':fname_en', $search_by);
                $directors->bindParam(':lname_en', $search_by);
                $directors->execute();
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
                                <h3 class="page-title"><?php echo $lang['director'] ?></h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="officer-list.php"><?php echo $lang['director'] ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $lang['all_dir'] ?></li>
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
                                    <button type="submit" name="search" class="btn btn-primary"><?php echo $lang['search'] ?></button>
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
                                            <h3 class="page-title"><?php echo $lang['off01'] ?></h3>
                                        </div>
                                        <!-- <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="director-add.php" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table
                                        class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th><?php echo $lang['no'] ?></th>
                                                <th><?php echo $lang['dir_id'] ?></th>
                                                <th><?php echo $lang['full_name'] ?></th>
                                                <th><?php echo $lang['tel'] ?></th>
                                                <th><?php echo $lang['email'] ?></th>
                                                <th class="text-end"><?php echo $lang['action'] ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            if ($directors == "No Director!") {  ?>
                                            <tr>
                                                <td><?php echo $lang['no_dir'] ?></td>
                                            </tr>
                                            <?php } else {
                                                foreach ($directors as $director) {
                                                    $i++; ?>

                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $director['dir_id'] ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <?php $director_image = $director['image'];
                                                                if ($director_image == '') { ?>
                                                        <a href="director-detail.php?id=<?= $director['dir_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "upload/profile.png" ?>"
                                                                alt="User Image"></a>
                                                        <?php } else { ?>
                                                        <a href="director-detail.php?id=<?= $director['dir_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "upload/director_profile/$director_image" ?>"
                                                                alt="User Image"></a>
                                                        <?php } ?>

                                                        <?php
                                                                if ($director['gender'] == 'Male') { ?>
                                                        <a><?php echo $lang['mr'] ?>
                                                            <?php echo $director['fname_en'] . " " . $director['lname_en'] ?></a>
                                                        <?php } else { ?>
                                                        <a><?php echo $lang['miss'] ?>
                                                            <?php echo $director['fname_en'] . " " . $director['lname_en'] ?></a>
                                                        <?php }
                                                                ?>
                                                    </h2>
                                                </td>
                                                <td><?php echo $director['tel'] ?></td>
                                                <td><?php echo $director['email'] ?></td>
                                                <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="director-detail.php?id=<?= $director['dir_id'] ?>"
                                                            class="btn btn-sm bg-success-light me-2 ">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <!-- <a href="director-edit.php?id=<?= $director['dir_id'] ?>"
                                                            class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="director-delete.php?id=<?= $director['dir_id'] ?>"
                                                            class="btn btn-sm bg-danger-light" onclick="return confirm('Do you want to delete this item?')">
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