<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php  
    require_once 'include/config/dbcon.php';
    session_start();
    
    if(!isset($_SESSION['admin_login'])) {
        header('location: ../index.php');
    } else {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            include "admin-datas/group-db.php";
            if (removeGroupByID($id, $conn)) {
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'Success',
                            text: 'Group Delete Successfully!',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    });
                </script>";
                // $_SESSION['success'] = "Successfully deleted!";
                header('refresh:2; url=group-list.php');
                exit;
            } else {
                $_SESSION['error'] = "Delete Fail, Please try again!";
                header('location: classroom-list.php');
                exit;
            }
        }
    }
    
?>