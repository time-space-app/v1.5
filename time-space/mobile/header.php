<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL ^ E_DEPRECATED );
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
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="height=device-height,width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no;" />

	<title>Time-Space Web Service</title>
	<link rel="stylesheet" type="text/css" href="/time-space/mobile/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/time-space/mobile/css/style.css">

	<script type="text/javascript">
	window.addEventListener("load", function() {
		setTimeout(loaded, 100);
	}, false);
	window.addEventListener("orientationchange", function() {
		setTimeout(loaded, 100);
	}, false);
	function loaded() {
		window.scrollTo(0, 1);
	}
	</script>
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
<div id="wrap">
<header>
	<h1><a href="/time-space/mobile/" title="" tabindex="-1"><span>Time-Space.biz</span></a></h1>
	<!--로그인영역시작-->
	<div id="login">
	<?php if($_SESSION['valid_user'] != "") { ?>
		<form name="form_logout" id="form_logout" action="" autocomplete="on" method="post">
		<span id="icon-id"><label data-icon="u" for="id">ID </label></span>
		<span class="type-text">WELCOME<br><?php echo $_SESSION['valid_user'];?></span>
		<a href="/time-space/mobile/board/logout.php"><span class="button">Log Out</span></a>
		<a href="/time-space/mobile/board/join.html"><span class="button">Mypage</span></a>
		</form>
	<?php }else{ ?>
		<form name="form_login" id="form_login" action="" autocomplete="on" method="post">
		<span id="icon-id"><label data-icon="u" for="id">ID </label></span>
		<input id="id" name="id" placeholder="User Id" required="required" type="text" class="type-text" tabindex="1" />
		<button type="submit" class="type-submit">Login</button>
		<div class="clear5"></div>
		<span id="icon-pass"><label data-icon="p" for="password">Password </label></span>
		<input id="pw" name="pw" placeholder="User Password" required="required" type="password" class="type-text" tabindex="2" />
		<a href="/time-space/mobile/board/join.html"><span class="button">New Id</span></a>
		</form>
	<?php } ?>
	</div>
</header>
<div class="clear5"></div>
