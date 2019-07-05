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
<script type="text/javascript">
 function del_chk(frm)
 {
	if (confirm('Are you sure you want to delete?') == true) {
	frm.submit();
	return true;
	} else {
	return false;
	}
 }
</script>
<title>Time-Space HTML5</title>
</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Menu Manager</h2>
</header>
<!-- 테이블 시작 -->
<div class="board_list_table">

<form name="form" action="write_ok.php" method="post">
<table class="list_table">
	<thead>
	<tr>
		<th style="width:50px"> LARGE MENU ADD </th>
		<th style="width:80%">
			LARGE MENU NAME : <input type="text" class="type-text" name="L_NAME" ID="L_NAME" value="" size="20">
			URL : <input type="text" class="type-text" name="L_URL" ID="L_URL" value="" size="100" style="width:260px;">
			<input type="hidden" name="MODE" id="MODE" value="ADD" />
			<input type="hidden" name="CATEGORY" id="CATEGORY" value="0" />
		</th>
		<th>
		<!-- 등록버튼 시작 -->
		<div id="board_list_button_table">
			<input type="SUBMIT" value="+L_ADD" name="SUBMIT" class="type-btn">
		</div>
		</th>
	</tr>
	</thead>
</table>
</form>
<!--리스트시작-->
<table class="list_table">
	<caption>MENU ADD</caption>
        <colgroup>
	   <col />
	   <col width="10%" />
	   <col width="10%" />
	   <col width="10%" />
	   <col width="10%" />
	   <col width="10%" />
	  </colgroup>
        <thead>
	<tr>
		<th>MENU NAME</th>
		<th style="text-align:right;">ORDER</th>
		<th style="text-align:right;padding-right:30px">+MENU</th>
		<th style="text-align:right;padding-right:30px">USE_YN</th>
		<th style="text-align:right;padding-right:30px">PAGE</th>
		<th style="text-align:right;padding-right:30px">DEL</th>
	</tr>
	</thead>
	<tbody>
	<?php
		//셀렉트 
		$SQL .= " SELECT DISTINCT A.CATEGORY ";
		$SQL .= "     , A.SUN ";
		$SQL .= "     , A.SEQ ";
		$SQL .= "     , A.L_CODE ";
		$SQL .= "     , A.M_CODE ";
		$SQL .= "     , A.S_CODE ";
		$SQL .= "     , (CASE IFNULL(B.MENUCD,'000000') WHEN '000000' THEN CONCAT(A.L_CODE,A.M_CODE,A.S_CODE) ELSE B.MENUCD END) AS MENUCD ";
		$SQL .= "     , (CASE IFNULL(B.SUNCD,'00') WHEN '00' THEN CONCAT(A.SUN,'00') ELSE B.SUNCD END) AS SUNCD ";
		$SQL .= "     , A.L_NAME ";
		$SQL .= "     , A.M_NAME ";
		$SQL .= "     , A.S_NAME ";
		$SQL .= "     , A.USE_YN ";
		$SQL .= "     , A.L_URL,A.M_URL,A.S_URL ";
		$SQL .= " FROM ( ";
		$SQL .= "     SELECT '0' AS CATEGORY ";
		$SQL .= "         , SUN ";
		$SQL .= "         , SEQ ";
		$SQL .= "         , L_CODE ";
		$SQL .= "         , '000' AS M_CODE ";
		$SQL .= "         , '000' AS S_CODE ";
		$SQL .= "         , L_NAME ";
		$SQL .= "         , '' AS M_NAME ";
		$SQL .= "         , '' AS S_NAME ";
		$SQL .= "         , USE_YN ";
		$SQL .= "     , L_URL,'' AS M_URL,'' AS S_URL ";
		$SQL .= "     FROM $T_L_MENU ";
		$SQL .= " ) A LEFT OUTER JOIN ";
		$SQL .= " ( ";
		$SQL .= "     SELECT ";
		$SQL .= "         (CASE IFNULL(Z.S_CODE,0) WHEN 0 THEN (CASE IFNULL(Z.M_CODE,0) WHEN 0 THEN 0 ELSE 1 END) ELSE 2 END) AS CATEGORY ";
		$SQL .= "         , Z.L_CODE ";
		$SQL .= "         , Z.M_CODE ";
		$SQL .= "         , Z.S_CODE ";
		$SQL .= "         , Z.MENUCD ";
		$SQL .= "         , Z.SUNCD ";
		$SQL .= "         , Z.L_SUN ";
		$SQL .= "         , Z.L_NAME ";
		$SQL .= "         , Z.M_SUN ";
		$SQL .= "         , Z.M_NAME ";
		$SQL .= "         , Z.S_SUN ";
		$SQL .= "         , Z.S_NAME ";
		$SQL .= "     FROM ( ";
		$SQL .= "         SELECT ";
		$SQL .= "              A.L_CODE ";
		$SQL .= "             , IFNULL(B.M_CODE,'000') AS M_CODE ";
		$SQL .= "             , IFNULL(C.S_CODE,'000') AS S_CODE ";
		$SQL .= "             , CONCAT(A.L_CODE,IFNULL(B.M_CODE,'000'),IFNULL(C.S_CODE,'000')) AS MENUCD ";
		$SQL .= "             , CONCAT(IFNULL(A.SUN,0),IFNULL(B.SUN,0),IFNULL(C.SUN,0)) AS SUNCD ";
		$SQL .= "             , A.SUN AS L_SUN ";
		$SQL .= "             , A.L_NAME ";
		$SQL .= "             , B.SUN AS M_SUN ";
		$SQL .= "             , B.M_NAME ";
		$SQL .= "             , C.SUN AS S_SUN ";
		$SQL .= "             , C.S_NAME ";
		$SQL .= "         FROM ";
		$SQL .= "         $T_L_MENU A ";
		$SQL .= "         LEFT OUTER JOIN $T_M_MENU B ON A.L_CODE = B.L_CODE ";
		$SQL .= "         LEFT OUTER JOIN $T_S_MENU C ON B.L_CODE = C.L_CODE AND B.M_CODE = C.M_CODE ";
		$SQL .= "         ) Z ";
		$SQL .= "     ORDER BY Z.SUNCD ASC ";
		$SQL .= " ) B ON A.L_CODE = B.L_CODE AND A.M_CODE = B.M_CODE ";
		
		$SQL .= " UNION ALL ";
		$SQL .= " SELECT DISTINCT A.CATEGORY ";
		$SQL .= "     , A.SUN ";
		$SQL .= "     , A.SEQ ";
		$SQL .= "     , A.L_CODE ";
		$SQL .= "     , A.M_CODE ";
		$SQL .= "     , A.S_CODE ";
		$SQL .= "     , (CASE IFNULL(B.MENUCD,'000000') WHEN '000000' THEN CONCAT(A.L_CODE,A.M_CODE,A.S_CODE) ELSE (CASE A.CATEGORY WHEN '1' THEN CONCAT(A.L_CODE,A.M_CODE,A.S_CODE) ELSE B.MENUCD END) END) AS MENUCD ";
		$SQL .= "     , (CASE IFNULL(B.SUNCD,'00') WHEN '00' THEN CONCAT((SELECT SUN FROM $T_L_MENU WHERE L_CODE=A.L_CODE),A.SUN,'0') ELSE (CASE A.CATEGORY WHEN '1' THEN CONCAT(SUBSTR(B.SUNCD,1,1),A.SUN,'0') ELSE B.SUNCD END) END) AS SUNCD ";
		$SQL .= "     , A.L_NAME ";
		$SQL .= "     , A.M_NAME ";
		$SQL .= "     , A.S_NAME ";
		$SQL .= "     , A.USE_YN ";
		$SQL .= "     , A.L_URL,A.M_URL,A.S_URL ";
		$SQL .= " FROM ( ";
		$SQL .= "     SELECT '1' AS CATEGORY ";
		$SQL .= "         , SUN ";
		$SQL .= "         , SEQ ";
		$SQL .= "         , L_CODE ";
		$SQL .= "         , M_CODE ";
		$SQL .= "         , '000' AS S_CODE ";
		$SQL .= "         , '' AS L_NAME ";
		$SQL .= "         , M_NAME ";
		$SQL .= "         , '' AS S_NAME ";
		$SQL .= "         , USE_YN ";
		$SQL .= "     , '' AS L_URL,M_URL,'' AS S_URL ";
		$SQL .= "     FROM $T_M_MENU ";
		$SQL .= " ) A LEFT OUTER JOIN ";
		$SQL .= " ( ";
		$SQL .= "     SELECT ";
		$SQL .= "         (CASE IFNULL(Z.S_CODE,0) WHEN 0 THEN (CASE IFNULL(Z.M_CODE,0) WHEN 0 THEN 0 ELSE 1 END) ELSE 2 END) AS CATEGORY ";
		$SQL .= "         , Z.L_CODE ";
		$SQL .= "         , Z.M_CODE ";
		$SQL .= "         , Z.S_CODE ";
		$SQL .= "         , Z.MENUCD ";
		$SQL .= "         , Z.SUNCD ";
		$SQL .= "         , Z.L_SUN ";
		$SQL .= "         , Z.L_NAME ";
		$SQL .= "         , Z.M_SUN ";
		$SQL .= "         , Z.M_NAME ";
		$SQL .= "         , Z.S_SUN ";
		$SQL .= "         , Z.S_NAME ";
		$SQL .= "     FROM ( ";
		$SQL .= "         SELECT ";
		$SQL .= "              A.L_CODE ";
		$SQL .= "             , IFNULL(B.M_CODE,'000') AS M_CODE ";
		$SQL .= "             , IFNULL(C.S_CODE,'000') AS S_CODE ";
		$SQL .= "             , CONCAT(A.L_CODE,IFNULL(B.M_CODE,'000'),IFNULL(C.S_CODE,'000')) AS MENUCD ";
		$SQL .= "             , CONCAT(IFNULL(A.SUN,0),IFNULL(B.SUN,0),IFNULL(C.SUN,0)) AS SUNCD ";
		$SQL .= "             , A.SUN AS L_SUN ";
		$SQL .= "             , A.L_NAME ";
		$SQL .= "             , B.SUN AS M_SUN ";
		$SQL .= "             , B.M_NAME ";
		$SQL .= "             , C.SUN AS S_SUN ";
		$SQL .= "             , C.S_NAME ";
		$SQL .= "         FROM ";
		$SQL .= "         $T_L_MENU A ";
		$SQL .= "         LEFT OUTER JOIN $T_M_MENU B ON A.L_CODE = B.L_CODE ";
		$SQL .= "         INNER JOIN $T_S_MENU C ON B.L_CODE = C.L_CODE AND B.M_CODE = C.M_CODE ";
		$SQL .= "         ) Z ";
		$SQL .= "     ORDER BY Z.SUNCD ASC ";
		$SQL .= " ) B ON A.L_CODE = B.L_CODE AND A.M_CODE = B.M_CODE ";
		
		$SQL .= " UNION ALL ";
		$SQL .= " SELECT DISTINCT A.CATEGORY ";
		$SQL .= "     , A.SUN ";
		$SQL .= "     , A.SEQ ";
		$SQL .= "     , A.L_CODE ";
		$SQL .= "     , A.M_CODE ";
		$SQL .= "     , A.S_CODE ";
		$SQL .= "     , (CASE IFNULL(B.MENUCD,'000000') WHEN '000000' THEN CONCAT(A.L_CODE,A.M_CODE,A.S_CODE) ELSE B.MENUCD END) AS MENUCD ";
		$SQL .= "     , (CASE IFNULL(B.SUNCD,'00') WHEN '00' THEN CONCAT(A.SUN,'00') ELSE B.SUNCD END) AS SUNCD ";
		$SQL .= "     , A.L_NAME ";
		$SQL .= "     , A.M_NAME ";
		$SQL .= "     , A.S_NAME ";
		$SQL .= "     , A.USE_YN ";
		$SQL .= "     , A.L_URL,A.M_URL,A.S_URL ";
		$SQL .= " FROM ( ";
		$SQL .= "     SELECT '2' AS CATEGORY ";
		$SQL .= "         , SUN ";
		$SQL .= "         , SEQ ";
		$SQL .= "         , L_CODE ";
		$SQL .= "         , M_CODE ";
		$SQL .= "         , S_CODE ";
		$SQL .= "         , '' AS L_NAME ";
		$SQL .= "         , '' AS M_NAME ";
		$SQL .= "         , S_NAME ";
		$SQL .= "         , USE_YN ";
		$SQL .= "     , '' AS L_URL,'' AS M_URL,S_URL ";
		$SQL .= "     FROM $T_S_MENU ";
		$SQL .= " ) A LEFT OUTER JOIN ";
		$SQL .= " ( ";
		$SQL .= "     SELECT ";
		$SQL .= "         (CASE IFNULL(Z.S_CODE,0) WHEN 0 THEN (CASE IFNULL(Z.M_CODE,0) WHEN 0 THEN 0 ELSE 1 END) ELSE 2 END) AS CATEGORY ";
		$SQL .= "         , Z.L_CODE ";
		$SQL .= "         , Z.M_CODE ";
		$SQL .= "         , Z.S_CODE ";
		$SQL .= "         , Z.MENUCD ";
		$SQL .= "         , Z.SUNCD ";
		$SQL .= "         , Z.L_SUN ";
		$SQL .= "         , Z.L_NAME ";
		$SQL .= "         , Z.M_SUN ";
		$SQL .= "         , Z.M_NAME ";
		$SQL .= "         , Z.S_SUN ";
		$SQL .= "         , Z.S_NAME ";
		$SQL .= "     FROM ( ";
		$SQL .= "         SELECT ";
		$SQL .= "              A.L_CODE ";
		$SQL .= "             , IFNULL(B.M_CODE,'000') AS M_CODE ";
		$SQL .= "             , IFNULL(C.S_CODE,'000') AS S_CODE ";
		$SQL .= "             , CONCAT(A.L_CODE,IFNULL(B.M_CODE,'000'),IFNULL(C.S_CODE,'000')) AS MENUCD ";
		$SQL .= "             , CONCAT(IFNULL(A.SUN,0),IFNULL(B.SUN,0),IFNULL(C.SUN,0)) AS SUNCD ";
		$SQL .= "             , A.SUN AS L_SUN ";
		$SQL .= "             , A.L_NAME ";
		$SQL .= "             , B.SUN AS M_SUN ";
		$SQL .= "             , B.M_NAME ";
		$SQL .= "             , C.SUN AS S_SUN ";
		$SQL .= "             , C.S_NAME ";
		$SQL .= "         FROM ";
		$SQL .= "         $T_L_MENU A ";
		$SQL .= "         LEFT OUTER JOIN $T_M_MENU B ON A.L_CODE = B.L_CODE ";
		$SQL .= "         LEFT OUTER JOIN $T_S_MENU C ON B.L_CODE = C.L_CODE AND B.M_CODE = C.M_CODE ";
		$SQL .= "         ) Z ";
		$SQL .= "     ORDER BY Z.SUNCD ASC ";
		$SQL .= " ) B ON A.L_CODE = B.L_CODE AND A.M_CODE = B.M_CODE AND A.S_CODE = B.S_CODE ";
		$SQL .= " ORDER BY SUNCD ASC";
		//ECHO $SQL;//디버그
		$result = $GPLdb5->GPLexcute_query($SQL);
		$i=0;
		?>
		<tr><th colspan="6" style="background-color:#787878;text-align:center;font-weight:bold;height:30px;color:#fff">TOTAL MENU: <?php echo mysql_num_rows($result);?> ea</th></tr>
		<?php
		if($result){
			while($row = mysqli_fetch_array($result)) {
	?>
		<tr>
		<td style="text-align:left;"><!-- 메뉴수정 --><?php if(strlen($row[SUNCD])>3)echo"주)대중소별10개까지 가능";?>
			<?php if($row[CATEGORY] == "0"){ ?>
				&nbsp;◆ <a href="write.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&CATEGORY=<?php echo $row[CATEGORY]?>&MODE=EDIT"><?php echo $row[L_NAME]?>
				<span style="float:right">Link:[<?php echo $row['L_URL']?>]</span></a>
			<?php }else if($row[CATEGORY] == "1"){ ?>
				&nbsp;&nbsp;&nbsp;&nbsp;┠▶ <a href="write.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&M_CODE=<?php echo $row['M_CODE']?>&CATEGORY=<?php echo $row[CATEGORY]?>&MODE=EDIT"><?php echo $row[M_NAME]?>
				<span style="float:right">Link:[<?php echo $row['M_URL']?>]</span></a>
			<?php }else if( $row[CATEGORY] == "2"){ ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;└▶▶ <a href="write.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&M_CODE=<?php echo $row['M_CODE']?>&S_CODE=<?php echo $row['S_CODE']?>&CATEGORY=<?php echo $row[CATEGORY]?>&MODE=EDIT"><?php echo $row[S_NAME]?>
				<span style="float:right">Link:[<?php echo $row['S_URL']?>]</span></a>
			<?php } ?>
		</td>
		<td><!-- 메뉴위치변경 -->
			<?php
			//대메뉴,중메뉴,소메뉴별 최대,최소 순서구하기
			if ($row[CATEGORY] == "0") {
				$SQL2 = "SELECT MAX(SUN) AS MAX_SUN, MIN(SUN) AS MIN_SUN FROM $T_L_MENU";
			}else if ($row[CATEGORY] == "1") {
				$SQL2 = "SELECT MAX(SUN) AS MAX_SUN, MIN(SUN) AS MIN_SUN FROM $T_M_MENU WHERE L_CODE = '$row[L_CODE]'";
			}else if ($row[CATEGORY] == "2") {
				$SQL2 = "SELECT MAX(SUN) AS MAX_SUN, MIN(SUN) AS MIN_SUN FROM $T_S_MENU WHERE L_CODE = '$row[L_CODE]' AND M_CODE = '$row[M_CODE]'";
			}
			$row2 = $GPLdb5->GPLquery_fetch_assoc_one($SQL2);
			//ECHO $row2['MAX_SUN']; //디버그
			?>
			<form method="post" name="upfrm" id="upfrm" action="list_ok.php" style="float:right;padding-right:10px;">
			<?php if ($row2['MIN_SUN'] == $row['SUN']){	?>
			<input type="button" value="▲" name="UP" class="type-btn" onclick="alert('It is impossible to top');return false;">
			<?php	}else{ ?>
			<input type="hidden" name="SEQ" id="SEQ" value="<?php echo $row['SEQ']?>" />
			<input type="hidden" name="CATEGORY" id="CATEGORY" value="<?php echo $row['CATEGORY']?>" />
			<input type="hidden" name="L_CODE" id="L_CODE" value="<?php echo $row['L_CODE']?>" />
			<input type="hidden" name="M_CODE" id="M_CODE" value="<?php echo $row['M_CODE']?>" />
			<input type="hidden" name="S_CODE" id="S_CODE" value="<?php echo $row['S_CODE']?>" />
			<input type="hidden" name="MODE" id="MODE" value="MOVE_UP" />
			<input type="SUBMIT" value="▲" name="UP" class="type-btn">
			<?php	}	?>
			</form>
			<form method="post" name="downfrm" id="downfrm" action="list_ok.php" style="float:right;">
			<?php if ($row2['MAX_SUN'] == $row['SUN']){	?>
			<input type="button" value="▼" name="DOWN" class="type-btn" onclick="alert('It is impossible to bottom');return false;">
			<?php	}else{ ?>
			<input type="hidden" name="SEQ" id="SEQ" value="<?php echo $row['SEQ']?>" />
			<input type="hidden" name="CATEGORY" id="CATEGORY" value="<?php echo $row['CATEGORY']?>" />
			<input type="hidden" name="L_CODE" id="L_CODE" value="<?php echo $row['L_CODE']?>" />
			<input type="hidden" name="M_CODE" id="M_CODE" value="<?php echo $row['M_CODE']?>" />
			<input type="hidden" name="S_CODE" id="S_CODE" value="<?php echo $row['S_CODE']?>" />
			<input type="hidden" name="MODE" id="MODE" value="MOVE_DOWN" />
			<input type="SUBMIT" value="▼" name="DOWN" class="type-btn">
			<?php	}	?>
			</form>
		</td>
		<td><!-- 중,소메뉴 신규추가 -->
			<div id="board_list_button_table" style="padding:0px;margin:0px;">
			<?php if($row[CATEGORY]=="0"){?>
			<a href="write.php?L_CODE=<?php echo $row['L_CODE']?>&L_NAME=<?php echo $row[L_NAME]?>&CATEGORY=1&MODE=ADD"><span class="button" style="height:10px;padding:5px 5px 10px 5px;background-color:skyblue;">+M_ADD</span>
			<?php }else if($row[CATEGORY]=="1"){?>
			<a href="write.php?L_CODE=<?php echo $row['L_CODE']?>&M_CODE=<?php echo $row['M_CODE']?>&M_NAME=<?php echo $row[M_NAME]?>&CATEGORY=2&MODE=ADD"><span class="button" style="height:10px;padding:5px 5px 10px 5px;background-color:orange;">+S_ADD</span>
			<?php }else{}?>
			</a>
			</div>
		</td>
		<td><!-- 메뉴사용유무 -->
		<?php if ($row[USE_YN]=="") {	$row[USE_YN] = "Y";} ?>
		<?php if($row[CATEGORY] == "0"){ 
			$TABLE_NM = "$T_L_MENU";
			}else if($row[CATEGORY] == "1"){
			$TABLE_NM = "$T_M_MENU";
		 	}else if( $row[CATEGORY] == "2"){ 
			$TABLE_NM = "$T_S_MENU";
		} ?>
			<form method="post" name="used" id="used" action="list_ok.php">
			<input type="hidden" name="SEQ" id="SEQ" value="<?php echo $row['SEQ']?>" />
			<input type="hidden" name="CATEGORY" id="CATEGORY" value="<?php echo $row['CATEGORY']?>" />
			<input type="hidden" name="TABLE_NM" id="TABLE_NM" value="<?php echo $TABLE_NM?>" />
			<?php if($row[USE_YN]=="Y"){?>
			<input type="hidden" name="USE_YN" id="USE_YN" value="N" />
			<input type="hidden" name="MODE" id="MODE" value="M_USED" />			
			<?php }else{?>
			<input type="hidden" name="USE_YN" id="USE_YN" value="Y" />
			<input type="hidden" name="MODE" id="MODE" value="M_STOP" />
			<?php }?>
			<div id="board_list_button_table" style="margin:0px;padding:0px;">
			<input type="SUBMIT" value="<?php echo $row['USE_YN']?>" name="SUBMIT" class="type-btn" style="height:27px;">
			</div>
			</form>		
		</td>
		<td><!-- 페이지생성 -->
		<?php if($row[CATEGORY] == "0"){ 
			if(is_numeric($row['L_URL'])){
				$linkurl="cms_view";$BUTTONSTYLE = "background-color:skyblue;";
			}else{
				$linkurl="cms_write";$BUTTONSTYLE = "background-color:skyblue;";
			}
			(STRTOLOWER(SUBSTR($row['L_URL'],0,7))=="http://")?$HIDDEN = "display:none;":$HIDDEN = "";
		}else if($row[CATEGORY] == "1"){
			if(is_numeric($row['M_URL'])){
				$linkurl="cms_view";$BUTTONSTYLE = "";
			}else{
				$linkurl="cms_write";$BUTTONSTYLE = "";
			}
			(STRTOLOWER(SUBSTR($row['M_URL'],0,7))=="http://")?$HIDDEN = "display:none;":$HIDDEN = "";
		 }else if( $row[CATEGORY] == "2"){ 
			if(is_numeric($row['S_URL'])){
				$linkurl="cms_view";$BUTTONSTYLE = "background-color:yellow;";
			}else{
				$linkurl="cms_write";$BUTTONSTYLE = "background-color:yellow;";
			}
			(STRTOLOWER(SUBSTR($row['S_URL'],0,7))=="http://")?$HIDDEN = "display:none;":$HIDDEN = "";
		} ?>
			<div id="board_list_button_table" style="padding:0px;margin:0px;">
			<?php if($row[CATEGORY]=="0"){?>
			<a href="<?php echo $linkurl?>.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&L_NAME=<?php echo $row[L_NAME]?>&M_CODE=000&S_CODE=000&MODE=<?php echo $linkurl?>&CATEGORY=0">
			<?php }else if($row[CATEGORY]=="1"){?>
			<a href="<?php echo $linkurl?>.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&M_CODE=<?php echo $row['M_CODE']?>&M_NAME=<?php echo $row[M_NAME]?>&S_CODE=000&MODE=<?php echo $linkurl?>&CATEGORY=1">
			<?php }else if( $row[CATEGORY] == "2"){?>
			<a href="<?php echo $linkurl?>.php?SEQ=<?php echo $row['SEQ']?>&L_CODE=<?php echo $row['L_CODE']?>&M_CODE=<?php echo $row['M_CODE']?>&S_CODE=<?php echo $row['S_CODE']?>&S_NAME=<?php echo $row[S_NAME]?>&MODE=<?php echo $linkurl?>&CATEGORY=2">
			<?php } ?>
			<span class="button" style="height:10px;padding:5px 5px 10px 5px;<?php echo $HIDDEN?><?php echo $BUTTONSTYLE?>"><?php echo $linkurl?></span>
			</a>
			</div>
		</td>
		<td><!-- 메뉴삭제 -->
		<?php if($row[CATEGORY] == "0"){ 
			$DEL_MODE = "L_DEL";
			}else if($row[CATEGORY] == "1"){
			$DEL_MODE = "M_DEL";
		 	}else if( $row[CATEGORY] == "2"){ 
			$DEL_MODE = "S_DEL";
		} ?>
		<form method="post" name="frm" id="frm" action="list_ok.php">
		<input type="hidden" name="SEQ" id="SEQ" value="<?php echo $row['SEQ']?>" />
		<input type="hidden" name="L_CODE" id="L_CODE" value="<?php echo $row['L_CODE']?>" />
		<input type="hidden" name="M_CODE" id="M_CODE" value="<?php echo $row['M_CODE']?>" />
		<input type="hidden" name="S_CODE" id="S_CODE" value="<?php echo $row['S_CODE']?>" />
		<input type="hidden" name="MODE" id="MODE" value="<?php echo $DEL_MODE?>" />
		<div id="board_list_button_table" style="margin:0px;padding:0px;">
		<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);" style="height:27px;">
		</div>
		</form>
		</td>
		</tr>
		<?php
				$i++;
				}
		  }
		?>
	<?php if($i==0){?>
	<tr><td colspan="6">NONE DATA</td></tr>
	<?php }else{ ?>
	<tr><th colspan="6" style="background-color:#787878;text-align:center;font-weight:bold;height:30px;color:#fff">TOTAL MENU: <?php echo $i?> ea</th></tr>
	<?php } ?>
	</tbody>
</table>
<!--리스트끝-->

</div>
<!-- 테이블 종료 -->

</div>
</body>
</html>