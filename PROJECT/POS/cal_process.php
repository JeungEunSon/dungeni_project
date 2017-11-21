<?php
    include("../connect.php");

    // 계산완료처리된 행들에 대해서 가장 최신의 행 1개를 가져오는 부분
    $sql = "SELECT * FROM user_chk WHERE cal_yn='Y' ORDER BY id DESC limit 1";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);

    // 마지막 행의 ord_num를 구한다
    $ord_num = $row['ord_num'];

    // ord_num이 없는 첫번째 주문건에 대해선 기본값인 0으로 셋팅해준다
    if(empty($ord_num)){
        $ord_num = 0;
    }

    // 가장 최신의 주문번호의 다음번호로 주문번호를 update
    $sql = "UPDATE user_chk set ord_num = $ord_num+1, cal_yn='Y',cal_cmpt=sysdate() WHERE ord_num = '0'";
    mysqli_query($con,$sql);

?>

<script type="text/javascript">
    // 현재 페이지 처리 후 부모페이지 reload
    parent.location.reload();
</script>
