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
            echo "<script type='text/javascript'>";
            echo "alert('일치하는 정보가 없습니다. 다시 확인해주세요!');";
            echo "history.back();";
            echo "</script>";
        }
        else {
            $user_id = $row['user_id'];
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
        </style>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    </head>
    <body>
        <div id="center">
            <form name="pwd_modify_process" action="/PROJECT/MEMBER/userpwd_modify_process.php" method="post" target="_self">
                <input type='hidden' name='pwdcheck' id="pwdcheck" value='N'>
                <input type='hidden' name='user_id' id="user_id" value='<?=$user_id?>'>
                <table cellpadding=15 cellspacing=0 width=550>
                    <caption><h3>회원님의 정보는 아래과 같습니다.</h3></caption>
                    <colgroup>
                        <col style="width:30%" />
                        <col style="width:70%" />
                    </colgroup>
                    <tr>
                        <th scope="row">&middot; 아이디</th>
                        <td><strong><?=$user_id?></strong></td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="pwd" style="font-size:14.5px;">&middot; 비밀번호 재설정</label>
                        </th>
                        <td>
                            <input type="password" id="pwd" name="password" title="비밀번호를 입력해주세요">
                            <div id="pwd_overlap"  style="font-size:11.5px; margin-top:5px;">* 비밀번호는 8자이상 20자 이하입니다.(영문,숫자,특수문자포함)</div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="repwd" style="font-size:14.5px;">&middot; 비밀번호확인</label>
                        </th>
                        <td>
                            <input type="password" id="repwd" name="repassword" title="비밀번호를 다시 입력해주세요">
                        </td>
                    </tr>
                    <tr>
                        <td scope="row" colspan="2" style="text-align:center;"><input type="button" name="join_complete" value="수정완료" onclick="userpwd_modify_process();">&nbsp;&nbsp;
                        <a href="../../index.php">로그인하기</a></td>
                    </tr>
                </table>
            </form>
        </div>
        <script type="text/javascript">
        var jp = eval("document.pwd_modify_process");
        function userpwd_modify_process(){
            if(!jp.password.value){
                alert("비밀번호를 입력하세요.");
                jp.password.focus();
                return;
            }
            if(!jp.repassword.value){
                alert("비밀번호를 확인해주세요.");
                jp.password.focus();
                return;
            }
            if(jp.password.value !== jp.repassword.value){
                alert("비밀번호가 일치하지 않습니다.")
                jp.password.focus();
                jp.password.select();
                return;
            }
            if(jp.password.value.length < 8 || jp.password.value.length > 20){
                alert("비밀번호는 8자이상 20자 이하입니다.");
                jp.password.focus();
                jp.password.select();
                return;
            }
            if(jp.pwdcheck.value=='N')
            {
                alert("비밀번호는 8자이상 20자 이하입니다.(영문,숫자,특수문자포함)");
                return;
            }
            ask = confirm("정보를 수정 하시겠습니까?");
            if(ask === true){
                is_join ="Y";
                jp.submit();
            }
            else{
                return;
            }
        }

        // 패스워드 유효성체크
        function pwd_overlap(){
            $('#pwdcheck').val("N");
            var pw = jp.password.value;
            var rpw = jp.repassword.value;
            var num = pw.search(/[0-9]/g);
            var eng = pw.search(/[a-z]/ig);
            var spe = pw.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

            if(!pw){
                $('#pwd_overlap').text("비밀번호를 입력해주세요.");
                return false;
            }

            if(pw.length < 8 || pw.length > 20){
                $('#pwd_overlap').text("* 비밀번호는 8자이상 20자 이하입니다.(영문,숫자,특수문자포함)").css("font-size","11.5px");
                return false;
            }

            if(pw.search(/\s/) != -1){
                $('#pwd_overlap').text("비밀번호는 공백없이 입력해주세요.");
                return false;
            }

            if(num < 0 || eng < 0 || spe < 0 ){
                $('#pwd_overlap').text("영문,숫자, 특수문자를 혼합하여 입력해주세요.");
                return false;
            }

            if(pw !== rpw){
                $('#pwd_overlap').text("비밀번호가 일치하지 않습니다.");
                return false;
            }

            if(pw == rpw){
                $('#pwd_overlap').text("비밀번호가 일치합니다.");
                $('#pwdcheck').val("Y");
                return true;
            }
        }

        $(function(){
            $('input[name="password"]').focusout(function(){
                    pwd_overlap();
            });

            $('input[name="repassword"]').focusout(function(){
                    pwd_overlap();
            });
        })

        </script>
    </body>
</html>
