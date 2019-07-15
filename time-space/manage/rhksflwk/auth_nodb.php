<?php
session_start();
?>
<?php
if (isset($_POST['id']) && isset($_POST['pw']))
{
  $userid = $_POST['id'];
  $password = $_POST['pw'];

	  if ($userid == 'timespace' && $password == 'timespace1234' )
	  {
		$_SESSION['valid_user'] = $userid;
	  	$_SESSION['valid_name'] = '타임스페이스';//iconv('utf-8', 'euc-kr', $row['USER_NM']);
	  	$_SESSION['valid_level'] = '1';
	  	$_SESSION['valid_email'] = $row['USER_EMAIL'];
		$_SESSION['login_security']   = 1;//File시스템 연동세션
	    //echo '로그인완료: '.$_SESSION['valid_name'].' <br />';
	    //echo '<a href="/manage/admin/logout.php">로그아웃</a><br />';
	  	session_cache_limiter('private');
	  	ini_set("session.cookie_lifetime", "86400");
	  	ini_set("session.cache_expire", "86400");
	  	ini_set("session.gc_maxlifetime", "86400");
	    //echo "<meta http-equiv='Refresh' content='0;url=admin.html'>";
	  	echo("	<script language='javascript'>
	  			//parent.location.href='/time-space/manage/rhksflwk/admin.html';
	  			parent.location.href='/time-space/index.php';
	  			</script>
	  			");
	  }else{
	  	echo "<script>alert('Login Fail.')</script>";
	  	//echo "<meta http-equiv='Refresh' content='0;url=/time-space/manage/rhksflwk.php'>";
	  	echo "<meta http-equiv='Refresh' content='0;url=/time-space/index.php'>";
	  }

}else{
	echo "<script>alert('NO INPUT VALUE.')</script>";
	echo "<meta http-equiv='Refresh' content='0;url=/time-space/manage/rhksflwk.php'>";
}
?>