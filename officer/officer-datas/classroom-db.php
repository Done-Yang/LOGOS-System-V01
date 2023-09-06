
<?php 

// All season
function getAllClassrooms($conn) {
    $sql = "SELECT * FROM classrooms";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $classrooms = $stmt->fetchAll();
        return $classrooms;
    } else {
        $classrooms = "No Classroom!";
        return $classrooms;
    }
}

function getClassroomByID($id, $conn) {
    $sql = "SELECT * FROM classrooms WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $classrooms = $stmt->fetch();
        return $classrooms;
    } else {
        return 0;
    }
}

// Delete
function removeClassroomByID($id, $conn) {
    $sql = "DELETE FROM classrooms WHERE id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}











?>