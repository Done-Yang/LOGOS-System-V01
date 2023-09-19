<?php
    header('Content-Type: application/json');

    require_once 'db.php';
    // require_once 'admin-datas/season-db.php';
    
    $students = mysqli_query($conn, "SELECT * FROM students ORDER BY season_curent");
    $students_data = array();

    foreach($students as $row){
        $students_data[] = $row;
    }
        
    function seasons(){
        $seasons = mysqli_query($conn, "SELECT distinct season FROM seasons ");
        $seasons_data = array();
        foreach($seasons as $ss){
            $seasons_data[] = $ss;
        }

        mysqli_close($conn);

        return $seasons_data;
    }

    // Convert Array to Json 
    echo json_encode($students_data);
    // echo json_encode($seasons_data);
?>