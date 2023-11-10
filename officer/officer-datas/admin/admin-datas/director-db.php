<?php

// All Director
function getAllDirectors($conn) {
    $sql = "SELECT * FROM directors ORDER BY dir_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $directors = $stmt->fetchAll();
        return $directors;
    } else {
        $directors = "No Director!";
        return $directors;
    }
}

// Get Director By ID
function getDirectorById($id, $conn) {
    $sql = "SELECT * FROM directors WHERE dir_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $director = $stmt->fetch();
        return $director;
    } else {
        return 0;
    }
}

// Get User By ID
function directorGetUserById($id, $conn) {
    $sql = "SELECT * FROM users WHERE u_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        return $user;
    } else {
        return 0;
    }
}

// Delete 
function removeDirectorById($id, $conn) {
    $sql = "DELETE FROM users WHERE u_id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}


?>