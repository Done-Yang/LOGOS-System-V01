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
            
            $status = 'Officer';
            $change_off_status = $conn->prepare("UPDATE users SET status='$status' WHERE u_id='$id' ");
            $change_off_status->execute();
            
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'Success',
                        text: 'Officer status have changed successfully.',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                });
            </script>";
            header('refresh:2; url=admin-list.php');
            exit;
        }
    }
