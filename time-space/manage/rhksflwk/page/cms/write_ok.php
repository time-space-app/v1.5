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
<?php
//CMS메뉴시스템 공용변수값
$T_L_MENU = "T_L_MENU";
$T_M_MENU = "T_M_MENU";
$T_S_MENU = "T_S_MENU";
$T_CMS = "T_CMS";
?>
<?php
//파라미터 값
$i = 0;
$arr_key = array();
$arr_value = array();
foreach ($_POST as $key => $value){
	$arr_key[$i] = $key;
	if(!is_array($value)){
		$arr_value[$i] = $value;
		$$key = $arr_value[$i];
	}
	$post_var .= "arr_key($i): $$key => $arr_value[$i] <br>"; //디버그
	//$$key = $arr_value[$i];
	$i++;
}
//echo $post_var;
//exit; //디버그
if($MODE == "EDIT"){
	if($CATEGORY == "0"){
		$proc_edit = "UPDATE $T_L_MENU SET L_NAME='$L_NAME', L_URL='$L_URL' WHERE SEQ = $SEQ";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if($CATEGORY == "1"){
		$proc_edit = "UPDATE $T_M_MENU SET M_NAME='$M_NAME', M_URL='$M_URL' WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if( $CATEGORY == "2"){
		$proc_edit = "UPDATE $T_S_MENU SET S_NAME='$S_NAME', S_URL='$S_URL'";
		$proc_edit .=" WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";//echo $proc_edit;exit;
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "ADD"){
	if($CATEGORY == "0"){ 
		//UNIQUE 값 생성
		$proc_file = "SELECT MAX(SEQ) AS MAX_SEQ";
		$proc_file .= " FROM $T_L_MENU";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW['MAX_SEQ']>0){
			$NEW_SEQ = $ROW['MAX_SEQ'] + 1;
		} else {
		   $NEW_SEQ = 1;
		} 
		//대메뉴 순서값 값 생성
		$proc_file = "SELECT MAX(SUN) AS MAX_SUN";
		$proc_file .= " FROM $T_L_MENU";
		$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW3['MAX_SUN']>0){
			$NEW_SUN = $ROW3['MAX_SUN'] + 1;
		} else {
		   $NEW_SUN = 1;
		} 
		//대메뉴 값 생성
		$proc_file = "SELECT MAX(L_CODE) AS MAX_L_CODE";
		$proc_file .= " FROM $T_L_MENU";
		$ROW2 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW2['MAX_L_CODE']>0){
			$NEW_L_CODE = $ROW2['MAX_L_CODE'] + 1;
		} else {
		   $NEW_L_CODE = 1;
		} 
		//대메뉴 코드 정규화
		
		$L_CODE_SIZE = strlen($NEW_L_CODE);
		if( $L_CODE_SIZE == 1){
			$L_CODE = "00".$NEW_L_CODE;
		}elseif( $L_CODE_SIZE == 2){
			$L_CODE = "0".$NEW_L_CODE;
		}else{
			$L_CODE = $NEW_L_CODE;
		}
		/*빈값등록방지코드*/
		if(trim($L_NAME)==''){
				echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
				echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
				exit;
		}
		if(stristr($L_URL, '?')==FALSE){
			if(empty($L_URL) || is_numeric($L_URL) || (STRTOLOWER(SUBSTR($L_URL,0,7))=="http://"))$PASS=1; else $L_URL=$L_URL."/MENU_CODE/".$L_CODE."000000";
		}else{
			if(empty($L_URL) || is_numeric($L_URL) || (STRTOLOWER(SUBSTR($L_URL,0,7))=="http://"))$PASS=1; else $L_URL=$L_URL."/MENU_CODE/".$L_CODE."000000";
		}
		$proc_save = "INSERT INTO $T_L_MENU (";
		$proc_save .= "SEQ, SUN, L_CODE, L_NAME, L_URL, USE_YN";
		$proc_save .= ") VALUES (";
		$proc_save .=" $NEW_SEQ";
		$proc_save .=" ,$NEW_SUN";
		$proc_save .=" ,'$L_CODE'";
		$proc_save .=" ,'$L_NAME'";
		$proc_save .=" ,'$L_URL'";
		$proc_save .=" ,'Y'";
		$proc_save .= ")";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
		$i = $GPLdb5->GPLmysql_affected_rows();
	}else if($CATEGORY == "1"){
		//UNIQUE 값 생성
		$proc_file = "SELECT MAX(SEQ) AS MAX_SEQ";
		$proc_file .= " FROM $T_M_MENU WHERE L_CODE = '$L_CODE'";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW['MAX_SEQ']>0){
			$NEW_SEQ = $ROW['MAX_SEQ'] + 1;
		} else {
		   $NEW_SEQ = 1;
		} 
		//중메뉴 순서값 값 생성
		$proc_file = "SELECT MAX(SUN) AS MAX_SUN";
		$proc_file .= " FROM $T_M_MENU WHERE L_CODE = '$L_CODE'";
		$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW3['MAX_SUN']>0){
			$NEW_SUN = $ROW3['MAX_SUN'] + 1;
		} else {
		   $NEW_SUN = 1;
		} 
		//중메뉴 값 생성
		$proc_file = "SELECT MAX(M_CODE) AS MAX_M_CODE";
		$proc_file .= " FROM $T_M_MENU WHERE L_CODE = '$L_CODE'";
		$ROW2 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW2['MAX_M_CODE']>0){
			$NEW_M_CODE = $ROW2['MAX_M_CODE'] + 1;
		} else {
		   $NEW_M_CODE = 1;
		} 
		//중메뉴 코드 정규화
		$M_CODE_SIZE = strlen($NEW_M_CODE);
		if( $M_CODE_SIZE == 1){
			$M_CODE = "00".$NEW_M_CODE;
		}elseif( $M_CODE_SIZE == 2){
			$M_CODE = "0".$NEW_M_CODE;
		}else{
			$M_CODE = $NEW_M_CODE;
		}
		/*빈값등록방지코드*/
		if(trim($M_NAME)==''){
				echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
				echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
				exit;
		}
		if(stristr($M_URL, '?')==FALSE){
			if(empty($M_URL) || is_numeric($M_URL) || (STRTOLOWER(SUBSTR($M_URL,0,7))=="http://"))$PASS=1; else $M_URL=$M_URL."/MENU_CODE/".$L_CODE.$M_CODE."000";
		}else{
			if(empty($M_URL) || is_numeric($M_URL) || (STRTOLOWER(SUBSTR($M_URL,0,7))=="http://"))$PASS=1; else $M_URL=$M_URL."/MENU_CODE/".$L_CODE.$M_CODE."000";
		}	
		$proc_save = "INSERT INTO $T_M_MENU (";
		$proc_save .= "SEQ, SUN, L_CODE, M_CODE, M_NAME, M_URL, USE_YN";
		$proc_save .= ") VALUES (";
		$proc_save .=" $NEW_SEQ";
		$proc_save .=" ,$NEW_SUN";
		$proc_save .=" ,'$L_CODE'";
		$proc_save .=" ,'$M_CODE'";
		$proc_save .=" ,'$M_NAME'";
		$proc_save .=" ,'$M_URL'";
		$proc_save .=" ,'Y'";
		$proc_save .= ")";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	}else if( $CATEGORY == "2"){ 
		//UNIQUE 값 생성
		$proc_file = "SELECT MAX(SEQ) AS MAX_SEQ";
		$proc_file .= " FROM $T_S_MENU WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW['MAX_SEQ']>0){
			$NEW_SEQ = $ROW['MAX_SEQ'] + 1;
		} else {
		   $NEW_SEQ = 1;
		} 
		//중메뉴 순서값 값 생성
		$proc_file = "SELECT MAX(SUN) AS MAX_SUN";
		$proc_file .= " FROM $T_S_MENU WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
		$ROW3 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW3['MAX_SUN']>0){
			$NEW_SUN = $ROW3['MAX_SUN'] + 1;
		} else {
		   $NEW_SUN = 1;
		} 
		//중메뉴 값 생성
		$proc_file = "SELECT MAX(S_CODE) AS MAX_S_CODE";
		$proc_file .= " FROM $T_S_MENU WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
		$ROW2 = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		if($ROW2['MAX_S_CODE']>0){
			$NEW_S_CODE = $ROW2['MAX_S_CODE'] + 1;
		} else {
		   $NEW_S_CODE = 1;
		} 
		//대메뉴 코드 정규화
		$S_CODE_SIZE = strlen($NEW_S_CODE);
		if( $S_CODE_SIZE == 1){
			$S_CODE = "00".$NEW_S_CODE;
		}elseif( $L_CODE_SIZE == 2){
			$S_CODE = "0".$NEW_S_CODE;
		}else{
			$S_CODE = $NEW_S_CODE;
		}
		/*빈값등록방지코드*/
		if(trim($S_NAME)==''){
				echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
				echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
				exit;
		}
		if(stristr($S_URL, '?')==FALSE){
			if(empty($S_URL) || is_numeric($S_URL) || (STRTOLOWER(SUBSTR($S_URL,0,7))=="http://"))$PASS=1; else $S_URL=$S_URL."/MENU_CODE/".$L_CODE.$M_CODE.$S_CODE;
		}else{
			if(empty($S_URL) || is_numeric($S_URL) || (STRTOLOWER(SUBSTR($S_URL,0,7))=="http://"))$PASS=1; else $S_URL=$S_URL."/MENU_CODE/".$L_CODE.$M_CODE.$S_CODE;
		}
		$proc_save = "INSERT INTO $T_S_MENU (";
		$proc_save .= "SEQ, SUN, L_CODE, M_CODE, S_CODE, S_NAME, S_URL, USE_YN";
		$proc_save .= ") VALUES (";
		$proc_save .=" $NEW_SEQ";
		$proc_save .=" ,$NEW_SUN";
		$proc_save .=" ,'$L_CODE'";
		$proc_save .=" ,'$M_CODE'";
		$proc_save .=" ,'$S_CODE'";
		$proc_save .=" ,'$S_NAME'";
		$proc_save .=" ,'$S_URL'";
		$proc_save .=" ,'Y'";
		$proc_save .= ")";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	}
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('INSERT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	else
	{
		echo "<script type='text/javascript'>alert('INSERT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
?>