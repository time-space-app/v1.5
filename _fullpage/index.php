<?php include_once "header.php"; //전체공통 PHP헤더 ?>
<?php //echo htmlspecialchars_decode($ROW['CONTENT']);//컨텐츠 출력 사용안함 아래코드로 대체 ?>
<?php //컨텐츠 DB에서 PHP변수 사용가능하게 변경
    $contents = htmlspecialchars_decode($ROW['CONTENT']);
    $uniqid=$_SERVER['DOCUMENT_ROOT']."/time-space/upload/".date("d-m-Y h-i-s").'_'.$MENU_CODE.".php";
    $tmbfile = @fopen($uniqid,"w");
    @fwrite($tmbfile,$contents);
    include $uniqid;
    @ftruncate($tmbfile, 0);
    @fclose($tmbfile);
    @unlink($uniqid);
?>
<?php include_once "footer.php"; //전체공통 PHP푸터-현재 내용없음 ?>