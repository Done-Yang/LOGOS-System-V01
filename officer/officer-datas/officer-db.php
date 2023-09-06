<?php

// All Officer
function getAllOfficers($conn) {
    $sql = "SELECT * FROM officers ORDER BY off_id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $officers = $stmt->fetchAll();
        return $officers;
    } else {
        $officers = "No Officer!";
        return $officers;
    }
}

// Get Officer By ID
function getOfficerById($id, $conn) {
    $sql = "SELECT * FROM officers WHERE off_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $officer = $stmt->fetch();
        return $officer;
    } else {
        return 0;
    }
}
// Get User By ID
function officerGetUserById($id, $conn) {
    $sql = "SELECT * FROM users WHERE u_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch();
        return $user;
    } else {
        return 0;
    }
}


// Delete 
function removeOfficerById($id, $conn) {
    $sql = "DELETE FROM users WHERE u_id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}


?>