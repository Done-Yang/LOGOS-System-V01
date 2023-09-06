
<?php 


// All Group
function getAllGroups($conn) {
    $sql = "SELECT * FROM groups";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $groups = $stmt->fetchAll();
        return $groups;
    } else {
        $groups = "No Groups!";
        return $groups;
    }
}

// Get group By $program, $part, $season
function getAllGroupByPPSY($program, $part, $season, $year, $conn) {
    $sql = "SELECT * FROM groups WHERE program=? AND part=? AND season=? AND year=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$program, $part, $season, $year]);

    if ($stmt->rowCount() >= 1) {
        $groups = $stmt->fetchAll();
        return $groups;
    } else {
        $groups = "No Groups!";
        return $groups;
    }
}

function getGroupByID($group_id, $conn) {
    $sql = "SELECT * FROM groups WHERE group_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$group_id]);

    if ($stmt->rowCount() == 1) {
        $groups = $stmt->fetch();
        return $groups;
    } else {
        return 0;
    }
}

// Delete
function removeGroupByID($group_id, $conn) {
    $sql = "DELETE FROM groups WHERE group_id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$group_id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}











?>