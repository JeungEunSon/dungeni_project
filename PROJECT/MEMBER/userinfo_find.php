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
            #center { position:absolute; top:50%; left:50%; overflow:hidden; margin-top:-250px; margin-left:-170px;}
        </style>
    </head>
    <body>
        <div id="center">
            <form action="/PROJECT/MEMBER/userinfo_find_process.php" method="post">
                <table cellpadding=15 cellspacing=0>
                    <caption>
                        <h3>덩으니나라 <br/>아이디 및 비밀번호 찾기</h3>
                    </caption>
                    <tr><td  colspan="2" style="text-align:center;"><strong>입력정보</strong></td></tr>
                    <tr>
                        <th scope="row"><label for="user_name">&middot; 이름</label></th>
                        <td><input type="text" id="user_name" name="user_name" title="이름을 입력하세요"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="user_cp_num">&middot; 핸드폰번호</label></th>
                        <td><input type="text" id="user_cp_num" name="user_cp_num" title="핸드폰번호를 입력하세요"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="user_email">&middot; 이메일주소</label></th>
                        <td><input type="text" id="user_email" name="user_email" title="이메일주소를 입력하세요"></td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;"><input type="submit" name="userinfo_find" value="정보찾기">&nbsp; <a href="../../index.php">로그인하기</a></td>
                    </tr>
                    <tr>
                        <label>
                            <td scope="row" colspan="2" style="text-align:center;">
                                <h5 style="margin:10px;">아직 덩으니나라 회원이 아니시라면 서둘러서 가입하세요!</h5>
                                <a href="/PROJECT/MEMBER/join.php">회원가입</a>
                            </td>
                        </label>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>
