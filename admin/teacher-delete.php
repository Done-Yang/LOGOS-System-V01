<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php

require_once 'include/config/dbcon.php';
session_start();

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        include "admin-datas/teacher-db.php";
        if (removeTeacherById($id, $conn)) {
            $ss=$lang['ss'];
            $ss01=$lang['ss01'];
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: '$ss',
                            text: '$ss01',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
            // $_SESSION['success'] = "Successfully deleted!";
            header('refresh:2; url=teacher-list.php');
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: teacher-list.php');
            exit;
        }
    }
}

?>