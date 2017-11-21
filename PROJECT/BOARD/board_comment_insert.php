<?php
    include("../session.php");
    include("../connect.php");

    $sql = "SELECT * FROM members WHERE user_id ='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['user_name'];

    $b_cmt = mysqli_real_escape_string($con,strip_tags($_POST['comment']));
    $b_no = $_POST['b_no'];

    $sql = "SELECT max(grp) as grp FROM board_cmt WHERE b_no='".$b_no."'";
    $result = mysqli_query($con,$sql);

    if($result->num_rows==0){
        $grp = 1;
    }else{
        $row = mysqli_fetch_assoc($result);
        $grp = $row['grp']+1;
    }

    $sql = "INSERT INTO board_cmt SET
            user_id='".$_SESSION['user_id']."',
            user_nickname ='".$_SESSION['user_nickname']."',
            user_name = '".$user_name."',
            content = '".$b_cmt."',
            grp = $grp,
            seq = 1,
            b_no = '".$b_no."',
            cmt_time = sysdate()";

    mysqli_query($con,$sql);
    header("location:/PROJECT/BOARD/board_comment.php?id=$b_no");

?>
