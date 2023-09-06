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
        $timetable = $stmt->fetch();
        return $timetable;
    } else {
        return 0;
    }
}

// Get Timetables By Group ID
function getTimetableByGroupId($group_id, $conn) {
    $sql = "SELECT * FROM timetables WHERE group_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$group_id]);

    if ($stmt->rowCount() == 1) {
        $timetable = $stmt->fetch();
        return $timetable;
    } else {
        return 0;
    }
}

// Get Timetables By ID
function getTimetableBySeason($season, $semester, $conn) {
    $sql = "SELECT * FROM timetables WHERE season=? and $semester=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$season, $semester]);

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