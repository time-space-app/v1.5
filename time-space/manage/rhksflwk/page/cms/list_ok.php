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
if($MODE == "L_DEL"){
	//중메뉴 존재시 삭제 방지
	$proc_file = "SELECT (SELECT COUNT(*) FROM $T_M_MENU WHERE L_CODE='$L_CODE') AS M_CNT";
	$proc_file .= " FROM $T_L_MENU";
	$proc_file .= " WHERE SEQ = $SEQ";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
 	if($ROW['M_CNT'] > 0) {
 		echo "<script type='text/javascript'>alert('Not Del! Please delete sub-menu.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	$proc_delete = "DELETE FROM $T_L_MENU WHERE SEQ = $SEQ AND L_CODE='$L_CODE'";
	$i = 0;
    	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		$proc_delete = "DELETE FROM $T_CMS WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
		$x = 0;
	   	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
		$x = $GPLdb5->GPLmysql_affected_rows();
		if($x>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
		else 
		{
			echo "<script type='text/javascript'>alert('MENU DEL OK! CMS DELETE FAIL.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "M_DEL"){
	//소메뉴 존재시 삭제 방지
	$proc_file = "SELECT (SELECT COUNT(*) FROM $T_S_MENU WHERE L_CODE='$L_CODE' AND M_CODE='$M_CODE') AS M_CNT";
	$proc_file .= " FROM $T_M_MENU";
	$proc_file .= " WHERE SEQ = $SEQ";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
 	if($ROW['M_CNT'] > 0) {
 		echo "<script type='text/javascript'>alert('Not Del! Please delete sub-menu.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	$proc_delete = "DELETE FROM $T_M_MENU WHERE SEQ = $SEQ AND L_CODE='$L_CODE' AND M_CODE='$M_CODE'";
	$i = 0;
    	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		$proc_delete = "DELETE FROM $T_CMS WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
		$x = 0;
	   	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
		$x = $GPLdb5->GPLmysql_affected_rows();
		if($x>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
		else 
		{
			echo "<script type='text/javascript'>alert('MENU DEL OK! CMS DELETE FAIL.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "S_DEL"){
	$proc_delete = "DELETE FROM $T_S_MENU WHERE SEQ = $SEQ AND L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
	$i = 0;
    	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		$proc_delete = "DELETE FROM $T_CMS WHERE L_CODE = '$L_CODE' AND M_CODE = '$M_CODE' AND S_CODE = '$S_CODE'";
		$x = 0;
	   	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
		$x = $GPLdb5->GPLmysql_affected_rows();
		if($x>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
		else 
		{
			echo "<script type='text/javascript'>alert('MENU DEL OK! CMS DELETE FAIL.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
		}
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "MOVE_UP"){
	if($CATEGORY == "0"){ 
		$proc_file = "SELECT SEQ, SUN FROM $T_L_MENU WHERE SEQ = $SEQ ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_L_MENU SET SUN = SUN-1 WHERE SEQ = $SEQ";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_L_MENU SET SUN = SUN+1 WHERE SEQ <> $SEQ AND SUN = $ROW[SUN]-1";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if($CATEGORY == "1"){
		$proc_file = "SELECT SEQ, SUN, L_CODE FROM $T_M_MENU WHERE SEQ = $SEQ AND L_CODE = $L_CODE ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_M_MENU SET SUN = SUN-1 WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND L_CODE = $L_CODE";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_M_MENU SET SUN = SUN+1 WHERE SEQ <> $SEQ AND L_CODE = $L_CODE AND SUN = $ROW[SUN]-1";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if( $CATEGORY == "2"){ 
		$proc_file = "SELECT SEQ, SUN, L_CODE, M_CODE FROM $T_S_MENU WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND M_CODE = $M_CODE";
		$proc_file .= " ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_S_MENU SET SUN = SUN-1";
		$proc_edit .=" WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND L_CODE = $L_CODE AND M_CODE = $M_CODE";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_S_MENU SET SUN = SUN+1";
		$proc_edit .=" WHERE SEQ <> $SEQ AND L_CODE = $L_CODE AND M_CODE = $M_CODE AND SUN = $ROW[SUN]-1";
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
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "MOVE_DOWN"){
	if($CATEGORY == "0"){ 
		$proc_file = "SELECT SEQ, SUN FROM $T_L_MENU WHERE SEQ = $SEQ ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_L_MENU SET SUN = SUN+1 WHERE SEQ = $SEQ";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_L_MENU SET SUN = SUN-1 WHERE SEQ <> $SEQ AND SUN = $ROW[SUN]+1";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if($CATEGORY == "1"){
		$proc_file = "SELECT SEQ, SUN, L_CODE FROM $T_M_MENU WHERE SEQ = $SEQ AND L_CODE = $L_CODE ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_M_MENU SET SUN = SUN+1 WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND L_CODE = $L_CODE";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_M_MENU SET SUN = SUN-1 WHERE SEQ <> $SEQ AND L_CODE = $L_CODE AND SUN = $ROW[SUN]+1";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	}else if( $CATEGORY == "2"){ 
		$proc_file = "SELECT SEQ, SUN, L_CODE, M_CODE FROM $T_S_MENU WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND M_CODE = $M_CODE";
		$proc_file .= " ORDER BY SUN ASC";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
		$proc_edit = "UPDATE IGNORE $T_S_MENU SET SUN = SUN+1";
		$proc_edit .=" WHERE SEQ = $SEQ AND L_CODE = $L_CODE AND L_CODE = $L_CODE AND M_CODE = $M_CODE";
		$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
		$proc_edit = "UPDATE IGNORE $T_S_MENU SET SUN = SUN-1";
		$proc_edit .=" WHERE SEQ <> $SEQ AND L_CODE = $L_CODE AND M_CODE = $M_CODE AND SUN = $ROW[SUN]+1";
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
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "M_USED"){
	/*빈값등록방지코드*/
	if(trim($USE_YN)==''){
			echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
			exit;
	}
	$proc_edit = "UPDATE $TABLE_NM SET USE_YN = '$USE_YN' WHERE SEQ = $SEQ";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
if($MODE == "M_STOP"){
	/*빈값등록방지코드*/
	if(trim($USE_YN)==''){
			echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
			exit;
	}
	$proc_edit = "UPDATE $TABLE_NM SET USE_YN = '$USE_YN' WHERE SEQ = $SEQ";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";exit;
	}
}
?>