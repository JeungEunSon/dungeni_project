<?php
    include("../session.php");
    include("../connect.php");

    // 입력받은 회원정보 가져오기
    // $_POST 로 넘어온 값을 mysqli_real_escape_string 처리해주기
    $result = array_map("mres",$_POST);

    function mres($values){
        global $con;
        return mysqli_real_escape_string($con,$values);
    }

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

    // 회원정보 UPDATE
    $sql = "UPDATE members set password=password('".$pwd."'), user_name='".$name."', user_nickname='".$nickname."', user_cp='".$user_cp."', zip='".$zip."',
                               user_adr='".$user_addr."', user_email='".$email."', user_birth='".$user_birth."', mail_yn='".$mail_yn."', sms_yn='".$sms_yn."'
                               WHERE user_id ='".$_SESSION['user_id']."'";
    mysqli_query($con,$sql);

    $sql = "SELECT * FROM members WHERE user_id='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = htmlspecialchars($row['user_id']);

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
            button{
              background:#9D9D9D;
              color:#fff;
              border:none;
              position:relative;
              height:35px;
              padding:0 2em;
              cursor:pointer;
              transition:800ms ease all;
              outline:none;
            }
            button:hover{
              background:#fff;
              color:#000000;
            }
            button:before,button:after{
              content:'';
              position:absolute;
              top:0;
              right:0;
              height:2px;
              width:0;
              background: #9D9D9D;
              transition:400ms ease all;
            }
            button:after{
              right:inherit;
              top:inherit;
              left:0;
              bottom:0;
            }
            button:hover:before,button:hover:after{
              width:100%;
              transition:800ms ease all;
            }
        </style>
    </head>
    <body>
        <div id="center">
            <div id="center2">
                <h2><?=$user_id?> 고객님의 소중한 개인정보 수정이 완료되었습니다!</h2>
                <br/>
                <button type="button" onclick="location.href='/PROJECT/MEMBER/membership.php'">되돌아가기</button>
            </div>
        </div>
    </body>
</html>
