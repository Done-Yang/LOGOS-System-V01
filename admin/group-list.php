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
    
    include "admin-datas/group-db.php";
    $groups = getAllGroups($conn);
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
                                <h3 class="page-title"><?php echo $lang['group'] ?></h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="group-list.php"><?php echo $lang['group'] ?></a></li>
                                    <li class="breadcrumb-item active"><?php echo $lang['all_group'] ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="student-group-form">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo $lang['search_byID'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo $lang['search_byName'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="<?php echo $lang['search_byPhone'] ?>">
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="search-student-btn">
                                <button type="btn" class="btn btn-primary"><?php echo $lang['search'] ?></button>
                            </div>
                        </div>
                    </div>
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
                                            <h3 class="page-title"><?php echo $lang['group'] ?></h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="group-add.php" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <?php
                                    if (isset($errorMsg)) {
                                    ?>
                                        <div class="alert alert-danger">
                                            <strong><?php echo $errorMsg; ?></strong>
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if (isset($successMsg)) {
                                    ?>
                                        <div class="alert alert-success">
                                            <strong><?php echo $successMsg; ?></strong>
                                        </div>
                                    <?php } ?>
                                    <table class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th><?php echo $lang['no'] ?></th>
                                                <th><?php echo $lang['group'] ?></th>
                                                <th><?php echo $lang['program'] ?></th>
                                                <th><?php echo $lang['season'] ?></th>
                                                <th><?php echo $lang['part'] ?></th>
                                                <th><?php echo $lang['years'] ?></th>
                                                <th><?php echo $lang['createAt'] ?></th>
                                                <th><?php echo $lang['updateAt'] ?></th>
                                                <th class="text-end"><?php echo $lang['action'] ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i = 0;
                                            if ($groups == "No Groups!") { ?>
                                                <tr>
                                                    <td><?php echo $lang['noGroup'] ?></td>
                                                </tr>
                                                <?php } else {
                                                foreach ($groups as $group) {
                                                    $i++; ?>

                                                    <tr>
                                                        <td><?php echo $i ?></td>
                                                        <td><?php echo $group['group_id'] ?></td>
                                                        <td><?php echo $group['program'] ?></td>
                                                        <td><?php echo $group['season'] ?></td>
                                                        <td><?php echo $group['part'] ?></td>
                                                        <td><?php echo $group['year'] ?></td>
                                                        <td><?php echo $group['created_at'] ?></td>
                                                        <td><?php echo $group['updated_at'] ?></td>
                                                        <td class="text-end">
                                                            <div class="actions ">
                                                                <a href="group-edit.php?id=<?= $group['group_id'] ?>" class="btn btn-sm bg-danger-light">
                                                                    <i class="feather-edit"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                            <?php }
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