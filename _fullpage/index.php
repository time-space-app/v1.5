<?php include "header.php";?>
<?php //echo htmlspecialchars_decode($ROW['CONTENT']);//메뉴-컨텐츠 출력 기존코드?>
<?php
/* 메뉴-컨텐츠 DB에서 PHP변수 사용가능하게 변경 Start */
$contents = htmlspecialchars_decode($ROW['CONTENT']);
$uniqid=$_SERVER['DOCUMENT_ROOT']."/time-space/upload/".date("d-m-Y h-i-s").'_'.$MENU_CODE.".php";
$tmbfile = @fopen($uniqid,"w");
@fwrite($tmbfile,$contents);
include $uniqid;
@ftruncate($tmbfile, 0);
@fclose($tmbfile);
@unlink($uniqid);
/* 메뉴-컨텐츠 DB에서 PHP변수 사용가능하게 변경 End */
?>
<?php include "footer.php";?>