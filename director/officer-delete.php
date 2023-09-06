<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php  

require_once 'include/config/dbcon.php';
session_start();
    
    if(!isset($_SESSION['director_login'])) {
        header('location: ../index.php');
    } else {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            include "director-datas/officer-db.php";
            if (removeOfficerById($id, $conn)) {
                // $_SESSION['success'] = "Successfully deleted!";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Officer Delete Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                header('refresh:2; url=officer-list.php');
                exit;
            } else {
                $_SESSION['error'] = "Delete Fail, Please try again!";
                header('location: officer-list.php');
                exit;
            }
        }
    }
    
?>