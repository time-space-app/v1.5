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
<?php /*아이디 자동등록코드*/
if($_POST['LOGIN_ID'] == ""){
	$proc_id = "SELECT COUNT(LOGIN_ID) AS MAXCNT";
	$proc_id .= " FROM T_MEMBER";
	$proc_id .= " WHERE CONVERT(LOGIN_ID,UNSIGNED) >= 100001";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_id);
	$MAXCNT=$ROW['MAXCNT'];
	if($MAXCNT==0){ 
		$_POST['LOGIN_ID'] = "100001"; 
		$_POST['LOGIN_PWD'] = "100001"; 
	}else{ 
		$proc_id = "SELECT MAX(LOGIN_ID) AS MAX_ID";
		$proc_id .= " FROM T_MEMBER";
		$proc_id .= " WHERE CONVERT(LOGIN_ID,UNSIGNED) > 0";
		$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_id); 
		$MAX_ID=$ROW['MAX_ID']+1;
		$_POST['LOGIN_ID'] = $MAX_ID; 
		$_POST['LOGIN_PWD'] = $MAX_ID; 
	} 
	//echo "<script type='text/javascript'>alert('필수 입력값이 빠졌습니다.');</script>";
	//echo "<meta http-equiv='Refresh' content='0;url=list.php?now_page=$now_page&GUBN=$GUBN&SEARCH=$SEARCH&BOARD_ID=$BOARD_ID&MODE=list'>";
	//exit;
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
	//$EMAIL = $EMAIL0."@".$EMAIL1;
}
if(count($_POST['VISIT_INFO']) > 0){
	foreach ($_POST['VISIT_INFO'] as $value){
		$VISIT_INFO .= "$value,"; //디버그
	}
}
	$VISIT_INFO = substr($VISIT_INFO, 0, -1);
	$EMAIL = $EMAIL0."@".$EMAIL1;
	$HP_NO = $HP0."-".$HP1."-".$HP2;
	$PROFILE_EXPERT= ($PROFILE_EXPERT !="")?implode(',',$PROFILE_EXPERT):"";
	//$VISIT_INFO= ($VISIT_INFO !="")?implode(',',$VISIT_INFO ):"";
/*
if(isset($_POST['AGREE_YN']) && ($_POST['AGREE_YN']!="false")) $AGREE_YN="true";
if(isset($_POST['HP_YN']) && ($_POST['HP_YN']!="false")) $HP_YN="true";
if(isset($_POST['EMAIL_YN']) && ($_POST['EMAIL_YN']!="false")) $EMAIL_YN="true";
*/
//echo $post_var."<br>".$PROFILE_EXPERT."<br>비지트".$VISIT_INFO;
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

