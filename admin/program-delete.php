<?php
session_start();
require_once 'include/config/dbcon.php';
require_once 'include/config/language.php';


include "admin-datas/program-db.php";

if (!isset($_SESSION['admin_login'])) {
    header('location: ../index.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (removeProgramByID($id, $conn)) {
            $ss=$lang['ss'];
            $ss01=$lang['ss01'];
            $_SESSION['success'] = "$ss01";
            header('location: program-list.php');
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: program-list.php');
            exit;
        }
    }
}
