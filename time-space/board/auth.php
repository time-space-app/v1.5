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
	  if (count($row) >0 )
	  {
	  	$_SESSION['valid_user'] = $userid;
	  	$_SESSION['valid_name'] = $row['USER_NM'];//iconv('utf-8', 'euc-kr', $row['USER_NM']);
	  	$_SESSION['valid_level'] = $row['USER_LEVEL'];
	  	$_SESSION['valid_email'] = $row['USER_EMAIL'];
	  	if($row['USER_LEVEL']<3)$_SESSION['login_security']   = 1;//파일시스템 연동세션
	  	session_cache_limiter('private');
	  	@ini_set("session.cookie_lifetime", "86400");
	  	@ini_set("session.cache_expire", "86400");
	  	@ini_set("session.gc_maxlifetime", "86400");
	  	echo "<script>alert('Login Ok.');</script>";
	  	//echo "<script>location.replace('".$_SERVER['REQUEST_URI']."');</script>";
	  	echo "<meta http-equiv='Refresh' content='0;url=".$_SERVER['REQUEST_URI']."'>";
	  	//header('Location: '.$_SERVER['REQUEST_URI']);
	  }else{
	  	echo "<script>alert('Login Fail.');</script>";
	  	//echo "<script>location.replace('".$_SERVER['REQUEST_URI']."');</script>";
	  	echo "<meta http-equiv='Refresh' content='0;url=".$_SERVER['REQUEST_URI']."'>";
	  	//header('Location: '.$_SERVER['REQUEST_URI']);
	  }

}
?>