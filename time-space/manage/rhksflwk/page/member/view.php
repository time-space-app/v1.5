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
<?php //입력값 바인딩
//Board 공통변수 항상 페이지 상단에 위치
$GUBN = $_REQUEST['GUBN'];
$SEARCH = $_REQUEST['SEARCH'];
$MODE = $_REQUEST['MODE'];
$LOGIN_ID = $_REQUEST['LOGIN_ID'];
$now_page = $_REQUEST['now_page'];
//============================
//정보 가져오기 쿼리정리
	$SQL = "SELECT LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,AGREE_YN,EMAIL_YN";
	$SQL .= " ,DATE_FORMAT(CREATE_DT, '%Y-%m-%d') AS CREATE_DT";
	$SQL .= " ,DATE_FORMAT(UPDATE_DT, '%Y-%m-%d') AS UPDATE_DT";
	$SQL .= " FROM T_MEMBER";
	$SQL .= " WHERE LOGIN_ID = '$LOGIN_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	//바인딩변수값 정의
	$LOGIN_ID = $ROW['LOGIN_ID'];
	$USER_NM = $ROW['USER_NM'];
	$USER_LEVEL = $ROW['USER_LEVEL'];
	$CREATE_DT =  $ROW['CREATE_DT'];
	$UPDATE_DT = $ROW['UPDATE_DT'];
	$USE_YN = $ROW['USE_YN'];
	$USER_EMAIL = $ROW['USER_EMAIL'];
	$AGREE_YN= $ROW['AGREE_YN'];
	$EMAIL_YN= $ROW['EMAIL_YN'];
?>
<?php
	//변수 처리
	switch ($USER_LEVEL) { //notice, qa, repair, form, faq
		case '1'  : $USER_LEVEL='admin';break;
		case '2' : $USER_LEVEL='staff';break;
		default   : break;
	}
	//변수 처리
	switch ($USE_YN) { //notice, qa, repair, form, faq
		case 'Y'  : $USE_YN='USE';break;
		case 'N' : $USE_YN='STOP';break;
		default   : break;
	}
?>
﻿<!DOCTYPE html>
<html lang="auto">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ja">
<meta name="product" content="Metro UI CSS Framework">
<meta name="description" content="Time-Space css framework">
<meta name="author" content="Time-Space">
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<script type="text/javascript">
     function del_chk()
     {
		frm = document.del_frm;
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "delete"; 
        	frm.submit();
            return true;
	     } else {
	    	 frm.MODE.value = ""; 
	        return false;
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
<!-- 테이블 시작 -->
<div class="board_write_table">
     <table summary="" class="write_table">
      <caption></caption>
       <colgroup>
           <col width="10%" />
	   <col width="30%" />
	   <col width="10%" />
	   <col width="30%" />
	   <col width="10%" />
	   <col width="10%" />
       </colgroup>
       <tbody>
            <tr>
		<th>LOGIN_ID</th>
		<td><?php echo $LOGIN_ID?></td>
		<th>USER_NM</th>
		<td><?php echo $USER_NM?></td>
		<th>USER_LEVEL</th>
		<td><?php echo $USER_LEVEL?></td>
	</tr>
	<tr>
		<th>USER_EMAIL</th>
		<td><?php echo $USER_EMAIL?></td>
		<th>EMAIL_YN</th>
		<td><?php echo $EMAIL_YN?></td>
		<th>USE_YN</th>
		<td><?php echo $USE_YN?></td>
	</tr>
	</tbody>
   </table>
</div>
<!-- 테이블 종료 -->
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&MODE=list'">
	<span class="button">LIST</span></a>
	<?php if($_SESSION['valid_level']=="1"){ //최고관리자일경우?>
	<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk();" />
	<a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&MODE=edit&LOGIN_ID=<?php echo $LOGIN_ID?>" >
		<span class="button">EDIT</span>
	</a>
	<?php }?>
</div>
<div style="display:none">
	<form method="post" name="del_frm" id="del_frm" action="write_ok.php" >
	<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="text" value="<?php echo $LOGIN_ID?>" name="LOGIN_ID" id="LOGIN_ID">
	<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
	<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
	<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
</div>
</form>
</div>
</body>
</html>