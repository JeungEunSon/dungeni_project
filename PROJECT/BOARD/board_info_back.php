<?php
ini_set('display_errors', true);
    include("../session.php");
    include("../connect.php");

    $sql = "SELECT * FROM members WHERE user_id='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $uname = $row['user_name'];

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
        include("../login_yn.php");
    }else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라게시판</title>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            #center{position: absolute; left: 50%; top:3%;}
            #center2{position: relative; left: -50%;}
            #content{width:750px; height: 350px; overflow: auto; }
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            h2{text-align:left;}
            table{border-top: 2px solid black;}
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
                $b_no = $_GET['id'];
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
                ?>  <form name="board_comment" method="post" id="board_comment" target="form_iframe">
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
                            <?php
                                // 본문내용 출력
                                echo "<tr>";
                                echo "<td colspan='4'><div id='content'><pre>".($content)."</pre></div></td>";
                                echo "</tr>";
                            ?>
                            <tbody id="com_cnt">
                            <?php
                            // 댓글달기 영역
                                $sql = "SELECT count(*) as cnt FROM board_cmt WHERE b_no=".$_GET['id'];
                                $result = mysqli_query($con,$sql);
                                $row = mysqli_fetch_assoc($result);
                                $cmt_cnt = $row['cnt'];
                                if(!$cmt_cnt)  $cmt_cnt=0;
                            ?>
                                <tr>
                                    <th>댓글 <?=$cmt_cnt?>개</th>
                                    <td colspan="3"></td>
                                </tr>
                            </tbody>
                            <tbody id="b_cmt">
                        <?php
                            if($cmt_cnt != 0) {
                                $sql = "SELECT * FROM board_cmt WHERE b_no=".$_GET['id'];
                                $result = mysqli_query($con,$sql);

                                while($row = mysqli_fetch_assoc($result)){
                                    $user_name = $row['user_name'];
                                    $content = $row['content'];
                                    $cmt_time = $row['cmt_time'];
                                    $user_id = $row['user_id'];
                                    $bc_no = $row['bc_no'];
                                    ?>
                                    <tr>
                                        <th><?=$user_name?></th>
                                        <td><div id="<?=$bc_no?>" style="display:inline-block;"><?=$content?>&nbsp;&nbsp;&nbsp;&nbsp;<div id="cmt_time" style="display:inline-block; font-size:11px;">(<?=$cmt_time?>)</div></div></td>
                                <?php   if($_SESSION['user_id'] == $user_id) {?>
                                            <td colspan="2">
                                                <div id="btn_all_<?=$bc_no?>" style="display:inline-block;">
                                                    <button class="btn" type="button" name="cmt_modify" onclick="cmt_mod(<?=$bc_no?>);">수정</button>
                                                    <button class="btn" type="button" name="cmt_delete" onclick="cmt_del(<?=$bc_no?>);">삭제</button>
                                                    <button class="btn" type="button" name="cmt_reply">답글</button>
                                                </div>
                                            </td>
                                <?php   } else {?>
                                            <td colspan="2">
                                                <button class="btn" type="button" name="button">답글</button>
                                            </td>
                                <?php   } ?>
                                    </tr>
                        <?      }
                            }
                        ?>
                            </tbody>
                            <tr>
                                <th><?=$uname?></th>
                                <td colspan="2">
                                    <textarea id="comment" name="comment" rows="3" cols="75"></textarea>
                                </td>
                                <td>
                                    <button type="button" id="cmt_btn" name="cmt_btn" onclick="b_comment();">댓글달기</button>
                                </td>
                            </tr>
                        </table>
                    </form>
                    <br/>
              <?php if($user_id === $_SESSION['user_id']) {?>
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

                        // 조회수 증가 부분
                        if($_GET['id']){
                            $b_no = $_GET['id'];
                            if(!empty($b_no) && empty($_COOKIE['board_free_'.$b_no])) {
                                $sql = 'update board set hit = hit + 1 where id ='.$b_no;
                                $result = mysqli_query($con,$sql);
                                if(empty($result)) {
                                    ?>
                                    <script>
                                        alert('오류가 발생했습니다.');
                                        history.back();
                                    </script>
                                    <?php
                                } else {
                                    setcookie('board_free_'.$b_no,TRUE, 0, '/');
                                }
                            }
                        }

                } ?>
      <?php } ?>
            </div>
        </div>
