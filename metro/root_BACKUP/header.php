<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/time-space/board/auth.php"; ?>
<?php
$userid = $_SESSION['valid_user'];
//===========================
	$proc_file = "SELECT LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL";
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
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <META HTTP-EQUIV="Content-Language" CONTENT="ja">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Time-Space css framework">
    <meta name="author" content="Time-Space">
    <meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
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

    <title>Time-Space:Website Makeup+Computer Repair</title>

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
		if (frm.LOGIN_ID.value.length == 0) {
		    errorMessage = "Please input the ID.";
		    objFocus = frm.LOGIN_ID;
		   }
		<?php if($MODE == "write"){?>
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
<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] < 3) { ?>
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<?php } ?>
</head>
<body class="metro" style="background-color: #efeae3">
    <header class="bg-dark" data-load="/metro/header.html"></header>