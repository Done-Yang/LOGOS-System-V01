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
            include "director-datas/director-db.php";
            if (removeDirectorById($id, $conn)) {
                // $_SESSION['success'] = "Successfully deleted!";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Director Delete Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                header('refresh:2; url=director-list.php');
                exit;
            } else {
                $_SESSION['error'] = "Delete Fail, Please try again!";
                header('location: director-list.php');
                exit;
            }
        }
    }
    
?>