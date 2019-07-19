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
//CMS메뉴시스템 공용변수값
$T_L_MENU = "T_L_MENU";
$T_M_MENU = "T_M_MENU";
$T_S_MENU = "T_S_MENU";
$T_CMS = "T_CMS";
?>
<?php //입력값 바인딩
//Board 공통변수 항상 페이지 상단에 위치
$SEQ= $_REQUEST['SEQ'];
$L_CODE= $_REQUEST['L_CODE'];
$M_CODE= $_REQUEST['M_CODE'];
$S_CODE= $_REQUEST['S_CODE'];
$L_NAME= $_REQUEST['L_NAME'];
$M_NAME= $_REQUEST['M_NAME'];
$S_NAME= $_REQUEST['S_NAME'];
$MODE= $_REQUEST['MODE'];
$CATEGORY= $_REQUEST['CATEGORY'];
//조회카운터+1
	$proc_edit = "UPDATE $T_CMS SET";
	$proc_edit .=" READCOUNT = IFNULL(READCOUNT,0) + 1";
	$proc_edit .=" WHERE";
	$proc_edit .=" L_CODE= '$L_CODE'AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
//============================
//정보 가져오기 쿼리정리
	$proc_file = "SELECT L_CODE,M_CODE,S_CODE,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE,READCOUNT";
	$proc_file .= " FROM $T_CMS";
	$proc_file .= " WHERE L_CODE='$L_CODE' AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	if(empty($ROW['USER_ID'])) $MODE = "cms_write"; else $MODE = "cms_edit";
?>
<!DOCTYPE html>
<html lang="auto">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ja">
<meta name="product" content="Metro UI CSS Framework">
<meta name="description" content="Time-Space css framework">
<meta name="author" content="Time-Space">
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<link href="/_metro/css/metro-bootstrap.css" rel="stylesheet">
<script src="/_metro/js/jquery/jquery.min.js"></script>
<script src="/_metro/js/jquery/jquery.widget.min.js"></script>
<script src="/_metro/js/metro.min.js"></script>

<link rel="stylesheet" href="/time-space/reset.css" type="text/css">
<link rel="stylesheet" href="/time-space/manage/rhksflwk/board/board.css" type="text/css">
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
<body class="metro">
<script type="text/javascript">
     function del_chk()
     {
	 frm = document.del_frm;
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.submit();
            return true;
	     } else {
	        return false;
	     }
     }
</script>
<div id="wrap">
	<header id="board_list_header">
		<h2><?php echo $TITLE?></h2>
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
				<th>MENU</th>
				<td><?php echo $ROW['TITLE']?></td>
				<th>REGDATE</th>
				<td><?php echo $ROW['REGDATE']?></td>
				<th>HITS</th>
				<td><?php echo $ROW['READCOUNT']?></td>
			</tr>
			</tbody>
		</table>
		<table summary="" class="write_table">
			<tbody>
			<tr>
				<td colspan="5">
				<!-- 등록버튼 시작 -->
				<div id="board_list_button_table" style="width:inherit;float:left;">
					<a href="list.php">
					<span class="button">LIST</span></a>
					<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk();" />
					<a href="cms_write.php?CATEGORY=<?php echo $CATEGORY?>&SEQ=<?php echo $SEQ?>&L_CODE=<?php echo $L_CODE?>&M_CODE=<?php echo $M_CODE?>&S_CODE=<?php echo $S_CODE?>&L_NAME=<?php echo $L_NAME?>&M_NAME=<?php echo $M_NAME?>&S_NAME=<?php echo $S_NAME?>&MODE=<?php echo $MODE?>">
					<span class="button">EDIT</span></a>
				</div>
				</td>
			</tr>
			<tr>
				<td colspan="6" class="contents">
					<pre style="font-size:15px;line-height:18px;"><?php echo str_replace("\r\n", "<br/>",$ROW['CONTENT']);?></pre>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
	<!-- 테이블 종료 -->
	<!-- 등록버튼 시작 -->
	<div id="board_list_button_table">
		<a href="list.php">
		<span class="button">LIST</span></a>
		<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk();" />
		<a href="cms_write.php?CATEGORY=<?php echo $CATEGORY?>&SEQ=<?php echo $SEQ?>&L_CODE=<?php echo $L_CODE?>&M_CODE=<?php echo $M_CODE?>&S_CODE=<?php echo $S_CODE?>&L_NAME=<?php echo $L_NAME?>&M_NAME=<?php echo $M_NAME?>&S_NAME=<?php echo $S_NAME?>&MODE=<?php echo $MODE?>">
		<span class="button">EDIT</span></a>
	</div>
	<div style="display:none">
	<form method="post" name="del_frm" id="del_frm" action="cms_write_ok.php" >
	<input type="text" value="cms_del" name="MODE" id="MODE">
	<input type="text" value="<?php echo $CATEGORY?>" name="CATEGORY" id="CATEGORY">
	<input type="text" value="<?php echo $SEQ?>" name="SEQ" id="SEQ">
	<input type="text" value="<?php echo $ROW['L_CODE']?>" name="L_CODE" id="L_CODE">
	<input type="text" value="<?php echo $ROW['M_CODE']?>" name="M_CODE" id="M_CODE">
	<input type="text" value="<?php echo $ROW['S_CODE']?>" name="S_CODE" id="S_CODE">
	</form>
	</div>
</div>
</body>
</html>