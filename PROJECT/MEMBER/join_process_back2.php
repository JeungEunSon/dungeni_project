<?php
    include("../connect.php");

    $not_col = array('password');
    $string = get_col_val($_POST,'members',array('password'));
    $string.= ", password = password('$_POST[password]')"; // 비밀번호 암호화때문에
    echo $string;

    function get_col_val($array, $table_name, $not_col = array(), $glue = ',') { // 쿼리스트링 가공
        global $con;

        $sql = "desc ".$table_name;
        $result = mysqli_query($con, $sql);
        $desc_col = array();
        while ($row = mysqli_fetch_array($result)) {
            $desc_col[] = $row[0];
        }

        $db_col = array();
        $db_val = array();
        $col_val = array();
        foreach($array as $col => $val) {
            if (in_array($col, $desc_col) && !in_array($col, $not_col)) {
                $db_col[] = $col;
                $db_val[] = $val;

                $col_val[] = addslashes($col).'="'.mysqli_real_escape_string($con,htmlentities(trim($val), ENT_QUOTES | ENT_IGNORE, "utf-8")).'"';
            }
        }
        $col_val = @implode($glue, $col_val);
        return $col_val;
    }
    exit;




    var_dump($result);
    exit;

    // $id = mysqli_real_escape_string($con,$_POST['id']);
    // $pwd = mysqli_real_escape_string($con,$_POST['password']);
    // $name = mysqli_real_escape_string($con,$_POST['name']);
    // $nickname = mysqli_real_escape_string($con,$_POST['nickname']);
    //
    // $cp1 = mysqli_real_escape_string($con,$_POST['cp1']);
    // $cp2 = mysqli_real_escape_string($con,$_POST['cp2']);
    // $cp3 = mysqli_real_escape_string($con,$_POST['cp3']);
    // $user_cp = $cp1.$cp2.$cp3;
    //
    // $zip = mysqli_real_escape_string($con,$_POST['zip']);
    // $addr1 = mysqli_real_escape_string($con,$_POST['addr1']);
    // $addr2 = mysqli_real_escape_string($con,$_POST['addr2']);
    // $user_addr = $addr1." ".$addr2;
    //
    // $email = mysqli_real_escape_string($con,$_POST['email']);
    //
    // $birth_year = mysqli_real_escape_string($con,$_POST['birth_year']);
    // $birth_month = mysqli_real_escape_string($con,$_POST['birth_month']);
    // $birth_day = mysqli_real_escape_string($con,$_POST['birth_day']);
    // $user_birth = $birth_year.".".$birth_month.".".$birth_day;
    //
    // $mail_yn = mysqli_real_escape_string($con,$_POST['mail_yn']);
    // $sms_yn = mysqli_real_escape_string($con,$_POST['sms_yn']);
    //
    // // 회원정보 INSERT
    // $sql = "INSERT INTO members(user_id,password,user_name,user_nickname,user_cp,zip,user_adr,user_email,user_birth,mail_yn,sms_yn,join_date,user_num)
    //         VALUES('".$id."','".$pwd."','".$name."','".$nickname."','".$user_cp."','".$zip."','".$user_addr."','".$email."','".$user_birth."','".$mail_yn."','".$sms_yn."',sysdate(),' ')";
    // mysqli_query($con,$sql);
    //
    // $sql = "SELECT * FROM members WHERE user_id='".$id."'";
    // $result = mysqli_query($con,$sql);
    // $row = mysqli_fetch_assoc($result);
    // $user_id = htmlspecialchars($row['user_id']);

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>회원가입완료</title>
        <style media="screen">
            *{font-family: "맑은고딕";}
            body{text-align: center;}
        </style>
    </head>
    <body>
        <h1>회원가입이 완료되었습니다!</h1>
        <h2><?=$user_id?> 님 덩으니나라에 오신것을 환영합니다^^</h2>
        <h3>이제 덩으니나라의 회원으로 모든 혜택을 맘껏 누리세요!</h3>
        <h3>로그인 후 이용바랍니다.</h3>

        <a href="/PROJECT/MEMBER/join.php">되돌아가기</a>&nbsp;<a href="/PROJECT/MEMBER/login.php">로그인하기</a>
    </body>
</html>
