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
$BOARD_ID = $_REQUEST['BOARD_ID'];
$MODE = $_REQUEST['MODE'];
$BOARD_SEQ = $_REQUEST['SEQ'];
$now_page = $_REQUEST['now_page'];
$arremail = explode("@",$_SESSION['valid_email']);
//===========================
if($MODE == "edit"){ //&& $_SESSION['valid_user'] 로그인사용자만
	$proc_file = "SELECT CONTENT,EMAIL,TITLE,USER_NM,REGDATE,READCOUNT,FILECNT,USER_ID,STATE,POPUP,POPUP_W,POPUP_H,TOP_NEWS";
	$proc_file .= " FROM T_BOARD";
	$proc_file .= " WHERE SEQ = '$BOARD_SEQ'";
	$proc_file .= " AND BOARD_ID = '$BOARD_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$EMAIL=$ROW['EMAIL'];
	$arremail = explode("@",$EMAIL);
	if ($ROW['FILECNT'] > 0)
	{
		$SQL = "SELECT";
			$SQL .= " SEQ,FILE_NM,FILE_SIZE,DOWN_CNT";
			$SQL .= " ,BOARD_SEQ,BOARD_ID";
			$SQL .= " FROM T_ATTACH_FILE";
			$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
			$SQL .= " ORDER BY SEQ ASC";
			$fileresult = $GPLdb5->GPLexcute_query($SQL);
			$i=0;
			if($fileresult){
				while($filerow = mysqli_fetch_array($fileresult)) {	
					if($filerow['FILE_NM']){
					$FILE_NM[$i] = $filerow['FILE_NM'];
					$FILE_NUM[$i] = $filerow['SEQ'];
					}
					$i++;
				}
		}
	}
}
//메뉴 변수
//메뉴 변수
	switch ($BOARD_ID) { //notice, qa, qa, pds, faq
		case 'notice'  : $body='1'; $title='NOTICE';break;
		case 'community' : $body='2'; $title='COMMUNITY';break;
		case 'qa'  : $body='3'; $title='Q/A';break;
		case 'faq'  : $body='4'; $title='FAQ';break;
		case 'pds'  : $body='5'; $title='PDS';break;
		default   : $body='1'; $title='NOTICE';break;
	}
