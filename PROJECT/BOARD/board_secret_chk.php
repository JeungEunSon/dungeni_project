<?php
    include("../connect.php");

    $b_no = mysqli_real_escape_string($con,$_POST['bno']);
    $input_pwd = mysqli_real_escape_string($con,$_POST['w_pwd']);


    $sql = "SELECT * FROM board WHERE id=".$b_no;
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $real_pwd = $row['w_pwd'];

    $sql = "SELECT password('".$input_pwd."') as pwd FROM dual";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    $input_pwd = $row['pwd'];

    if($real_pwd === $input_pwd){
        header("Location:/PROJECT/BOARD/board_info.php?id='".$b_no."'");
    }else{
        include("../password_chk.php");
    }
 ?>
