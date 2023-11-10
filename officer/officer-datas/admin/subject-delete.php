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
        include "admin-datas/subject-db.php";
        if (userRemoveSubjectById($id, $conn)) {
            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Subject Delete Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
            // $_SESSION['success'] = "Successfully deleted!";
            header('refresh:2; url=subject-list.php');
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: subject-list.php');
            exit;
        }
    }
}

?>