?>
<?php /*자동등록방지코드*/
$se_num1 = mt_rand(1, 9);
$se_num2 = mt_rand(1, 9);
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
 <script type="text/javascript">
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
     function submitForm(frm)
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
     function selectmail() {
         var mail = document.getElementById('DDLEMAIL');
         var txt = document.getElementById('EMAIL1');
         if (mail == "") {
             txt.focus();
             txt.innerText = "";
         } else {
             txt.innerText = mail.value;
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
<?php }?>
</head>
<body class="sub1_<?php echo $body?>">
<div id="wrap">
<header id="board_list_header">
	<h2><?php echo $title." Board"?></h2>
</header>
<span class="br10"></span>
<!--Board 시작-->
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
			<th>SUBJECT</th>
			<td><input type="text" size="70"  name="TITLE" id="TITLE" value="<?php echo $ROW['TITLE']?>" /></td>
		</tr>
		<tr>
			<th>NAME</th>
			<td>
			<input type="text" size="10"  name="USER_NM" id="USER_NM" value="<?php echo ($ROW['USER_NM']=="")?$_SESSION['valid_name']:$ROW['USER_NM'];?>" />
			<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] < 3){?>
			TOP_NEWS : <input type="checkbox" name="TOP_NEWS" id="TOP_NEWS" <?php echo ($ROW['TOP_NEWS']=="on")?"checked=true":"";?>>
			<?php }?>
			</td>
		</tr>
		<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] < 3){?>
		<tr>
			<th>POPUP</th>
			<td>
			USE : <input type="checkbox" name="POPUP" id="POPUP" <?php echo ($ROW['POPUP']=="on")?"checked=true":"";?>>
			WIDTH: <input type="text" value="<?php echo $ROW['POPUP_W']?>" name="POPUP_W" id="POPUP_W" SIZE="10">
			HEIGHT: <input type="text" value="<?php echo $ROW['POPUP_H']?>" name="POPUP_H" id="POPUP_H" SIZE="10">
			</td>
		<tr>
		<?php }?>
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
			</SELECT>
			</td> 
		</tr>
		<?php if($BOARD_ID=="notice" || $BOARD_ID=="pds"){?>
		<tr>
			<th>FILE1</th>
			<td>
				<input type="FILE" ID="FILEUPLOAD0" NAME="FILEUPLOAD0" />
				<?php if($FILE_NM[0]){?>
				<a href="/time-space/manage/core/function/download.php?filename=<?php echo $FILE_NM[0]?>&target=<?php echo $BOARD_ID?>"><?php echo $FILE_NM[0]?></a>
				<input type="button" value="삭제" onclick="file_del(0);" /> 
				<?php }?>
			</td>
		</tr>
		<tr>
			<th>FILE2</th>
			<td>
				<input type="FILE" ID="FILEUPLOAD1" NAME="FILEUPLOAD1" />
				<?php if($FILE_NM[1]){?>
				<a href="/time-space/manage/core/function/download.php?filename=<?php echo $FILE_NM[1]?>&target=<?php echo $BOARD_ID?>"><?php echo $FILE_NM[1]?></a>
				<input type="button" value="삭제" onclick="file_del(1);" /> 
				<?php }?>
			</td>
		</tr>  
		<?php }?>
		<tr>
			<th>Content</th>
			<td><textarea name="CONTENT" id="CONTENT" rows="20"><?php echo str_replace("<br/>", "\r\n",$ROW['CONTENT']);?> </textarea></td>
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
	<a href="list.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=list">
	<span class="button">CANCEL</span></a>
	<?php if($MODE=="edit"){?>
	<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);">
	<?php }?>
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
	<div style="display:none">
		<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
		<input type="text" value="<?php echo $BOARD_SEQ?>" name="BOARD_SEQ" id="BOARD_SEQ">
		<input type="text" value="<?php echo $BOARD_ID?>" name="BOARD_ID" id="BOARD_ID">
		<input type="text" value="<?php echo ($ROW['USER_ID']=="")?$_SESSION['valid_user']:$ROW['USER_ID'];?>" name="USER_ID" id="USER_ID">
		<input type="text" value="<?php echo $FILE_NUM[0]?>" name="FILE_NUM0" id="FILE_NUM0">
		<input type="text" value="<?php echo $FILE_NUM[1]?>" name="FILE_NUM1" id="FILE_NUM1">
		<input type="text" value="<?php echo $FILE_NM[0]?>" name="FILE_NM0" id="FILE_NM0">
		<input type="text" value="<?php echo $FILE_NM[1]?>" name="FILE_NM1" id="FILE_NM1">
		<input type="text" value="" name="FILE_DEL0" id="FILE_DEL0">
		<input type="text" value="" name="FILE_DEL1" id="FILE_DEL1">
		<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
		<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
		<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
		<input type="text" value="<?php echo $ROW['FILECNT']?>" name="FILECNT" id="FILECNT">
		<input type="text" value="<?php echo $ROW['STATE']?>" name="STATE" id="STATE">
	</div>
</form>
</div>
<!--Board 끝-->
<?php if($BOARD_ID=="notice" || $BOARD_ID=="community" || preg_match('/stay-/',$BOARD_ID)) { ?>
<script type="text/javascript">
CKEDITOR.replace( "CONTENT",
		    {
		        height: 300,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images"
		    });
CKEDITOR.config.docType = '<!DOCTYPE html>';
CKEDITOR.config.contentsCss = ['/_metro/css/metro-bootstrap.css'];
CKEDITOR.config.bodyClass = 'metro';
</script>
<?php } ?>
</body>
</html>