<?php
    include("../connect.php");

    $id = mysqli_real_escape_string($con,$_POST['id']);
    $sql = "SELECT * FROM members WHERE user_id='".$id."'";
    $result = mysqli_query($con,$sql);

    if($result->num_rows==0){
        echo "1";
    }
    else{
        echo "2";
    }

?>
