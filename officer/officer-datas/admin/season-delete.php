<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();
include "admin-datas/season-db.php";

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['admin_login'];
    include "admin-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (removeSeasonByID($id, $conn)) {
            // $_SESSION['success'] = "Successfully deleted!";

            echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Season Delete Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
            header('refresh:2; url=season-list.php');
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: season-list.php');
            exit;
        }
    }
}

?>