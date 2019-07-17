<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL ^ E_DEPRECATED );
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
// 파일이 존재한다면 재설치할 수 없다.
if (file_exists(GPLDIR.'/core/config/db.php')) {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
    echo "<script type='text/javascript'>alert('기존 DB 설정 파일이 존재합니다.\\n\\n더 이상 진행할 수 없습니다. 관리자에게 문의해 주세요');</script>";
    echo "<meta http-equiv='Refresh' content='0;url=/'>";
	exit;
}
?>
<?php include $_SERVER['DOCUMENT_ROOT']."/time-space/version.php";?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <META HTTP-EQUIV="Content-Language" CONTENT="ja">
    <meta name="product" content="Metro UI CSS Framework">
    <meta name="description" content="Time-Space css framework">
    <meta name="author" content="Time-Space">
    <meta name="keywords" content="Time-Space, 타임스페이스, 웹 CMS툴">
<?php 
//echo $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(?i)msie [10]/',$_SERVER['HTTP_USER_AGENT']))
{
    // if IE = 10 but 1-9 version replace }else if{... [1-9]
   echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >'; //rest of your code
}
?>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--[if IE]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 <script src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.3.0/respond.js”></script>
<![endif]-->
<!--[if lte IE 8]>
 <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
 <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<![endif]-->
<!--[if IE 9]>
 <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js”></script>
 <script type="text/javascript" language="javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<![endif]-->
<!--[if gte IE 9]>
 <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
<![endif]-->
<!--[if !IE]> -->
 <script src="http://code.jquery.com/jquery-2.0.0b2.js"></script>
<!-- <![endif]-->
<script src="/_metro/js/ajax_functions.js"></script>
<script type="text/javascript">
var myReq = getXMLHTTPRequest();
</script>
<link href="/time-space/skin/one/design/favicon.ico" rel="shortcut icon" type="image/ico" />
    <link href="/_metro/css/metro-bootstrap.css" rel="stylesheet">
    <link href="/_metro/css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="/_metro/css/docs.css" rel="stylesheet">
    <link href="/_metro/js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="/_metro/js/jquery/jquery.min.js"></script>
    <script src="/_metro/js/jquery/jquery.widget.min.js"></script>
    <script src="/_metro/js/jquery/jquery.mousewheel.js"></script>
    <script src="/_metro/js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="/_metro/js/load-metro.js"></script>

    <!-- Local JavaScript -->
    <script src="/_metro/js/docs.js"></script>

    <title>Time-Space:웹 CMS툴</title>
<script type="text/javascript">
	function submitLicense(frm)
	{
		var errorMessage = null;
		var objFocus = null;
		if (frm.AGREE_YN.checked == false) {
		    errorMessage = "Please input the 이용약관동의.";
		    objFocus = frm.AGREE_YN;
		   }
		else if (frm.DB_HOST.value.length == 0) {
		    errorMessage = "Please input the DB_HOST.";
		    objFocus = frm.DB_HOST;
		   }
		else if (frm.DB_USER.value.length == 0) {
		    errorMessage = "Please input the DB_USER.";
		    objFocus = frm.DB_USER;
		   }
		else if (frm.DB_PASSWORD.value.length == 0) {
		    errorMessage = "Please input the DB_PASSWORD.";
		    objFocus = frm.DB_PASSWORD;
		   }
		else if (frm.DB_NAME.value.length == 0) {
		    errorMessage = "Please input the DB_NAME.";
		    objFocus = frm.DB_NAME;
		   }
		if(errorMessage != null) {
		    alert(errorMessage);
		    objFocus.focus();
		    return false;
		   }
	}
</script>
</head>
<body class="metro" style="background-color: #efeae3">
    <header class="bg-dark"></header>
	<div class="page">
          <div class="page-region">
            <div class="page-region-content">
                <h1>
                    타임스페이스 <?php echo $code['version']?><small class="on-right">Install Form(Mysql/마리아DB 정보입력)</small>
                </h1>
		<!--게시판 시작-->
		<section>
		<form method="post" name="frm" id="frm" action="install_ok.php" onsubmit="return submitLicense(this)" enctype="multipart/form-data" >
		<!-- 테이블 시작 -->
			<div class="board_write_table">
			     <table summary="" class="table">
			      <caption></caption>
			       <colgroup>
			        <col style="width:100px;" />
			        <col />
			       </colgroup>
			       <tbody>
			        <tr>
			        	<th>이용약관</th>
			        	<td>
<pre>
<?php
$input= fopen("LICENSE.html", "r");
//$result= fread($input, 4000);
$result = fread($input, filesize("LICENSE.html"));
$result = substr($result,$s=strpos($result,'<pre>')+5,strrpos($result,'</pre>')-$s);
//$result = strip_tags($result);
echo $result;
fclose($input);
?>
</pre>
			        		<label>
						설치를 원하시면 위 내용에 동의 하셔야합니다.(필수)
						<input type="checkbox" name="AGREE_YN" id="AGREE_YN" <?php echo ($ROW['AGREE_YN']=="on")?"checked=true":"";?>>
						</label>
			        	</td>
			        </tr>
				<tr>
					<th>DB_Host</th>
					<td>
					<div class="input-control text span3 block" data-role="input-control">
					<input type="text" name="DB_HOST" id="DB_HOST" value="localhost" />
					</div>
					</td>
				</tr>
				<tr>
					<th>DB_User</th>
					<td>
					<div class="input-control text span3 block" data-role="input-control">
					<input type="text" name="DB_USER" id="DB_USER" value="" />
					</div>
					</td>
				</tr>
				<tr>
					<th width="18%">DB_Password</th>
					<td>
					<div class="input-control password span3 block" data-role="input-control">
					<input type="password" size="21"  name="DB_PASSWORD" id="DB_PASSWORD" value="" />
					</div>
					</td>
				</tr>
				<tr>
					<th>DB_Name</th>
					<td>
					<div class="input-control text span3 block" data-role="input-control">
					<input type="text" name="DB_NAME" id="DB_NAME" value="" />
					</div>
					</td>
				</tr>
			</tbody>
			</table>
			</div>
			<!-- 등록버튼 시작 -->
			<div id="board_list_button_table" style="text-align:right">
			<button type="reset" class="button large info">RESET</button>
			<button type="submit" class="button large info">COMMIT</button>
			</div>
		</form>
		</section>
		<!--게시판 끝-->
            </div>
        </div>

<?php include "_metro/footer.php";?>