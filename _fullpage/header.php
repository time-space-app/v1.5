<?php //세션 Start + 환경설정 코드
	session_start();
	ini_set('log_errors','On');
	ini_set('display_errors','Off');
	ini_set('error_reporting', E_ALL);
	define('DS', DIRECTORY_SEPARATOR);
	define('GPLROOT', $_SERVER['DOCUMENT_ROOT'].DS.'time-space');
	define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
	include_once GPLDIR . '/core/config/default.php';
	include_once GPLDIR_CLASS . '/GPLbase.class.php';
	$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
	$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php //검색엔진최적화를 위한 URl쿼리 특수문자 / 문자로 대체 후 변수 뽑기 작업
	if(strpos( $_SERVER['REQUEST_URI'] , "MENU_CODE/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "MENU_CODE" ));
	$_REQUEST['MENU_CODE']=$arr_param[1];//echo $MENU_CODE.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "BOARD_ID/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "BOARD_ID" ));
	$_REQUEST['BOARD_ID']=str_replace(" ","",$arr_param[1]);//echo $BOARD_ID.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "SEQ/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "SEQ" ));
	$_REQUEST['SEQ']=str_replace(" ","",$arr_param[1]);//echo $SEQ.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "now_page/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "now_page" ));
	$_REQUEST['now_page']=str_replace(" ","",$arr_param[1]);//echo $now_page.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "GUBN/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "GUBN" ));
	$_REQUEST['GUBN']=str_replace(" ","",$arr_param[1]);//echo $GUBN.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "SEARCH/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "SEARCH" ));
	$_REQUEST['SEARCH']=urldecode(str_replace(" ","",$arr_param[1]));//echo $SEARCH.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "MODE/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "MODE" ));
	$_REQUEST['MODE']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "CATEGORY/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "CATEGORY" ));
	$_REQUEST['CATEGORY']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
	}
	if(strpos( $_SERVER['REQUEST_URI'] , "COMMENT_MODE/" )){
	$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "COMMENT_MODE" ));
	$_REQUEST['COMMENT_MODE']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
?>
<?php include_once GPLROOT."/time-space/board/auth.php"; //공통 인증처리 ?>
<?php //스팸방지 처리
	$userid = $_SESSION['valid_user'];
	$proc_file = "SELECT LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,AGREE_YN,EMAIL_YN";
	$proc_file .= " FROM T_MEMBER";
	$proc_file .= " WHERE LOGIN_ID = '$userid'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$EMAIL=$ROW['USER_EMAIL'];
	$arremail = explode("@",$EMAIL);
?>
<?php //자동등록방지코드
	$se_num1 = mt_rand(1, 9);
	$se_num2 = mt_rand(1, 9);
?>
<?php //CMS메뉴시스템 공용변수값
	$T_L_MENU = "T_L_MENU";
	$T_M_MENU = "T_M_MENU";
	$T_S_MENU = "T_S_MENU";
	$T_CMS = "T_CMS";
?>
<?php //초기 메뉴코드 지정
 if(empty($_REQUEST['MENU_CODE'])) $_REQUEST['MENU_CODE']= "001000000"; 
?>
<?php //메뉴값 바인딩
	//메뉴 공통변수 항상 페이지 상단에 위치
	$MENU_CODE= str_replace(" ","",$_REQUEST['MENU_CODE']);
	$L_CODE= SUBSTR($MENU_CODE,0,3);
	$M_CODE= SUBSTR($MENU_CODE,3,3);
	$S_CODE= SUBSTR($MENU_CODE,6,3);
	//대메뉴정보
		$proc_file = "SELECT L_NAME AS MENU_TITLE";
		$proc_file .= " FROM T_L_MENU WHERE L_CODE = '$L_CODE'";
		$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>
<?php //사용자 접속 브라우저 확인
	if(preg_match('/(?i)msie [10]/',$_SERVER['HTTP_USER_AGENT']))
	{
    // if IE = 10 but 1-9 version replace }else if{... [1-9]
   //echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" >'; //rest of your code
	}
?>
<?php //메뉴-콘텐츠 공통변수 항상 페이지 상단에 위치
	//메뉴-컨텐츠 조회카운터+1
	$proc_edit = "UPDATE T_CMS SET";
	$proc_edit .=" READCOUNT = IFNULL(READCOUNT,0) + 1";
	$proc_edit .=" WHERE";
	$proc_edit .=" L_CODE= '$L_CODE'AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	//메뉴 정보 가져오기 쿼리정리
	$proc_file = "SELECT L_CODE,M_CODE,S_CODE,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE,READCOUNT";
	$proc_file .= " FROM T_CMS";
	$proc_file .= " WHERE L_CODE='$L_CODE' AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>