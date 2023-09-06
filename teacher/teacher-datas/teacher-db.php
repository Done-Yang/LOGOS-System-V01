<?php

// All teachers
function getAllTeachers($conn) {
    $sql = "SELECT * FROM teachers ORDER BY t_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $teachers = $stmt->fetchAll();
        return $teachers;
    } else {
        $teachers = "No Teacher!";
        return $teachers;
    }
}

// Get teacher By ID
function getTeacherById($id, $conn) {
    $sql = "SELECT * FROM teachers WHERE t_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $teacher = $stmt->fetch();
        return $teacher;
    } else {
        return 0;
    }
}
// Get User By ID
function teacherGetUserById($id, $conn) {
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
function removeTeacherById($id, $conn) {
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