<?php
// All Timetables
function getAllTimetables($conn) {
    $sql = "SELECT * FROM timetables";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $timetables = $stmt->fetchAll();
        return $timetables;
    } else {
        $timetables = "No Timetable!";
        return $timetables;
    }
}

// Get Timetables By ID
function getTimetableById($id, $conn) {
    $sql = "SELECT * FROM timetables WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $timetables = $stmt->fetch();
        return $timetables;
    } else {
        return 0;
    }
}

// Get Timetables By Season, Program, Year
function getTimetableBySPY($season, $program, $year, $conn) {
    $sql = "SELECT * FROM timetables WHERE season=? and program=? and year=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$season, $program, $year]);

    if ($stmt->rowCount() == 1) {
        $timetables = $stmt->fetch();
        return $timetables;
    } else {
        return 0;
    }
}


// Delete 
function removeSubjectById($id, $conn) {
    $sql = "DELETE FROM timetables WHERE id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}


?>