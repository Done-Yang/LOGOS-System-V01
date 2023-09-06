
<?php 

// All season
function getAllRooms($conn) {
    $sql = "SELECT * FROM rooms ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $rooms = $stmt->fetchAll();
        return $rooms;
    } else {
        $rooms = "No Room!";
        return $rooms;
    }
}

function getRoomByID($id, $conn) {
    $sql = "SELECT * FROM rooms WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $rooms = $stmt->fetch();
        return $rooms;
    } else {
        return 0;
    }
}

// Delete
function removeRoomByID($id, $conn) {
    $sql = "DELETE FROM rooms WHERE id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}











?>