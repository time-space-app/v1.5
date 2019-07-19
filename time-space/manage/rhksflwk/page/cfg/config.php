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
<!DOCTYPE html>
<html lang="auto">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ko">
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
<?php //사이트 환경 설정 변수 설정 echo $GPLbase->GPLplugin;
if(isset($_POST['GPLplugin'])==''){
	$GPLplugin = @$GPLbase->GPLplugin;
}else{
	$GPLplugin=$_POST['GPLplugin'];
}
function getDirectories($path)
{
	$path = realpath($path);
    if (!is_dir($path))
        return false;
    $directories = array();
    foreach (scandir($path) as $val) {
        if( preg_match('/^_/',$val) ){
			$dir = $path.DIRECTORY_SEPARATOR.$val;
			if (is_dir($dir)) {
				$dir = str_replace("\\", "/", $dir);
				$explode_dir = explode("/",$dir);
				$arr_last=array_pop($explode_dir);
				//echo $arr_last;//디버그
				$directories[] = $arr_last;
				$directories = array_merge($directories, getDirectories($dir));
			}
		}else{ continue; }
    }
    return $directories;
}
$plugin_path = $_SERVER['DOCUMENT_ROOT'];
$directories = getDirectories($plugin_path);
//print_r($directories);//디버그
?>
<title>Time-Space HTML5</title>
</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Site Manager</h2>
</header>
<!-- 테이블 시작 -->
<div class="board_list_table">

<form name="form" action="" method="post">
<table class="list_table">
	<thead>
	<tr>
		<th style="width:20%"> Select Plugin </th>
		<th style="width:80%">
			Plugin NAME : 
			<select name="GPLplugin" id="GPLplugin">
			<?php foreach($directories as $val) { ?>
				<option value="<?php echo $val?>"<?php echo ($GPLplugin==$val)?" selected":"";?>><?php echo $val?></option>
			<?php } ?>
			</select><?php echo ($GPLplugin=="")?" Plugin Name Not Set?":""; ?>
		</th>
		<th>
		<!-- 등록버튼 시작 -->
		<div id="board_list_button_table">
			<input type="SUBMIT" value="SAVE" name="SUBMIT" class="type-btn">
		</div>
		</th>
	</tr>
	</thead>
</table>
</form>

</div>
</body>
</html>