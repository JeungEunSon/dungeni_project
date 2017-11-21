<?php
    include("../connect.php");

    // 계산완료 전 구매 전체 취소 요청시 데이터 모두 delete
    $sql = "DELETE FROM user_chk WHERE ord_num='0' AND cal_yn='N'";
    mysqli_query($con,$sql);
?>

<script type="text/javascript">
    // 현재 페이지 처리 후 부모페이지 reload
    parent.location.reload();
</script>
