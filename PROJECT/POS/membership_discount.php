<?php
    include("../connect.php");

    // 멤버십 할인구분 값 받아오는 부분
    $user_num = mysqli_real_escape_string($con,$_POST['user_num']);

    // 멤버십 바코드 입력값이 회원정보 테이블에 있는지 조회
    $sql = "SELECT * FROM members WHERE user_num ='".$user_num."'";
    $result = mysqli_query($con,$sql);

    // user_num과 매칭되는 유저가 없을때
    if($result->num_rows==0){
        $tmp = array();
        $tmp['hap_amt'] = '';
        echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
    }
    else{
        // 합계금액값 가져오는 부분
        $sql = "SELECT * FROM user_chk WHERE cal_yn='N' ORDER BY id DESC limit 1";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $hap_amt = $row['hap_amt'];
        $id = $row['id'];

        $hap_amt = $hap_amt * 0.95;
        $sql = "UPDATE user_chk set hap_amt=$hap_amt WHERE id=$id";
        mysqli_query($con,$sql);
        $sql = "UPDATE user_chk set dic_yn='Y',user_num='".$user_num."' WHERE cal_yn='N'";
        mysqli_query($con,$sql);

        // 사용자가 선택한 상품들에 대한 합계금액 표시
        $dic_amt=0;
        $sql = "SELECT * FROM user_chk WHERE cal_yn='N' ORDER BY id DESC limit 1 ";
        $result = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($result);
        $mem_yn = htmlspecialchars($row['dic_yn']);
        $hap_amt = htmlspecialchars($row['hap_amt']); // 구매금액
        $org_hap_amt = $hap_amt/0.95; // 할인전 원래 총 금액
        $dic_amt = $org_hap_amt-$hap_amt; // 할인된 금액

        // 데이터가 있을경우에만 출력한다.
        if($result->num_rows!=0){
            $tmp = array();
            $tmp['org_hap_amt'] = $org_hap_amt;
            $tmp['dic_amt'] = $dic_amt;
            $tmp['hap_amt'] = $hap_amt;
            echo json_encode($tmp, JSON_UNESCAPED_UNICODE);
        }
    }

?>
