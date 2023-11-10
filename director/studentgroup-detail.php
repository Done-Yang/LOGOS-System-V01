<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/officer-db.php";
    include "director-datas/director-db.php";
    $user = directorGetUserById($id, $conn);
    $director = getDirectorById($id, $conn);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // $students = $conn->prepare("SELECT group_id, students.std_id, fname_en, lname_en, image FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id");
        $students = $conn->prepare("SELECT * FROM studentgroups INNER JOIN students ON studentgroups.std_id=students.std_id WHERE group_id=:group_id");
        $students->bindParam(':group_id', $id);
        $students->execute();

        include "director-datas/group-db.php";
        include "director-datas/studentgroup-db.php";
        $std_group = getGroupByID($id, $conn);

        // Count students
        $count_std = $conn->prepare("SELECT COUNT(*) AS count FROM studentgroups WHERE group_id=:group_id");
        $count_std->bindParam(":group_id", $id);
        $count_std->execute();
        while ($row = $count_std->fetch(PDO::FETCH_ASSOC)) {
            $count_std_resault = $row['count'];
        };

        if (isset($_REQUEST['submit'])) {
            try {
                $delete_id = $_REQUEST['std_id'];
                $group_id = $_REQUEST['group_status'];
                $year = $_REQUEST['year'];

                if (removeStudent($group_id, $delete_id, $year, $conn)) {
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
                    // header("refresh:2; url=studentgroup-detail.php?id=$group_id");
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
                    <div class="card card-table comman-shadow">
                        <div class="card-body">
                            
                            <?php if (isset($_SESSION['error'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php
                                    echo $_SESSION['error'];
                                    unset($_SESSION['error']);
                                    ?>
                            </div>
                            <?php } ?>
                            <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php
                                    echo $_SESSION['success'];
                                    unset($_SESSION['success']);
                                    ?>
                            </div>
                            <?php } ?>
                            <form method="post">
                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col-6">
                                            <h3 class="page-title">Entire Student: <?php echo $count_std_resault ?>,
                                                Program: <?php echo $std_group['program'] ?>, Year:
                                                <?php echo $std_group['year'] ?>, Part: <?php echo $std_group['part'] ?>,
                                                Class: <?php echo $std_group['group_id'] ?> </h3>
                                        </div>
                                        <?php if ($students->rowCount() > 0) { ?>
                                        <div class="col-6 text-end float-end">
                                            <a href="studentgroup-card-preview.php?id=<?= $std_group['group_id'] ?>" id="print-btn" class="btn btn-primary"><i class="fas fa-address-card"></i></a>
                                            <a href="studentgroup-clone.php?std_g_id=<?= $std_group['group_id'] ?>" class="btn btn-primary ms-3" id="print-btn"><i class="fas fa-clone"></i></a>
                                            <button onclick="window.print();" class="btn btn-primary ms-3" id="print-btn"><i class="fas fa-print"></i></button>
                                            <a href="studentgroup-add.php?std_g_id=<?= $std_group['group_id'] ?>" class="btn btn-primary ms-3" id="print-btn"><i class="fas fa-plus"></i></a>
                                        </div>
                                        <?php } else { ?>
                                        <div class="col-6 text-end float-end ms-auto download-grp">
                                            <a href="studentgroup-add.php?" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered star-student table-hover table-center mb-0 table-striped">
                                        <thead class="student-thread">
                                            <tr>
                                                <th>No</th>
                                                <th id="print-btn">Student ID</th>
                                                <th>Full Name</th>
                                                <th id="print-btn">Study Program</th>
                                                <th id="print-btn">Part</th>
                                                <th id="print-btn">Year</th>
                                                <th>Tel</th>
                                                <th>Email Address</th>
                                                <th>Status</th>
                                                <th class="text-end" id="print-btn">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 0;
                                            if ($students == "No Student!") {  ?>
                                            <tr>
                                                <td>No Student!</td>
                                            </tr>
                                            <?php } else {
                                                foreach ($students as $student) {
                                                    $i++; ?>
                                            <tr>
                                                <td><?php echo $i ?></td>
                                                <td id="print-btn"><?php echo $student['std_id'] ?></td>
                                                <td>
                                                    <h2 class="table-avatar">
                                                        <?php
                                                                $student_image = $student['image'];

                                                                if ($student_image == '') { ?>
                                                        <a href="student-detail.php?id=<?= $student['std_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "../admin/upload/profile.png" ?>"
                                                                alt="User Image"></a>
                                                        <?php } else { ?>
                                                        <a href="student-detail.php?id=<?= $student['std_id'] ?>"
                                                            class="avatar avatar-sm me-2"><img
                                                                class="avatar-img rounded-circle"
                                                                src="<?php echo "../admin/upload/student_profile/$student_image" ?>"
                                                                alt="User Image"></a>
                                                        <?php } ?>



                                                        <?php
                                                                if ($student['gender'] == 'Male') { ?>
                                                        <a>Mr
                                                            <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                        <?php } else { ?>
                                                        <a>Miss
                                                            <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                                                        <?php }
                                                                ?>      
                                                    </h2>
                                                </td>
                                                <td id="print-btn"><?php echo $student['program'] ?></td>
                                                <td id="print-btn"><?php echo $student['part'] ?></td>
                                                <td id="print-btn" name="year"><?php echo $student['year'] ?></td>
                                                <input type="hidden" name="year" value="<?php echo $student['year'] ?>" >
                                                <td><?php echo $student['tel'] ?></td>
                                                <td><?php echo $student['email'] ?></td>
                                                <td><?php echo $student['std_status'] ?></td>

                                                <td class="text-end" id="print-btn">
                                                    <div class="actions ">
                                                        <a href="student-detail.php?id=<?= $student['std_id'] ?>"
                                                            class="btn btn-sm bg-success-light me-2 ">
                                                            <i class="feather-eye"></i>
                                                        </a>
                                                        <input type="text" value="<?php echo $student['std_id'] ?>"
                                                            name="std_id" hidden>
                                                        <input type="text"
                                                            value="<?php echo $student['group_id'] ?>"
                                                            name="group_status" hidden>
                                                        <button type="submit" name="submit"
                                                            class="btn btn-sm bg-danger-light"
                                                            onclick="return confirm('Do you want to delete this item?')">
                                                            <i class="feather-delete"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php  }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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