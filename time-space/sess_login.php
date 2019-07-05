<?php
  session_start();
  header('Content-Type: text/html; charset=UTF-8');
  if($_GET["logout"] == "yes")
  {
	   unset($_SESSION['login_security']);
	   session_destroy();
	   echo "<script>alert('LogoutOK');location.replace('index.html');</script>";
  }
  else
  {
	   if((trim($_POST["USERID"]) == "kimilguk") && (trim($_POST["PASSWD"]) == "time-9"))
	   {
		$_SESSION['login_security']   = no access;
		Header("Location:index.php");
	   }
	   else
	   {
		echo "<script>alert('AccessFail');location.replace('index.html');</script>";
	   }
  }
 
?>