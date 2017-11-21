<?php
    include("../session.php");
    include("../connect.php");

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
        include("../login_yn.php");
    }else{

    // 페이징처리
    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(!empty($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

    $sql = "SELECT count(*) as cnt from board order by id desc";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();

    $allPost = $row['cnt']; //전체 게시글의 수

    $onePage = 10; // 한 페이지에 보여줄 게시글의 수.
    $allPage = ceil($allPost / $onePage); //전체 페이지의 수

    if($page < 1 || ($allPage && $page > $allPage)) {
    ?>
        <script>
            alert("존재하지 않는 페이지입니다.");
            history.back();
        </script>
    <?php
        exit;
    }

    $oneSection = 10; //한번에 보여줄 총 페이지 개수(1~10,11~20...)
    $currentSection = ceil($page / $oneSection); // 현재 섹션
    $allSection = ceil($allPage / $oneSection); // 전체 섹션의 수

    $firstPage = ($currentSection * $oneSection) - ($oneSection - 1); // 현재 섹션의 가장 첫번째 페이지

    if($currentSection == $allSection){
        $lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
    } else {
        $lastPage = $currentSection * $oneSection; // 현재 섹션의 마지막 페이지
    }

    $prevPage = (($currentSection - 1) * $oneSection); // 이전페이지 , 11~20일때 이전 누르면 10페이지 보여주기
    $nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

    $paging = "<ul>"; // 페이징을 저장할 변수

    // 첫페이지가 아니라면 처음 버튼 생성
    if($page != 1){
        $paging .= "<li class ='page page_start'><a href='/PROJECT/BOARD/board.php?page=1'>처음</a></li>";
    }
    // 첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1){
        $pageing .= "<li class='page page_prev'><a href='/PROJECT/BOARD/board.php?page=".$prevPage.">이전</a></li>";
    }

    for($i=$firstPage; $i<=$lastPage; $i++){
        if($i == $page){
            $paging .= "<li class ='page current'>".$i."</li>";
        } else {
            $paging .= "<li class ='page'><a href='/PROJECT/BOARD/board.php?page=".$i."'>".$i."</a></li>";
        }
    }

    // 마지막 섹션이 아니라면 다음 버튼 생성
    if($currentSection != $allSection){
        $paging .= "<li class='page page_next'><a href='/PROJECT/BOARD/board.php?page=".$nextPage."'>다음</a></li>";
    }

    // 마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage){
        $paging .= "<li class='page page_end'><a href='/PROJECT/BOARD/board.php?page=".$allPage."'>끝</a></li>";
    }

    $paging .= "</ul>";

    // 페이징 처리 끝
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
            #center2{position: relative; left: -50%; width:800px;}
            #b_title{width:500px; text-align: center;}
            .b_num{width: 50px;}
            .b_title{width:500px; text-align: left;}
            .user_name{width: 100px}
            .w_date{width: 100px;}
            .b_hit{width: 50px; font-size: 13px;}
            .search{text-align: right; margin-top:-30px;}
            .paging{display: inline-block;  margin-top:-35px; margin-left: 150px; }
            li{float:left; list-style:none; margin:4px;}
            tr,th{font-size: 13px; height: 20px; border-bottom: 1px solid grey;}
            h2{text-align:left;}
            h1{text-align: center;}
            table{border-top: 2px solid black;}
            a{text-decoration: none;}
            button{
              background:#FFFFFF;
              color:#000000;
              border:none;
              position:relative;
              height:35px;
              padding:0 2em;
              cursor:pointer;
              transition:800ms ease all;
              outline:none;
              font-size:14px;
            }
            button:hover{
              background:#fff;
              color:#000000;
            }
            button:before,button:after{
              content:'';
              position:absolute;
              top:0;
              right:0;
              height:2px;
              width:0;
              background: #666666;
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
        <a href="/PROJECT/MEMBER/membership.php"><?=$_SESSION['user_nickname']?></a>님 환영합니다!&nbsp;&nbsp;
        <a href="/PROJECT/MEMBER/logout.php">로그아웃</a>
        <div id="center">
            <div id="center2">
                <h1><a href="/PROJECT/MEMBER/membership.php">덩 으 니 나 라</a></h1>
                <table cellpadding=15 cellspacing=0 >
                    <caption><h2><a href="/PROJECT/BOARD/board.php">자유게시판</a></h2></caption>
                    <tr>
                        <th class="b_num">번호</th><th id="b_title">제목</th><th class="user_name">작성자</th><th class="w_date">작성일</th><th class="b_hit">조회수</th>
                    </tr>
                    <?php
                        $currentLimit = ($onePage * $page)  - $onePage; // 몇번쨰의 글부터 가져오는지
                        $sqlLimit = " limit ".$currentLimit.",".$onePage; // limit sql 구문

                        $sql = "SELECT * FROM board ORDER BY id desc".$sqlLimit; // 원하는 개수만큼 가져온다.
                        $result = $con->query($sql);

                        if($result->num_rows!=0){
                            while($row = mysqli_fetch_assoc($result)){
                                // 글 제목이 길 경우에는 말줄임표로 대체
                                if(strlen($row["title"]) > 60){
                                    $title  = mb_strcut($row["title"], 0, 60, 'utf-8');
                                    $title .= "...";
                                }else{
                                    $title = $row["title"];
                                }

                                $sql2=  "SELECT count(*) as cnt FROM board_cmt WHERE b_no='".$row['id']."'";
                                $result2 = mysqli_query($con,$sql2);
                                $row2 = mysqli_fetch_assoc($result2);
                                $cmt_cnt = $row2['cnt'];

                                echo "<tr>";
                                echo "<th class='b_num'>".htmlspecialchars($row['id'])."</th>";

                                // 댓글 갯수 여부
                                if($cmt_cnt === '0'){
                                    // 비밀글 여부
                                    if($row['w_pwd']==NULL){
                                        echo "<th class='b_title'><a href='/PROJECT/BOARD/board_info.php?id=".htmlspecialchars($row['id'])."'>".$title."</a></th>";
                                    }else{
                                        if(($_SESSION['user_id']==='tpfvmdkdlel') || ($_SESSION['user_id']===$row['user_id'])) // 관리자와 글쓴이는 비밀글 열람 가능
                                            echo "<th class='b_title'><a href='/PROJECT/BOARD/board_info.php?id=".htmlspecialchars($row['id'])."'>".$title."</a>&nbsp;&nbsp;<img src='/PROJECT/lock.png' alt='비밀글' title='비밀글' width='15px' height='15px'></th>";
                                        else
                                            echo "<th class='b_title'><a href='/PROJECT/BOARD/board_secret_screen.php?id=".htmlspecialchars($row['id'])."'>".$title."</a>&nbsp;&nbsp;<img src='/PROJECT/lock.png' alt='비밀글' title='비밀글' width='15px' height='15px'></th>";
                                    }
                                }else{
                                    // 비밀글 여부
                                    if($row['w_pwd']==NULL){
                                        echo "<th class='b_title'><a href='/PROJECT/BOARD/board_info.php?id=".htmlspecialchars($row['id'])."'>".$title."&nbsp;[".$cmt_cnt."]"."</a></th>";
                                    }else{
                                        if(($_SESSION['user_id']==='tpfvmdkdlel') || ($_SESSION['user_id']===$row['user_id'])) // 관리자와 글쓴이는 비밀글 열람 가능
                                            echo "<th class='b_title'><a href='/PROJECT/BOARD/board_info.php?id=".htmlspecialchars($row['id'])."'>".$title."&nbsp;[".$cmt_cnt."]"."</a>&nbsp;&nbsp;<img src='/PROJECT/lock.png' alt='비밀글' title='비밀글' width='15px' height='15px'></th>";
                                        else
                                            echo "<th class='b_title'><a href='/PROJECT/BOARD/board_secret_screen.php?id=".htmlspecialchars($row['id'])."'>".$title."&nbsp;[".$cmt_cnt."]"."</a>&nbsp;&nbsp;<img src='/PROJECT/lock.png' alt='비밀글' title='비밀글' width='15px' height='15px'></th>";
                                    }
                                }

                                echo "<th class='user_name'>".htmlspecialchars($row['user_name'])."</th>";
                                echo "<th class='w_date'>".htmlspecialchars(substr($row['created'],0,10))."</th>";
                                echo "<th class='b_hit'>".htmlspecialchars($row['hit'])."</th>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </table>
                <br/>
                <button type="button" name="write" onclick="location.href='/PROJECT/BOARD/board_write.php'"><strong>글쓰기</strong></button>
                <div class="paging">
                    <?= $paging ?>
                </div>
                <!--게시판 내용 검색 처리 부분 -->
                <form action="/PROJECT/BOARD/board_search.php" name="board_search" method="get">
                    <input type="hidden" name="page" value="1">
                    <div class="search">
                        <select name="b_search_select">
                            <option value="title">제 목</option>
                            <option value="content">내 용</option>
                            <option value="user_name">작성자</option>
                        </select>
                        <input type="text" name="b_search_text">&nbsp;<input type="button" name="search_btn" value="검색" onclick="search_process();">
                    </div>

                </form>
            </div>
        </div>
<?php } ?>
    </body>
    <script type="text/javascript">
        function search_process(){
            var bs = eval("document.board_search");
            if(!bs.b_search_text.value){
                alert("검색어를 입력해주세요!");
                return;
            }
            else{
                bs.submit();
            }
        }
    </script>
</html>
