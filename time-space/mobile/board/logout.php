<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL ^ E_DEPRECATED );
  session_start();
  header('Content-Type: text/html; charset=UTF-8');
  unset($_SESSION['valid_user']);
  unset($_SESSION['valid_level']);
  unset($_SESSION['valid_name']);
  unset($_SESSION['login_security']);
  session_destroy();
  echo "<script>alert('LOGOUT SUCCESS.')</script>";
  echo "<meta http-equiv='Refresh' content='0;url=/time-space/mobile/'>";
?>
