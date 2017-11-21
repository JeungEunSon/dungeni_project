<?php
    include("../session.php");
    include("../connect.php");

if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
    include("../login_yn.php");
}else{

$b_no = $_GET['id'];

// 조회수 증가 부분
if(!empty($b_no) && empty($_COOKIE['board_free_'.$b_no])) {
    $sql = 'update board set hit = hit + 1 where id ='.$b_no;
    mysqli_query($con,$sql);
    setcookie('board_free_'.$b_no,TRUE, 0 , '/');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라게시판</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script type="text/javascript">
            function autoResize(i)
            {
                var obj = $('#comment_frame');
                var height = obj.contents().find('html').height();
                    obj.height(height);
            }
        </script>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            #center{position: absolute; left: 50%; top:3%;}
            #center2{position: relative; left: -50%;}
            #content{width:750px; height: 350px; overflow: auto; }
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            a{text-decoration: none;}
            h2{text-align:left;}
            table{border-top: 2px solid black;}
            iframe{background-color:#EDEDED;}
            .board_secret{text-align: center; width:300px;}
            .title{width:90px;}
            .bt1{width:450px;}
            .bt2{width:200px;}
            .btn{font-size: 11px;}
            textarea {
                min-width: 100%;
                max-width: 100%;
                width: 90%;
                height: 90%;
                min-height: 80%;
                max-height: 80%;
                overflow: auto;
            }
            button{
              background:#787A78;
              color:#FFFFFF;
              border:none;
              position:relative;
              height:35px;
              padding:0 2em;
              cursor:pointer;
              transition:800ms ease all;
              outline:none;
              font-size:13px;
            }
            button:hover{
              background:#fff;
              color:#787A78;
            }
            button:before,button:after{
              content:'';
              position:absolute;
              top:0;
              right:0;
              height:2px;
              width:0;
              background: #787A78;
              transition:400ms ease all;
            }
            button:after{
              right:inherit;
              top:inherit;
              left:0;
              bottom:0;
            }
            button:hover:before,button:hover:after{
              width:100%;
              transition:800ms ease all;
            }
        </style>
    </head>
    <body>
        <div id="center">
            <div id="center2">
      <?php if($_GET['id']){

                //게시판 글 내용 보여주기
                $sql = "SELECT * FROM board WHERE id =".$_GET['id'];
                $result = mysqli_query($con,$sql);

                if($result->num_rows!=0){
                    $row = mysqli_fetch_assoc($result);
                    $title = trim($row['title']);
                    $user_name = $row['user_name'];
                    $w_date = $row['created'];
                    $b_hit = $row['hit'];
                    $content = trim($row['content']);
                    $file_name = $row['file_name'];
                    $user_id = $row['user_id'];
                    $w_pwd = $row['w_pwd'];

                    // 글 제목이 길 경우에는 말줄임표로 대체
                    if(strlen($title) > 74){
                        $title  = mb_strcut($title, 0, 74, 'utf-8');
                        $title .= "...";
                    }
                ?>
                    <table cellpadding=15 cellspacing=0>
                        <caption><h2><a href="/PROJECT/BOARD/board.php">자유게시판</a></h2></caption>
                        <tr>
                            <th class="title">제목</th><td class="bt1"><?=$title?></td><th class="title">작성자</th><td class="bt2"><?=$user_name?></td>
                        </tr>
                        <tr>
                            <th class="title">작성일</th><td class="bt1"><?=$w_date?></td><th class="title">조회수</th><td class="bt2"><?=$b_hit?></td>
                        </tr>
                        <tr>
                            <?php if(substr($file_name,0,4) == 'null') { ?>
                                <th class="title">첨부파일</th><td colspan="4" class="bt1">첨부파일 없음</td>
                            <?php } else { ?>
                                <th class="title">첨부파일</th><td colspan="4" class="bt1"><a href="/PROJECT/BOARD/board_file_download.php?id=<?=$b_no?>"><?=$file_name?></a></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td colspan="4"><div id="content"><pre><?=$content?></pre></div></td>
                        </tr>
                        <?php
                            $sql = "SELECT count(*) as cnt FROM board_cmt WHERE del_yn='N' AND b_no='".$_GET['id']."'";
                            $result = mysqli_query($con,$sql);
                            $row = mysqli_fetch_assoc($result);
                            $cmt_cnt = $row['cnt'];

                        ?>
                        <tr>
                            <th class="title"><a href="#" onclick="comment_open();">댓글 <?=$cmt_cnt?>개</a></th>
                            <td colspan="3"></td>
                        </tr>
                        <tbody id="b_cmt" style="display:none; margin:0px;">
                            <tr>
                                <td colspan="4">
                                    <iframe id="comment_frame" src="/PROJECT/BOARD/board_comment.php?id=<?=$_GET['id']?>" scrolling ="no" onload="autoResize(this)" frameborder="0" width="100%"></iframe>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br/>
              <?php if($user_id == $_SESSION['user_id']) {?>
                        <button type="button" name="modify" onclick="b_modify();">글 수정</button>&nbsp;
                        <button type="button" name="delete" onclick="b_delete();">글 삭제</button>&nbsp;
              <?php } ?>
                    <button type="button" name="back" onclick="location.href='/PROJECT/BOARD/board.php'">글 목록</button>&nbsp;
                    <?php
                    // 이전글 다음글 링크 처리
                    $sql ="SELECT * FROM board WHERE id in
                            ( select id from
                                (
                                    (select id from board WHERE id < '$b_no' ORDER BY id DESC limit 1) as tmp
                                )
                            )";
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_assoc($result);
                        $pre_no = $row['id'];

                        $sql ="SELECT * FROM board WHERE id in
                                ( select id from
                                    (
                                        (select id from board WHERE id > '$b_no' ORDER BY id limit 1) as tmp
                                    )
                                )";
                        $result = mysqli_query($con,$sql);
                        $row = mysqli_fetch_assoc($result);
                        $next_no = $row['id'];

                        if(!empty($pre_no)){
                            echo "<a href='/PROJECT/BOARD/board_info.php?id=".$pre_no."'>이전글</a>&nbsp;";
                        }

                        if(!empty($next_no)){
                            echo "<a href='/PROJECT/BOARD/board_info.php?id=".$next_no."'>다음글</a>&nbsp;";
                        }

                } ?>
      <?php } ?>
            </div>
        </div>
<?php } ?>
    </body>
    <script type="text/javascript">
        function b_modify(){
            location.href="/PROJECT/BOARD/board_modify.php?id=<?=$_GET['id']?>";
        }

        function b_delete(){
            if(confirm("정말 삭제하시겠습니까?")===true){
                location.href="/PROJECT/BOARD/board_delete.php?id=<?=$_GET['id']?>";
            }
            else{
                return;
            }
        }
        function comment_open(){
            if( $('#b_cmt').is(':hidden') ){ // 안보이는 상태
                $('#b_cmt').show();
                var obj = $('#comment_frame');
				var height = obj.contents().find('html').height();
					obj.height(height);
			}else{
                $('#b_cmt').hide();
			}
        }

    </script>
</html>
