<?php include("../connect.php"); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script type="text/javascript" src="/PROJECT/jquery/infinite/jquery.tinyscrollbar.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/PROJECT/jquery/infinite/tinyscrollbar2.css">
	<style media="screen">
		@import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
		*{font-family: 'Nanum Gothic', serif;}
		table{border-top: 2px solid black;}
		tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
	</style>
	<title>덩으니나라회원가입</title>
</head>

<body>
	<br/>
	<div style="position: absolute; left: 50%;">
		<div id="center" style="position: relative; left: -50%;">
			<form name="join_process" action="/PROJECT/MEMBER/join_process.php" method="post" target="_self">
				<input type='hidden' name='idcheck' id="idcheck" value='N'>
				<input type='hidden' name='nickcheck' id="nickcheck" value='N'>
				<input type='hidden' name='pwdcheck' id="pwdcheck" value='N'>
				<table cellpadding=15 cellspacing=0>
					<caption>
						<h1>회원가입</h1>
						<h3>덩으니나라 회원으로 다양한 혜택을 받으세요!</h3>
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
							<input id="user_id" type="text" name="user_id" title="아이디를 입력해주세요">
							<div id="id_overlap" style="display:inline-block;"></div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="password">&middot; 비밀번호</label>
						</th>
						<td>
							<input type="password" id="password" name="password" title="비밀번호를 입력해주세요">
							<div id="pwd_overlap"  style="display:inline-block; font-size:11.5px;">* 비밀번호는 8자이상 20자 이하입니다.(영문,숫자,특수문자포함)</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="repassword">&middot; 비밀번호확인</label>
						</th>
						<td>
							<input type="password" id="repassword" name="repassword" title="비밀번호를 다시 입력해주세요">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="user_name">&middot; 이름</label>
						</th>
						<td>
							<input type="text" name="user_name" id="user_name" title="이름을 입력해주세요">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="user_nickname">&middot; 닉네임</label>
						</th>
						<td>
							<input type="text" id="user_nickname" name="user_nickname" minlength="2" maxlength="10" title="닉네임을 입력해주세요">
							<div id="nickname_chk" style="display:inline-block;">* 2~10자리 입력가능합니다</div>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="user_cp">&middot; 휴대전화</label>
						</th>
						<td>
							<input type="text" id="user_cp" name="user_cp1" maxlength="3" title="핸드폰번호 앞 3자리" style="width:45px">-
							<input type="text" name="user_cp2" maxlength="4" title="핸드폰번호 중간 4자리" style="width:50px">-
							<input type="text" name="user_cp3" maxlength="4" title="핸드폰번호 뒷 4자리" style="width:50px">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="adr">&middot; 주소</label>
						</th>
						<td>
							<input type="text" id="zip" name="zip" title="우편번호를 입력해주세요" readonly="readonly" style="width:70px">
							<input type="button" name="zip_search" value="우편번호검색" onclick="zip_pop()">
							<p>
								<input type="text" id="user_addr1" name="user_addr1" title="주소" readonly="readonly">
								<input type="text" id="user_addr2" name="user_addr2" title="상세주소를 입력하세요">
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="user_email">&middot; 이메일</label>
						</th>
						<td>
							<input type="email" id="user_email" name="user_email" title="이메일을 입력해주세요">
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
					<input type="button" name="join_complete" value="동의하고 가입하기" onclick="join_pro();">&nbsp;
					<a href="../../index.php">되돌아가기</a>
				</p>
				<h4 style="font-size:20px;font-family:'나눔고딕';">개인정보수집 및 이용</h4>
				<!-- 개인정보 처리 동의부분 -->
				<div id="scrollbar1">
					<div class="scrollbar">
						<div class="track">
							<div class="thumb">
								<div class="end"></div>
							</div>
						</div>
					</div>
					<div class="viewport" style='height: 120px;'>
						<div class="overview" style="background-color:#D9E2F6;"> <pre style="line-height:150%">
에스엔패션그룹(주)가 운영하는 쇼핑몰 브랜드 "덩으니나라"는 고객님의 개인정보를 중요시하며,  "정보통신망 이용촉진 및 정보보호"에 관한 법률을 준수하고 있습니다.
개인정보취급방침을 통하여 고객님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며, 개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다.

개인정보취급방침을 개정하는 경우 웹사이트 공지사항(또는 개별공지)을 통하여 공지할 것입니다.

