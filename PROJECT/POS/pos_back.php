<?php
    include("../session.php");
    include("../connect.php");
    // 계산완료처리되지 않은 데이터들에 대한 SELECT문
    $sql="select * from user_chk where cal_yn='N'";
    $result=mysqli_query($con,$sql);

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
        echo "<div id='center' style='position: absolute; left: 50%; top:30%;'><div id='center2' style='position: relative; left: -50%; width:800px; text-align: center;'>";
        echo "<h3>로그인하신 회원분만 보실 수 있는 페이지입니다.</h3>";
        echo "<h4>로그인 후 이용 바랍니다.</h4>";
        echo "<a href='../../index.php'>로그인하기</a>";
        echo "</div></div>";
    }
    else{
?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>덩으니나라POS기기</title>
      <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script src="../jquery/jquery-number-master/jquery.number.js"></script>
      <style media="screen">
          @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
          *{font-family: 'Nanum Gothic', serif;}
          table{border-top: 2px solid black; margin-top:-40px;}
          tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
          h1{text-align: left;}
          #mem_check{border-top: 0px; border:none;}
          #rt_main{margin-top:70px; text-align: center;}
      </style>
   </head>
   <body>
       <a href="/PROJECT/MEMBER/membership.php"><?=$_SESSION['user_nickname']?></a>님 환영합니다!&nbsp;&nbsp;
       <a href="/PROJECT/MEMBER/logout.php">로그아웃</a>
       <div style="position: absolute; left: 50%;">
           <div id="center" style="position: relative; left: -50%; margin-top:-40px;">
              <h1 id="rt_main"><a href="/PROJECT/MEMBER/membership.php">덩 으 니 나 라</a></h1>
			  <form method="post" name="myForm" id="myForm" target="form_iframe">
				  <table cellpadding=15 cellspacing=0>
					 <caption><h1><a href="pos.php">덩으니나라 POS</a></h1></caption>
					  <br/>
						  <tr>
							  <th>&middot; 상품번호</th>
							  <td>
								  <input type="text" id="goods_num" name="goods_num">
								  <input type="button" name="goods_add" value="추가" onclick="my_submit(1)">
								  <input type="button" name="goods_del" value="제거" onclick="my_submit(3)">
								  <div style="font-size:12px; margin-top:8px;" >
									  (※ 상품번호는 1 ~ 5 까지의 숫자중 선택 , 중복선택가능 )
								  </div>
							  </td>
						  </tr>
						 <br/><br/>
						 <tr>
							 <th>&middot; 선택한 상품목록</th>
							 <td></td>
						 </tr>
						 <tr>
							 <td colspan="2">
								 <ol id='list' style="display:inline-block; margin-top:-2px; margin-left:-20px;">
									<?php
										//사용자가 선택한 상품들에 대한 list 출력 (계산완료처리 전)
										while($row = mysqli_fetch_assoc($result)){
											// echo "<div id=".$row['id']." style='margin-left:-20px; margin-bottom:5px;'>";
											echo "<li><div id=".$row['id']." style='display:inline-block; margin-left:5px; margin-bottom:5px; width=470px;'>".htmlspecialchars($row['gd_nm'])." ".htmlspecialchars(number_format($row['gd_amt']))."원 ".htmlspecialchars($row['gd_qnt'])."개 ".htmlspecialchars(number_format($row['gd_amt']*$row['gd_qnt']))."원</div>";
											echo "<input type='checkbox' name='gd_chk[]' value='".$row['gd_num']."'></li>";
										}

										// 가장 최근에 수량 및 추가로 인해 변경사항이 생긴 행의 id값을 가져온다.
										$id=0; // 초기값 설정필수! 이것때문에 다른 js까지 계속 실행안되었었음
										$sql = "SELECT * FROM user_chk WHERE cal_yn='N' ORDER BY insert_date DESC limit 1";
										$result = mysqli_query($con,$sql);
										if(mysqli_data_seek($result,0)){
											$row = mysqli_fetch_assoc($result);
											$id = $row['id'];
										}
									?>
								 </ol>
							 </td>
						 </tr>
						 <tr>
							 <th>&middot; 멤버십할인</th>
							 <td>
								 <div id="mem_yn">
									 <input type="text" id="usernum_input" name="mem_yn"> <input type="button" name="mem_check" value="멤버십적용" onclick="my_submit(6)">

								 </div>
								 <p style="font-size:12px; margin-bottom:-5px;">(※ 회원번호는 개인정보 수정페이지에서 확인가능 ex) A0001 )</p>
							 </td>
						 </tr>
						 <tr>
							 <td colspan="2">
								 <div id="hap_amt">
									 <?php
										$dic_amt=0;
										// 사용자가 선택한 상품들에 대한 합계금액 표시
										$sql = "SELECT * FROM user_chk WHERE cal_yn='N' ORDER BY id DESC limit 1 ";
										$result = mysqli_query($con,$sql);
										$row = mysqli_fetch_assoc($result);
										$mem_yn = htmlspecialchars($row['dic_yn']);
										$hap_amt = htmlspecialchars($row['hap_amt']); // 구매금액
										$org_hap_amt = $hap_amt/0.95; // 할인전 원래 총 금액
										$dic_amt = $org_hap_amt-$hap_amt; // 할인된 금액

										// 데이터가 있을경우에만 출력한다.
										if($result->num_rows!=0){
											if($mem_yn=='Y'){
												echo "총 합계 금액 ".number_format($org_hap_amt)."원<br/>";
												echo "멤버십할인 -".number_format($dic_amt)."원<br/>";
												echo "구매금액 ".number_format($hap_amt)."원<br/>";
											}
											else{
												echo "구매금액 ".number_format($hap_amt)."원<br/>";
											}
										}

									 ?>
								 </div>
								 <br/>
								 <input type="button" name="complete" value="계산완료" onclick ="my_submit(2)">
								 <input type="button" name="cancle" value="계산취소" onclick ="my_submit(4)">
							 </td>
						 </tr>
						 <tr>

						 </tr>
						 <article>
						 <tr>
							  <th>&middot; 결제내역 및 환불처리</th>
							  <td></td>
						 </tr>
						 <tr>
							 <td colspan="2">
								 <div id="receipt" style="cursor:pointer">
									 <?php
										// DB에서 같은 ord_num끼리 묶어 하나의 영수증으로 처리하는 부분
										$sql = "SELECT ord_num FROM user_chk WHERE cal_yn='Y' GROUP BY ord_num";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_assoc($result)){
											echo '<li style="margin-bottom:5px;"><a href="pos.php?id='.htmlspecialchars($row['ord_num']).'">'."주문번호 ".htmlspecialchars($row['ord_num'])."의 영수증".'</a></li>'."\n";
										}
									 ?>
									 <br/>
									 <div id="rc_oc">
									 <?php
										// 영수증링크 클릭시 해당 주문번호에 대한 상품리스트 출력하는 부분
										if(empty($_GET['id']) === false){
											echo "※ 주문번호 ".$_GET['id']."에 대한 상품리스트"."<br/><br/>";
											$sql = "SELECT * FROM user_chk WHERE cal_yn='Y' AND ord_num = '".$_GET['id']."'";
											$result = mysqli_query($con,$sql);
											while($row = mysqli_fetch_assoc($result)){
												echo "<li>".htmlspecialchars($row['gd_nm']).' '.htmlspecialchars(number_format($row['gd_amt'])).'원 '.htmlspecialchars($row['gd_qnt']).'개 '.htmlspecialchars(number_format($row['gd_amt']*$row['gd_qnt']))."원</li>"."\n";
											}
											echo "<br/>";

											// 합계는 한번만 출력되도록 한다.
											$sql = "SELECT * FROM user_chk WHERE cal_yn='Y' AND ord_num = '".$_GET['id']."' ORDER BY id DESC limit 1";
											$result = mysqli_query($con,$sql);
											$row = mysqli_fetch_assoc($result);
											$cal_cmpt = htmlspecialchars($row['cal_cmpt']); // 구매완료일시
											$user_num = htmlspecialchars($row['user_num']); // 회원번호
											$mem_yn = htmlspecialchars($row['dic_yn']); // 멤버십 할인 여부
											$hap_amt = htmlspecialchars($row['hap_amt']); // 구매금액
											$org_hap_amt = $hap_amt/0.95; // 할인전 원래 총 금액
											$dic_amt = $org_hap_amt-$hap_amt; // 할인된 금액

											if(!empty($user_num)){
												$sql = "SELECT * FROM members WHERE user_num='".$user_num."'";
												$result = mysqli_query($con,$sql);
												$row = mysqli_fetch_assoc($result);
												$user_name = $row['user_name'];
											}

											if($mem_yn=='Y'){
												echo "총 합계 금액 ".number_format($org_hap_amt)."원<br/>";
												echo "멤버십할인  -".number_format($dic_amt)."원<br/>";
												echo "구매금액 ".number_format($hap_amt)."원<br/>";
												echo "=================================<br/>";
												echo "▶ 구매일시 : ".$cal_cmpt."<br/>";
												echo "▶ ".$user_name."님 덩으니나라를 이용해주셔서 감사합니다.";
											}
											else{
												echo "구매금액 ".number_format($hap_amt)."원<br/>";
												echo "=================================<br/>";
												echo "▶ 구매일시 : ".$cal_cmpt."<br/>";
											}
										}
									 ?>
									 </div>
								 </div>
							 </td>
						 </tr>
						 <tr>
							 <th>&middot; 주문번호</th>
							 <td><input type="text" name="ord_num">&nbsp;<input type="button" name="pur_cancle" value="환불처리" onclick="my_submit(5)"></td>
						 </tr>
						 </article>

					  <!-- <iframe  name='form_iframe'></iframe> -->
					  <iframe style='display:none;' name='form_iframe'>
						  <!-- name값과 form의 target 값을 일정하게 놓으면 iframe에 action이 실행되는 페이지가 들어온다.-->
					  </iframe>
				  </table>
			  </form>

              <script type="text/javascript">
                  $("#goods_num").keypress(function(e) {
                        if (e.keyCode == 13){
                            my_submit(1);
                        }
                    });

                    $("#usernum_input").keypress(function(e) {
                          if (e.keyCode == 13){
                              my_submit(6);
                          }
                      });

                  // input 버튼 선택에 따라 다른 action값을 취해준다.
                  function my_submit(index){
                      var pv = eval("document.myForm");

                      if(index==1){
                          // 선택된 상품 리스트를 보여주는 부분을 처리
                          $.ajax({
                            type:"post",
                            url:"/PROJECT/POS/goods_add.php",
                            data:{
                                  'gd_num':pv.goods_num.value
                            },
                            async:false,
                            success : function(data){
                                var data = $.parseJSON(data);
                                if(data.id== ''){
                                    alert("해당 상품이 존재하지 않습니다. 상품번호를 다시 확인해주세요!");
                                }
                                else{
                                    $('#goods_num').val('').focus();
                                    $('#list').empty();
                                    for(i in data) {
                                        $(function(){
                                            $('#'+data[i].recent_id).css('background-color','#A3CCC9');
                                        })
                                        $('#list').append(
                                            '<li><div id='+data[i].id+' style="display:inline-block; margin-left:5px; margin-bottom:5px; width=470px;">'+data[i].gd_nm+' '+$.number(data[i].gd_amt)+'원 '+data[i].gd_qnt+'개 '+$.number(data[i].gd_hap)+'원</div><input type="checkbox" name="gd_chk[]" value="'+data[i].gd_num+'"></li>'
                                        );
                                        $('#hap_amt').html('구매금액 '+$.number(data[i].hap_amt)+'원');
                                    }
                                }
                            }
                          })
                          //document.myForm.action='goods_add.php';
                      }
                      if(index==2){
                          // 계산완료 처리하는부분
                          document.myForm.action='/PROJECT/POS/cal_process.php';
                      }
                      if(index==3){
                          //계산완료전에 사용자가 특정상품 구매를 취소하려고 하는경우
						  /*
                          var checkboxValues = [];
                          $("input[name='gd_chk']:checked").each(function(i) {
                              checkboxValues.push($(this).val());
                          });
						  */

                          $.ajax({
                            type:"post",
                            url:"/PROJECT/POS/goods_del.php",
							data:$('#myForm').serialize(),
                            async:false,
                            success : function(data){
                                var data = $.parseJSON(data);

                                if(data.id== ''){
                                    alert("해당 상품이 존재하지 않습니다. 상품번호를 다시 확인해주세요!");
                                    // document.write(data.kk);
                                }
                                else{
                                    $('#list').empty();
                                    for(i in data) {
                                        $(function(){
                                            $('#'+data[i].recent_id).css('background-color','#A3CCC9');
                                        })
                                        $('#list').append('<li><div id='+data[i].id+' style="display:inline-block; margin-left:5px; margin-bottom:5px; width=470px;">'+data[i].gd_nm+' '+$.number(data[i].gd_amt)+'원 '+data[i].gd_qnt+'개 '+$.number(data[i].gd_hap)+'원'+'</div><input type="checkbox" name="gd_chk[]" value="'+data[i].gd_num+'"></li>');
                                        $('#hap_amt').html('구매금액 '+$.number(data[i].hap_amt)+'원');
                                    }
                                }
                            }
                          })
                          //document.myForm.action='goods_del.php';
                      }
                      if(index==4){
                          //계산완료전에 사용자가 계산 전체를 취소하려는 경우
                          document.myForm.action='/PROJECT/POS/cal_cancle.php';
                      }
                      if(index==5){
                          //이미 구매 완료된 계산에 대해 환불요청하는경우
                          document.myForm.action='/PROJECT/POS/pur_cancle.php';
                      }
                      if(index==6){
                          // 멤버십 할인 적용부분
                          $.ajax({
                            type:"post",
                            url:"/PROJECT/POS/membership_discount.php",
                            data:{
                                  'user_num':pv.mem_yn.value
                            },
                            async:false,
                            success : function(data){
                                var data = $.parseJSON(data);
                                if(data.hap_amt== ''){
                                    alert("멤버십 카드 번호를 다시 확인해주세요!");
                                }
                                else{
                                    $('#hap_amt').empty();
                                    $('#hap_amt').append('총 합계 금액 '+$.number(data.org_hap_amt)+'원<br/>');
                                    $('#hap_amt').append('멤버십할인 -'+$.number(data.dic_amt)+'원<br/>');
                                    $('#hap_amt').append('구매 금액 '+$.number(data.hap_amt)+'원<br/>');
                                    $('#usernum_input').val('').focus();
                                }
                            }
                         })
                          //document.myForm.action='membership_discount.php'
                      }
                      document.myForm.submit();
                  }

                  // 추가되거나 삭제된 상품에 대해 BG처리
                  $(function(){
                      $('#'+<?=$id?>).css('background-color','#A3CCC9');
                  })

              </script>
           </div>
       </div>
       <?php }?>
   </body>
</html>


<!--
<script>
// DB에서 SELECT 를 통해 합계 및 상품리스트를 출력하기도 하지만 실시간으로 값을 추가해주는 부분 이중으로 출력되는셈..
function gd_info(gname,amt,gqnt,hap_amt){
    $('#list').append("<li>"+gname+" "+gqnt+"개 "+amt+"원</li>");
    $('input[name="goods_num"]').val('').focus();
    $('#hap_amt').text(hap_amt+"원");
}

// 영수증 링크 클릭할때마다 내역 펼쳐주기 및 닫기 기능 구현 함수
// $(document).ready(function(){
//     $("#receipt").click(function(){
//         var submenu = $(this).find($("#rc_oc"));
//         if( submenu.is(":visible") ){
//             submenu.slideUp();
//         }else{
//             submenu.slideDown();
//         }
//     });
// });
</script> -->
