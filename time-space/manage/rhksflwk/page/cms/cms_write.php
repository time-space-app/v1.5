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
$L_NAME= $_REQUEST['L_NAME'];
$M_NAME= $_REQUEST['M_NAME'];
$S_NAME= $_REQUEST['S_NAME'];
$MODE= $_REQUEST['MODE'];
$CATEGORY= $_REQUEST['CATEGORY'];
?>
<?php
//===========================
//echo $MODE;//디버그
//if(empty($ROW['USER_ID'])) $MODE = "cms_write"; else $MODE = "cms_view";

if($MODE == "cms_edit"){ 
	$proc_file = "SELECT L_CODE,M_CODE,S_CODE,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE,READCOUNT";
	$proc_file .= " FROM $T_CMS";
	$proc_file .= " WHERE L_CODE='$L_CODE' AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
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
 <script type="text/javascript">
     function del_chk(frm)
     {
        if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "cms_del"; 
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
</script>
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<style>
body table * {
font-size:15px !important;"
}
</style>
</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Page Content [Menu code:<?php echo $L_CODE.$M_CODE.$S_CODE?>]</h2>
</header>
<span class="br10"></span>
<!--Board 시작-->
<form method="post" name="frm" id="frm" action="cms_write_ok.php" onsubmit="return submitForm(this)" enctype="multipart/form-data" >
<!-- 등록버튼 시작 -->
<div id="board_list_button_table" style="width:inherit;float:left;">
	<a href="list.php">
	<span class="button">CANCEL</span></a>
	<?php if($MODE=="cms_edit"){?>
	<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);">
	<?php }?>
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
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
			<th>MENU NAME</th>
			<td><input type="text" size="70"  name="TITLE" id="TITLE" value="<?php echo ($ROW['TITLE']=="")?$L_NAME.$M_NAME.$S_NAME:$ROW['TITLE'];?>"></td>
		</tr>
		<tr>
			<th>PERSON</th>
			<td>
			<input type="text" size="10"  name="USER_NM" id="USER_NM" value="<?php echo ($ROW['USER_NM']=="")?$_SESSION['valid_name']:$ROW['USER_NM'];?>" />
			<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] == 1){?>
			TOP_NEWS : <input type="checkbox" name="TOP_NEWS" id="TOP_NEWS" <?php echo ($ROW['TOP_NEWS']=="on")?"checked=true":"";?>>
			<?php }?>
			</td>
		</tr>
		<tr>
		<?php
		$content = stripslashes($ROW['CONTENT']);
		$content = htmlspecialchars($content);
		?>
		<th>Content
			<?php $html = htmlspecialchars_decode(str_replace("<br/>", "\r\n",$content)); ?></th>
			<td><textarea name="CONTENT" id="CONTENT" rows="20"><?php echo $html//str_replace("<br/>", "\r\n",$ROW['CONTENT']);?> </textarea></td>
		</tr>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php">
	<span class="button">CANCEL</span></a>
	<?php if($MODE=="cms_edit"){?>
	<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);">
	<?php }?>
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
	<div style="display:none">
		<input type="text" value="<?php echo $SEQ?>" name="SEQ" id="SEQ">
		<input type="text" value="<?php echo $CATEGORY?>" name="CATEGORY" id="CATEGORY">
		<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
		<input type="text" value="<?php echo $L_CODE?>" name="L_CODE" id="L_CODE">
		<input type="text" value="<?php echo $M_CODE?>" name="M_CODE" id="M_CODE">
		<input type="text" value="<?php echo $S_CODE?>" name="S_CODE" id="S_CODE">
		<input type="text" value="<?php echo $_SESSION['valid_email']?>" name="EMAIL" id="EMAIL">
		<input type="text" value="<?php echo ($ROW['USER_ID']=="")?$_SESSION['valid_user']:$ROW['USER_ID'];?>" name="USER_ID" id="USER_ID">
	</div>
</form>
</div>
<!--Board 끝-->
<script type="text/javascript">
CKEDITOR.replace( 'CONTENT', {
    customConfig: '/time-space/ckeditor/config_cms.js'
});
CKEDITOR.replace( "CONTENT",
		    {
		        height: 600,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images"
			});
CKEDITOR.dtd.$removeEmpty['i'] = false;
CKEDITOR.dtd.$removeEmpty['span'] = false;
/*
CKEDITOR.config.protectedSource.push(/<\?[\s\S]*?\?>/g);
CKEDITOR.config.docType = '<!DOCTYPE html>';
CKEDITOR.config.contentsCss = ['/_metro/css/metro-bootstrap.css'];
CKEDITOR.config.bodyClass = 'metro';
*/
</script>
</body>
</html>