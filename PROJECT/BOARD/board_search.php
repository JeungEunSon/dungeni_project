<?php
    include("../session.php");
    include("../connect.php");

    if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_pwd'])){
        include("../login_yn.php");
    }else{

    $s_gubun = mysqli_escape_string($con,$_GET['b_search_select']);
    $s_content = mysqli_escape_string($con,$_GET['b_search_text']);

    // 페이징처리
    //페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(!empty($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

    if($s_gubun === 'title'){
        $sql = "SELECT count(*) as cnt FROM board WHERE title like '%".$s_content."%' order by id desc";
    }else if($s_gubun === 'content'){
        $sql = "SELECT count(*) as cnt FROM board WHERE content like '%".$s_content."%' order by id desc";
    }else if($s_gubun === 'user_name'){
        $sql = "SELECT count(*) as cnt FROM board WHERE user_name like '%".$s_content."%' order by id desc";
    }

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
        $paging .= "<li class ='page page_start'><a href='/PROJECT/BOARD/board_search.php?page=1&b_search_select=$s_gubun&b_search_text=$s_content'>처음</a></li>";
    }
    // 첫 섹션이 아니라면 이전 버튼을 생성
    if($currentSection != 1){
        $pageing .= "<li class='page page_prev'><a href='/PROJECT/BOARD/board_search.php?page=".$prevPage."&b_search_select=$s_gubun&b_search_text=$s_content>이전</a></li>";
    }

    for($i=$firstPage; $i<=$lastPage; $i++){
        if($i == $page){
            $paging .= "<li class ='page current'>".$i."</li>";
        } else {
            $paging .= "<li class ='page'><a href='/PROJECT/BOARD/board_search.php?page=".$i."&b_search_select=$s_gubun&b_search_text=$s_content'>".$i."</a></li>";
        }
    }

    // 마지막 섹션이 아니라면 다음 버튼 생성
    if($currentSection != $allSection){
        $paging .= "<li class='page page_next'><a href='/PROJECT/BOARD/board_search.php?page=".$nextPage."&b_search_select=$s_gubun&b_search_text=$s_content'>다음</a></li>";
    }

    // 마지막 페이지가 아니라면 끝 버튼을 생성
    if($page != $allPage){
        $paging .= "<li class='page page_end'><a href='/PROJECT/BOARD/board_search.php?page=".$allPage."&b_search_select=$s_gubun&b_search_text=$s_content'>끝</a></li>";
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
            .search{text-align: right; margin-top:-27px;}
            .paging{display: inline-block;  margin-top:-35px; margin-left: 150px; }
            li{float:left; list-style:none; margin:4px;}
            tr,th,td{font-size: 13px; border-bottom: 1px solid grey;}
            h2{text-align:left;}
            table{border-top: 2px solid black;}
            a{text-decoration: none;}
        </style>
    </head>
    <body>
        <div id="center">
            <div id="center2">
                <table cellpadding=15 cellspacing=0 >
                    <caption><h2><a href="/PROJECT/BOARD/board.php">자유게시판</a></h2></caption>
                    <tr>
                        <th class="b_num">번호</th><th id="b_title">제목</th><th class="user_name">작성자</th><th class="w_date">작성일</th><th class="b_hit">조회수</th>
                    </tr>
                    <tr>
                        <th colspan="5">입력하신&nbsp;&nbsp;'<?=$s_content?>'&nbsp;에 대한 검색결과입니다.</th>
                    </tr>
                    <?php
                        $currentLimit = ($onePage * $page)  - $onePage; // 몇번쨰의 글부터 가져오는지
                        $sqlLimit = " limit ".$currentLimit.",".$onePage; // limit sql 구문

                        if($s_gubun === 'title'){
                            $sql = "SELECT * FROM board WHERE title like '%".$s_content."%' ORDER BY id desc".$sqlLimit;
                        }else if($s_gubun === 'content'){
                            $sql = "SELECT * FROM board WHERE content like '%".$s_content."%' ORDER BY id desc".$sqlLimit;
                        }else if($s_gubun === 'user_name'){
                            $sql = "SELECT * FROM board WHERE user_name like '%".$s_content."%' ORDER BY id desc".$sqlLimit;
                        }

                        $result = $con->query($sql);

                        if($result->num_rows==0){
                            echo "<tr>";
                            echo "<td colspan='5' style='text-align:center;'><strong>등록된 글이 없습니다.</strong></td>";
                            echo "</tr>";
                        }
                        else if($result->num_rows!=0){
                            while($row = mysqli_fetch_assoc($result)){
                                // 글 제목이 길 경우에는 말줄임표로 대체
                                if(strlen($row["title"]) > 60){
                                    $title  = mb_strcut($row["title"], 0, 60, 'utf-8');
                                    $title .= "...";
                                }else{
                                    $title = $row["title"];
                                }

                                echo "<tr>";
                                echo "<th class='b_num'>".htmlspecialchars($row['id'])."</th>";
                                echo "<th class='b_title'><a href='/PROJECT/BOARD/board_info.php?id=".htmlspecialchars($row['id'])."'>".$title."</a></th>";
                                echo "<th class='user_name'>".htmlspecialchars($row['user_name'])."</th>";
                                echo "<th class='w_date'>".htmlspecialchars(substr($row['created'],0,10))."</th>";
                                echo "<th class='b_hit'>".htmlspecialchars($row['hit'])."</th>";
                                echo "</tr>";
                            }
                        }
                    ?>
                </table>
                <br/>
                <input type="button" name="write" value="글쓰기" onclick="location.href='/PROJECT/BOARD/board_write.php'">
                <div class="paging">
                    <?= $paging ?>
                </div>
                <!--게시판 내용 검색 처리 부분 -->
                <form action="/PROJECT/BOARD/board_search.php" name="board_search" method="get">
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
