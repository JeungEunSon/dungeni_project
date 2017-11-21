<?php
    include("../session.php");
    include("../connect.php");
    // 계산완료처리되지 않은 데이터들에 대한 SELECT문
    $sql="select * from user_chk where cal_yn='N'";
    $result=mysqli_query($con,$sql);

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
        include("../login_yn.php");
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
          table{border-top: 2px solid black; width: 496px;}
          tr,th,td{font-size: 15px; border-bottom: 1px solid grey; text-align: left;}
          h2{text-align: left;}
          #back{text-align: center;}
          #mem_check{border-top: 0px; border:none;}
          #rt_main{margin-top:70px; text-align: center;}
          #title{font-size:18px; text-align: center;}
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
					 <caption><h2><a href="order_info.php">덩으니나라 POS</a></h2></caption>
					  <br/>
                         <tr>
							  <th colspan="2" id="title">&middot; 결제내역 및 환불처리 페이지 &middot;</th>
						 </tr>
                         <tr>
                              <th colspan="2" >&middot; 영수증목록</th>
                         </tr>
						 <tr>
							 <td colspan="2">
								 <div id="receipt" style="cursor:pointer">
									 <?php
										// DB에서 같은 ord_num끼리 묶어 하나의 영수증으로 처리하는 부분
										$sql = "SELECT ord_num FROM user_chk WHERE cal_yn='Y' GROUP BY ord_num";
										$result = mysqli_query($con,$sql);
										while($row = mysqli_fetch_assoc($result)){
											echo '<li style="margin-bottom:5px;"><a href="order_info.php?id='.htmlspecialchars($row['ord_num']).'">'."주문번호 ".htmlspecialchars($row['ord_num'])."의 영수증".'</a></li>'."\n";
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
							 <th colspan="2">&middot; 주문 환불처리</th>
						 </tr>
                         <tr>
							 <td colspan="2"><input type="text" name="ord_num" id="ord_num" placeholder="주문번호를 입력해주세요" style="width:200px;">&nbsp;
                             <input type="button" name="pur_cancle" value="환불처리" onclick="my_submit(5)"></td>
						 </tr>
                         <tr>
                             <th colspan="2">&middot; 환불내역</th>
                         </tr>
                          <tr>
                             <td colspan="2"></td>
                         </tr>
                         <tr>
							 <th colspan="2" id="back">&middot; <a href="/PROJECT/POS/pos.php">결제페이지로 이동 &middot;</a></th>
						 </tr>

					  <iframe style='display:none;' name='form_iframe'>
						  <!-- name값과 form의 target 값을 일정하게 놓으면 iframe에 action이 실행되는 페이지가 들어온다.-->
					  </iframe>
				  </table>
			  </form>

              <script type="text/javascript">
                  $("#ord_num").keypress(function(e) {
                        if (e.keyCode == 13){
                            my_submit(5);
                        }
                    });

                  // input 버튼 선택에 따라 다른 action값을 취해준다.
                  function my_submit(index){
                      var pv = eval("document.myForm");

                      if(index==5){
                          //이미 구매 완료된 계산에 대해 환불요청하는경우
                          document.myForm.action='/PROJECT/POS/pur_cancle.php';
                      }
                      document.myForm.submit();
                  }

              </script>
           </div>
       </div>
       <?php }?>
   </body>
</html>
