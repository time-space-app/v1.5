<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL ^ E_DEPRECATED );
session_start();
header('Content-Type: text/html; charset=UTF-8');
	if (isset($_SESSION['valid_user']) && $_SESSION['valid_level'] < 3){
		session_cache_limiter('private');
		@ini_set("session.cookie_lifetime", "86400");
		@ini_set("session.cache_expire", "86400");
		@ini_set("session.gc_maxlifetime", "86400");
	}else{//세션 유지시간

		unset($_SESSION['valid_user']);
		unset($_SESSION['valid_level']);
		session_destroy();
		echo "<script>alert('LOGIN FAIL. RETRY LOGIN.')</script>";
		echo("	<script language='javascript'>
				parent.location.href='/time-space/manage/';
				</script>
			");
		//자바스크립트가 꺼저 있을때
		echo "<meta http-equiv='Refresh' content='0;url=/time-space/manage/' target='_top'>";
		exit;
	}
?>
