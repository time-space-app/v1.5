<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL ^ E_DEPRECATED );
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php
if (isset($_POST['id']) && isset($_POST['pw']))
{
  $userid = $_POST['id'];
  $password = $_POST['pw'];
  //일반쿼리 사용 (단일출력)
  $userid = $GPLdb5->GPLescape_check($userid); //sql 인젝션 방지 사용
  $password = $GPLdb5->GPLescape_check($password); //sql 인젝션 방지 사용
  $SQL = "SELECT USER_NM,USER_LEVEL,USER_EMAIL FROM T_MEMBER";
  $SQL .= " WHERE LOGIN_ID = '$userid'";
  $SQL .= " AND LOGIN_PWD = sha1('$password')";
  $SQL .= " AND USE_YN = 'Y'";
  $row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	  if (count($row) >0 && $row['USER_LEVEL']<3 )
	  {
	  	$_SESSION['valid_user'] = $userid;
	  	$_SESSION['valid_name'] = $row['USER_NM'];//iconv('utf-8', 'euc-kr', $row['USER_NM']);
	  	$_SESSION['valid_level'] = $row['USER_LEVEL'];
	  	$_SESSION['valid_email'] = $row['USER_EMAIL'];
		$_SESSION['login_security']   = 1;//File시스템 연동세션
	    //echo '로그인완료: '.$_SESSION['valid_name'].' <br />';
	    //echo '<a href="/manage/admin/logout.php">로그아웃</a><br />';
	  	session_cache_limiter('private');
	  	@ini_set("session.cookie_lifetime", "86400");
	  	@ini_set("session.cache_expire", "86400");
	  	@ini_set("session.gc_maxlifetime", "86400");
	    //echo "<meta http-equiv='Refresh' content='0;url=admin.html'>";
	  	echo("	<script language='javascript'>
	  			//parent.location.href='/time-space/manage/rhksflwk/admin.html';
	  			parent.location.href='/time-space/index.php';
	  			</script>
	  			");
	  }else if (count($row) >0){
	  	echo "<meta http-equiv='Refresh' content='0;url=/'>";
		}else{
	  	echo "<script>alert('Login Fail.')</script>";
	  	echo "<meta http-equiv='Refresh' content='0;url=/'>";
	  }
}else{
	echo "<script>alert('NO INPUT VALUE.')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=/time-space/manage/'>";
}
?>
