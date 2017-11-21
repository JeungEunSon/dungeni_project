<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <title>덩으니나라 로그인</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            table{border-top: 2px solid black;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; }
            #center { position:absolute; top:50%; left:50%; overflow:hidden; margin-top:-250px; margin-left:-170px;}
        </style>
    </head>
    <body>
        <div id="center">
            <form action="/PROJECT/MEMBER/login_process.php" method="post">
                <table cellpadding=15 cellspacing=0>
                    <caption>
                        <h2>덩으니나라 로그인</h2>
                    </caption>
                    <tr>
                        <th scope="row"><label for="user_id">&middot; 아이디</label></th>
                        <td><input type="text" id="user_id" name="user_id" title="아이디를 입력하세요"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="user_pwd">&middot; 비밀번호</label></th>
                        <td><input type="password" id="user_pwd" name="user_pwd" title="비밀번호를 입력하세요"></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;">
                            <input type="submit" name="login_btn" value="로그인"> &nbsp;
                            <a href="/PROJECT/MEMBER/userinfo_find.php">아이디 및 비밀번호 찾기</a><br/>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;">
                            <h5 style="margin:10px;">아직 덩으니나라 회원이 아니시라면 서둘러서 가입하세요!</h5>
                            <a href="/PROJECT/MEMBER/join.php">회원가입</a>
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;">
                            <h4 style="margin:10px;">테스트계정(test1234 / test1234!)</h4>  
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