//echo $post_var;
//exit; //디버그
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
	$proc_save .= "LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,AGREE_YN,EMAIL_YN,CREATE_DT";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$LOGIN_ID'";
	$proc_save .=" ,sha1('$LOGIN_PWD')";
	$proc_save .=" ,'$USER_NM'";
	$proc_save .=" ,'$USER_LEVEL'";
	$proc_save .=" ,'$USE_YN'";
	$proc_save .=" ,'$EMAIL'";
	$proc_save .=" ,'on'";
	$proc_save .=" ,'on'";
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
	$proc_edit .=" ,UPDATE_DT = NOW()";
	$proc_edit .=" WHERE LOGIN_ID = '$LOGIN_ID'";
	$i = 0;
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
if($MODE=="delete_checked"){
		//echo $_POST["SEQS"];exit;//디버그
		$SEQS= explode(',',($_POST["SEQS"]));
		for ($x = 0; $x < count($SEQS)-1; $x++){
	  	$proc_delete = "DELETE FROM T_MEMBER";
		$proc_delete .= " WHERE LOGIN_ID = '$SEQS[$x]'";
		$i = 0;
		$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
		}
	$i = $GPLdb5->GPLmysql_affected_rows();
	//$i=1;//디버그
	if($i>0){
		echo "<script type='text/javascript'>alert(\"CHECHED DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
	}
	else 
	{
		echo "<script type='text/javascript'>alert('CHECHED DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=list.php'>";
	}
exit;
}
?>
<?php
if($MODE=="excel_checked"){
//echo $_POST["SEQS"];exit;//디버그
/*
	$proc_select = "SELECT * FROM T_MEMBER ORDER BY CREATE_DT DESC";  
	$result = $GPLdb5->GPLexcute_query($proc_select); //결과값 리턴
	$cnt = $GPLdb5->GPLmysql_affected_rows();
	if (!$cnt) {
	    alert("출력할 내역이 없습니다.");
	}
 	require_once $_SERVER['DOCUMENT_ROOT'].'/PHPExcel/Classes/PHPExcel.php';
	$objPHPExcel = new PHPExcel();
	
	$sheet      = $objPHPExcel->getActiveSheet();
	
	// 글꼴
	$sheet->getDefaultStyle()->getFont()->setName('맑은 고딕');
	
	$sheetIndex = $objPHPExcel->setActiveSheetIndex(0);
	
	// 제목
	$sheetIndex->setCellValue('A1',$subtitle.' 예약확인');
	$sheetIndex->mergeCells('A1:H1');
	$sheetIndex->getStyle('A1')->getFont()->setSize(20)->setBold(true);
	$sheetIndex->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 부제목
	$sheetIndex->setCellValue('A2',$ROW['USER_NM'].'('.$ROW['USER_ID'].')');
	$sheetIndex->mergeCells('A2:H2');
	$sheetIndex->getStyle('A2')->getFont()->setSize(12)->setBold(true);
	$sheetIndex->getStyle('A2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	// 내용
	$sheetIndex ->setCellValue('A3', '여관선택')
	->setCellValue('B3', $subtitle)
	->setCellValue('A4', '체크인날짜')
	->setCellValue('B4', $ROW['TITLE'])               
	->setCellValue('A5', '체크인시간')
	->setCellValue('B5', $ROW['CK_HOUR'].'시 '.$ROW['CK_MIN'].'분')
	->setCellValue('A6', '숙박일수')
	->setCellValue('B6', $ROW['STAY_NUM'])
	->setCellValue('A7', '객실 수')
	->setCellValue('B7', $ROW['ROOM_NUM'])
	->setCellValue('A8', '사람 수')
	->setCellValue('B8', '성인남성 '.$ROW['MAN_1'].' 명 / 성인여성 '.$ROW['WOMAN_1'].' 명')            
	->setCellValue('A9', '숙박자대표이름')
	->setCellValue('B9', $ROW['USER_NM'])
	->setCellValue('A10', '숙박자대표영문이름')
	->setCellValue('B10', $ROW['NAME_EN'])
	->setCellValue('A11', '숙박자대표생일')
	->setCellValue('B11', $ROW['BIRTH_DAY'])
	->setCellValue('A12', 'E-MAIL')
	->setCellValue('B12', '수신동의('.$ROW['EMAIL_YN'].') '.$ROW['EMAIL'])
	->setCellValue('A13', '전화번호')
	->setCellValue('B13', $ROW['GUEST_TEL'])
	->setCellValue('A14', '주소')
	->setCellValue('B14', $ROW['GUEST_ADDR_ID'].' '.$ROW['GUEST_ADDRESS'])
	->setCellValue('A15', '요청/희망사항')
	->setCellValue('B15', str_replace("<br/>", "\r\n",$ROW['CONTENT']));
	
	function utf2euc($str) { return iconv("UTF-8","cp949//IGNORE", $str); }
	function is_ie() { return isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false; }
	$output_file_name = $ROW['USER_NM'].$subtitle.$ROW['TITLE']."예약.xls";
	if( is_ie() ) $output_file_name = utf2euc($output_file_name);
	header( "Content-type: application/vnd.ms-excel" );
	header( "Content-Disposition: attachment; filename={$output_file_name}" );
	header('Cache-Control: max-age=0');
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
     exit;
*/
$SEQS= explode(',',($_POST["SEQS"]));
if(trim($_POST["SEQS"])!==""){
	for ($x = 0; $x < count($SEQS)-1; $x++){
		if($x<(count($SEQS)-2))
		$checked_id.= "'".$SEQS[$x]."',";
		else
		$checked_id.= "'".$SEQS[$x]."'";
	}
//echo $checked_id; exit;//디버그
$proc_select = "SELECT * FROM T_MEMBER WHERE LOGIN_ID IN (".$checked_id.")"; 
$proc_select .= " ORDER BY CREATE_DT DESC"; 
//exit;/디버그
}else{
$proc_select = "SELECT * FROM T_MEMBER ORDER BY CREATE_DT DESC";  
}
$result = $GPLdb5->GPLexcute_query($proc_select); //결과값 리턴
$cnt = $GPLdb5->GPLmysql_affected_rows();
if (!$cnt) {
    echo "<script>alert('출력할 내역이 없습니다.');</script>";
}
/** PHPExcel */
 require_once $_SERVER['DOCUMENT_ROOT'].'/PHPExcel/Classes/PHPExcel.php';
/* PHPExcel.php 파일의 경로를 정확하게 지정해준다. */
 
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
 
// Set properties
// Excel 문서 속성을 지정해주는 부분이다. 적당히 수정하면 된다.
$objPHPExcel->getProperties()->setCreator("작성자")
                             ->setLastModifiedBy("최종수정자")
                             ->setTitle("회원리스트")
                             ->setSubject("회원리스트")
                             ->setDescription("회원리스트")
                             ->setKeywords("회원")
                             ->setCategory("License");
 
// Add some data
// Excel 파일의 각 셀의 타이틀을 정해준다.
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A1", "아이디")
            ->setCellValue("B1", "이름")
            ->setCellValue("C1", "이메일")
            ->setCellValue("D1", "로그인")
            ->setCellValue("E1", "등록일시");
 
// for 문을 이용해 DB에서 가져온 데이터를 순차적으로 입력한다.
// 변수 i의 값은 2부터 시작하도록 해야한다.while($row = mysqli_fetch_array($result)) { 
for ($i=2; $row=mysqli_fetch_array($result); $i++)
{   
    // Add some data
    $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A$i", "$row[LOGIN_ID]")
                ->setCellValue("B$i", "$row[USER_NM]")
                ->setCellValue("C$i", "$row[USER_EMAIL]")
                ->setCellValue("D$i", "$row[USE_YN]")
                ->setCellValue("E$i", "$row[CREATE_DT]");
}

 
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("회원리스트");
 
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
 
// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
$filename = iconv("UTF-8", "EUC-KR", "회원리스트");
 
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
ob_end_clean();
header('Cache-Control: max-age=0');
 
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
}
?>