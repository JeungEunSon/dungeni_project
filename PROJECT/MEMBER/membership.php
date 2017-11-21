<?php
    include("../session.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; }
            #center
            {
                position:absolute; top:50%; left:50%;
                overflow:hidden;
                margin-top:-250px;
                margin-left:-380px;
                text-align: center;
                width:700px;
                height: 600px;
            }
            ul.mylist{list-style: none; margin-left: -45px; margin-top:40px;}
            button{
              background:#E4E4E4;
              color:#535551;
              border:none;
              position:relative;
              height:50px;
              width: 250px;
              padding:0 2em;
              cursor:pointer;
              transition:800ms ease all;
              outline:none;
              font-size:20px;
              margin-bottom: 15px;
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
              background: #666666;
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
            <?php if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){ ?>
                <h3>로그인하신 회원분만 보실 수 있는 페이지입니다.</h3>
                <h4>로그인 후 이용 바랍니다.</h4>
                <a href="../../index.php">로그인하기</a>
            <?php } else { ?>
            <h2><?=$_SESSION['user_nickname']?>님 덩으니나라에 방문해주셔서 감사합니다!</h2>
            <h3>다양한 활동을 즐겨보세요!</h3>
            <ul class="mylist">
                <li><button type="button" name="userinfo_modify" onclick="location.href='/PROJECT/MEMBER/introduce.php'"><strong>소  개</strong></button></li>
                <li><button type="button" name="userinfo_modify" onclick="location.href='/PROJECT/MEMBER/userinfo_check.php'"><strong>개인정보 수정</strong></button></li>
                <li><button type="button" name="board_write" onclick="location.href='/PROJECT/BOARD/board.php'"><strong>게시판 글 작성</strong></button></li>
                <li><button type="button" name="use_pos" onclick="location.href='/PROJECT/POS/pos.php'"><strong>POS기기사용</strong></button></li>
                <li><button type="button" name="logout" onclick="location.href='/PROJECT/MEMBER/logout.php'"><strong>로그아웃</strong></button></li>
            </ul>
            <?php }?>
        </div>
    </body>
    <!-- <script type="text/javascript">
        $(".hover").mouseleave(
            function() {
                $(this).removeClass("hover");
            }
        );
    </script> -->
</html>
