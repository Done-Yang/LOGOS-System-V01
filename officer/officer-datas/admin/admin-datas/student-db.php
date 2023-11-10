<?php
// All students
function getAllStudents($conn) {
    $sql = "SELECT * FROM students ORDER BY std_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $students = $stmt->fetchAll();
        return $students;
    } else {
        $students = "No Student!";
        return $students;
    }
}


// Get Student By ID
function getStudentById($id, $conn) {
    $sql = "SELECT * FROM students WHERE std_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $student = $stmt->fetch();
        return $student;
    } else {
        return 0;
    }
}

// Get User By ID
function studentGetUserById($id, $conn) {
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
function removeStudentById($id, $conn) {
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