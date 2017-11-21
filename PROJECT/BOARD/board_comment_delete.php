<?php
    include("../session.php");
    include("../connect.php");

    $bc_no = $_GET['bc_no'];

    $sql = "SELECT * FROM board_cmt WHERE bc_no='".$bc_no."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $b_no = $row['b_no'];
    $grp = $row['grp'];
    $lvl = $row['lvl'];

    // // 0이라면 완전 삭제하지말고 댓글 형태를 남겨줘야함
    if($lvl === '0'){
        $sql = "SELECT * FROM board_cmt WHERE b_no='".$b_no."' AND grp = '".$grp."' AND lvl > $lvl";
        $result = mysqli_query($con,$sql);

        if($result->num_rows ==0){
            $sql = "DELETE FROM board_cmt WHERE b_no='".$b_no."' AND bc_no='".$bc_no."'";
        }else{
            $sql = "UPDATE board_cmt set content = '삭제된 댓글입니다.', user_name='',del_yn='Y' WHERE b_no='".$b_no."' AND bc_no='".$bc_no."'";
        }
    } else{
        $sql = "DELETE FROM board_cmt WHERE b_no='".$b_no."' AND bc_no='".$bc_no."'";
    }
    mysqli_query($con,$sql);

    // 댓글삭제하고 한번더 체크 이미 원글이 삭제된 상태에서 답글도 다 삭제될경우
    // 원글 댓글도 아예 삭제처리
    $sql = "SELECT * FROM board_cmt WHERE b_no='".$b_no."' AND grp='".$grp."'";
    $result = mysqli_query($con,$sql);
    $row_cnt = mysqli_num_rows($result);

    if($row_cnt === 1){
        $row = mysqli_fetch_assoc($result);
        $lvl = $row['lvl'];
        $del_yn = $row['del_yn'];

        if($lvl ==='0' && $del_yn ==='Y'){
            $sql = "DELETE FROM board_cmt WHERE b_no='".$b_no."' AND grp ='".$grp."'";
            mysqli_query($con,$sql);
        }
    }

    header("location:/PROJECT/BOARD/board_comment.php?id=$b_no");

?>
