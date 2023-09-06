<?php
require_once 'include/config/dbcon.php';
session_start();

include "director-datas/program-db.php";

if (!isset($_SESSION['director_login'])) {
    header('location: ../index.php');
} else {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        if (removeProgramByID($id, $conn)) {
            $_SESSION['success'] = "Successfully deleted!";
            header('location: program-list.php');
            exit;
        } else {
            $_SESSION['error'] = "Delete Fail, Please try again!";
            header('location: program-list.php');
            exit;
        }
    }
}
