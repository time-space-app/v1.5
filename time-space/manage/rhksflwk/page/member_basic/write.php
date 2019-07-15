<?php include_once $_SERVER['DOCUMENT_ROOT']."/time-space/manage/rhksflwk/auth_only.php" //관리자인증 ?>
<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php
//Board 공통변수 항상 페이지 상단에 위치
$GUBN = $_REQUEST['GUBN'];
$SEARCH = $_REQUEST['SEARCH'];
$MODE = $_REQUEST['MODE'];
$LOGIN_ID = $_REQUEST['LOGIN_ID'];
$now_page = $_REQUEST['now_page'];
//===========================
if($MODE == "edit"){ 
	$proc_file = "SELECT LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL";
	$proc_file .= " FROM T_MEMBER";
	$proc_file .= " WHERE LOGIN_ID = '$LOGIN_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$EMAIL=$ROW['USER_EMAIL'];
	$arremail = explode("@",$EMAIL);
}
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

<script type="text/javascript">
 function del_chk(frm)
 {
	if (confirm('Are you sure you want to delete?') == true) {
	frm.MODE.value = "delete"; 
	frm.submit();
	return true;
	} else {
	frm.MODE.value = ""; 
	return false;
	}
 }
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
</script>
<link rel="stylesheet" href="/time-space/reset.css" type="text/css">
<link rel="stylesheet" href="/time-space/board/board.css" type="text/css">
<link href="/time-space/skin/one/design/favicon.ico" rel="shortcut icon" type="image/ico" />
<script type="text/javascript" charset="utf-8" src="/time-space/mobile/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/time-space/js/common.js"></script>
<!--[if lt IE 9]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->
<title>Time-Space HTML5</title>
</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Member Manager</h2>
</header>
<span class="br10"></span>

<form method="post" name="frm" id="frm" action="write_ok.php" onsubmit="return submitForm(this)" enctype="multipart/form-data" >
<!-- 테이블 시작 -->
<div class="board_write_table">
     <table summary="" class="write_table">
      <caption></caption>
       <colgroup>
        <col style="width:100px;" />
        <col />
       </colgroup>
       <tbody>
		<tr>
			<th>LOGIN_ID</th>
			<td><input type="text" size="30"  name="LOGIN_ID" id="LOGIN_ID" value="<?php echo $ROW['LOGIN_ID']?>" /></td>
		</tr>
		<tr>
			<th width="18%">LOGIN_PWD</th>
			<td><input type="password" size="31"  name="LOGIN_PWD" id="LOGIN_PWD" value="" />
			<input type="hidden" size="30"  name="HIDDEN_PWD" id="HIDDEN_PWD" value="<?php echo $ROW['LOGIN_PWD']?>" /></td>
		</tr>
		<tr>
			<th>NAME</th>
			<td><input type="text" size="30"  name="USER_NM" id="USER_NM" value="<?php echo $ROW['USER_NM']?>" /></td>
		</tr>
		<tr>
			<th>LEVEL</th> 
			<td>
			<SELECT ID="USER_LEVEL" name='USER_LEVEL' size='1' style="width:100px">
			        <option value=''>-SELECT-</option>
			        <option value="1" <?php echo ($ROW['USER_LEVEL']=="1")?"SELECTED":"";?>>admin</option>
			        <option value="2" <?php echo ($ROW['USER_LEVEL']=="2")?"SELECTED":"";?>>staff</option>
			        <option value="9" <?php echo ($ROW['USER_LEVEL']=="9")?"SELECTED":"";?>>member</option>
			</SELECT>
			</td>
		</tr>
		<tr>
			<th>E-MAIL</th> 
			<td>
			<input type="text" ID="EMAIL0" NAME="EMAIL0" VALUE="<?php echo $arremail[0]?>" />@
			<input type="text" ID="EMAIL1" NAME="EMAIL1" VALUE="<?php echo $arremail[1]?>" />
			<SELECT ID="DDLEMAIL" name='DDLEMAIL' size='1' style="width:100px" onchange="selectmail()">
			        <option value=''>-SELECT-</option>
			        <option value="naver.com">naver.com</option>
			        <option value="nate.com">nate.com</option>
			        <option value="gmail.com">gmail.com</option>
			        <option value="hanmail.net">hanmail.net</option>
			        <option value="yahoo.co.kr">yahoo.co.kr</option>
			</SELECT>
			</td> 
		</tr>
		<tr>
			<th>USER_YN</th> 
			<td>
			<SELECT ID="USE_YN" name='USE_YN' size='1' style="width:100px">
			        <option value="Y" <?php echo ($ROW['USE_YN']=="Y")?"SELECTED":"";?>>USE</option>
			        <option value="N" <?php echo ($ROW['USE_YN']=="N")?"SELECTED":"";?>>STOP</option>
			</SELECT>
			</td> 
		</tr>
		<?php if($_SESSION['valid_user'] == "") { ?>
			<tr>
				<th>자동등록방지</th>
				<td><span style="color:#fff"><?php echo $se_num1." + ".$se_num2." = "?></span>
				<input type="text" size="10"  name="SE_NUM" id="SE_NUM" value="" />
				<input type="hidden" size="10"  name="SE_NUM1" id="SE_NUM1" value="<?php echo $se_num1?>" />
				<input type="hidden" size="10"  name="SE_NUM2" id="SE_NUM2" value="<?php echo $se_num2?>" />
				</td>
			</tr>
		<?php } ?>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&MODE=list"><span class="button">CANCEL</span></a>	
	<?php if($MODE=="edit"){?>
		<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);">
	<?php }?>
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
<div style="display:none">
	<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
	<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
	<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
</div>
</form>
</div>
<!--Board 끝-->
</body>
</html>