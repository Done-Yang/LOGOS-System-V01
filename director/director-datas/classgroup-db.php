<?php


// Get students By program, season_start and part
function getStdinPSP($program, $season_start, $part, $conn) {
    $sql = "SELECT * FROM students WHERE program=? and $season_start=? and $part=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$program, $season_start, $part]);

    if ($stmt->rowCount() >= 1) {
        $students = $stmt->fetch();
        return $students;
    } else {
        $students = 'No Student!';
        return $students;
    }
}


?>