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
		
		require_once $_SERVER['DOCUMENT_ROOT'].'/Excel/reader.php';
		$data = new Spreadsheet_Excel_Reader();
		$data->setUTFEncoder('mb');
		$data->setOutputEncoding('utf-8');
		$data->read($uploaddir);
		error_reporting(E_ALL ^ E_NOTICE);
		for ($i = 2; $i <= ($data->sheets[0]['numRows']); $i++) {
			/*
			for ($j = 1; $j <= ($data->sheets[0]['numCols']); $j++) {
				if($data->sheets[0]['cells'][$i][1]!=""){
				echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";//디버그
				}
			}
			*/
			$proc_file = "SELECT COUNT(LOGIN_ID) AS DUPCNT";
			$proc_file .= " FROM T_MEMBER";
			$proc_file .= " WHERE LOGIN_ID = '".$data->sheets[0]['cells'][$i][1]."'";
			$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
			$DUPCNT=$ROW['DUPCNT'];
			if($DUPCNT>0){
				$DUPCNT=0;//중복아이디 입력방지
			}else{
				if($data->sheets[0]['cells'][$i][1]!=""){
				$proc_save= "INSERT INTO T_MEMBER (LOGIN_ID,USER_NM,USER_EMAIL,USE_YN,CREATE_DT,LOGIN_PWD,USER_LEVEL,AGREE_YN";
				$proc_save.= " ) values ";
				$proc_save.= "('".$data->sheets[0]['cells'][$i][1]."','".$data->sheets[0]['cells'][$i][2]."','".$data->sheets[0]['cells'][$i][3]."','Y',NOW(),sha1('".$data->sheets[0]['cells'][$i][1]."'),'9','true')";
				$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
				}
			}
			
		}
		//echo "<br/>";		//디버그
		@unlink($uploaddir);//실제 파일삭제
		@rmdir($path);//실제 디렉토리 삭제
		//exit;//디버그
	}
	if($mode=="del"){
		/////////////////////////////임시파일,디렉토리 삭제/////////////////////////////	
		@unlink($uploaddir);//실제 파일삭제
		@rmdir($path);//실제 디렉토리 삭제
	}
	$location="./list.php";
    echo "<script>location.href='$location' ;</script>";
		
?>