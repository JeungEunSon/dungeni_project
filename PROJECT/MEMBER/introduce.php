<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <title>덩으니나라 소개</title>
        <style media="screen">
            @import url(http://fonts.googleapis.com/earlyaccess/nanumgothic.css);
            *{font-family: 'Nanum Gothic', serif;}
            .title{font-size: 18px; font-weight:bolder;}
            table{border-top: 2px solid black; width:800px;}
            tr,th,td{font-size: 16px; border-bottom: 1px solid grey;}
            body { margin-left: 0px; margin-top: 0px; margin-right: 0px; margin-bottom: 0px; }
            #center { position:absolute; top:50%; left:50%; overflow:hidden; margin-top:-400px; margin-left:-400px;}
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
            <table cellpadding=15 cellspacing=0>
                <caption>
                    <h2>덩으니나라 소개</h2>
                </caption>
                <tr>
                    <th colspan="2">덩으니나라는 특별한 주제를 가지고 구현된 웹사이트가 아닌 , <br/>
                                    기능 구현 목적을 위해 구현된 웹사이트입니다. 아직 한참 부족하지만 많은 관심과 양해 부탁드립니다.</th>
                </tr>
                <tr>
                    <th colspan="2" >
                        <br/>
                        <div class="title">1. 회원가입 및 개인정보 수정기능</div><br/>
                        회원가입 후 개인정보 수정을 통해 자유로이 정보를 수정 할 수 있습니다.<br/>
                        <br/>
                    </th>
                </tr>
                <tr>
                    <th colspan="2" >
                        <br/>
                        <div class="title">2. 회원정보 찾기기능</div><br/>
                        정보가 기억나지 않을경우 아이디 및 패스워드 정보를 개인정보를 가입하실때 적어주셨던 <br/>
                        이메일 주소를 통해 보내드립니다. 패스워드는 임시비밀번호로 생성되어 전송됩니다. <br/>
                        <br/>
                    </th>
                </tr>
                <tr>
                    <th colspan="2" >
                        <br/>
                        <div class="title">3. POS프로그램 기능</div><br/>
                        덩으니나라에서 구현된 POS프로그램을 통해 선택한 상품을 구매하고 환불처리 할 수 있습니다.<br/>
                        여건상 바코드입력이 아닌 키보드로 입력값을 받아 진행합니다. <br/>
                        <br/>
                    </th>
                </tr>
                <tr>
                    <th colspan="2" >
                        <br/>
                        <div class="title">4. 게시판 기능</div><br/>
                        글쓰기 및 수정 , 댓글, 파일 업로드, 기능을 사용 할 수 있습니다.<br/>
                        비밀글 체크시 해당 글은 관리자와 본인만 확인 할 수 있습니다. <br/>
                        <br/>
                    </th>
                </tr>
                <tr >
                    <td scope="row" colspan="2" style="border-bottom:none;">
                        <center><button type="button" name="back" onclick="location.href='/PROJECT/MEMBER/membership.php'">되돌아가기</button></center><br/>
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
