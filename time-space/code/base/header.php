<?php
/* 
open HTML
*/
echo '
<!DOCTYPE html>
<html lang="auto">
<head>
        <title>'.$code['name'].'</title>
	<meta charset="utf-8">
	<META HTTP-EQUIV="Content-Language" CONTENT="ja">
	<meta name="product" content="Metro UI CSS Framework">
	<meta name="description" content="Time-Space css framework">
	<meta name="author" content="Time-Space">
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
	';?>
<?php 
//echo $_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(?i)msie [10]/',$_SERVER['HTTP_USER_AGENT']))
{
    // if IE = 10 but 1-9 version replace }else if{... [1-9]
   echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >'; //rest of your code
}
?>
<?php
echo '  <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="robots" content="noindex,nofollow" />
        <meta name="author" content="GMEditor.com" />
        <link rel="stylesheet" type="text/css" media="screen" href="'.$code['skin_path'].'base.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="'.$code['skin_path'].'tabs.css" />';
        include "code/base/css.php"; // browser specific base css ## 
        include "code/tabs/css.php"; // browser specific tabs css ##        
        echo '
        <!--<script src="code/base/debug.js" type="text/javascript"></script>-->
        <script src="code/tabs/javascript.js" type="text/javascript"></script>';
        include "code/base/javascript.php"; // pass required variables from javascript to php ## 
        echo '        
        <script src="code/base/shortcuts.js" type="text/javascript"></script>
        <script src="code/base/javascript.js" type="text/javascript"></script>
        <link href="'.$code['skin_path'].'design/favicon.ico" rel="shortcut icon" type="image/ico" />';
	echo '
	<link href="/_metro/css/metro-bootstrap.css" rel="stylesheet">
    	<script src="/_metro/js/jquery/jquery.min.js"></script>
    	<script src="/_metro/js/jquery/jquery.widget.min.js"></script>
    	<script src="/_metro/js/metro.min.js"></script>';
?>