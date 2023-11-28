<?php 
    if($_REQUEST['check'] == 'true'){
        $studentID = $_REQUEST[$i . 'studentID'];
        $check_u_id = $conn->prepare("SELECT std_id FROM studentgroups WHERE std_id = :std_id");
        $check_u_id->bindParam(":std_id", $studentID);
        $check_u_id->execute();
        try{
            if($check_u_id->rowCount() > 0){
                // For Group student's class
                $stmt1 = $conn->prepare("UPDATE studentgroups SET group_id='$group_id', t_id='$teacher',  program='$program', season='$season', year='$year', part='$part' WHERE std_id='$studentID'");
                $stmt1->execute();

                // For Student group's status
                $stmt2 = $conn->prepare("UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                $stmt2->execute();
            }else{
                // For Group student's class
                $stmt1 = $conn->prepare("INSERT INTO studentgroups (group_id, t_id, std_id, program, season, year, part)
                            VALUES ('$group_id', '$teacher', '$studentID', '$program', '$season', '$year', '$part')");
                $stmt1->execute();

                // For Student group's status
                $stmt2 = $conn->prepare("UPDATE students SET group_status='$group_id' WHERE std_id='$studentID'");
                $stmt2->execute();
            }
        }catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <thead class="student-thread">
        <tr>
            <th>Select</th>
            <th>No</th>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Study Program</th>
            <th>Part</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><input type="checkbox" name="check" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
            <td><?php echo $i ?></td>
            <td><?php echo $student['std_id'] ?></td>
            <input type="hidden" name="<?php echo $i . 'studentID' ?>" value="<?php echo $student['std_id'] ?>">
            <td>
                <h2 class="table-avatar">
                    <?php
                        $student_image = $student['image'];
    
                        if ($student_image == '') { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image"></a>
                        <?php } else { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/student_profile/$student_image" ?>"
                                alt="User Image"></a>
                    <?php } ?>
    
    
    
                    <?php
                        if ($student['gender'] == 'Male') { ?>
                    <a>Mr
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } else { ?>
                    <a>Miss
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } ?>
                </h2>
            </td>
            <td><?php echo $student['program'] ?></td>
            <td><?php echo $student['part'] ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="check" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
            <td><?php echo $i ?></td>
            <td><?php echo $student['std_id'] ?></td>
            <input type="hidden" name="<?php echo $i . 'studentID' ?>" value="<?php echo $student['std_id'] ?>">
            <td>
                <h2 class="table-avatar">
                    <?php
                        $student_image = $student['image'];
    
                        if ($student_image == '') { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image"></a>
                        <?php } else { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/student_profile/$student_image" ?>"
                                alt="User Image"></a>
                    <?php } ?>
    
    
    
                    <?php
                        if ($student['gender'] == 'Male') { ?>
                    <a>Mr
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } else { ?>
                    <a>Miss
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } ?>
                </h2>
            </td>
            <td><?php echo $student['program'] ?></td>
            <td><?php echo $student['part'] ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="check" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
            <td><?php echo $i ?></td>
            <td><?php echo $student['std_id'] ?></td>
            <input type="hidden" name="<?php echo $i . 'studentID' ?>" value="<?php echo $student['std_id'] ?>">
            <td>
                <h2 class="table-avatar">
                    <?php
                        $student_image = $student['image'];
    
                        if ($student_image == '') { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image"></a>
                        <?php } else { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/student_profile/$student_image" ?>"
                                alt="User Image"></a>
                    <?php } ?>
    
    
    
                    <?php
                        if ($student['gender'] == 'Male') { ?>
                    <a>Mr
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } else { ?>
                    <a>Miss
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } ?>
                </h2>
            </td>
            <td><?php echo $student['program'] ?></td>
            <td><?php echo $student['part'] ?></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="check" value='true' class="checkbox" onchange="updateCheckedCount()"></td>
            <td><?php echo $i ?></td>
            <td><?php echo $student['std_id'] ?></td>
            <input type="hidden" name="<?php echo $i . 'studentID' ?>" value="<?php echo $student['std_id'] ?>">
            <td>
                <h2 class="table-avatar">
                    <?php
                        $student_image = $student['image'];
    
                        if ($student_image == '') { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/profile.png" ?>" alt="User Image"></a>
                        <?php } else { ?>
                        <a href="student-detail.php?$id=<? $student['id'] ?>" class="avatar avatar-sm me-2"><img
                                class="avatar-img rounded-circle" src="<?php echo "upload/student_profile/$student_image" ?>"
                                alt="User Image"></a>
                    <?php } ?>
    
    
    
                    <?php
                        if ($student['gender'] == 'Male') { ?>
                    <a>Mr
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } else { ?>
                    <a>Miss
                        <?php echo $student['fname_en'] . " " . $student['lname_en'] ?></a>
                    <?php } ?>
                </h2>
            </td>
            <td><?php echo $student['program'] ?></td>
            <td><?php echo $student['part'] ?></td>
        </tr>
    </tbody>
</body>

</html>