<?php
    include("../session.php");
    include("../connect.php");

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
        <script type="text/javascript" src="/PROJECT/editor/workspace/js/service/HuskyEZCreator.js" charset="utf-8"></script>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            #center{position: absolute; left: 50%; top:3%;}
            #center2{position: relative; left: -50%;}
            #textarea{width:770px; height: 350px; overflow: auto; }
            #content{width:760px;}
            #input_title{width: 400px;}
            tr,th,td{font-size: 15px; border-bottom: 1px solid grey;}
            a{text-decoration: none;}
            h2{text-align:left;}
            table{border-top: 2px solid black;}
            .title{width:80px; text-align: center;}
            .bt1{width:450px;}
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
                <form name="board_modify" enctype="multipart/form-data" action="/PROJECT/BOARD/board_modify_process.php" method="post">
                    <?php
                    $b_no = $_GET['id'];
                    $sql = "SELECT * FROM board WHERE id =".$b_no;
                    $result = mysqli_query($con,$sql);
                    if($result->num_rows!=0){
                        $row = mysqli_fetch_assoc($result);
                        $user_name = $row['user_name'];
                        $user_id = $row['user_id'];
                        $content = $row['content'];
                        $title = $row['title'];
                        $file_name =$row['file_name'];
                    ?>

                    <table cellpadding=15 cellspacing=0>
                        <caption><h2><a href="/PROJECT/BOARD/board.php">자유게시판</a></h2></caption>
                        <tr>
                            <th class="title">제목</th><td class="bt1"><input type="text" name = "title" id="input_title" title="제목을입력하세요." maxlength="40" value="<?=$title?>">&nbsp;&nbsp;&nbsp;* 40자 이내로 기재</td>
                        </tr>
                        <tr>
                            <th class="title">작성자</th><td class="bt1"><?=$user_name?></td>
                        </tr>
                        <tr>
                            <th class="title">파일업로드</th><td class="bt1"><input type="file" name="upload_file">&nbsp;(※파일명 한글 불가)</td>
                        </tr>
                        <tr>
                            <th class="title">본문작성</th>
                            <td class="bt2">
                                비밀글작성 <input type="checkbox" id="s_chk" name="s_chk" value="w_secret"><div id="w_pwd" style="display:inline-block;"><input type='password' id='w_pwd' name='w_pwd' style='display:none;'></div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><div id="textarea"><textarea name="content" id="content" rows="19" cols="105"><?=$content?></textarea></div></td>
                        </tr>
                    </table>
                    <br/>
                    <center>
                        <button type="button" name="bw" onclick="modify_process();">수정완료</button>&nbsp;
                        <button type="button" name="back" onclick="save();">글 목록</button>
                    </center>
                    <input type="hidden" name="user_id" value="<?=$user_id?>">
                    <input type="hidden" name="b_no" value="<?=$b_no?>">
                </form>
          <?php } ?>
            </div>
        </div>
<?php } ?>
    </body>

    <script type="text/javascript">
    var oEditors = [];
    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "content",
        sSkinURI: "/PROJECT/editor/workspace/SmartEditor2Skin.html",
        fCreator: "createSEditor2"
    });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#content').on('keyup', function() {
                if($(this).val().length > 2000) {
                    $(this).val($(this).val().substring(0, 2000));
                }
            });

            $("#s_chk").change(function(){
                if($("#s_chk").is(":checked")){
                    $("#w_pwd").html("<input type='password' id='w_pwd' name='w_pwd'>");
                }else if($("#w_pwd").attr('checked', false)){
                    $("#w_pwd").html("<input type='password' id='w_pwd' name='w_pwd' style='display:none;'>");
                }
            });

        });

        function save(){
            if(confirm("저장하지 않고 나가시겠습니까?") === true){
                location.href='/PROJECT/BOARD/board.php';
            }else{
                return;
            }
        }

        function modify_process(){
            oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);

            var bm = eval("document.board_modify");
            if(!bm.title.value){
                alert("제목을 입력해주세요!");
                return;
            }

            if(!bm.content.value){
                alert("본문을 입력해주세요!");
                return;
            }

            if(bm.w_pwd.value.length > 15){
                alert("비밀번호는 15자 이하로 설정해주세요!");
                bm.w_pwd.focus();
                bm.w_pwd.select();
                return;
            }

            if(confirm("글을 수정 하시겠습니까?") === true){
                bm.submit();
            }
            else{
                return;
            }
        }
    </script>
</html>
