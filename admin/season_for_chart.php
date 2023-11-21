<?php
    header('Content-Type: application/json');

    require_once 'db.php';

    $select_std = "SELECT * FROM seasons ORDER BY season DESC limit 1"; 
    $seasons = mysqli_query($conn, $select_std);
    $season_data = array();

    foreach($seasons as $row){
        $season_data[] = $row;
    }

    mysqli_close($conn);


    // Convert Array to Json
    echo json_encode($season_data);
?>