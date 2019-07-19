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
$BOARD_ID = $_REQUEST['BOARD_ID'];
$MODE = $_REQUEST['MODE'];
$BOARD_SEQ = $_REQUEST['SEQ'];
$now_page = $_REQUEST['now_page'];
//============================
//조회카운터+1
	$proc_edit = "UPDATE T_BOARD SET";
	$proc_edit .=" READCOUNT = IFNULL(READCOUNT,0) + 1";
	$proc_edit .=" WHERE SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
//정보 가져오기 쿼리정리
	$SQL = "SELECT CONTENT, EMAIL, TITLE, USER_NM, READCOUNT, FILECNT, USER_ID, STATE";
	$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
	$SQL .= " FROM T_BOARD";
	$SQL .= " WHERE SEQ = '$BOARD_SEQ'";
	$SQL .= " AND BOARD_ID = '$BOARD_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	$EMAIL=$ROW['EMAIL'];
	$arremail = explode("@",$EMAIL);
	//바인딩변수값 정의
	$CONTENT = $ROW['CONTENT'];
	$TITLE = $ROW['TITLE'];
	$NAME = $ROW['USER_NM'];
	$REGDATE =  $ROW['CREATE_DT'];
	$READCOUNT = $ROW['READCOUNT'];
	$FILECNT = $ROW['FILECNT'];
	$USER_ID = $ROW['USER_ID'];
	$STATE = $ROW['STATE'];
	if ($FILECNT > 0)
	{
		$SQL = "SELECT";
		$SQL .= " SEQ,FILE_NM,FILE_SIZE,DOWN_CNT";
		$SQL .= " ,BOARD_SEQ,BOARD_ID";
		$SQL .= " ,CREATE_DT,CREATE_ID,UPDATE_DT,UPDATE_ID";
		$SQL .= " FROM T_ATTACH_FILE";
		$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
		$SQL .= " ORDER BY SEQ ASC";
		$fileresult = $GPLdb5->GPLexcute_query($SQL);
	}
	//메뉴 변수
