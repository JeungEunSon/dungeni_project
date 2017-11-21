<?php
    include("../session.php");
    include("../connect.php");

    $input_bc_no = $_GET['bc_no'];

    $sql = "SELECT * FROM board_cmt WHERE bc_no='".$input_bc_no."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $input_b_no = $row['b_no'];

    $sql = "SELECT count(*) as cnt FROM board_cmt WHERE del_yn='N' AND b_no ='".$input_b_no."'";
    $result=mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $cmt_cnt = $row['cnt'];

    $sql = "SELECT * FROM members WHERE user_id ='".$_SESSION['user_id']."'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_assoc($result);
    $uname = $row['user_name'];

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>덩으니나라게시판댓글</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            a{text-decoration: none;}
            .title{width:110px;}
            .bt1{width:620px;}
            .bt2{width:134px; font-size: 13px;}
            .bt1_d{width:620px;}
            .bt2_d{width:134px;}
            /*.bt1_d{width:400px;}
            .bt2_d{width:260px;}*/
            .btn{font-size: 12px; width:59px;}
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
    <body style="overflow-y:hidden;">
            <table cellpadding=15 cellspacing=0>
                <!-- <tr>
                    <th id="title">댓글 <?=$cmt_cnt?>개</th>
                    <td colspan="3"></td>
                </tr> -->
                    <?php
                    // 댓글이 1개 이상일때
                    if($cmt_cnt != 0) {
                        $sql = "SELECT * FROM board_cmt WHERE b_no='".$input_b_no."' ORDER BY grp asc,lvl asc,seq desc ";
                        $result = mysqli_query($con,$sql);
                        while($row = mysqli_fetch_assoc($result)){
                            $user_name = $row['user_name'];
                            $content = $row['content'];
                            $cmt_time = $row['cmt_time'];
                            $cmt_user_id = $row['user_id'];
                            $bc_no = $row['bc_no'];
                            $re_cnt = $row['re_cnt'];
                            $grp = $row['grp'];
                            $seq = $row['seq'];
                            $lvl = $row['lvl'];
                            $re_name = $row['re_name'];
                            $del_yn = $row['del_yn'];

                            // 수정하려는 댓글번호일때
                            if($input_bc_no === $bc_no){ ?>
                                <tr>
                                    <form name="board_comment_modify" method="post" id="board_comment_modify" action="/PROJECT/BOARD/board_comment_modify.php">
                                        <input type="hidden" name="b_no" value="<?=$input_b_no?>">
                                        <input type="hidden" name="bc_no" value="<?=$input_bc_no?>">
                                        <!-- 답글일땐 앞에 특수문자 삽입 -->
                                        <?php
                                            if($lvl === '0'){ ?>
                                                <th class="title"><?=$user_name?></th>
                                        <?    }else{  ?>
                                                <th class="title">┗&nbsp;&nbsp;<?=$user_name?></th>
                                        <?    } ?>

                                        <td class="bt1" >
                                            <textarea id="recomment" name="recomment" rows="3" cols="75"><?=$content?></textarea>
                                        </td>
                                        <td class="bt2">
                                            <center>
                                                <a href="javascript:board_comment_modify.submit();" id="mod_btn" name="mod_btn">수정</a>&nbsp;
                                                <a href="#" id="mod_btn_cle" name="mod_btn_cancl" onclick="mod_btn_x();">수정취소</a>
                                                <!-- <button type="submit" id="mod_btn" name="mod_btn">수정완료</button>
                                                <button type="button" id="mod_btn_cle" name="mod_btn_cancl" onclick="mod_btn_x();">수정취소</button> -->
                                            </center>
                                        </td>
                                    </form>
                                </tr>
                         <? } else if($input_bc_no != $bc_no) { ?>
                             <tr>
                                 <!-- 답글일땐 앞에 특수문자 삽입 -->
                                 <?php
                                     if($lvl ==='0'){ ?>
                                         <th class="title"><?=$user_name?></th>
                             <?      }else{  ?>
                                         <th class="title">┗&nbsp;&nbsp;<?=$user_name?></th>
                             <?      }  ?>

                                 <!-- 댓글의 댓글일때만 앞에 누구에 대한 답글인지 원글 쓴사람 이름 표기 -->
                                 <?php
                                     if($lvl > '1'){ ?>
                                         <td class="bt1_d">
                                             <div id="<?=$bc_no?>" style="display:inline-block;"><strong><?=$re_name?></strong>&nbsp;&nbsp;<?=$content?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <div id="cmt_time" style="display:inline-block; font-size:11px;">(<?=$cmt_time?>)</div>
                                             </div>
                                         </td>
                                 <?  }else{ ?>
                                         <td class="bt1_d">
                                             <div id="<?=$bc_no?>" style="display:inline-block;"><?=$content?>&nbsp;&nbsp;&nbsp;&nbsp;
                                                 <div id="cmt_time" style="display:inline-block; font-size:11px;">(<?=$cmt_time?>)</div>
                                             </div>
                                         </td>
                                 <?  } ?>

                         <?php   if($_SESSION['user_id'] === $cmt_user_id) {?>
                                     <td class="bt2_d">
                                         <center>
                                             <a href="#" class="btn" name="cmt_modify" onclick="cmt_mod(<?=$bc_no?>)">수정</a>
                                             <a href="#" class="btn" name="cmt_delete" onclick="cmt_del(<?=$bc_no?>)">삭제</a>
                                             <a href="#" class="btn" name="cmt_reply" onclick="cmt_re(<?=$bc_no?>)">답글</a>
                                         </center>
                                     </td>
                         <?php   } else {?>
                                     <td class="bt2_d">
                                         <center><a href="#" class="btn" name="cmt_reply" onclick="cmt_re(<?=$bc_no?>)">답글</a></center>
                                     </td>
                         <?php   } ?>
                             </tr>
                        <?}
                        }
                  } ?>
                <tr>
                    <form name="board_comment" method="post" id="board_comment" action="/PROJECT/BOARD/board_comment_insert.php">
                        <input type="hidden" name="b_no" value="<?=$input_b_no?>">
                        <th class="title"><?=$uname?></th>
                        <td class="bt1" >
                            <textarea id="comment" name="comment" rows="3" cols="75"></textarea>
                        </td>
                        <td class="bt2">
                            <center><button type="submit" id="cmt_btn" name="cmt_btn" >댓글달기</button></center>
                        </td>
                    </form>
                </tr>
            </table>
    </body>
    <script type="text/javascript">
        function cmt_mod(index){
            location.href="/PROJECT/BOARD/board_comment_modify_screen.php?bc_no="+index;
        }

        function cmt_del(index){
            if(confirm("정말 삭제하시겠습니까?")===true){
                location.href="/PROJECT/BOARD/board_comment_delete.php?bc_no="+index;
            } else{
                return;
            }
        }

        function cmt_re(index){
            location.href="/PROJECT/BOARD/board_comment_reply_screen.php?bc_no="+index;
        }

        function mod_btn_x(){
            location.href ="/PROJECT/BOARD/board_comment.php?id=<?=$input_b_no?>";
        }
    </script>
</html>
