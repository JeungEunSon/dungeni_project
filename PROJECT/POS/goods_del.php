<?php
  include("../connect.php");

  // 사용자가 입력한 상품번호 값을 받아오는 부분
  $gd_num = $_POST['gd_chk'];
  $gd_cnt = count($gd_num);

  $gd_number = @implode(',',$_POST['gd_chk']);

  // 사용자가 입력한 상품번호와 DB상의 상품번호 매칭하는 부분
  $sql = "SELECT * FROM goods_info WHERE gd_num in(".$gd_number.")";
  $result = mysqli_query($con,$sql);
  $row = mysqli_fetch_assoc($result);

  // 사용자가 입력한 상품번호와 DB상의 상품번호가 매칭되지 않는경우 경고창 표시
  if($result->num_rows==0){
      $tmp = array();
      $tmp['id'] = '';
      echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
  }
  else{
      for($i=0; $i<$gd_cnt; $i++){
          $hap_amt = 0;
          // 사용자가 선택한 상품과 DB상에 동일한 상품이 있는지 검색
          $sql = "SELECT * FROM user_chk WHERE gd_num=$gd_num[$i] AND cal_yn='N'";
          $result = mysqli_query($con,$sql);
          $row = mysqli_fetch_assoc($result);
          $gd_all_qnt = $row['gd_qnt'];

          // 제거하려는 상품이 DB에 한개만 등록되어있는 경우
          if($gd_all_qnt==1){
              $sql = "DELETE FROM user_chk WHERE cal_yn='N' AND gd_num=$gd_num[$i]";
              mysqli_query($con,$sql);
          }
          else { // 제거하련느 상품이 2개 이상인 경우는 수량조절을 해준다.
              $gd_all_qnt = $gd_all_qnt - 1;
              $sql = "UPDATE user_chk set insert_date = sysdate(), gd_qnt ='".$gd_all_qnt."' WHERE gd_num =$gd_num[$i] AND cal_yn='N'" ;
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

      }

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
          $tmp['gd_nm']  = $row['gd_nm'];
          $tmp['gd_amt'] = $row['gd_amt'];
          $tmp['gd_qnt'] = $row['gd_qnt'];
          $tmp['gd_hap'] = $row['gd_amt']*$row['gd_qnt'];
          $tmp['recent_id'] = $recent_id;
          $tmp['hap_amt'] = $hap_amt;
          $tmp['gd_num'] = $row['gd_num'];
          $json[] = $tmp;
      }
      echo json_encode($json, JSON_UNESCAPED_UNICODE);
  }

?>