■ 수집하는 개인정보 항목
에스엔패션그룹(주)가 운영하는 쇼핑몰 브랜드 "덩으니나라"는 회원가입, 상담, 서비스 신청 등등을 위해 아래와 같은 개인정보를 수집하고 있습니다.
ο 수집항목 : 이름 , 생년월일 , 성별 , 로그인ID , 비밀번호 , 비밀번호 질문과 답변 , 자택 전화번호 , 자택 주소 , 휴대전화번호 , 이메일 , 기념일 , 서비스 이용기록 , 접속 로그 , 접속 IP 정보 , 결제기록
ο 개인정보 수집방법 : 홈페이지(회원가입) , 서면양식

■ 개인정보의 수집 및 이용목적
에스엔패션그룹(주)가 운영하는 쇼핑몰 브랜드 ""는  수집한 개인정보를 다음의 목적을 위해 활용합니다.

ο 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산 콘텐츠 제공 , 구매 및 요금 결제 , 물품배송 또는 청구지 등 발송
ο 회원 관리
회원제 서비스 이용에 따른 본인확인 , 개인 식별 , 연령확인 , 만14세 미만 아동 개인정보 수집 시 법정 대리인 동의여부 확인 , 고지사항 전달
ο 마케팅 및 광고에 활용
접속 빈도 파악 또는 회원의 서비스 이용에 대한 통계

■ 개인정보의 보유 및 이용기간
에스엔패션그룹(주)가 운영하는 쇼핑몰 브랜드 "덩으니나라"는  개인정보 수집 및 이용목적이 달성된 후에는 예외 없이 해당 정보를 지체 없이 파기합니다.
	                            </pre>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					var jp = eval("document.join_process");
					            var is_join ="N";

					            // 회원가입 승인 전 예외사항 체크
					            function join_pro(){

					                if(is_join =='Y'){
					                    alert("회원가입 처리중입니다. 잠시만 기다려주세요!");
					                    return;
					                }

					                if(!jp.user_id.value){
					                    alert("아이디를 입력하세요.");
					                    jp.user_id.focus();
					                    return;
					                }
					                if(!id_check(jp.user_id.value)){
					                    alert("아이디는 5자이상 20자 이하입니다.");
					                    jp.user_id.select();
					                    return;
					                }
					                if(jp.idcheck.value=='N')
					                {
					                    alert("ID중복체크를 해주세요");
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
					                ask = confirm("회원가입 하시겠습니까?");
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

					            // ID가 영문 및 숫자로만 이루어져있는지 체크
					            function id_check(id_value){
					                if(id_value.length < 5 || id_value.length > 20)
					                    return false;
					                for(var i=0; i<id_value.length; i++){
					                    var str = id_value.substr(i,1);
					                        if((str < '0' || str > '9') && (str < 'a' || str > 'z'))
					                            return false;
					                }
					                return true;
					            }

					            //ID중복체크
					            function id_overlap(){
					                var id_han = /[ㄱ-힣]/g;
					                var id_han_check = jp.user_id.value.match(id_han);
					                $('#idcheck').val("N");

					                if(!jp.user_id.value){
					                    $('#id_overlap').text("아이디를 입력해주세요.");
					                    return false;
					                }

					                if(jp.user_id.value.length < 5 || jp.user_id.value.length > 20){
					                    $('#id_overlap').text("아이디는 5자이상 20자 이하입니다.").css("font-size","12px");
					                    return false;
					                }

					                if(id_han_check){
					                    $('#id_overlap').text("아이디는 한글을 사용하실 수 없습니다.");
					                    return false;
					                }

					                var msg = $.ajax({
					                                  type:"post",
					                                  url:"/PROJECT/MEMBER/id_check_ajax.php",
					                                  data:{
					                                        'id':jp.user_id.value
					                                  },
					                                  async:false,
					                                  success : function(data){
					                                  }
					                                }).responseText;


					                if(msg == 1){
					                    $('#id_overlap').text("사용 할 수 있는 아이디입니다.");
					                    $('#idcheck').val("Y");
					                }
					                else if(msg==2){
					                    $('#id_overlap').text("이미 사용중인 아이디입니다.");
					                }

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
					            	$('input[name="user_id"]').focusout(function(){
					            		id_overlap();
					            	});

					            	$('input[name="user_nickname"]').focusout(function(){
					            		nickname_overlap();
					            	});

									$('input[name="password"]').focusout(function(){
											pwd_overlap();
									});

									$('input[name="repassword"]').focusout(function(){
											pwd_overlap();
									});
					            });

					            $(function(){
					              $('#scrollbar1').tinyscrollbar();
					            });

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
				<h5>덩으니나라 이용약관, 개인정보수집 및 이용내용을 확인 하였으며, 동의합니다.</h5>
			</form>
		</div>
	</div>
</body>

</html>
