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
<?php
//Board 공통변수 항상 페이지 상단에 위치
$SEQ= $_REQUEST['SEQ'];
$L_CODE= $_REQUEST['L_CODE'];
$M_CODE= $_REQUEST['M_CODE'];
$S_CODE= $_REQUEST['S_CODE'];
if($L_CODE=="")$L_CODE="000";
if($M_CODE=="")$M_CODE="000";
if($S_CODE=="")$S_CODE="000";
$CATEGORY= $_REQUEST['CATEGORY'];
$MODE= $_REQUEST['MODE'];
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
<?php
if($CATEGORY == "0"){ 
	if($MODE=='EDIT'){$proc_file = "SELECT SEQ, L_CODE, L_NAME, L_URL FROM $T_L_MENU WHERE SEQ = $SEQ AND L_CODE='$L_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);}
?>
<!-- 대메뉴 시작 -->
<div id="wrap">
<header id="board_list_header">
	<h2>LARGE MENU NAME <?php if($MODE=="ADD"){ echo "ADD"; }else{ echo "EDIT"; }?>
	<?php if($MODE=="EDIT"){?> [Auto Add Menu code: /MENU_CODE/<?php echo $L_CODE.$M_CODE.$S_CODE?> ](External File Only!)<?php }?>
	</h2>
</header>
<span class="br10"></span>
<form method="post" name="frm" id="frm" action="write_ok.php">
<div class="board_write_table">
     <table summary="" class="write_table">
      <caption></caption>
       <colgroup>
        <col style="width:100px;" />
        <col />
       </colgroup>
       <tbody>
		<tr>
			<th width="18%">LARGE MENU NAME</th>
			<td><input type="text" class="type-text" name="L_NAME" ID="L_NAME" value="<?php echo $ROW['L_NAME']?>" size="20"></td>
		</tr>
		<tr>
			<th width="18%">URL</th>
			<td><input type="text" class="type-text" name="L_URL" ID="L_URL" value="<?php echo $ROW['L_URL']?>" size="100" style="width:500px">
			</td>
		</tr>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php"><span class="button">CANCEL</span></a>	
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
	<input type="hidden" value="<?php echo $CATEGORY?>" name="CATEGORY" id="CATEGORY">
	<input type="hidden" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="hidden" value="<?php echo $SEQ?>" name="SEQ" id="SEQ">
	<input type="hidden" value="<?php echo $L_CODE?>" name="L_CODE" id="L_CODE">
</form>
</div>
<!-- 대메뉴 끝-->
<?php
}else if($CATEGORY == "1"){
	if($MODE=='EDIT'){$proc_file = "SELECT SEQ, M_CODE, M_NAME, M_URL FROM $T_M_MENU WHERE SEQ = $SEQ AND L_CODE='$L_CODE' AND M_CODE='$M_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);}
	$proc_file = "SELECT L_NAME FROM $T_L_MENU WHERE L_CODE = $L_CODE";
	$ROW2 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>
<!-- 중메뉴 시작 -->
<div id="wrap">
<header id="board_list_header">
	<h2>MIDDLE MENU NAME <?php if($MODE=="ADD"){ echo "ADD"; }else{ echo "EDIT"; }?>
	<?php if($MODE=="EDIT"){?> [Auto Add Menu code: /MENU_CODE/<?php echo $L_CODE.$M_CODE.$S_CODE?> ](External File Only!)<?php }?>
	</h2>
</header>
<span class="br10"></span>
<form method="post" name="frm" id="frm" action="write_ok.php">
<div class="board_write_table">
     <table summary="" class="write_table">
      <caption></caption>
       <colgroup>
        <col style="width:100px;" />
        <col />
       </colgroup>
       <tbody>
		<tr>
			<th width="18%">LARGE MENU CODE</th>
			<td><?php echo $L_CODE?></td>
		</tr>
		<tr>
			<th width="18%">LARGE MENU NAME</th>
			<td><?php echo $ROW2['L_NAME']?></td>
		</tr>
		<tr>
			<th width="18%">MIDDLE MENU NAME</th>
			<td><input type="text" class="type-text" name="M_NAME" ID="M_NAME" value="<?php echo $ROW['M_NAME']?>" size="20"></td>
		</tr>
		<tr>
			<th width="18%">URL</th>
			<td><input type="text" class="type-text" name="M_URL" ID="M_URL" value="<?php echo $ROW['M_URL']?>" size="100" style="width:500px">
			</td>
		</tr>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php"><span class="button">CANCEL</span></a>	
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
	<input type="hidden" value="<?php echo $CATEGORY?>" name="CATEGORY" id="CATEGORY">
	<input type="hidden" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="hidden" value="<?php echo $SEQ?>" name="SEQ" id="SEQ">
	<input type="hidden" value="<?php echo $L_CODE?>" name="L_CODE" id="L_CODE">
	<input type="hidden" value="<?php echo $ROW['M_CODE']?>" name="M_CODE" id="M_CODE">
</form>
</div>
<!-- 중메뉴 끝-->
<?php
}else if( $CATEGORY == "2"){ 
	if($MODE=='EDIT'){$proc_file = "SELECT SEQ, S_CODE, S_NAME, S_URL FROM $T_S_MENU WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);}
	$proc_file = "SELECT L_NAME FROM $T_L_MENU WHERE L_CODE = '$L_CODE'";
	$ROW2 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$proc_file = "SELECT M_NAME FROM $T_M_MENU WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
	$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>
<!-- 소메뉴 시작 -->
<div id="wrap">
<header id="board_list_header">
	<h2>SMALL MENU NAME <?php if($MODE=="ADD"){ echo "ADD"; }else{ echo "EDIT"; }?>
	<?php if($MODE=="EDIT"){?> [Auto Add Menu code: /MENU_CODE/<?php echo $L_CODE.$M_CODE.$S_CODE?> ](External File Only!)<?php }?>
	</h2>
</header>
<span class="br10"></span>
<form method="post" name="frm" id="frm" action="write_ok.php">
<div class="board_write_table">
     <table summary="" class="write_table">
      <caption></caption>
       <colgroup>
        <col style="width:100px;" />
        <col />
       </colgroup>
       <tbody>
		<tr>
			<th width="18%">LARGE MENU CODE</th>
			<td><?php echo $L_CODE?></td>
		</tr>
		<tr>
			<th width="18%">LARGE MENU NAME</th>
			<td><?php echo $ROW2['L_NAME']?></td>
		</tr>
		<tr>
			<th width="18%">MIDDLE MENU CODE</th>
			<td><?php echo $M_CODE?></td>
		</tr>
		<tr>
			<th width="18%">MIDDLE MENU NAME</th>
			<td><?php echo $ROW3['M_NAME']?></td>
		</tr>
		<tr>
			<th width="18%">SMALL MENU NAME</th>
			<td><input type="text" class="type-text" name="S_NAME" ID="S_NAME" value="<?php echo $ROW['S_NAME']?>" size="20"></td>
		</tr>
		<tr>
			<th width="18%">URL</th>
			<td><input type="text" class="type-text" name="S_URL" ID="S_URL" value="<?php echo $ROW['S_URL']?>" size="100" style="width:500px">
			</td>
		</tr>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php"><span class="button">CANCEL</span></a>	
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
	<input type="hidden" value="<?php echo $CATEGORY?>" name="CATEGORY" id="CATEGORY">
	<input type="hidden" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="hidden" value="<?php echo $SEQ?>" name="SEQ" id="SEQ">
	<input type="hidden" value="<?php echo $L_CODE?>" name="L_CODE" id="L_CODE">
	<input type="hidden" value="<?php echo ($M_CODE=='')?$ROW['M_CODE']:$M_CODE?>" name="M_CODE" id="M_CODE">
	<input type="hidden" value="<?php echo $ROW['S_CODE']?>" name="S_CODE" id="S_CODE">
</form>
</div>
<!-- 소메뉴 끝-->
<?php } ?>
</body>
</html>