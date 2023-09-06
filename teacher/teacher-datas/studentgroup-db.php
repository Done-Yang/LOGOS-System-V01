<?php

// Get Student By $program, $part, $season_start
function getStudentGroupByPPSY($program, $part, $season_start, $conn) {
    $sql = "SELECT * FROM students WHERE program=? AND part=? AND season_start=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$program, $part, $season_start]);

    if ($stmt->rowCount() >= 1) {
        $students = $stmt->fetchAll();
        return $students;
    } else {
        $students = "No Student!";
        return $students;
    }
}



?>