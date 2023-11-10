<?php
    header('Content-Type: application/json');

    require_once 'db.php';

    $sqlQuery = "SELECT * FROM studentgroups";
    $result = mysqli_query($conn, $sqlQuery);
    $data_student = array();

    foreach($result as $row){
        $data_student[] = $row;
    }

    mysqli_close($conn);

    // Convert Array to Json 
    echo json_encode($data_student);

    
?>