<?php } ?>
    </body>
    <script type="text/javascript">
    var dc = eval("document.board_comment");

        function b_comment(){
            if(!dc.comment.value){
                alert("댓글 내용을 입력해주세요!");
                dc.comment.focus();
                return;
            }

            $.ajax({
              type:"post",
              url:"/PROJECT/BOARD/board_comment.php",
              data:{
                    'b_cmt':dc.comment.value,
                    'b_no' :<?=$_GET['id']?>
              },
              async:false,
              success : function(data){
                  var data = $.parseJSON(data);
                  $('#comment').val('').focus();
                  $('#b_cmt').html("");
                  $('#com_cnt').html("");
                  for(i in data) {
                      $('#b_cmt').append(
                          '<tr id="'+data[i].bc_no+'">'+
                            '<th>'+data[i].user_name+'</th>'+
                            '<td>'+data[i].content+'&nbsp;&nbsp;&nbsp;&nbsp;<div id="cmt_time" style="display:inline-block; font-size:11px;">('+data[i].cmt_time+')</div></td>'+
                        if(<?=$_SESSION['uesr_id']?> === data[i].user_id)
                            '<td colspan="2">'+
                                '<button class="btn" type="button" name="cmt_modify" onclick="cmt_mod('+data[i].bc_no+');">수정</button> '+
                                '<button class="btn" type="button" name="cmt_delete" onclick="cmt_del('+data[i].bc_no+')">삭제</button> '+
                                '<button class="btn" type="button" name="cmt_reply">답글</button> '+
                            '</td>'+
                        } else {
                            '<td colspan="2">'+
                                '<button class="btn" type="button" name="button">답글</button>'+
                            '</td>'+
                        }
                          '</tr>'
                      );
                      $('#com_cnt').html(
                          '<tr>'+
                             '<th>댓글 '+data[i].comment_cnt+'개</th>'+
                             '<td colspan="3"></td>'+
                          '</tr>'
                      );
                  }
              }
            })

            dc.submit();
        }

        function cmt_del(index){
            if(confirm("댓글을 삭제하시겠습니까?") === true){
                dc.submit();
            }
            else{
                return;
            }

            $.ajax({
              type:"post",
              url:"/PROJECT/BOARD/board_comment_delete.php",
              data:{
                    'bc_no':index,
                    'b_no' :<?=$_GET['id']?>
              },
              async:false,
              success : function(data){
                  var data = $.parseJSON(data);
                  $('#comment').val('').focus();
                  $('#b_cmt').html("");
                  $('#com_cnt').html("");
                  for(i in data) {
                      $('#b_cmt').append(
                          '<tr id="'+data[i].bc_no+'">'+
                            '<th>'+data[i].user_name+'</th>'+
                            '<td>'+data[i].content+'&nbsp;&nbsp;&nbsp;&nbsp;<div id="cmt_time" style="display:inline-block; font-size:11px;">('+data[i].cmt_time+')</div></td>'+
                        if(<?=$_SESSION['uesr_id']?> === data[i].user_id)
                            '<td colspan="2">'+
                                '<button class="btn" type="button" name="cmt_modify" onclick="cmt_mod('+data[i].bc_no+');">수정</button> '+
                                '<button class="btn" type="button" name="cmt_delete" onclick="cmt_del('+data[i].bc_no+')">삭제</button> '+
                                '<button class="btn" type="button" name="cmt_reply">답글</button> '+
                            '</td>'+
                        } else {
                            '<td colspan="2">'+
                                '<button class="btn" type="button" name="button">답글</button>'+
                            '</td>'+
                        }
                          '</tr>'

                      );
                      $('#com_cnt').html(
                          '<tr>'+
                             '<th>댓글 '+data[i].comment_cnt+'개</th>'+
                             '<td colspan="3"></td>'+
                          '</tr>'
                      );
                  }
              }
            })
        }

        function cmt_mod(index){
            $.ajax({
              type:"post",
              url:"/PROJECT/BOARD/board_comment_modify_1.php",
              data:{
                    'bc_no':index,
                    'b_no' :<?=$_GET['id']?>
              },
              async:false,
              success : function(data){
                  var data = $.parseJSON(data);
                  for(i in data) {
                      $('#'+index).html(
                          '<textarea id="re_comment" name="re_comment" rows="3" cols="75">'+data[i].content+'</textarea>'
                      );
                      $('#btn_all_'+index).html(
                          '<button class="btn" type="button" name="cmt_modify" onclick="real_modify('+data[i].bc_no+');">수정완료</button>'
                      );
                      $('#com_cnt').html(
                          '<tr>'+
                             '<th>댓글 '+data[i].comment_cnt+'개</th>'+
                             '<td colspan="3"></td>'+
                          '</tr>'
                      );
                  }
              }
            })
            //dc.submit();
        }

        function real_modify(index){
            $.ajax({
              type:"post",
              url:"/PROJECT/BOARD/board_comment_modify.php",
              data:{
                    'bc_no':index,
                    'b_no' :<?=$_GET['id']?>,
                    'content' : dc.re_comment.value
              },
              async:false,
              success : function(data){
                  var data = $.parseJSON(data);
                  $('#comment').val('').focus();
                  $('#b_cmt').html("");
                  $('#com_cnt').html("");
                  for(i in data) {
					  console.log(data);
                      $('#b_cmt').append(
                          '<tr>'+
                            '<th>'+data[i].user_name+'</th>'+
                            '<td><div id="'+data[i].bc_no+'">'+data[i].content+'&nbsp;&nbsp;&nbsp;&nbsp;<div id="cmt_time" style="display:inline-block; font-size:11px;">('+data[i].cmt_time+')</div></div></td>'+
                            if(<?=$_SESSION['uesr_id']?> === data[i].user_id)
                                '<td colspan="2">'+
                                    '<button class="btn" type="button" name="cmt_modify" onclick="cmt_mod('+data[i].bc_no+');">수정</button> '+
                                    '<button class="btn" type="button" name="cmt_delete" onclick="cmt_del('+data[i].bc_no+')">삭제</button> '+
                                    '<button class="btn" type="button" name="cmt_reply">답글</button> '+
                                '</td>'+
                            } else {
                                '<td colspan="2">'+
                                    '<button class="btn" type="button" name="button">답글</button>'+
                                '</td>'+
                            }
                              '</tr>'
                          '</tr>'

                      );
                      $('#com_cnt').html(
                          '<tr>'+
                             '<th>댓글 '+data[i].comment_cnt+'개</th>'+
                             '<td colspan="3"></td>'+
                          '</tr>'
                      );
                  }
              }
            })
            dc.submit();
        }

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

    </script>
    <iframe style='display:none;' name='form_iframe'>
    </iframe>
</html>
