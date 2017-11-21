<?php
    include("../connect.php");

    $nickname = mysqli_real_escape_string($con,$_POST['nickname']);
    $sql = "SELECT * FROM members WHERE user_nickname='".$nickname."'";
    $result = mysqli_query($con,$sql);

    if($result->num_rows==0){
        echo "1";
    }
    else{
        echo "2";
    }

?>
