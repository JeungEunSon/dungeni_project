<?php
    include("../session.php");
    include("../connect.php");

    $sql = "SELECT * FROM members WHERE user_id='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_pwd = $row['password'];

    $sql = "SELECT password('".addslashes($_POST['password'])."') as pwd FROM dual";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $user_input_pwd = $row['pwd'];

    if($user_pwd != $user_input_pwd){
        include("../password_chk.php");
    }else{
        if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
            include("../login_yn.php");
        }
        else{
            $sql = "SELECT * FROM members WHERE user_id='".$_SESSION['user_id']."'";
            $result = mysqli_query($con,$sql);
            $row = mysqli_fetch_assoc($result);

            $user_id = $row['user_id'];
            $user_name = $row['user_name'];
            $user_nickname = $row['user_nickname'];
            $user_cp1 = substr($row['user_cp'],0,3);
            $user_cp2 = substr($row['user_cp'],3,4);
            $user_cp3 = substr($row['user_cp'],7,4);
            $user_zip = $row['zip'];
            $user_adr1 = mb_substr($row['user_adr'],0,20, 'utf-8');
            $user_adr2 = mb_substr($row['user_adr'],20,null,'utf-8');
            $user_email = $row['user_email'];
            $user_num = $row['user_num'];
    ?>
    <!DOCTYPE html>
    <html>

    <head>
    	<meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            table{border-top: 2px solid black;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
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
    	<title>덩으니나라개인정보수정</title>
    </head>
    <body>
        <a href="/PROJECT/MEMBER/membership.php"><?=$_SESSION['user_nickname']?></a>님 환영합니다!&nbsp;&nbsp;
        <a href="/PROJECT/MEMBER/logout.php">로그아웃</a>
    	<br/>
        <div style="position: absolute; left: 50%;">
            <div id="center" style="position: relative; left: -50%;">
                <form name="join_process" action="/PROJECT/MEMBER/userinfo_update_process.php" method="post" target="_self">
                    <input type='hidden' name='idcheck' id="idcheck" value='N'>
                    <input type='hidden' name='nickcheck' id="nickcheck" value='Y'>
                    <input type='hidden' name='pwdcheck' id="pwdcheck" value='N'>
                    <table cellpadding=15 cellspacing=0>
                        <caption>
                            <h1>개인정보수정</h1>
                        </caption>
                        <colgroup>
                            <col style="width:20%" />
                            <col style="width:80%" />
                        </colgroup>
                        <tr>
                            <th scope="row">
                                <label for="user_id">&middot; 아이디</label>
                            </th>
                            <td>
                                <!-- <input id="user_id" type="text" name="user_id" title="아이디를 입력해주세요" readonly="readonly" value="<?=$user_id?>"> -->
                                <?=$user_id?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="pwd">&middot; 비밀번호</label>
                            </th>
                            <td>
                                <input type="password" id="pwd" name="password" title="비밀번호를 입력해주세요">
                                <div id="pwd_overlap"  style="display:inline-block; font-size:11.5px;">* 비밀번호는 8자이상 20자 이하입니다.(영문,숫자,특수문자포함)</div>
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
                            <th scope="row">
                                <label for="user_name">&middot; 이름</label>
                            </th>
                            <td>
                                <input type="text" name="user_name" id="user_name" title="이름을 입력해주세요" value="<?=$user_name?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="user_nickname">&middot; 닉네임</label>
                            </th>
                            <td>
                                <input type="text" id="user_nickname" name="user_nickname" minlength="2" maxlength="10" title="닉네임을 입력해주세요" value="<?=$user_nickname?>">
                                <div id="nickname_chk" style="display:inline-block;">* 2~10자리 입력가능합니다</div>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="user_num">&middot; 회원번호</label>
                            </th>
                            <td>
                                <?=$user_num?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="user_cp">&middot; 휴대전화</label>
                            </th>
                            <td>
                                <input type="text" id="user_cp" name="user_cp1" maxlength="3" title="핸드폰번호 앞 3자리" style="width:45px" value="<?=$user_cp1?>">-
                                <input type="text" name="user_cp2" maxlength="4" title="핸드폰번호 중간 4자리" style="width:50px" value="<?=$user_cp2?>">-
                                <input type="text" name="user_cp3" maxlength="4" title="핸드폰번호 뒷 4자리" style="width:50px" value="<?=$user_cp3?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="adr">&middot; 주소</label>
                            </th>
                            <td>
                                <input type="text" id="zip" name="zip" title="우편번호를 입력해주세요" readonly="readonly" style="width:70px" value="<?=$user_zip?>">
                                <input type="button" name="zip_search" value="우편번호검색" onclick="zip_pop()">
                                <p>
                                    <input type="text" id="user_addr1" name="user_addr1" title="주소" readonly="readonly" value="<?=$user_adr1?>">
                                    <input type="text" id="user_addr2" name="user_addr2" title="상세주소를 입력하세요" value="<?=$user_adr2?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="user_email">&middot; 이메일</label>
                            </th>
                            <td>
                                <input type="user_email" id="user_email" name="user_email" title="이메일을 입력해주세요" value="<?=$user_email?>">
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label for="birth">&middot; 생년월일</label>
                            </th>
                            <td>
                                <script type="text/javascript">
    								function birth_year_check(){
    									var today = new Date();
    									var toyear = parseInt(today.getFullYear());
    									var start = toyear;
    									var end = toyear - 70;

    									document.write("<select name='birth_year' style='width:100px'>");
    									document.write("<option value='' selected>");
    									for (i=start;i>=end;i--) document.write("<option>"+i);
    									document.write("</select>년  ");

    									document.write("<select name='birth_month' style='width:120px'>")
    									document.write("<option value='' selected>");
    									for (i=1;i<=12;i++) document.write("<option>"+i);
    									document.write("</select>월  ");

    									document.write("<select name='birth_day' style='width:120px'>");
    									document.write("<option value='' selected>");
    									for (i=1;i<=31;i++) document.write("<option>"+i);
    									document.write("</select>일  ");
    								}
    								birth_year_check();
    							</script>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                &middot; 메일수신
                            </th>
                            <td>
                                <input type="radio" id="mail_y" name="mail_yn" value="Y" checked="checked"><label for="mail_y">수신함</label>
                                <input type="radio" id="mail_n" name="mail_yn" value="N"><label for="mail_n">수신안함</label>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                &middot; SMS수신
                            </th>
                            <td>
                                <input type="radio" id="sms_y" name="sms_yn" value="Y" checked="checked"><label for="sms_y">수신함</label>
                                <input type="radio" id="sms_n" name="sms_yn" value="N"><label for="sms_n">수신안함</label>
                                </td>
                        </tr>
                    </table>
                    <p style="text-align:center;">
                        <button type="button" name="update_complete" onclick="userinfo_update_pro();">수정완료</button>&nbsp;
                        <button type="button" onclick="location.href='/PROJECT/MEMBER/membership.php'">되돌아가기</button>
                    </p>

                    <script type="text/javascript">
                        var jp = eval("document.join_process");
                                    var is_join ="N";
                                    var user_nickname = "<?=$user_nickname?>";

                                    // 개인정보 수정 전 예외사항 체크
                                    function userinfo_update_pro(){

                                        alert("회원정보 수정 처리중입니다. 잠시만 기다려주세요!");
                                        if(is_join =='Y'){
                                            return;
                                        }
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
                                        if(!jp.user_name.value){
                                            alert("이름을 입력해주세요.");
                                            jp.user_name.focus();
                                            return;
                                        }
                                        if(!jp.user_nickname.value){
                                            alert("닉네임을 입력해주세요.");
                                            jp.user_nickname.focus();
                                            return;
                                        }
                                        if(jp.nickcheck.value=='N')
                                        {
                                            alert("닉네임 중복체크를 해주세요");
                                            return;
                                        }

                                        if(!jp.user_cp1.value){
                                            alert("핸드폰번호 앞 3자리 입력해주세요.");
                                            jp.user_cp1.focus();
                                            return;
                                        }
                                        if(!jp.user_cp2.value){
                                            alert("핸드폰번호 중간 4자리 입력해주세요.");
                                            jp.user_cp2.focus();
                                            return;
                                        }
                                        if(!jp.user_cp3.value){
                                            alert("핸드폰번호 뒷 4자리 입력해주세요.");
                                            jp.user_cp3.focus();
                                            return;
                                        }
                                        if(!cp_check(jp.user_cp1.value)){
                                            alert("핸드폰번호는 숫자만 입력해주세요.");
                                            jp.user_cp1.focus();
                                            jp.user_cp1.select();
                                            return;
                                        }
                                        if(!cp_check(jp.user_cp2.value)){
                                            alert("핸드폰번호는 숫자만 입력해주세요.");
                                            jp.user_cp2.focus();
                                            jp.user_cp2.select();
                                            return;
                                        }
                                        if(!cp_check(jp.user_cp3.value)){
                                            alert("핸드폰번호는 숫자만 입력해주세요.");
                                            jp.user_cp3.focus();
                                            jp.user_cp3.select();
                                            return;
                                        }

                                        if(!jp.birth_year.value || !jp.birth_month.value || !jp.birth_day.value){
                                            alert("생년월일을 선택해주세요.");
                                            jp.birth_year.focus();
                                            return;
                                        }
                                        if(!jp.user_email.value){
                                            alert("이메일주소를 입력해주세요.");
                                            jp.user_email.focus();
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

                                    // 핸드폰번호 숫자체크
                                    function cp_check(cp_value){
                                        var cp_han = /[ㄱ-힣]/g;
                                        var cp_check_han = cp_value.match(cp_han);

                                        if(cp_check_han){
                                            return false;
                                        }

                                        for(var i=0; i<cp_value.length; i++){
                                            var str = cp_value.substr(i,1);
                                                if(str < '0' || str > '9')
                                                    return false;
                                        }
                                        return true;
                                    }

                                    // 닉네임 중복체크
                                    function nickname_overlap(){
                                        $('#nickcheck').val("N");

                                        if(!jp.user_nickname.value){
                                            $('#nickname_chk').text("닉네임을 입력해주세요.");
                                            return false;
                                        }

                                        if(jp.user_nickname.value.length < 2 || jp.user_nickname.value.length > 10){
                                            $('#nickname_chk').text("닉네임은 2자이상 10자 이하입니다.").css("font-size","12px");
                                            return false;
                                        }

                                        var msg = $.ajax({
                                                          type:"post",
                                                          url:"/PROJECT/MEMBER/nickname_check_ajax.php",
                                                          data:{
                                                                'nickname':jp.user_nickname.value
                                                          },
                                                          async:false,
                                                          success : function(data){
                                                          }
                                                        }).responseText;


                                        if(msg == 1){
                                            $('#nickname_chk').text("사용 할 수 있는 닉네임입니다.");
                                            $('#nickcheck').val("Y");
                                        }
                                        else if(msg==2){
                                            $('#nickname_chk').text("이미 사용중인 닉네임입니다.");
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
                                        $('input[name="user_nickname"]').focusout(function(){
                                            if(user_nickname !=jp.user_nickname.value)
                                                nickname_overlap();
                                        });

                                        $('input[name="password"]').focusout(function(){
                                                pwd_overlap();
                                        });

                                        $('input[name="repassword"]').focusout(function(){
                                                pwd_overlap();
                                        });
                                    })

                                    // 우편번호 찾기 서비스
                                    function zip_pop(){
                                        new daum.Postcode({
                                            oncomplete: function(data) {
                                            // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                            var fullAddr = ''; // 최종 주소 변수
                                            var extraAddr = ''; // 조합형 주소 변수

                                            // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                                fullAddr = data.roadAddress;

                                            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                                fullAddr = data.jibunAddress;
                                            }

                                            // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                            if(data.userSelectedType === 'R'){
                                                //법정동명이 있을 경우 추가한다.
                                                if(data.bname !== ''){
                                                    extraAddr += data.bname;
                                                }
                                                // 건물명이 있을 경우 추가한다.
                                                if(data.buildingName !== ''){
                                                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                                }
                                                // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                                fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                                            }

                                            // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                            document.getElementById('zip').value = data.zonecode; //5자리 새우편번호 사용
                                            document.getElementById('user_addr1').value = fullAddr;

                                            // 커서를 상세주소 필드로 이동한다.
                                            document.getElementById('user_addr2').focus();
                                            }
                                        }).open();
                                    }
                    </script>
                </form>
            </div>
        </div>
    <?php }?>
<?php } ?>
</body>
</html>
