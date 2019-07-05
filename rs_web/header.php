<!DOCTYPE html>
<!--[if IE 6]><html class="no-js old ie6"><![endif]-->
<!--[if IE 7]><html class="no-js old ie7"><![endif]-->
<!--[if IE 8]><html class="no-js old ie8"><![endif]-->
<!--[if IE 9]><html class="no-js modern ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html class="no-js modern"><!--<![endif]-->
<!--html class=no-js... 기능 브라우저의 버전에 따라 html에 태그에 각기 다른 클래스를 할당함. 작업자가 CSS에서 사용-->
<head>
<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php //검색엔진최적화를 위한 URl쿼리 특수문자 / 문자로 대체 후 변수 뽑기 작업
if(strpos( $_SERVER['REQUEST_URI'] , "MENU_CODE/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "MENU_CODE" ));
$_REQUEST['MENU_CODE']=$arr_param[1];//echo $MENU_CODE.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "BOARD_ID/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "BOARD_ID" ));
$_REQUEST['BOARD_ID']=str_replace(" ","",$arr_param[1]);//echo $BOARD_ID.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "SEQ/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "SEQ" ));
$_REQUEST['SEQ']=str_replace(" ","",$arr_param[1]);//echo $SEQ.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "now_page/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "now_page" ));
$_REQUEST['now_page']=str_replace(" ","",$arr_param[1]);//echo $now_page.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "GUBN/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "GUBN" ));
$_REQUEST['GUBN']=str_replace(" ","",$arr_param[1]);//echo $GUBN.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "SEARCH/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "SEARCH" ));
$_REQUEST['SEARCH']=urldecode(str_replace(" ","",$arr_param[1]));//echo $SEARCH.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "MODE/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "MODE" ));
$_REQUEST['MODE']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "CATEGORY/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "CATEGORY" ));
$_REQUEST['CATEGORY']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "COMMENT_MODE/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "COMMENT_MODE" ));
$_REQUEST['COMMENT_MODE']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
?>
<?php include $_SERVER[DOCUMENT_ROOT]."/time-space/board/auth.php"; ?>
<?php
$userid = $_SESSION['valid_user'];
//===========================
	$proc_file = "SELECT LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,AGREE_YN,EMAIL_YN";
	$proc_file .= " FROM T_MEMBER";
	$proc_file .= " WHERE LOGIN_ID = '$userid'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$EMAIL=$ROW['USER_EMAIL'];
	$arremail = explode("@",$EMAIL);
?>
<?php /*자동등록방지코드*/
$se_num1 = mt_rand(1, 9);
$se_num2 = mt_rand(1, 9);
?>
<?php
//CMS메뉴시스템 공용변수값
$T_L_MENU = "T_L_MENU";
$T_M_MENU = "T_M_MENU";
$T_S_MENU = "T_S_MENU";
$T_CMS = "T_CMS";
?>
<?php //메뉴값 바인딩
//게시판 공통변수 항상 페이지 상단에 위치
$MENU_CODE= str_replace(" ","",$_REQUEST['MENU_CODE']);
$L_CODE= SUBSTR($MENU_CODE,0,3);
$M_CODE= SUBSTR($MENU_CODE,3,3);
$S_CODE= SUBSTR($MENU_CODE,6,3);
//대메뉴정보
	$proc_file = "SELECT L_NAME AS MENU_TITLE";
	$proc_file .= " FROM T_L_MENU WHERE L_CODE = '$L_CODE'";
	$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>
<link href="/time-space/skin/one/design/favicon.ico" rel="shortcut icon" type="image/ico" />

<meta charset="utf-8" />
<title>반응형 웹 - Responsible Web + Time-Space</title>
<meta name="description" content="Time-Space css framework, 타임스페이스" />
<meta name="author" content="Time-Space, 타임스페이스" />
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui, 타임스페이스" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" href="/rs_web/include/css/style.css" /><!-- html 기본구조에대한 CSS처리 및 반응형 CSS 프레임웍 로드 -->
<link rel="stylesheet" href="/rs_web/include/css/sub.css" /><!-- 서브페이지 CSS처리 -->
<script src="/rs_web/include/js/libs/modernizr.min.js"></script><!-- 사용중인 브라우저가 HTML5의 특정 기능을 지원하는지 감지 true false 반환-->
<link rel="stylesheet" href="//code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css"><!-- 제이쿼리 UI에 연동하는 CSS 로드 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script><!-- 제이쿼리 프레임웍 로드 -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script><!--  jQuery를 기본 뷰를 표현하는 다양한 컴포넌트, 위젯을 모아놓은=예 달력위젯등을 모아 놓은 것 -->
<script src="/rs_web/include/js/jquery.scrolledFix.js"></script><!-- 스크롤 시, 특정영역을 넘어가면 내비게이션이 고정하게 하는 함수.-->
<script src="/rs_web/include/js/script.js"></script><!-- 사용자 지정 자바스크립트 코드 -->
<script src="/rs_web/include/js/libs/respond.min.js"></script><!-- IE 구 버전에서 미디어쿼리 가능하게하는 자바스크립트 코드 -->
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" /><![endif]--><!-- 호환성 보기모드이면서 크롬프레임웍상태로 화면 표시-->
<script src="/metro/js/ajax_functions.js"></script>
<script type="text/javascript">
var myReq = getXMLHTTPRequest();
</script>
<script type="text/javascript">
	function setMessage(arg) {
		//var mainFrame = document.getElementById('textMessageFromApp');
		//var createFrame = document.createElement("div");
		//createFrame.innerHTML = arg;
		//mainFrame.appendChild(createFrame);
		alert("자바스크립트 연동 샘플: 모바일 -> 웹 함수호출" + arg);
	}
	function submitForm(frm)
	{
		var errorMessage = null;
		var objFocus = null;
		if (frm.AGREE_YN.checked == false) {
		    errorMessage = "Please input the 이용약관동의.";
		    objFocus = frm.AGREE_YN;
		   }
		else if (frm.LOGIN_ID.value.length == 0) {
		    errorMessage = "Please input the ID.";
		    objFocus = frm.LOGIN_ID;
		   }
		<?php if($_SESSION['valid_user'] == ""){?>
		else if (frm.LOGIN_PWD.value.length == 0) {
		    errorMessage = "Please input the PASSWORD.";
		    objFocus = frm.LOGIN_PWD;
		   }
		<?php }?>
		else if (frm.USER_LEVEL.value.length == 0) {
		    errorMessage = "Please input the LEVEL.";
		    objFocus = frm.USER_LEVEL;
		   }
		else if (frm.USER_NM.value.length == 0) {
		    errorMessage = "Please input the NAME.";
		    objFocus = frm.USER_NM;
		   }
		else if (frm.EMAIL_YN.checked == false) {
		    errorMessage = "Please input the 수신동의.";
		    objFocus = frm.EMAIL_YN;
		   }
		else if (frm.EMAIL0.value.length == 0) {
		    errorMessage = "Please input the EMAIL.";
		    objFocus = frm.EMAIL0;
		   }
		else if (frm.EMAIL1.value.length == 0) {
		    errorMessage = "Please input the EMAIL.";
		    objFocus = frm.EMAIL1;
		   }
		if(errorMessage != null) {
		    alert(errorMessage);
		    objFocus.focus();
		    return false;
		   }
	}
	function selectmail() {
		var mail = document.getElementById('DDLEMAIL');
		var txt = document.getElementById('EMAIL1');
		if (mail == "") {
		txt.focus();
		txt.value = "";
		} else {
		txt.value= mail.value;
		}
	}
	function del_chk()
        {
		frm = document.del_frm;
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "delete"; 
        	frm.FILE_DEL0.value = 'FILE_DEL0';
    		frm.FILE_DEL1.value = 'FILE_DEL1';
        	frm.submit();
            return true;
	     } else {
	    	 frm.MODE.value = ""; 
	         frm.FILE_DEL0.value = '';
	    	 frm.FILE_DEL1.value = '';
	        return false;
	     }
        }
        function del_chk_new()
        {
		frm = document.del_frm;
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "delete"; 
        	frm.FILE_DEL0.value = 'FILE_DEL0';
    		frm.FILE_DEL1.value = 'FILE_DEL1';
        	frm.submit();
            return true;
	     } else {
	    	 frm.MODE.value = ""; 
	         frm.FILE_DEL0.value = '';
	    	 frm.FILE_DEL1.value = '';
	        return false;
	     }
        }
        function del_chk(frm)
        {
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "delete"; 
        	frm.FILE_DEL0.value = 'FILE_DEL0';
    		frm.FILE_DEL1.value = 'FILE_DEL1';
        	frm.submit();
            return true;
	     } else {
	    	 frm.MODE.value = ""; 
	         frm.FILE_DEL0.value = '';
	    	 frm.FILE_DEL1.value = '';
	        return false;
	     }
        }
        function submitFormComment(frm){    
        var errorMessage = null;
        var objFocus = null;
        if (frm.USER_NM.value.length == 0) {
            errorMessage = "Please input the name.";
            objFocus = frm.USER_NM;
           }
        else if (frm.COMMENTS.value.length == 0) {
            errorMessage = "Please input the comment.";
            objFocus = frm.COMMENTS;
           }
        if(errorMessage != null) {
            alert(errorMessage);
            objFocus.focus();
            return false;
           }
        }

     function submitFormWrite(frm)
      {
        var errorMessage = null;
        var objFocus = null;
        if (frm.TITLE.value.length == 0) {
            errorMessage = "Please input the title.";
            objFocus = frm.TITLE;
           }
        else if (frm.CONTENT.value.length == 0) {
            errorMessage = "Please input the content.";
            objFocus = frm.CONTENT;
           }
        if(errorMessage != null) {
            alert(errorMessage);
            objFocus.focus();
            return false;
           }
      }
     function file_del(num)
      {
	if(num==0)frm.FILE_DEL0.value = 'FILE_DEL0';
	if(num==1)frm.FILE_DEL1.value = 'FILE_DEL1';
    	 frm.submit();
      }
