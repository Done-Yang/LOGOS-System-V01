
<?php 

// All season
function getAllSeasons($conn) {
    $sql = "SELECT * FROM seasons ORDER BY id DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $seasons = $stmt->fetchAll();
        return $seasons;
    } else {
        $seasons = "No Season!";
        return $seasons;
    }
}
function getLastSeason($conn) {
    $sql = "SELECT * FROM seasons ORDER BY id DESC LIMIT 1;";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        $seasons = $stmt->fetchAll();
        return $seasons;
    } else {
        $seasons = "No Season!";
        return $seasons;
    }
}

function getSeasonByID($id, $conn) {
    $sql = "SELECT * FROM seasons WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    if ($stmt->rowCount() == 1) {
        $season = $stmt->fetch();
        return $season;
    } else {
        return 0;
    }
}

// Delete
function removeSeasonByID($id, $conn) {
    $sql = "DELETE FROM seasons WHERE id=?";
    $stmt = $conn->prepare($sql);
    $re = $stmt->execute([$id]);
    if ($re) {
        return 1;
    } else {
        return 0;
    }
}











?>