//메뉴 변수
	switch ($BOARD_ID) { //notice, qa, qa, pds, faq
		case 'notice'  : $body='1'; $title='NOTICE';break;
		case 'community' : $body='2'; $title='COMMUNITY';break;
		case 'qa'  : $body='3'; $title='Q/A';break;
		case 'faq'  : $body='4'; $title='FAQ';break;
		case 'pds'  : $body='5'; $title='PDS';break;
		case 'stay-sea'  : $body='6'; $title='粛　海風';break;
		case 'stay-mi'  : $body='7'; $title='ニューみやこ';break;
		case 'stay-ho'  : $body='8'; $title='呼帆壮';break;
		case 'stay-doo'  : $body='9'; $title='豆千待月';break;
		default   : $body='1'; $title='NOTICE';break;
	}
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
<body>
<script type="text/javascript">
     function del_chk()
     {
		var frm = document.getElementById('del_frm');
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
     function submitForm(frm)
     {
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
			<th>NAME</th>
			<td><?php echo $NAME?></td>
			<th>REGDATE</th>
			<td><?php echo $REGDATE?></td>
			<th>HITS</th>
			<td><?php echo $READCOUNT?></td>
		</tr>
		<?php if ($FILECNT > 0){ ?>
		<tr>
			<th>FILES</th>
			<td colspan="5">
				<?php 
				if($fileresult){
					while($filerow = mysqli_fetch_array($fileresult)) {	
					?>
					<a href="/time-space/manage/core/function/download.php?filename=<?php echo $filerow['FILE_NM']?>&target=<?php echo $BOARD_ID?>"><?php echo $filerow['FILE_NM']?></a><br/>
				<?php } ?>
				<?php } ?>
			</td>
		</tr>
		<tr>
		<?php } ?>
		<tr>
			<td colspan="6" class="contents">
				<?php //=str_replace("<br/>", "\r\n",$CONTENT);?>
				<?php
				//$CONTENT=str_replace('   ','',$CONTENT);
				//$CONTENT=str_replace("\t",'',$CONTENT);
				//$CONTENT=str_replace("<br/>",'',$CONTENT);
				//$CONTENT=str_replace("\r\n", "<br>",$CONTENT);
				echo $CONTENT;
				?>	
			</td>
		</tr>
		</tbody>
	    </table>
	</div>
	<!-- 테이블 종료 -->
	<!-- 등록버튼 시작 -->
	<div id="board_list_button_table">
		<a href="list.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=list'">
		<span class="button">LIST</span></a>
		<?php if($_SESSION['valid_level'] < 3 && $_SESSION['valid_level'] > 0) { ?>
		<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk();" />
		<a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=edit&SEQ=<?php echo $BOARD_SEQ?>">
		<span class="button">EDIT</span></a>
		<?php }else{ ?>
			<?php if($_SESSION['valid_user']==$USER_ID && $_SESSION['valid_name']==$NAME){ //본인이 쓴 글 수정삭제기능?>
			<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk();" />
			<a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=edit&SEQ=<?php echo $BOARD_SEQ?>">
			<span class="button">EDIT</span></a>
			<?php }?>
		<?php }?>
	</div>
	<!-- COMMENT START -->
	<?php if($BOARD_ID=="notice" || $BOARD_ID=="pds" || $BOARD_ID=="community" || preg_match('/stay-/',$BOARD_ID)){?>
	<?php }else{ ?>
	<!-- 코멘트 시작 -->
	<div id="comment_wrap">
	<header id="board_list_header">
		<h2>Comment Form</h2>
	</header>
	<span class="br10"></span>
	<div class="board_write_table">
	<?php 
		//코멘트셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,USER_ID,USER_NM,COMMENTS";
		$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
		$SQL .= " FROM T_BOARD_COMMENT";
		$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ'";
		$SQL .= " AND BOARD_ID = '$BOARD_ID'";
		$SQL .= " ORDER BY SEQ ASC";
		$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		$COMMENT_MODE = ($row)?"edit":"write";
		//$result = $GPLdb5->GPLexcute_query($SQL);
		if($row){
		//if($result){
		//	while($row = mysqli_fetch_array($result)) {
		?>
		<table summary="" class="write_table">
		      <caption></caption>
		       <colgroup>
		           <col width="20%" />
			   <col width="55%" />
			   <col width="20%" />
		       </colgroup>
		       <tbody>
			<tr>
			<th><?php echo $row['USER_NM']?></th>
			<td><?php echo $row['COMMENTS']?></td>
			<td><?php echo $row['CREATE_DT']?></td>
			<td><?php //if($_SESSION['valid_user']==$USER_ID && $_SESSION['valid_name']==$NAME){ //본인이 쓴 글 삭제기능?>
			<!-- <a href="write_ok.php?BOARD_SEQ=<?php echo $BOARD_SEQ?>&BOARD_ID=<?php echo $BOARD_ID?>&COMMENT_MODE=delete&SEQ=<?php echo $row['SEQ']?>">
			DEL</a> -->
			<?php //}?>
			</td>
			</tr>
			</tbody>
		</table>
		<?php //}?>
	   <?php //}?>
	</div>
	<?php }?>
	<?php if($_SESSION['valid_user'] != "") { ?>
	<!-- 테이블 시작 -->
	   <form method="post" name="frm" id="frm" action="write_ok.php" onsubmit="return submitForm(this)" enctype="multipart/form-data" >
	     <table summary="" class="comment_table">
	      <caption></caption>
	       <colgroup>
	           <col width="20%" />
		   <col width="55%" />
		   <col width="25%" />
	       </colgroup>
	       <tbody>
		<tr>
		<th>NAME</th>
		<th>COMMENT</th>
		<th></th>
		</tr>
		<tr>
		<td>
		<input type="text" name="USER_NM" id="USER_NM" value="<?php echo ($row['USER_NM']=="")?$_SESSION['valid_name']:$row['USER_NM'];?>" />
		<SELECT ID="STATE" name='STATE'>
	        <option value=''>-STATE-</option>
	        <option value="접수중" <?php echo ($STATE=="접수중")?"SELECTED":"";?>>접수중</option>
	        <option value="답변완료" <?php echo ($STATE=="답변완료")?"SELECTED":"";?>>답변완료</option>
		</SELECT>
		</td>
		<td>
		<textarea name="COMMENTS" id="COMMENTS" rows="3"><?php echo str_replace("<br/>", "\r\n",$row['COMMENTS']);?></textarea>
		</td>
		<td>
		<!-- 등록버튼 시작 -->
		<div id="board_list_button_table">
		<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
		<a href="write_ok.php?BOARD_SEQ=<?php echo $BOARD_SEQ?>&BOARD_ID=<?php echo $BOARD_ID?>&COMMENT_MODE=delete&SEQ=<?php echo $row['SEQ']?>">
		<span class="button">DEL</span></a>
		</div>
		</td>
		</tr>
		</tbody>
	   </table>
		<div style="display:none">
		<input type="text" value="<?php echo $COMMENT_MODE?>" name="COMMENT_MODE" id="COMMENT_MODE">
		<input type="text" value="<?php echo $BOARD_SEQ?>" name="BOARD_SEQ" id="BOARD_SEQ">
		<input type="text" value="<?php echo $BOARD_ID?>" name="BOARD_ID" id="BOARD_ID">
		<input type="text" value="<?php echo $row['SEQ']?>" name="SEQ" id="SEQ">
		<input type="text" value="<?php echo $_SESSION['valid_user']?>" name="USER_ID" id="USER_ID">
		</div>
	   </form>
		<?php } ?>
	</div>
	<?php }?>
	<!-- COMMENT END -->
	<!-- 이전,다음 게시물 링크시작 -->
	<div id="prev_wrap">
	<div class="board_write_table">
	     <table summary="" class="write_table">
	      <caption>Preview, Nextview Contents</caption>
	       <colgroup>
	           <col width="100px" />
		   <col />
	       </colgroup>
	       <tbody>
	<?php
	//셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,TITLE";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE (SEQ = (SELECT MIN(SEQ) FROM T_BOARD WHERE SEQ > '$BOARD_SEQ')";
		$SQL .= " OR SEQ = (SELECT MAX(SEQ) FROM T_BOARD WHERE SEQ < '$BOARD_SEQ'))";
		$SQL .= " AND BOARD_ID = '$BOARD_ID'";
		$SQL .= " ORDER BY SEQ ASC";
		$result = $GPLdb5->GPLexcute_query($SQL);
		$Prevtcnt = mysql_num_rows($result);
		if($result){
			while($row = mysqli_fetch_array($result)) {
		        if ($BOARD_SEQ > $row['SEQ'])
		        {
		?>
					<tr><th>Prev</th>
					<td>
					<a href="view.php?SEQ=<?php echo $row['SEQ']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=view">
						<?php echo $row['TITLE']?>
					</a>
					</td></tr>
					<?php if ($Prevtcnt == 1) { ?>
					 <tr><th>Next</th>
					 <td>None</td></tr>
					<?php } ?>
		<?php } else if ($BOARD_SEQ < $row['SEQ']) {	
		?>			
					<tr><th>Next</th>
					<td>
					<a href="view.php?SEQ=<?php echo $row['SEQ']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=view">
						<?php echo $row['TITLE']?>
					</a>
					</td></tr>
					<?php if ($Prevtcnt == 1) { ?>
					 <tr><th>Prev</th>
					 <td>None</td></tr>
					<?php } ?>
			<?php } ?>
		<?php } ?>
	<?php } ?>
	</tbody>
	</table>
	</div>
	</div>
	<div style="display:none">
	<form method="post" name="del_frm" id="del_frm" action="write_ok.php" >
	<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="text" value="<?php echo $BOARD_SEQ?>" name="BOARD_SEQ" id="BOARD_SEQ">
	<input type="text" value="<?php echo $BOARD_ID?>" name="BOARD_ID" id="BOARD_ID">
	<input type="text" value="<?php echo $FILENUM[0]?>" name="FILENUM0" id="FILENUM0">
	<input type="text" value="<?php echo $FILENUM[1]?>" name="FILENUM1" id="FILENUM1">
	<input type="text" value="<?php echo $FILE_NM[0]?>" name="FILE_NM0" id="FILE_NM0">
	<input type="text" value="<?php echo $FILE_NM[1]?>" name="FILE_NM1" id="FILE_NM1">
	<input type="text" value="" name="FILE_DEL0" id="FILE_DEL0">
	<input type="text" value="" name="FILE_DEL1" id="FILE_DEL1">
	<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
	<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
	<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
	</form>
	</div>
</div>
</body>
</html>