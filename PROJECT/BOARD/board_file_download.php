<?php
    include("../connect.php");

    $sql = "SELECT * FROM board WHERE id =".$_GET['id'];
    $result = mysqli_query($con,$sql);

    if($result->num_rows!=0){
        $row = mysqli_fetch_assoc($result);
        $file_name = mysqli_real_escape_string($con,$row['file_name']);
    }

    $reail_filename = urldecode("$file_name");
    $file_dir = "file_upload/".$file_name;

    header('Content-Type: application/x-octetstream');
    header('Content-Length: '.filesize($file_dir));
    header('Content-Disposition: attachment; filename='.$reail_filename);
    header('Content-Transfer-Encoding: binary');

    $fp = fopen($file_dir, "r");
    fpassthru($fp);
    fclose($fp);

?>
