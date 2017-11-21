<?php
    include("../connect.php");

    $b_no = mysqli_real_escape_string($con,$_GET['id']);

    $sql = "DELETE FROM board WHERE id=".$b_no;
    mysqli_query($con,$sql);

    header("Location:/PROJECT/BOARD/board.php");
?>
