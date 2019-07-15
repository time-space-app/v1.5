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
$BOARD_SEQ = $_REQUEST['SEQ'];
$BOARD_ID = 'notice';
//정보 가져오기 쿼리정리
$SEQ = "";
$SQL = "SELECT";
$SQL .= " SEQ, TITLE, CONTENT, FILECNT,POPUP, POPUP_W, POPUP_H";
$SQL .= " FROM T_BOARD";
$SQL .= " WHERE SEQ='$BOARD_SEQ'";
$SQL .= " AND BOARD_ID='$BOARD_ID'";
$SQL .= " AND POPUP='on'";
$SQL .= " ORDER BY REGDATE";
$ROW = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	//바인딩변수값 정의
	$CONTENT = $ROW['CONTENT'];
	$TITLE = $ROW['TITLE'];
	$FILECNT = $ROW['FILECNT'];
	if ($FILECNT > 0)
	{
		$SQL = "SELECT";
				$SQL .= " SEQ,FILE_NM,FILE_SIZE,DOWN_CNT";
				$SQL .= " ,BOARD_SEQ,BOARD_ID";
				$SQL .= " FROM T_ATTACH_FILE";
				$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
				$SQL .= " ORDER BY SEQ ASC";
				$fileresult = $GPLdb5->GPLexcute_query($SQL);
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NOTICE_POPUP</title>
<style type="text/css">
<!--
body {
	padding:0;
	margin:0;
	font-size:12px;
	font-family:Dotum, verdana, sans-serif;
}
h1 {
	font-size:14px;
	color:#555555;
	text-align:center;
	padding:10px 0;
}
h1 span {
	color:#00aeef;
}
table {
	color:#555555;
	border:1px solid #d7d7d7;
	border-top:2px solid #444547;
	border-collapse:collapse;
}
td, th {
	padding:5px;
	line-height:18px;
}
th {
	background:#f2fbfe;
	text-align:right
}
a {
	color:#00aeef;
}
-->
</style>
</head>
<script type="text/javascript">
    <!--
        function setCookie(name, value, expiredays) {
            var todayDate = new Date();
            todayDate.setDate(todayDate.getDate() + expiredays);
            document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";"
        }
        function closeWin() {
            if (document.formpop.Notice.checked)
                setCookie("POP<?php echo $BOARD_SEQ?>", "done", 1); //1은 하루동안 쿠키보관, 테스트시 팝업을 새로 열려면 -5로 설정
            self.close();
        }
    // --> 
</script>
<body>
<form method="post" name="formpop" id="frm" >
	<h1><strong>TITLE :</strong> <span><?php echo $TITLE?> </span></h1>
	<table width="100%" border="" cellspacing="0" cellpadding="0" style="">
		<tr>
			<th width="70px">CONTENTS </th>
			<td><?php echo str_replace("\r\n", "",$CONTENT);?></td>
		</tr>
		<?php if ($FILECNT > 0){ ?>
		<tr>
			<th>DOWNLOAD </th>
			<td>
			<?php 
			if($fileresult){
					while($filerow = mysqli_fetch_array($fileresult)) {	
					?>
					<a href="/time-space/manage/core/function/download.php?filename=<?php echo $filerow['FILE_NM']?>&target=<?php echo $BOARD_ID?>"><?php echo $filerow['FILE_NM']?></a><br/>
				<?php } ?>
			<?php } ?>
			</td>
		</tr>
		<?php }?>
	</table>
	<br />
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="center" bgcolor="#454545" style="color:#ffffff;"><input type="checkbox" name="Notice" id="Notice" onclick="javascript:closeWin()">
				Open day not&nbsp;<a style="color:#FFF" href="#" onClick="javascript:closeWin();">[CLOSE]</a></td>
		</tr>
	</table>
</form>
</body>
</html>