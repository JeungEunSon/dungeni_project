<?php
    include("../session.php");
    include("../connect.php");

    // 입력받은 회원정보 가져오기
    $pwd = mysqli_real_escape_string($con,$_POST['password']);
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);

    // 회원정보 UPDATE
    $sql = "UPDATE members set password=password('".$pwd."')
                               WHERE user_id ='".$user_id."'";
    mysqli_query($con,$sql);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>개인정보수정완료</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            body{text-align: center; }
            #center{position: absolute; left: 50%; top:30%;}
            #center2{position: relative; left: -50%; width:800px; text-align: center;}
        </style>
    </head>
    <body>
        <div id="center">
            <div id="center2">
                <h2><?=$user_id?> 고객님의 소중한 개인정보 수정이 완료되었습니다!</h2>
                <br/>
                <a href="../../index.php">로그인하기</a>
            </div>
        </div>
    </body>
</html>
