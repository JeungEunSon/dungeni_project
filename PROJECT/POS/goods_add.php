<?php
  include("../connect.php");
  // 사용자가 입력한 상품번호 값을 받아오는 부분
  $gd_num = mysqli_real_escape_string($con,$_POST['gd_num']);

  // 사용자가 입력한 상품번호와 DB상의 상품번호 매칭하는 부분
  $sql = "SELECT * FROM goods_info WHERE gd_num ='".$gd_num."'";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_assoc($result);

  // 사용자가 입력한 상품번호와 DB상의 상품번호가 매칭되지 않는경우 데이터 공란처리
   if($result->num_rows==0){
       $tmp = array();
       $tmp['id']     = '';
       echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
   }
   else{
       $hap_amt = 0;
       $goods_name = $row['name'];
       $goods_amt = $row['amount'];

       // 사용자가 선택한 상품과 DB상에 동일한 상품이 있는지 검색
       $sql = "SELECT * FROM user_chk WHERE gd_num=$gd_num AND cal_yn='N'";
       $result = mysqli_query($con,$sql);
       $row = mysqli_fetch_assoc($result);
       $gd_all_qnt = $row['gd_qnt'];

       // 새로운 상품이 등록될때
       if(empty($gd_all_qnt)){
           // user_chk 테이블에 사용자가 선택한 상품데이터 insert 해주는 부분
           $sql = "INSERT INTO user_chk(ord_num,gd_num,gd_nm,gd_amt,hap_amt,insert_date,cal_yn,gd_qnt,dic_yn,user_num,cal_cmpt)
                   VALUES('0','".$gd_num."','".$goods_name."', '".$goods_amt."','".$hap_amt."',sysdate(),'N','1','N',' ',null)";
           mysqli_query($con,$sql);
       }
       else { // 기존에 등록된 상품일때
           $gd_all_qnt = $gd_all_qnt + 1;
           $sql = "UPDATE user_chk set insert_date=sysdate(), gd_qnt ='".$gd_all_qnt."' WHERE gd_num =$gd_num AND cal_yn='N'" ;
           mysqli_query($con,$sql);

       }

       // 사용자가 선택한 상품들에 대해 전체적인 합계금액을 구하는 부분
       $sql = "SELECT * FROM user_chk WHERE cal_yn='N'";
       $result = mysqli_query($con,$sql);
       if(mysqli_data_seek($result,0)){
           while($row = mysqli_fetch_assoc($result)){
                   $hap_amt = $hap_amt + ($row['gd_amt']*$row['gd_qnt']);
           }
       }

       // 최종 합계금액 update
       $sql = "UPDATE user_chk set hap_amt = '".$hap_amt."' WHERE cal_yn='N' ORDER BY id DESC limit 1";
       mysqli_query($con,$sql);

       // 가장 최근에 수량 및 추가로 인해 변경사항이 생긴 행의 id값을 가져온다.
       $recent_id=0; // 초기값 설정필수! 이것때문에 다른 js까지 계속 실행안되었었음
       $sql = "SELECT * FROM user_chk WHERE cal_yn='N' ORDER BY insert_date DESC limit 1";
       $result = mysqli_query($con,$sql);
       if(mysqli_data_seek($result,0)){
           $row = mysqli_fetch_assoc($result);
           $recent_id = $row['id'];
       }

       // 사용자가 선택한 상품들에 대한 list 출력 (계산완료처리 전)
       $sql="select * from user_chk where cal_yn='N'";
       $result=mysqli_query($con,$sql);
       $json = array();
       while($row = mysqli_fetch_assoc($result)){
           $tmp = array();
           $tmp['id']     = $row['id'];
           $tmp['gd_num'] = $row['gd_num'];
           $tmp['gd_nm']  = $row['gd_nm'];
           $tmp['gd_amt'] = $row['gd_amt'];
           $tmp['gd_qnt'] = $row['gd_qnt'];
           $tmp['gd_hap'] = $row['gd_amt']*$row['gd_qnt'];
           $tmp['recent_id'] = $recent_id;
           $tmp['hap_amt'] = $hap_amt;
           $json[] = $tmp;
       }

       echo json_encode($json, JSON_UNESCAPED_UNICODE);
   }

?>
