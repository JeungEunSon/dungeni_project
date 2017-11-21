<?php
    // 로그인 세션처리 위해 세션 스타트
    include("../session.php");
    include("../connect.php");

    // 입력받은 아이디 및 패스워드 값 가져오기
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $user_pwd = mysqli_real_escape_string($con,$_POST['user_pwd']);

    if(empty($user_id) || empty($user_pwd)){
        include("../userinfo_chk.php");
    }
    else{
        $sql = "SELECT * FROM members WHERE user_id='".$user_id."' AND password =password('".$user_pwd."')";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $user_nickname = $row['user_nickname'];

        // 회원정보가 일치하지 않을때
        if($result->num_rows==0){
            include("../userinfo_error.php");
        }
        else{
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_pwd'] = $user_pwd;
            $_SESSION['user_nickname'] = $user_nickname;
            header("location: /PROJECT/MEMBER/membership.php");
        }
    }

?>
