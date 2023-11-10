
<?php 

// All season
function getAllPrograms($conn) {
    $sql = "SELECT * FROM programs";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $programs = $stmt->fetchAll();
        return $programs;
    } else {
        $programs = "No Program!";
        return $programs;
    }
}

function getProgramByID($id, $conn) {
    $sql = "SELECT * FROM programs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $program = $stmt->fetch();
        return $program;
    } else {
        return 0;
    }
}

// Delete
function removeProgramByID($id, $conn) {
    $sql = "DELETE FROM programs WHERE id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}











?>