<?php
require_once 'admin/include/config/dbcon.php';

$stm = $conn->prepare("SELECT * FROM users");
$stm->execute();

// Use fetchAll to retrieve all rows as an array of associative arrays
$rows = $stm->fetchAll(PDO::FETCH_ASSOC);

foreach ($rows as $row) {
    echo $row['u_pass'] . "<br>";
    // Get information about the password hash
    $hashInfo = password_get_info($row['u_pass']);

    // Check the hash type
    if ($hashInfo['algoName'] === 'bcrypt') {
        echo "Password is allready hashed!. <br>";
    } else {
        // User's password to be hashed
        $user_password = $row['u_pass'];

        // Hash the password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $u_id = $row['u_id'];
        $update_normal_pass_to_hash = $conn->prepare("UPDATE users SET u_pass = '$hashed_password' WHERE u_id = '$u_id'");
        $update_normal_pass_to_hash->execute();
        echo $row['u_pass'] . "done hashing. <br>";
    }
}
?>
