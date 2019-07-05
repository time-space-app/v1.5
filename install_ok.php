<?php
session_start();
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL);
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
// 파일이 존재한다면 재설치할 수 없다.
if (file_exists(GPLDIR.'/core/config/db.php')) {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
    echo "<script type='text/javascript'>alert('DB 설정 파일이 존재합니다.\\n\\n더 이상 진행할 수 없습니다. 관리자에게 문의해 주세요');</script>";
    echo "<meta http-equiv='Refresh' content='0;url=/'>";
    exit;
}
?>
<?php /*이용약관 동의*/
if($_POST['AGREE_YN']==''){
		echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
		echo "<script type='text/javascript'>alert('이용약관 동의를 하지 않으셨습니다.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=install.php'>";
		exit;
}
?>
<?php
$i = 0;
$arr_key = array();
$arr_value = array();
$post_var = '';
foreach ($_POST as $key => $value){
	$arr_key[$i] = $key;
	if(!is_array($value)){
		$arr_value[$i] = $value;
		$$key = $arr_value[$i];
	}
	$post_var .= "arr_key($i): $$key => $arr_value[$i] <br>"; //디버그
	//echo $$key = $arr_value[$i];
}
//exit;
@mysqli_query("set names utf8"); 
$connect= @mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
if (!$connect) {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
    echo "<script type='text/javascript'>alert('Database Host, User, Password 를 확인해 주십시오');</script>";
    echo "<meta http-equiv='Refresh' content='0;url=install.php'>";
    exit;
}
//exit;
@mysqli_query("set names utf8"); 
$select_db = @mysqli_select_db($connect,$DB_NAME);
if (!$select_db) {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
    echo "<script type='text/javascript'>alert('DB 를 확인해 주십시오');</script>";
    echo "<meta http-equiv='Refresh' content='0;url=install.php'>";
    exit;
}
?>
<?php
//테이블 생성
$file = implode("", file(GPLDIR."/sql/ALL.sql"));
eval("\$file = \"$file\";");

$f = explode(";", $file);
for ($i=0; $i<count($f); $i++) {
    if (trim($f[$i]) == "") continue;
    mysqli_query($connect,$f[$i]) or die(mysqli_error());
}
//초기값 입력
$sql = "
INSERT INTO T_MEMBER (LOGIN_ID, LOGIN_PWD, USER_NM, USER_LEVEL, USE_YN, EMAIL_YN, AGREE_YN, CREATE_DT, UPDATE_DT) VALUES
('admin', sha1('admin1234'), '관리자', 1, 'Y', 'on', 'on', '2013-05-25 15:59:29', '2013-06-01 23:40:58');
";
mysqli_query($connect,$sql) or die(mysqli_error());

// DB 설정 파일 생성
@chmod(GPLDIR."/core/config", 0707);
$file = GPLDIR."/core/config/db.php";
$f = @fopen($file, "w");

fwrite($f, "<?php\n");
fwrite($f, "\$GPLdb_host = '$DB_HOST';\n");
fwrite($f, "\$GPLdb_user = '$DB_USER';\n");
fwrite($f, "\$GPLdb_pass = '$DB_PASSWORD';\n");
fwrite($f, "\$GPLdb_name = '$DB_NAME';\n");
fwrite($f, "?>");

fclose($f);
@chmod($file, 0606);
echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8'>";
echo "<script type='text/javascript'>alert('DB 설정이 완료 되었습니다.');</script>";
echo "<meta http-equiv='Refresh' content='0;url=/'>";
?>