<?php
//공통적용 환경설정
header('Content-Type: text/html; charset=UTF-8');
$GPLcookie_domain = '127.0.0.1';//쿠키나 세션을 공유할 도메인 설정
$GPLurl_default = 'http://127.0.0.1/';//스크립트가 설치된 기본 url
$GPLpath_default = '';
define('GPLDIR_DEFAULT', dirname(GPLDIR));
define('GPLDIR_COLTROL', GPLDIR . '/control');
define('GPLDIR_CLASS', GPLDIR . '/core');
define('GPLDIR_CONFIG', GPLDIR_CLASS . '/config');
define('GPLDIR_DB', GPLDIR_CLASS . '/database');
define('GPLDIR_DATA', GPLDIR_CLASS . '/tmp');
define('GPLDIR_FUNCTION', GPLDIR_CLASS . '/function');
define('GPLDIR_CACHE', GPLDIR_DATA . '/cache');
define('GPLDIR_SESSION', GPLDIR_DATA . '/session');
?>
<?php include_once $_SERVER['DOCUMENT_ROOT']."/time-space/version.php";?>
<?php
if (file_exists(GPLDIR.'/core/config/db.php'))
{
	//정상진행
}
else
{
    echo "<script type='text/javascript'>alert('DB 설정 File이 존재하지 않습니다.\\n\\n신규 솔루션 설치 후 실행하시기 바랍니다.');</script>";
    echo "<meta http-equiv='Refresh' content='0;url=/install.php'>";
	exit;
}
?>
