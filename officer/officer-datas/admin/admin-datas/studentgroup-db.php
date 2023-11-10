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

function getStudentGroupByID($id, $conn){
    $sql =  "SELECT * FROM studentgroups WHERE group_id =?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() >= 1) {
        $student_group = $stmt->fetch();
        return $student_group;
    } else {
        $student_group = "No Student Group!";
        return $student_group;
    }
}

function getAllStudentGroup($conn){
    $stmt= $conn->prepare("SELECT * FROM studentgroups");
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $student_group = $stmt->fetch();
        return $student_group;
    }else{
        $student_group = 'No Student Group!';
        return $student_group;
    }
}

function removeStudent($group_id, $std_id, $year, $conn){
    $stmt=$conn->prepare("DELETE FROM studentgroups WHERE group_id=? and std_id=? and year=?");
    $re = $stmt->execute([$group_id, $std_id, $year]);
    
    $stmt2 = $conn->prepare("UPDATE students SET group_status='' WHERE std_id=?");
    $re2 = $stmt2->execute([$std_id]);

    if($re and $re2){
        return 1;
    }else{
        return 0;
    }
}

?>