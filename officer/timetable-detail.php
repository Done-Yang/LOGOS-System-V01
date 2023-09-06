<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
session_start();
require_once 'include/config/dbcon.php';
if (!isset($_SESSION['officer_login'])) {
    header('location: ../index.php');
    exit;
} else {
    $id = $_SESSION['officer_login'];
    include "officer-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    include "officer-datas/program-db.php";
    include "officer-datas/season-db.php";
    include "officer-datas/timetable-db.php";
    $programs = getAllPrograms($conn);
    $seasons = getLastSeason($conn);

    $timetables1 = '';
    $timetables2 = '';
    $group_id = '';


    if (isset($_GET['id'])) {
        try {
            $group_id = $_GET['id'];

            $timetables1 = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id");
            $timetables1->bindParam(':group_id', $group_id);
            $timetables1->execute();

            $timetables2 = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id");
            $timetables2->bindParam(':group_id', $group_id);
            $timetables2->execute();

            // For get the first row in timetables
            $datas = $conn->prepare("SELECT * FROM timetables WHERE group_id=:group_id LIMIT 1");
            $datas->bindParam(':group_id', $group_id);
            $datas->execute();

            include "officer-datas/subject-db.php";
            include "officer-datas/teacher-db.php";
        } catch (PDOException $e) {
            $e->getMessage();
        }

        if(isset($_POST['delete'])) {
            if (removeTimetableBbGroupID($group_id, $conn)) {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Delete Time Table From Student Group Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                header("refresh:2; url=timetable-detail.php?id=$group_id");
                exit;
            } else {
                $_SESSION['error'] = "Delete Fail, Please try again!";
                header("refresh:2; url=timetable-detail.php?id=$group_id");
                exit;
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

    <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet" href="../assets/css/validate-form.css">
    
    <link rel="stylesheet" href="../assets/css/print-style.css" media="print">
    <style>
    @media print {
        body {
            font-size: 11pt;
        }

        @page {
            size: A4;
        }

        .table {
            width: 100%;
            font-size: 10pt;
            border: 1px solid black;
        }

        .table,
        thead,
        tr,
        th {
            margin: 0;
            padding: 0;
        }
    }
    </style>
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

                <div class="page-header" id="print-btn">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-sub-header">
                                <h3 class="page-title">Time Teble List</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="timetable-list.php">Time Tebles</a></li>
                                    <li class="breadcrumb-item active">Time Teble List</li>
                                </ul>
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
                                <?php if (isset($_SESSION['error'])) { ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php
                                        echo $_SESSION['error'];
                                        unset($_SESSION['error']);
                                        ?>
                                </div>
                                <?php } ?>
                                <div class="page-header">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h3 class="page-title">Time Tables</h3>
                                        </div>
                                        <div id="print-btn" class="col-auto text-end float-end ms-auto download-grp">
                                            <button onclick="window.print();" class="btn btn-primary ms-5"><i
                                                    class="fas fa-print"></i></button>
                                        </div>
                                        <!-- <div id="print-btn" class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="timetable-edit.php?id=<?= $group_id ?>" class="btn btn-primary"><i
                                                    class="fas fa-edit"></i></a>
                                        </div>
                                        <div id="print-btn" class="col-auto text-end float-end ms-auto download-grp">
                                            <a href="timetable-add.php" class="btn btn-primary"><i
                                                    class="fas fa-plus"></i></a>
                                        </div>
                                        <form id="print-btn" method="POST" action=""
                                            class="col-auto text-end float-end ms-auto download-grp mt-3">
                                            <button type="submit" name="delete" class="btn btn-primary"
                                                onclick="return confirm('Do you want to delete all infomation in this time table?')">
                                                <i class="feather-delete"></i>
                                            </button>
                                        </form> -->
                                    </div>
                                </div>
                                <?php if ($_GET['id']) {
                                    foreach ($datas as $data) { ?>
                                <div class="table-responsive">
                                    <div class="container">
                                        <p class="text-center"><b><?php echo $data['program'] ?>'s Learning Schedule
                                                (<?php echo $data['part'] ?>)</b></p>
                                        <p class="text-center">For class: <?php echo $data['group_id'] ?>,
                                            <?php echo $data['year'] ?>st, Semester <?php echo $data['semester'] ?>, in
                                            Academic year <?php echo $data['season'] ?></p>
                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center ttb-print-style">
                                                <thead>
                                                    <tr class="bg-light-gray">
                                                        <th class="text-uppercase">Time</th>
                                                        <th class="text-uppercase">Monday</th>
                                                        <th class="text-uppercase">Tuesday</th>
                                                        <th class="text-uppercase">Wednesday</th>
                                                        <th class="text-uppercase">Thursday</th>
                                                        <th class="text-uppercase">Friday</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>

                                                        <td class="align-middle">
                                                            <?php echo $data['times1'] ?>
                                                        </td>

                                                        <?php foreach ($timetables1 as $timetable) {
                                                                    
                                                                    if($timetable['sub1_id'] != ''){
                                                                        $subject = getSubjectById($timetable['sub1_id'], $conn);
                                                                        $subject1 = $subject['name'];
                                                                    }else{
                                                                        $subject1 = 'No Subject';
                                                                    }
                                                                    if($timetable['teacher1_id'] != ''){
                                                                        $teacher = getTeacherById($timetable['teacher1_id'], $conn);
                                                                        $teacher1 = $teacher['fname_en'];
                                                                    }else{
                                                                        $teacher1 = 'No Professor';
                                                                    }

                                                                    if ($timetable['days'] == 'Monday') { ?>
                                                        <td>
                                                            <span><?php echo $subject1 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book1'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class1'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher1 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Tuesday') { ?>
                                                        <td>
                                                            <span><?php echo $subject1 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book1'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class1'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher1 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Wednesday') { ?>
                                                        <td>
                                                            <span><?php echo $subject1 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book1'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class1'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher1 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Thursday') { ?>
                                                        <td>
                                                            <span><?php echo $subject1 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book1'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class1'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher1 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Friday') { ?>
                                                        <td>
                                                            <span><?php echo $subject1 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book1'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class1'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher1 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                } ?>
                                                    </tr>

                                                    <tr>
                                                        <td class="align-middle">
                                                            <?php echo $data['times2'] ?>
                                                        </td>

                                                        <?php foreach ($timetables2 as $timetable) {
                                                                    if($timetable['sub2_id'] != ''){
                                                                        $subject = getSubjectById($timetable['sub2_id'], $conn);
                                                                        $subject2 = $subject['name'];
                                                                    }else{
                                                                        $subject2 = 'No Subject';
                                                                    }
                                                                    if($timetable['teacher2_id'] != ''){
                                                                        $teacher = getTeacherById($timetable['teacher2_id'], $conn);
                                                                        $teacher2 = $teacher['fname_en'];
                                                                    }else{
                                                                        $teacher2 = 'No Professor';
                                                                    }
                                                                    if ($timetable['days'] == 'Monday') { ?>
                                                        <td>
                                                            <span><?php echo $subject2 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book2'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class2'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher2 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Tuesday') { ?>
                                                        <td>
                                                            <span><?php echo $subject2 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book2'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class2'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher2 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Wednesday') { ?>
                                                        <td>
                                                            <span><?php echo $subject2 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book2'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class2'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher2 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Thursday') { ?>
                                                        <td>
                                                            <span><?php echo $subject2 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book2'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class2'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher2 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                    if ($timetable['days'] == 'Friday') { ?>
                                                        <td>
                                                            <span><?php echo $subject2 ?></span>
                                                            <div class="small text-secondary">(Book id:
                                                                <?php echo $timetable['book2'] ?>)</div>
                                                            <div class="small text-secondary">(Room:
                                                                <?php echo $timetable['class2'] ?>)</div>
                                                            <div class="small text-secondary">(Prf:
                                                                <?php echo $teacher2 ?> )</div>
                                                        </td>
                                                        <?php }
                                                                } ?>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div><br><br>
                                        <p><i><b>Remark: </b></i></p>
                                        <p><i>1. Google Meet Link will be post on Google Classroom.</i></p>
                                        <p><i>2. Join your online class as scheduled everyday.</i></p>
                                        <p><i>3. Don't be LATE! Attendance will be taken!</i></p>
                                    </div>
                                </div>
                                <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
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