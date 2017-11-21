<?php
    include("../connect.php");

    // $_POST 로 넘어온 값을 mysqli_real_escape_string 처리해주기
    $result = array_map("mres",$_POST);

    function mres($values){
        global $con;
        return mysqli_real_escape_string($con,$values);
    }

    $id = $result['user_id'];
    $pwd = $result['password'];
    $name = $result['user_name'];
    $nickname = $result['user_nickname'];

    $cp1 = $result['user_cp1'];
    $cp2 = $result['user_cp2'];
    $cp3 = $result['user_cp3'];
    $user_cp = $cp1.$cp2.$cp3;

    $zip = $result['zip'];
    $addr1 = $result['user_addr1'];
    $addr2 = $result['user_addr2'];
    $user_addr = $addr1." ".$addr2;

    $email = $result['user_email'];

    $birth_year = $result['birth_year'];
    $birth_month = $result['birth_month'];
    $birth_day = $result['birth_day'];
    $user_birth = $birth_year.".".$birth_month.".".$birth_day;

    $mail_yn = $result['mail_yn'];
    $sms_yn = $result['sms_yn'];

    // 회원 고유번호 설정해주는 부분
    $sql = "SELECT * FROM members ORDER BY join_date DESC limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_num = mysqli_real_escape_string($con,$row['user_num']);

    $new_user_num = sprintf("%04d",substr($user_num,1,4)+1);

    if($new_user_num =='9999'){
        include("../join_error.php");
    } else {
        $new_user_num = "A".$new_user_num;
    }

    // 회원정보 INSERT
    $sql = "INSERT INTO members(user_id,password,user_name,user_nickname,user_cp,zip,user_adr,user_email,user_birth,mail_yn,sms_yn,join_date,user_num)
            VALUES('".$id."',password('".$pwd."'),'".$name."','".$nickname."','".$user_cp."','".$zip."','".$user_addr."','".$email."','".$user_birth."','".$mail_yn."','".$sms_yn."',sysdate(),'".$new_user_num."')";
    mysqli_query($con,$sql);

    $sql = "SELECT * FROM members WHERE user_id='".$id."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = htmlspecialchars($row['user_id']);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>회원가입완료</title>
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
                <h1>회원가입이 완료되었습니다!</h1>
                <h2><?=$user_id?> 님 덩으니나라에 오신것을 환영합니다^^</h2>
                <h3>이제 덩으니나라의 회원으로 모든 혜택을 맘껏 누리세요!</h3>
                <h3>로그인 후 이용바랍니다.</h3>
                <br/>
                <a href="/PROJECT/MEMBER/join.php">되돌아가기</a>&nbsp;<a href="../../index.php">로그인하기</a>
            </div>
        </div>
    </body>
</html>
