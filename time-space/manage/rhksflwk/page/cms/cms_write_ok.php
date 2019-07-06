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
//$CONTENT = str_replace("\r\n", "<br/>",$CONTENT);
//$COMMENTS = str_replace("\r\n", "<br/>",$COMMENTS);
$CONTENT = htmlspecialchars($CONTENT);
$CONTENTS = htmlspecialchars($CONTENTS);
//echo $post_var;
//echo $MODE."mode".$T_CMS;
//exit; //디버그
if($MODE == "cms_write"){
	$proc_save = "INSERT INTO $T_CMS (";
	$proc_save .= "L_CODE,M_CODE,S_CODE,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$L_CODE'";
	$proc_save .=" ,'$M_CODE'";
	$proc_save .=" ,'$S_CODE'";
	$proc_save .=" ,'$USER_ID'";
	$proc_save .=" ,'$USER_NM'";
	$proc_save .=" ,'$EMAIL'";
	$proc_save .=" ,'$TITLE'";
	$proc_save .=" ,'$CONTENT'";
	$proc_save .=" ,NOW()";
	$proc_save .= ")";
	$i = 0;
	//echo $proc_save;
	//exit; //디버그
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		if($CATEGORY == "0"){ 
			$proc_edit = "UPDATE $T_L_MENU SET L_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE') WHERE SEQ = $SEQ";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}else if($CATEGORY == "1"){
			$proc_edit = "UPDATE $T_M_MENU SET M_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE') WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE'";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}else if( $CATEGORY == "2"){ 
			$proc_edit = "UPDATE $T_S_MENU SET S_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE')";
			$proc_edit .=" WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}
		$x = $GPLdb5->GPLmysql_affected_rows();
		if($x>0){
		echo "<script type='text/javascript'>alert('SAVE OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=cms_view.php?CATEGORY=$CATEGORY&SEQ=$SEQ&L_CODE=$L_CODE&M_CODE=$M_CODE&S_CODE=$S_CODE'>";
		}
		else
		{
			echo "<script type='text/javascript'>alert('SAVE URL FAIL.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>alert('SAVE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
	}
}
if($MODE == "cms_edit"){
	$proc_edit = "UPDATE $T_CMS SET";
	$proc_edit .=" USER_NM ='$USER_NM'";
	$proc_edit .=" ,EMAIL ='$EMAIL'";
	$proc_edit .=" ,TITLE ='$TITLE'";
	$proc_edit .=" ,CONTENT ='$CONTENT'";
	$proc_edit .=" WHERE L_CODE = '$L_CODE'";
	$proc_edit .=" AND M_CODE = '$M_CODE'";
	$proc_edit .=" AND S_CODE = '$S_CODE'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	//echo $proc_edit;exit;//디버그
	if($i>0){
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=cms_view.php?CATEGORY=$CATEGORY&SEQ=$SEQ&L_CODE=$L_CODE&M_CODE=$M_CODE&S_CODE=$S_CODE'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=cms_view.php?CATEGORY=$CATEGORY&SEQ=$SEQ&L_CODE=$L_CODE&M_CODE=$M_CODE&S_CODE=$S_CODE'>";
	}
}

if($MODE == "cms_del"){
	$proc_delete = "DELETE FROM $T_CMS WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
	$i = 0;
   	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		if($CATEGORY == "0"){ 
			$proc_edit = "UPDATE $T_L_MENU SET L_URL= NULL WHERE L_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE')";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}else if($CATEGORY == "1"){
			$proc_edit = "UPDATE $T_M_MENU SET M_URL= NULL WHERE M_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE')";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}else if( $CATEGORY == "2"){ 
			$proc_edit = "UPDATE $T_S_MENU SET S_URL= NULL WHERE S_URL= CONCAT('$L_CODE','$M_CODE','$S_CODE')";
			$x = 0;
			$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		}
		$x = $GPLdb5->GPLmysql_affected_rows();
		if($x>0){
			echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
		else
		{
			echo "<script type='text/javascript'>alert('UPDATE URL FAIL.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
exit;
}
?>