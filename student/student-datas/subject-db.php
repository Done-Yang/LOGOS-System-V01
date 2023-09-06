<?php
// All Subjects
function getAllSubjects($conn) {
    $sql = "SELECT * FROM subjects ORDER BY sub_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $subjects = $stmt->fetchAll();
        return $subjects;
    } else {
        $subjects = "No Subject!";
        return $subjects;
    }
}

// Get Subject By ID
function getSubjectById($sub_id, $conn) {
    $sql = "SELECT * FROM subjects WHERE sub_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$sub_id]);

    if ($stmt->rowCount() == 1) {
        $subject = $stmt->fetch();
        return $subject;
    } else {
        return 0;
    }
}

// Get subject By season, program and year
function getSubBySP($season, $program, $conn) {
    $sql = "SELECT * FROM subjects WHERE season=? AND program=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$season, $program]);

    if($stmt->rowCount() >= 1) {
        $subjects = $stmt->fetchAll();
        return $subjects;
    } else {
        $subjects = "No Subjects!";
        return $subjects;
    }
}


// Delete 
function userRemoveSubjectById($sub_id, $conn) {
    $sql = "DELETE FROM subjects WHERE sub_id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$sub_id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}


?>