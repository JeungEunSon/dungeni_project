<?php
    include("../session.php");
    include("../connect.php");

    $b_cmt = mysqli_real_escape_string($con,strip_tags($_POST['reply_comment']));
    $b_no = $_POST['b_no'];
    $bc_no = $_POST['bc_no'];
    $grp = $_POST['grp'];
    $seq = $_POST['seq'];
    $lvl = $_POST['lvl'];
    $uname = $_POST['uname'];
    $re_name = $_POST['re_name'];

    // 댓글을 삽입하기 이전에
    // 한 글에 대한 댓글이 여러개인 경우 우선순위를 맞춰주기 위해서
    // 부모글과 동일한 그룹 번호에 있으면서
    // 부모글의 seq 번호보다 큰 게시물의 seq 번호를 모두 1만큼 증가시킨다
    $sql = "UPDATE board_cmt set seq= seq+1 WHERE b_no='".$b_no."' AND  grp = '".$grp."' AND seq > $lvl+1";
    mysqli_query($con,$sql);

    // lvl이 0일때 seq 1 , 1일때 2, 2일때 3, 3일때 4

    $sql = "INSERT INTO board_cmt SET
            user_id='".$_SESSION['user_id']."',
            user_nickname ='".$_SESSION['user_nickname']."',
            user_name = '".$uname."',
            content = '".$b_cmt."',
            grp = $grp,
            seq = ($lvl+1)+1,
            lvl = $lvl+1,
            b_no = '".$b_no."',
            re_name = '".$re_name."',
            cmt_time = sysdate()";
    mysqli_query($con,$sql);

    header("location:/PROJECT/BOARD/board_comment.php?id=$b_no");

?>
