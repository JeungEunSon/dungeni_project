<?php
    include("../connect.php");

    // 사용자가 입력한 주문번호 값을 받아오는 부분
    $ord_num = mysqli_real_escape_string($con,$_POST['ord_num']);

    // 이미 계산완료된 주문번호에 환불처리
    // $sql = "DELETE FROM user_chk WHERE ord_num=$ord_num AND cal_yn='Y'";
    // mysqli_query($con,$sql);

    $sql = "UPDATE user_chk set refund_yn ='Y', refund_date = sysdate() WHERE ord_num='".$ord_num."'";
    mysqli_query($con,$sql);
?>

<script type="text/javascript">
    // 현재 페이지 처리 후 부모페이지 reload
    parent.location.reload();
</script>
