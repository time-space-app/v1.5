<?php
session_start();
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL);
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
<?php include $_SERVER['DOCUMENT_ROOT']."/time-space/board/auth.php"; ?>
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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <META HTTP-EQUIV="Content-Language" CONTENT="ja">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="재팬익스플로어:일본여행,일본온천,일본알프스 안내,재팬익스플로러">
    <meta name="author" content="Japan-Explore">
    <meta name="keywords" content="Japan-Explore, 일본여행, 일본온천, 일본관광, 재팬익스플로어, 재팬 익스플로어, 재팬익스플로러, 재팬 익스플로러">
<?php
//echo $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(?i)msie [10]/',$_SERVER['HTTP_USER_AGENT']))
{
    // if IE = 10 but 1-9 version replace }else if{... [1-9]
   echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >'; //rest of your code
}
?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--[if IE]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js”></script>
<![endif]-->
<!--[if lte IE 8]>
 <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
 <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<![endif]-->
<!--[if IE 9]>
 <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js”></script>
 <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<![endif]-->
<!--[if gte IE 9]>
 <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
<![endif]-->
<!--[if !IE]> -->
 <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
<!-- <![endif]-->
<script src="/metro/js/ajax_functions.js"></script>
<script type="text/javascript">
var myReq = getXMLHTTPRequest();
</script>
<link href="/time-space/skin/one/design/favicon.ico" rel="shortcut icon" type="image/ico" />
    <link href="/metro/css/metro-bootstrap.css" rel="stylesheet">
    <link href="/metro/css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="/metro/css/docs.css" rel="stylesheet">
    <link href="/metro/js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="/metro/js/jquery/jquery.min.js"></script>
    <script src="/metro/js/jquery/jquery.widget.min.js"></script>
    <script src="/metro/js/jquery/jquery.mousewheel.js"></script>
    <script src="/metro/js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="/metro/js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="/metro/js/docs.js"></script>

    <title>Time-Space:웹 CMS툴</title>

    <style>
        ol.styled {
            counter-reset:li;
            margin-left:0;
            padding-left:0;
        }
        ol.styled > li {
            position:relative;
            margin:0 0 6px 2em;
            padding:4px 8px;
            list-style:none;
        }
        ol.styled > li:before {
            content:counter(li);
            counter-increment:li;
            position:absolute;
            top:-2px;
            left:-2em;
            box-sizing:border-box;
            width:2em;
            margin-right:8px;
            padding:4px;
            border-top:2px solid #666;
            color:#fff;
            background:#666;
            font-weight:bold;
            font-family:Arial, sans-serif;
            text-align:center;
        }
    </style>
<script type="text/javascript">
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
<?php if($BOARD_ID=="notice" || $BOARD_ID=="community" || preg_match('/stay-/',$BOARD_ID)) { ?>
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<?php } ?>
</head>
<body class="metro" style="background-color: #efeae3">
    <header class="bg-dark" data-load="/metro/topmenu.php"></header>
