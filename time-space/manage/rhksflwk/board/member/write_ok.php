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
<?php /*자동등록방지코드*/
if($_SESSION['valid_user'] == ""){
if($_POST['SE_NUM1']=='' || $_POST['SE_NUM2']=='' || trim($_POST['SE_NUM1'])+trim($_POST['SE_NUM2'])!=trim($_POST['SE_NUM'])){
		echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.html?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&BOARD_ID=$BOARD_ID&MODE=list'>";
		exit;
	}
}
?>
<?php /*자동등록방지코드*/
if($_POST['LOGIN_ID'] == ""){
		echo "<script type='text/javascript'>alert('필수 입력값이 빠졌습니다.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&BOARD_ID=$BOARD_ID&MODE=list'>";
		exit;
}
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
	$EMAIL = $EMAIL0."@".$EMAIL1;
	$HP_NO = $HP0."-".$HP1."-".$HP2;
	$PROFILE_EXPERT= ($PROFILE_EXPERT !="")?implode(',',$PROFILE_EXPERT):"";
	$VISIT_INFO= ($VISIT_INFO !="")?implode(',',$VISIT_INFO ):"";
/*
if(isset($_POST['AGREE_YN']) && ($_POST['AGREE_YN']!="false")) $AGREE_YN="true";
if(isset($_POST['HP_YN']) && ($_POST['HP_YN']!="false")) $HP_YN="true";
if(isset($_POST['EMAIL_YN']) && ($_POST['EMAIL_YN']!="false")) $EMAIL_YN="true";
*/
//echo $post_var."<br>".$PROFILE_EXPERT."<br>".$VISIT_INFO;
//exit; //디버그
$CONTENT = str_replace("\r\n", "<br/>",$CONTENT);
$COMMENTS = str_replace("\r\n", "<br/>",$COMMENTS);
$PROFILE_INFO= str_replace("\r\n", "<br/>",$PROFILE_INFO);
//첨부파일1 처리 시작
if($_FILES["FILEUPLOAD0"]["tmp_name"]) {
	$tmp_name = $_FILES["FILEUPLOAD0"]["tmp_name"];
	$FILE_NM = $_FILES["FILEUPLOAD0"]["name"];
	$ext = strtolower(substr($FILE_NM, (strrpos($FILE_NM, '.') + 1)));
		if ('jpg' != $ext && 'jpeg' != $ext && 'gif' != $ext && 'png' != $ext) {
			echo "<script type='text/javascript'>alert('IMAGE ONLY.');</script>";
			echo "<meta http-equiv='Refresh' content='0;url=list.html?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&BOARD_ID=$BOARD_ID&MODE=list'>";
			exit;
			return false;
		}
	$realfilename=$LOGIN_ID.".jpg";//POST로 받은 파일명 중복방지 코드
	$FILE_SAVE_NM = strtolower($realfilename); //대문자->소문자 윈도우에서 대소문자 같은 파일명 중복방지처리
	$upLoad  = "../../../../upload/profile/".iconv('UTF-8','EUC-KR',$FILE_SAVE_NM); // 중복체크전 업로드 경로+한글파일명
	$exist = file_exists("$upLoad");    //파일있는지 검사
	if($exist) @unlink($upLoad);		 //중복된 파일을 삭제한다
	move_uploaded_file($tmp_name, $upLoad);
}
if($MODE == "write"){
	//ID 중복방지
	$proc_file = "SELECT COUNT(LOGIN_ID) AS DUPCNT";
	$proc_file .= " FROM T_MEMBER";
	$proc_file .= " WHERE LOGIN_ID = '$LOGIN_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$DUPCNT=$ROW['DUPCNT'];
	if($DUPCNT>0){
		echo "<script type='text/javascript'>alert('SAVE FAIL. ID ALREADY EXISTS.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&BOARD_ID=$BOARD_ID&MODE=list'>";
		exit;
	}
	$proc_save = "INSERT INTO T_MEMBER (";
	$proc_save .= "LOGIN_ID,LOGIN_GUBN,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,EMAIL_YN,AGREE_YN,HP_NO,HP_YN";
	$proc_save .= ",PROFILE_TITLE,PROFILE_INFO,PROFILE_EXPERT,VISIT_INFO,CREATE_DT";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$LOGIN_ID'";
	$proc_save .=" ,'$LOGIN_GUBN'";
	$proc_save .=" ,sha1('$LOGIN_PWD')";
	$proc_save .=" ,'$USER_NM'";
	$proc_save .=" ,'$USER_LEVEL'";
	$proc_save .=" ,'$USE_YN'";
	$proc_save .=" ,'$EMAIL'";
	$proc_save .=" ,'$EMAIL_YN'";
	$proc_save .=" ,'$AGREE_YN'";
	$proc_save .=" ,'$HP_NO'";
	$proc_save .=" ,'$HP_YN'";
	$proc_save .=" ,'$PROFILE_TITLE'";
	$proc_save .=" ,'$PROFILE_INFO'";
	$proc_save .=" ,'$PROFILE_EXPERT'";
	$proc_save .=" ,'$VISIT_INFO'";
	$proc_save .=" ,NOW()";
	$proc_save .= ")";
	$i = 0;
	//echo $proc_save;
	//exit; //디버그
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('SAVE OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&MODE=list'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('SAVE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&MODE=list'>";
	}
}
if($MODE == "edit"){
	$proc_edit = "UPDATE T_MEMBER SET";
	$proc_edit .=" USER_NM ='$USER_NM'";
	if($LOGIN_PWD!='')
	$proc_edit .=" ,LOGIN_PWD =sha1('$LOGIN_PWD')";
	$proc_edit .=" ,USER_LEVEL ='$USER_LEVEL'";
	$proc_edit .=" ,USE_YN ='$USE_YN'";
	$proc_edit .=" ,USER_EMAIL ='$EMAIL'";
	$proc_edit .=" ,EMAIL_YN ='$EMAIL_YN'";
	$proc_edit .=" ,LOGIN_GUBN='$LOGIN_GUBN'";
	$proc_edit .=" ,AGREE_YN='$AGREE_YN'";
	$proc_edit .=" ,HP_NO='$HP_NO'";
	$proc_edit .=" ,HP_YN='$HP_YN'";
	$proc_edit .=" ,PROFILE_TITLE='$PROFILE_TITLE'";
	$proc_edit .=" ,PROFILE_INFO ='$PROFILE_INFO'";
	$proc_edit .=" ,PROFILE_EXPERT='$PROFILE_EXPERT'";
	$proc_edit .=" ,VISIT_INFO='$VISIT_INFO'";
	
	$proc_edit .=" ,UPDATE_DT = NOW()";
	$proc_edit .=" WHERE LOGIN_ID = '$LOGIN_ID'";
	$i = 0;
	//echo $proc_edit;
	//exit; //디버그
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=view.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&LOGIN_ID=$LOGIN_ID'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=view.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&LOGIN_ID=$LOGIN_ID'>";
	}
}

if($MODE == "delete"){
	$proc_delete = "DELETE FROM T_MEMBER WHERE LOGIN_ID = '$LOGIN_ID'";
	$i = 0;
    $result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
	}
exit;
}
?>