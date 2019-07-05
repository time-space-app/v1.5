<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
?>
<?php
//$upload_path = "C:\\APM_Setup\\htdocs\\time-space\\upload\\".$_GET['target']."\\";  
$upload_path = $_SERVER['DOCUMENT_ROOT']."/time-space/upload/".$_GET['target']."/";  
$filename = $_GET['filename'];
$filename = iconv('UTF-8','EUC-KR',$filename);
$file_path = $upload_path.$filename; 
$handle = fopen($file_path, "rb");
    if(!$handle) 
    { 
        echo "{$filename} 파일을 찾을 수 없습니다"; 
        exit; 
    } 
    if(strstr($HTTP_USER_AGENT, "MSIE 6.")) 
	{ 
		header("Content-type: application/octetstream"); 
		header("Content-Length:".(string)(filesize($file_path)));
		header("Content-disposition: attachment; filename=$filename"); 
		header("Content-Transfer-Encoding: binary"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	} else if(strstr($HTTP_USER_AGENT, "MSIE 5.5")) { 
		header("Content-Type: doesn/matter"); 
		header("Content-Length:".(string)(filesize($file_path)));
		header("Content-disposition: attachment; filename=$filename"); 
		header("Content-Transfer-Encoding: binary"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	} else if(strstr($HTTP_USER_AGENT, "MSIE 5.0")) { 
		header("Content-type: file/unknown"); 
		header("Content-Length:".(string)(filesize($file_path)));
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Description: PHP Generated Data"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	} else { 
		header("Content-type: file/unknown"); 
		header("Content-Length:".(string)(filesize($file_path)));
		header("Content-Disposition: attachment; filename=$filename"); 
		Header("Content-Description: PHP Generated Data"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
	} 
    $fp = fopen($file_path, "rb"); 
    if($fp) 
    { 
        if (!fpassthru($fp)) 
        fclose($fp); 
    } 
    session_write_close(); // this is the solution
?>