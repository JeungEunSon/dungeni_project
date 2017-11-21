<?php
    include("../session.php");
    include("../connect.php");

    $sql = "SELECT * FROM members WHERE user_id ='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['user_name'];

    $bc_no = $_POST['bc_no'];

    $sql = "SELECT * FROM board_cmt WHERE bc_no=".$bc_no;
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $b_no = $row['b_no'];
    $content = mysqli_real_escape_string($con,strip_tags($_POST['recomment']));

    $sql ="UPDATE board_cmt SET content='".$content."', user_name ='".$user_name."' WHERE bc_no=$bc_no";
    mysqli_query($con,$sql);
    header("location:/PROJECT/BOARD/board_comment.php?id=$b_no");

?>
