<script src="../assets/js/jquery-3.6.0.min.js"></script>
<script src="../assets/js/sweetalert2.js"></script>
<?php  

require_once 'include/config/dbcon.php';
require_once 'include/config/language.php';
session_start();
    
    if(!isset($_SESSION['admin_login'])) {
        header('location: ../index.php');
    } else {
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            include "admin-datas/classroom-db.php";
            if (removeClassroomByID($id, $conn)) {
                // $_SESSION['success'] = "Successfully deleted!";
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
                header('refresh:2; url=classroom-list.php');
                exit;
            } else {
                // $_SESSION['error'] = "Delete Fail, Please try again!";
                header('location: classroom-list.php');
                exit;
            }
        }
    }
