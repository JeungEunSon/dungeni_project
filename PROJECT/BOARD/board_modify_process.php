<?php
    include("../connect.php");

    $title = mysqli_real_escape_string($con,$_POST['title']);
    $content = mysqli_real_escape_string($con,$_POST['content']);
    $user_id = mysqli_real_escape_string($con,$_POST['user_id']);
    $b_no = mysqli_real_escape_string($con,$_POST['b_no']);

    if(isset($_POST['s_chk'])){
        $w_pwd = mysqli_real_escape_string($con,$_POST['w_pwd']);
    } else{
        $w_pwd = "";
    }

    $file_error = $_FILES['upload_file']['error'];               // 파일 에러 여부

    if(empty($_FILES['upload_file']['name'])){
        $file_name = "null.txt";
        $sql = "UPDATE board set w_pwd =password('".addslashes($w_pwd)."'), file_name='".$file_name."', title='".$title."',content='".$content."',created=sysdate() WHERE id='".$b_no."'";
        mysqli_query($con,$sql);
        header("Location:/PROJECT/BOARD/board.php");
    }
    else{
        if(preg_match("/[ㄱ-힣]/", $_FILES['upload_file']['name'])){
            include("../filename_chk.php");
        }else{
            if($file_error > 0){
                echo "ERRRO : ".$file_error."<br>";
            }
            else {
                $file_name = $_FILES['upload_file']['name'];
                $file_tmp_name = $_FILES['upload_file']['tmp_name'];   // 임시 디렉토리에 저장된 파일명
                $file_size = $_FILES['upload_file']['size'];                 // 업로드한 파일의 크기
                $mimeType = $_FILES['upload_file']['type'];                 // 업로드한 파일의 MIME Type

                // 첨부 파일이 저장될 서버 디렉토리 지정(원하는 경로에 맞게 수정하세요)
                $save_dir = "./file_upload/".$file_name;

                move_uploaded_file($file_tmp_name,$save_dir);

                $sql = "UPDATE board set w_pwd =password('".addslashes($w_pwd)."'), file_name='".$file_name."', title='".$title."',content='".$content."',created=sysdate() WHERE id='".$b_no."'";
                mysqli_query($con,$sql);

                header("Location:/PROJECT/BOARD/board.php");
            }
        }
    }



?>
