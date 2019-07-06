<?php
$file_name = date("Y-m-d-h-i-s",time())."_테이블구조.xls";
function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }
function is_ie() { return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false; }
if( is_ie() ) $file_name = utf2euc($file_name);
header( "Content-type: application/vnd.ms-excel" );
header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename={$file_name}" );
header( "Content-Description: PHP4 Generated Data");
echo $strBuffer;
?>