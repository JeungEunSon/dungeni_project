<?php    include("../session.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            #center{position: absolute; left: 50%; top:30%;}
            #center2{position: relative; left: -50%; width:800px; text-align: center;}
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
    </head>
    <body>
        <div id="center">
            <div id="center2">
                <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){ ?>
                    <h3>로그인하신 회원분만 보실 수 있는 페이지입니다.</h3>
                    <h4>로그인 후 이용 바랍니다.</h4>
                    <a href="../../index.php">로그인하기</a>
                <?php } else { ?>
                <?php session_destroy(); //로그아웃할땐 세션 지우기 ?>
                <h2>이용해 주셔서 감사합니다. 또 방문해주세요 ^^ </h2>
                <h3>다음에 다시 만나요!</h3>
                <center><button type="button" name="login_btn" onclick="location.href='../../index.php'">로그인하기</button></center>
                <?php }?>
            </div>
        </div>
    </body>
</html>
