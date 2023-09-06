<?php

// Get Student By Season
function getStudentBySeason($season, $conn) {
    $sql = "SELECT * FROM students WHERE season=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$season]);

    if ($stmt->rowCount() == 1) {
        $student = $stmt->fetch();
        return $student;
    } else {
        return 0;
    }
}



?>