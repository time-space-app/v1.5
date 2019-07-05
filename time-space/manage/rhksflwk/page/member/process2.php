<?php include_once $_SERVER['DOCUMENT_ROOT']."/time-space/manage/rhksflwk/auth_only.php" //관리자인증 ?>
<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?
	$mode		=	$_REQUEST["mode"];
	$filename	=	$_REQUEST["filename"];
	/////////////////////////////디비에 데이터 인서트/////////////////////////////
	$path = "./temp";//임시디렉토리
	$uploaddir = "./temp/". $filename;//임시파일
	if($mode=="insert"){
		$row = 1;//줄수 초기화
		$fp = fopen ("$uploaddir","r");//파일오픈
		while ($data = fgetcsv ($fp, 1000, ",")) {//csv파일열기
		$num = count ($data);//총 줄수카운드
		
		$proc_file = "SELECT COUNT(LOGIN_ID) AS DUPCNT";
		$proc_file .= " FROM T_MEMBER";
		$proc_file .= " WHERE LOGIN_ID = '".$data[0]."'";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$DUPCNT=$ROW['DUPCNT'];
		if($DUPCNT>0){
			$DUPCNT=0;//중복아이디 입력방지
		}else{
			if($row>1){
			$proc_save= "INSERT INTO T_MEMBER (LOGIN_ID,USER_NM,USER_EMAIL,USE_YN,CREATE_DT,LOGIN_PWD,USER_LEVEL,AGREE_YN";
			$proc_save.= " ) values ";
			$proc_save.= "('".$data[0]."','".$data[1]."','".$data[2]."','Y',NOW(),sha1('".$data[0]."'),'9','true')";
			$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
			}
		}
		$row++;			
		}
		fclose ($fp);
		@unlink($uploaddir);//실제 파일삭제
		@rmdir($path);//실제 디렉토리 삭제
	}
	if($mode=="del"){
		/////////////////////////////임시파일,디렉토리 삭제/////////////////////////////	
		@unlink($uploaddir);//실제 파일삭제
		@rmdir($path);//실제 디렉토리 삭제
	}
	$location="./list.php";
    //echo "<script>location.href='$location' ;</script>";
		
?>