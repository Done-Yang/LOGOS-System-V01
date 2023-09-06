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

    include "director-datas/classroom-db.php";
    $classrooms = getAllClassrooms($conn);
    $search_by = '';

    if (isset($_REQUEST['search'])) {
        try {
            $search_by = $_REQUEST['search_by'];
            if (!empty($search_by)) {

                $classrooms = $conn->prepare("SELECT * FROM classrooms WHERE classroom=:classroom");
                $classrooms->bindParam(':classroom', $search_by);
                $classrooms->execute();
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
                                <h3 class="page-title">Classroom</h3>

                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="classroom-list.php">Classroom</a></li>
                                    <li class="breadcrumb-item active">All Classrooms</li>
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
                                            <h3 class="page-title">Classroom</h3>
                                        </div>
                                        <div class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="classroom-add.php" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a>
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
                                    <table
                                        class="table border-0 star-student table-hover table-center mb-0 datatable table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th>Classroom</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                                <th class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $i = 0;
                                            if ($classrooms == "No Classroom!") { ?>
                                            <tr>
                                                <td>No Classroom!</td>
                                            </tr>
                                            <?php } else {
                                                foreach ($classrooms as $classroom) {
                                                    $i++; ?>

                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td><?php echo $classroom['classroom'] ?></td>
                                                <td><?php echo $classroom['created_at'] ?></td>
                                                <td><?php echo $classroom['updated_at'] ?></td>
                                                <td class="text-end">
                                                    <div class="actions ">
                                                        <a href="classroom-edit.php?id=<?= $classroom['id'] ?>"
                                                            class="btn btn-sm bg-danger-light">
                                                            <i class="feather-edit"></i>
                                                        </a>
                                                        <a href="classroom-delete.php?id=<?= $classroom['id'] ?>"
                                                            class="btn btn-sm bg-danger-light"
                                                            onclick="return confirm('Do you want to delete this item?')">
                                                            <i class="feather-delete"></i>
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