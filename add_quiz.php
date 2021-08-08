<?php
include('db_connect.php');
?>
<form method="post">
    <input type="submit" name="submit" value="submt" />
</form>
<?php
if (isset($_POST['submit'])) {
    $data = $conn->query("SELECT * FROM data_quiz");
    while ($row = $data->fetch_array()) {
        // $sql = "INSERT INTO questions (id, question, qid) VALUES (DEFAULT, '".$row['question']."', '6')";
        // $conn->query($sql);
        $dtq = $conn->query("SELECT * FROM questions where question like '" . $row['question'] . "' ");
        while ($rt = $dtq->fetch_array()) {
            $id_qs =  $rt['id'];
        }
        $ans = $row['done'];
        $is_right1 = 0;
        $is_right2 = 0;
        $is_right3 = 0;
        $is_right4 = 0;
        if($ans == 'A'){
            $is_right1 =1;
        }
        else if($ans == 'B'){
            $is_right2 = 1;
        } else if($ans == 'C'){
            $is_right3 =1;
        } else if ($ans =='D'){
            $is_right4 = 1;
        }
        $sql1 = "INSERT INTO question_opt (id, option_txt, question_id, is_right) VALUES (DEFAULT, '" . $row['op1'] . "', $id_qs, $is_right1)";
        $conn->query($sql1);
        $sql2 = "INSERT INTO question_opt (id, option_txt, question_id, is_right) VALUES (DEFAULT, '" . $row['op2'] . "', $id_qs, $is_right2)";
        $conn->query($sql2);
        $sql3 = "INSERT INTO question_opt (id, option_txt, question_id, is_right) VALUES (DEFAULT, '" . $row['op3'] . "', $id_qs, $is_right3)";
        $conn->query($sql3);
        $sql4 = "INSERT INTO question_opt (id, option_txt, question_id, is_right) VALUES (DEFAULT, '" . $row['op4'] . "', $id_qs, $is_right4)";
        $conn->query($sql4);

        // echo $row['question'];
        // echo '<br>';
        // echo $row['op1'];
        // echo '<br>';
        // echo $row['op2'];
        // echo '<br>';
        // echo $row['op3'];
        // echo '<br>';
        // echo $row['op4'];
        // echo '<br>';
    }
}
?>