<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php
require_once 'include/config/dbcon.php';
session_start();

include "director-datas/studentgroup-db.php";

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    $id = $_SESSION['director_login'];
    include "director-datas/officer-db.php";
    $user = officerGetUserById($id, $conn);
    $officer = getOfficerById($id, $conn);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (removeStudent($id, $conn)) {
            // $_SESSION['success'] = "Successfully deleted student from student group!";

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
            header("refresh:2; url=studentgroup-detail.php?id=$id");
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: season-list.php');
            exit;
        }
    }
}

?>