</script>
</head>
<body lang="ko-KR">

<header>
   <div class="row"><!--반응형CSS-DIV감싸주기추가-->
	<a href="/"><h1 id="brand">Time-Space.biz</h1></a>
	<nav id="gnb">
		<a href="#contents" class="blind">skip navigation</a>
		<ul class="clearfix"><!--반응형CSS-클래스만추가-->
			<li on><a title="Posts" href="/rs_web/board/list.html/BOARD_ID/notice/MENU_CODE/003001000" style="display:block">Posts</a></li>
			<li><a title="Work Request" href="/metro/page/canvas.html/MENU_CODE/002001000" style="display:block">하이브리드앱</a></li>
			<li><a title="WordPress" href="/wordpress/?page_id=24" style="display:block">WordPress</a></li>			
			<?php if($_SESSION['valid_user'] != "") { ?>
				<?php if($_SESSION['valid_level'] < 3) { ?>
				<li><a title="Intranet" href="/time-space/index.php" target="_new" style="display:block">Admin</a></li>
				<?php } ?>
		        <li><a title="LogOut" href="/rs_web/board/logout.php" style="display:block">LogOut</a></li>
		        <li><a title="Mypage" href="/rs_web/board/join.html" style="display:block">Mypage</a></li>
		        <?php }else{ ?>
		        <li><a title="Join" href="/rs_web/board/join.html" style="display:block">Join</a></li>
		        <li><a title="Login" href="/rs_web/board/login.html" style="display:block">Login</a></li>
		        <?php } ?>
		</ul>
	</nav>
   </div>
</header>

<div id="header-bar">
   <div class="row clearfix"><!--반응형CSS-DIV감싸주기추가-->
	<p>
		<a href="javascript:;" id="phone_menu" class="menu_swap">
			<img src="/rs_web/include/images/header-bar-logo.png" alt="Logo" width="36" height="36" />
		</a> 
		방문해 주셔서 감사드립니다.
	</p>
   </div>
</div>
<section id="contents" class="row"><!--반응형CSS-클래스만추가-->