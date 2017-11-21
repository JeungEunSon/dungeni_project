<?php
    include("../session.php");
    include("../connect.php");
    $user_name = mysqli_real_escape_string($con,$_POST['user_name']);
    $user_cp_num = mysqli_real_escape_string($con,$_POST['user_cp_num']);
    $user_email = mysqli_real_escape_string($con,$_POST['user_email']);

    if(empty($user_name) || empty($user_cp_num) || empty($user_email)){
        echo "<script type='text/javascript'>";
        echo "alert('정보를 정확히 입력해주세요!');";
        echo "history.back();";
        echo "</script>";
    }
    else{
        // 입력받은 세가지 정보를 모두 만족시켜야 아이디와 패스워드 정보 제공
        $sql = "SELECT * FROM members WHERE user_name='".$user_name."' and user_cp='".$user_cp_num."' and user_email ='".$user_email."'";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);

        if($result->num_rows==0){
            include("../userinfo_error.php");
        }
        else {
        //     // 패스워드 랜덤 생성
            function generateRandomPassword($length=8, $strength=0) {
                 $vowels = 'aeuy';
                 $consonants = 'bdghjmnpqrstvz';
                 if ($strength & 1) {
                     $consonants .= 'BDGHJLMNPQRSTVWXZ';
                 }
                 if ($strength & 2) {
                     $vowels .= "AEUY";
                 }
                 if ($strength & 4) {
                     $consonants .= '23456789';
                 }
                 if ($strength & 8) {
                     $consonants .= '@#$%';
                 }

                 $password = '';
                 $alt = time() % 2;
                 for ($i = 0; $i < $length; $i++) {
                     if ($alt == 1) {
                         $password .= $consonants[(rand() % strlen($consonants))];
                         $alt = 0;
                     } else {
                         $password .= $vowels[(rand() % strlen($vowels))];
                         $alt = 1;
                     }
                 }
                 return $password;
             }

            $imsi_pwd =  generateRandomPassword();
            $user_email = $row['user_email'];
            $user_nickname = $row['user_nickname'];
            $user_name = $row['user_name'];
            $user_id = $row['user_id'];

            // 개인정보 이메일로 전송
           $nameFrom  = "덩으니나라";
           $mailFrom = "jeson1126@naver.com";
           $nameTo  = $user_name."님";
           $mailTo = $user_email;

        //    $cc = "참조";
        //    $bcc = "숨은참조";
           $subject = $user_name."님의 개인정보내역입니다.";
           $content = $user_name."님의 개인정보 내역은 다음과 같습니다.<br/>".
                      "개인정보 보호를 위해 비밀번호를 반드시 변경해주세요.<br/><br/>".
                      "&middot; 아이디 : ".$user_id."<br/>".
                      "&middot; 임시비밀번호 : ".$imsi_pwd."<br/>";

           $charset = "UTF-8";

           $nameFrom   = "=?$charset?B?".base64_encode($nameFrom)."?=";
           $nameTo   = "=?$charset?B?".base64_encode($nameTo)."?=";
           $subject = "=?$charset?B?".base64_encode($subject)."?=";

           $header  = "Content-Type: text/html; charset=utf-8\r\n";
           $header .= "MIME-Version: 1.0\r\n";

           $header .= "Return-Path: <". $mailFrom .">\r\n";
           $header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
           $header .= "Reply-To: <". $mailFrom .">\r\n";
        //    if ($cc)  $header .= "Cc: ". $cc ."\r\n";
        //    if ($bcc) $header .= "Bcc: ". $bcc ."\r\n";

           $result = mail($mailTo, $subject, $content, $header);
           if(!$result) {
               echo "<script>alert('메일 전송 실패')</script>";
           }

           $sql = "UPDATE members SET password = password('".$imsi_pwd."') WHERE user_id ='".$user_id."'";
           mysqli_query($con,$sql);

        }

    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라회원정보찾기</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            table{border-top: 2px solid black;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; }
            #center { position:absolute; top:50%; left:50%; overflow:hidden; margin-top:-250px; margin-left:-250px;}
            button{
              background:#787A78;
              color:#FFFFFF;
              border:none;
              position:relative;
              height:35px;
              padding:0 2em;
              cursor:pointer;
              transition:800ms ease all;
              outline:none;
              font-size:13px;
            }
            button:hover{
              background:#fff;
              color:#787A78;
            }
            button:before,button:after{
              content:'';
              position:absolute;
              top:0;
              right:0;
              height:2px;
              width:0;
              background: #787A78;
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
        </style>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    </head>
    <body>
        <div id="center">
            <table cellpadding=15 cellspacing=0 width=550>
                <caption>
                    <h3>회원님의 정보는 가입 할 때 적어주신 이메일 주소로 보내드렸습니다.</h3>
                    <h3>확인 후 로그인 해주세요!</h3>
                </caption>
                <colgroup>
                    <col style="width:30%" />
                    <col style="width:70%" />
                </colgroup>
                <tr>
                    <td>
                        <center><button type="button" name="login_btn" onclick="location.href='../../index.php'">로그인하기</button></center>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
