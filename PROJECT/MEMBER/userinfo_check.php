<?php
    include("../session.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라개인정보수정</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            table{border-top: 2px solid black;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; }
            #center { position:absolute; top:50%; left:50%; overflow:hidden; margin-top:-250px; margin-left:-170px;}
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
        <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){ ?>
            <h3>로그인하신 회원분만 보실 수 있는 페이지입니다.</h3>
            <h4>로그인 후 이용 바랍니다.</h4>
            <a href="../../index.php">로그인하기</a>
        <?php } else { ?>
        <div id="center">
            <form action="/PROJECT/MEMBER/userinfo_update.php" method="post">
                <table cellpadding=15 cellspacing=0>
                    <caption>
                        <h3>고객님의 개인정보 보호를 위해</h3>
                        <h3>비밀번호를 다시 입력해주세요.</h3>
                    </caption>
                    <tr>
                        <th scope="row">&middot; 비밀번호</th>
                        <td><input type="password" name="password" ></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;">
                            <button type="submit" name="userinfo_check">확인</button>&nbsp;
                            <button type="button" onclick="location.href='/PROJECT/MEMBER/membership.php'">되돌아가기</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php }?>
    </body>
</html>
