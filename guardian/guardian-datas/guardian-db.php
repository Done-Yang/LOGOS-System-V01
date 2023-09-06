<?php 
    function guardianGetUserById($id, $conn) {
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

?>