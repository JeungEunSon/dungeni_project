<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라게시판</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <style media="screen">
        @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
        *{font-family: 'Nanum Gothic', serif;}
        #center{position: absolute; left: 50%; top:3%;}
        #center2{position: relative; left: -50%;}
        #content{width:750px; height: 350px; overflow: auto; }
        tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
        a{text-decoration: none;}
        h2{text-align:left;}
        table{border-top: 2px solid black;}
        .board_secret{text-align: center; width:300px;}
        .title{width:90px;}
        .bt1{width:450px;}
        .bt2{width:200px;}
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
                <form action="/PROJECT/BOARD/board_secret_chk.php" method="post">
                    <input type='hidden' name='bno' id='bno' value='<?=$_GET['id']?>'>
                    <table cellpadding=15 cellspacing=0>
                        <caption><h2><a href="/PROJECT/BOARD/board.php">자유게시판</a></h2></caption>
                        <tr>
                            <th class="board_secret" colspan="2">비밀번호를 입력해주세요</th>
                        </tr>
                        <tr>
                            <td colspan="2" class="board_secret"><input type="password" name="w_pwd"></td>
                        </tr>
                        <tr>
                            <td class="board_secret">
                                <button type="submit" name="btnsubmit">확인</button>
                                <button type="button" name="back" onclick="location.href='/PROJECT/BOARD/board.php'">글목록</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </body>
</html>
