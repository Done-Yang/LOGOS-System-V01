<?php
    function getToltalScoreOfEachSubject($group_id, $sub_id, $std_id, $conn){
        $sc = $conn->prepare("SELECT * FROM scores WHERE group_id=? and sub_id=? and std_id=?");
        $sc->execute([$group_id, $sub_id, $std_id]);

        if($sc->rowCount() > 0){
            $score = $sc->fetch();
            $total_score = $score['attending'] + $score['behavire'] +$score['activities'] + $score['midterm_ex'] + $score['final_ex'] ;
            return $total_score;
        }else{
            return 0;
        }
    }
?>