<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
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
if(strpos( $_SERVER['REQUEST_URI'] , "/SEQ/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "/SEQ" ));
$_REQUEST['SEQ']=str_replace(" ","",$arr_param[2]);//echo $SEQ.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "BOARD_SEQ/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "BOARD_SEQ" ));
$_REQUEST['BOARD_SEQ']=str_replace(" ","",$arr_param[1]);//echo $BOARD_SEQ.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "now_page/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "now_page" ));
$now_page=str_replace(" ","",$arr_param[1]);//echo $now_page.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "GUBN/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "GUBN" ));
$GUBN=str_replace(" ","",$arr_param[1]);//echo $GUBN.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "SEARCH/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "SEARCH" ));
$SEARCH=urldecode(str_replace(" ","",$arr_param[1]));//echo $SEARCH.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "/MODE/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "/MODE" ));
$MODE=str_replace(" ","",$arr_param[2]);//echo $MODE.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "CATEGORY/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "CATEGORY" ));
$CATEGORY=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
if(strpos( $_SERVER['REQUEST_URI'] , "COMMENT_MODE/" )){
$arr_param= explode('/',strstr( $_SERVER['REQUEST_URI'] , "COMMENT_MODE" ));
$_REQUEST['COMMENT_MODE']=str_replace(" ","",$arr_param[1]);//echo $MODE.'<br/>';
}
//echo $COMMENT_MODE;
//exit;
?>
<?php //메뉴값 바인딩
//게시판 공통변수 항상 페이지 상단에 위치
$MENU_CODE= str_replace(" ","",$_REQUEST['MENU_CODE']);
$L_CODE= SUBSTR($MENU_CODE,0,3);
$M_CODE= SUBSTR($MENU_CODE,3,3);
$S_CODE= SUBSTR($MENU_CODE,6,3);
?>
<?php /*자동등록방지코드*/
if($_SESSION['valid_user'] == ""){
if($_POST['SE_NUM1']=='' || $_POST['SE_NUM2']=='' || trim($_POST['SE_NUM1'])+trim($_POST['SE_NUM2'])!=trim($_POST['SE_NUM'])){
		echo "<script type='text/javascript'>alert('보안코드=INSERT NOT NULL OR WRONG.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/list'>";
		exit;
	}
		echo "<script type='text/javascript'>alert('보안코드=로그인 Only.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/list'>";
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
$CONTENT = str_replace("\r\n", "<br/>",$CONTENT);
$COMMENTS = str_replace("\r\n", "<br/>",$COMMENTS);
//echo $post_var;
//exit; //디버그
//파일 삭제 처리 시작
if($FILE_DEL0=="FILE_DEL0"){
	//첨부파일 삭제시작
	$proc_delete = "DELETE FROM T_ATTACH_FILE WHERE BOARD_SEQ = '$BOARD_SEQ'";
	$proc_delete .= " AND BOARD_ID = '$BOARD_ID'";
	$proc_delete .= " AND SEQ = '$FILE_NUM0'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		$FILECNT = $FILECNT - 1;
	}
	if($FILE_NM0 != ""){
		$upLoad  = "../../time-space/upload/$BOARD_ID/".iconv('UTF-8','EUC-KR',$FILE_NM0); // 중복체크전 업로드 경로+한글파일명
		$exist = file_exists("$upLoad");    //파일있는지 검사
		if($exist) @unlink($upLoad);		 //파일을 삭제한다
	}
}
if($FILE_DEL1=="FILE_DEL1"){
	//첨부파일 삭제시작
	$proc_delete = "DELETE FROM T_ATTACH_FILE WHERE BOARD_SEQ = '$BOARD_SEQ'";
	$proc_delete .= " AND BOARD_ID = '$BOARD_ID'";
	$proc_delete .= " AND SEQ = '$FILE_NUM1'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		$FILECNT = $FILECNT - 1;
	}
	if($FILE_NM1 != ""){
		$upLoad  = "../../time-space/upload/$BOARD_ID/".iconv('UTF-8','EUC-KR',$FILE_NM1); // 중복체크전 업로드 경로+한글파일명
		$exist = file_exists("$upLoad");    //파일있는지 검사
		if($exist) @unlink($upLoad);		 //파일을 삭제한다
	}
}
//고유ID생성
if($BOARD_SEQ==""){
	$proc_file = "SELECT MAX(SEQ) AS BOARD_SEQ";
	$proc_file .= " FROM T_BOARD";
	$proc_file .= " WHERE BOARD_ID = '$BOARD_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	$BOARD_SEQ=$ROW['BOARD_SEQ'];
}
//echo $BOARD_SEQ;
//exit; //디버그
//첨부파일1 처리 시작
if($_FILES["FILEUPLOAD0"]["tmp_name"]) {
	if($MODE == "write")$SEQ = $BOARD_SEQ+1; else $SEQ = $BOARD_SEQ; //최신글 번호 구하기
	$tmp_name = $_FILES["FILEUPLOAD0"]["tmp_name"];
	$FILE_NM = $_FILES["FILEUPLOAD0"]["name"];
	$realfilename=date("YmdHms").$FILE_NM;//POST로 받은 파일명 중복방지 코드
	$FILE_SAVE_NM = strtolower($realfilename); //대문자->소문자 윈도우에서 대소문자 같은 파일명 중복방지처리
	$upLoad  = "../../time-space/upload/$BOARD_ID/".iconv('UTF-8','EUC-KR',$FILE_SAVE_NM); // 중복체크전 업로드 경로+한글파일명
	$exist = file_exists("$upLoad");    //파일있는지 검사
	if($exist) @unlink($upLoad);		 //중복된 파일을 삭제한다
	move_uploaded_file($tmp_name, $upLoad);
	$SQL = "SELECT MAX(SEQ) AS FILE_SEQ FROM T_ATTACH_FILE";
	$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	$FILE_SEQ = $row['FILE_SEQ']+1; //최신글 번호 구하기
	$proc_save = "INSERT INTO T_ATTACH_FILE (";
	$proc_save .= "SEQ,FILE_NM,BOARD_SEQ,BOARD_ID,CREATE_ID,CREATE_DT";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$FILE_SEQ'";
	$proc_save .=" ,'$FILE_SAVE_NM'";
	$proc_save .=" ,'$SEQ'";
	$proc_save .=" ,'$BOARD_ID'";
	$proc_save .=" ,'$USER_ID'";
	$proc_save .=" ,DATE_FORMAT(NOW(), '%Y-%m-%d')";
	$proc_save .= ")";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
			$FILECNT = $FILECNT + 1;
	}
}
//첨부파일2 처리 시작
if($_FILES["FILEUPLOAD1"]["tmp_name"]) {
	if($MODE == "write")$SEQ = $BOARD_SEQ+1; else $SEQ = $BOARD_SEQ; //최신글 번호 구하기
	$tmp_name = $_FILES["FILEUPLOAD1"]["tmp_name"];
	$FILE_NM = $_FILES["FILEUPLOAD1"]["name"];
	$realfilename=date("YmdHms").$FILE_NM;//POST로 받은 파일명 중복방지 코드
	$FILE_SAVE_NM = strtolower($realfilename); //대문자->소문자 윈도우에서 대소문자 같은 파일명 중복방지처리
	$upLoad  = "../../time-space/upload/$BOARD_ID/".iconv('UTF-8','EUC-KR',$FILE_SAVE_NM); // 중복체크전 업로드 경로+한글파일명
	$exist = file_exists("$upLoad");    //파일있는지 검사
	if($exist) @unlink($upLoad);		 //중복된 파일을 삭제한다
	move_uploaded_file($tmp_name, $upLoad);
	$SQL = "SELECT MAX(SEQ) AS FILE_SEQ FROM T_ATTACH_FILE";
	$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	$FILE_SEQ = $row['FILE_SEQ']+1; //최신글 번호 구하기
	$proc_save = "INSERT INTO T_ATTACH_FILE (";
	$proc_save .= "SEQ,FILE_NM,BOARD_SEQ,BOARD_ID,CREATE_ID,CREATE_DT";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$FILE_SEQ'";
	$proc_save .=" ,'$FILE_SAVE_NM'";
	$proc_save .=" ,'$SEQ'";
	$proc_save .=" ,'$BOARD_ID'";
	$proc_save .=" ,'$USER_ID'";
	$proc_save .=" ,DATE_FORMAT(NOW(), '%Y-%m-%d')";
	$proc_save .= ")";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
			$FILECNT = $FILECNT + 1;
	}
}
//
//echo $COMMENT_MODE."여기";
//exit; //디버그
if ( $FILECNT < 0 || is_null($FILECNT) || empty($FILECNT) ) {$FILECNT=0;}
if($MODE == "write"){
	$SEQ = $BOARD_SEQ+1; //최신글 번호 구하기
	$proc_save = "INSERT INTO T_BOARD (";
	$proc_save .= "SEQ,BOARD_ID,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE,FILECNT,POPUP,POPUP_W,POPUP_H,TOP_NEWS";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$SEQ'";
	$proc_save .=" ,'$BOARD_ID'";
	$proc_save .=" ,'$USER_ID'";
	$proc_save .=" ,'$USER_NM'";
	$proc_save .=" ,'$EMAIL'";
	$proc_save .=" ,'$TITLE'";
	$proc_save .=" ,'$CONTENT'";
	$proc_save .=" ,NOW()";
	$proc_save .=" ,$FILECNT";
	$proc_save .=" ,'$POPUP'";
	$proc_save .=" ,'$POPUP_W'";
	$proc_save .=" ,'$POPUP_H'";
	$proc_save .=" ,'$TOP_NEWS'";
	$proc_save .= ")";
	$i = 0;
	//echo $proc_save;
	//exit; //디버그
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		if($_SESSION['valid_level'] > 3||$BOARD_ID=="qa") {
			$todaydate=date('Y-m-d');
			$comment1 ="
			Date :$todaydate\r\n
			FromName :$USER_NM\r\n
			ToName :Webmaster\r\n
			Subject :$TITLE.'문의'\r\n
			Contents :$CONTENT ";
			$comment2=nl2br($comment1);
			$to = "mohta6500@japan-explore.net"; 
			$fname = $USER_ID; 
			$mail_from=$EMAIL; 
			$subject = $TITLE.'문의';
			$subject = "=?UTF-8?B?".base64_encode($subject)."?="."\r\n"; 
			$header ="Content-Type: text/html; charset=UTF-8\r\n"; 
			$header .= "From: $fname <$mail_from>\n"; 
			$body = $comment2; 
			$result=mail($to, $subject, $body, $header, '-f'.$mail_from);
			/* 디버그
			if(!$result){
			   echo "<script>
			         alert('Sending Error!');
			         </script>";
			   }else{
			   echo "<script>
			         alert('Sending OK!');
			         </script>";
			 }*/
		 }

		echo "<script type='text/javascript'>alert('SAVE OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/list'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('SAVE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/list'>";
	}
}
if($MODE == "edit"){
	$proc_edit = "UPDATE T_BOARD SET";
	$proc_edit .=" USER_NM ='$USER_NM'";
	$proc_edit .=" ,EMAIL ='$EMAIL'";
	$proc_edit .=" ,TITLE ='$TITLE'";
	$proc_edit .=" ,CONTENT ='$CONTENT'";
	$proc_edit .=" ,FILECNT =$FILECNT";
	$proc_edit .=" ,STATE ='$STATE'";
	$proc_edit .=" ,POPUP ='$POPUP'";
	$proc_edit .=" ,POPUP_W ='$POPUP_W'";
	$proc_edit .=" ,POPUP_H ='$POPUP_H'";
	$proc_edit .=" ,TOP_NEWS ='$TOP_NEWS'";
	$proc_edit .=" WHERE SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	//echo $proc_edit;exit;//디버그
	if($i>0){
		if($BOARD_ID=="repair" && $_SESSION['valid_level'] > 2) {
			/*$todaydate=date('Y-m-d');
			$comment1 ="
			Date :$todaydate\r\n
			FromName :$USER_NM\r\n
			ToName :Manager\r\n
			Subject :$TITLE\r\n
			Contents :$CONTENT ";
			$comment2=nl2br($comment1);
			$to = "kimilguk@yahoo.co.kr"; 
			$fname = $USER_ID; 
			$mail_from=$EMAIL; 
			//$subject = $TITLE;
			$subject = "=?UTF-8?B?".base64_encode($subject)."?="."\r\n"; 
			$header ="Content-Type: text/html; charset=UTF-8\r\n"; 
			$header .= "From: $fname <$mail_from>\n"; 
			$body = $comment2; 
			$result=mail($to, $subject, $body, $header, '-f'.$mail_from);*/
			/*
			if(!$result){
			   echo "<script>
			         alert('Sending Error!');
			         </script>";
			   }else{
			   echo "<script>
			         alert('Sending OK!');
			         </script>";
			 }*/
		}
		echo "<script type='text/javascript'>alert('EDIT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/SEQ/$BOARD_SEQ'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('EDIT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/SEQ/$BOARD_SEQ'>";
	}
}

if($MODE == "delete"){
	$proc_delete = "DELETE FROM T_BOARD_COMMENT WHERE BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$proc_delete = "DELETE FROM T_BOARD WHERE SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
	$i = 0;
    $result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE/BOARD_ID/$BOARD_ID'>";
	}
	else 
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/list.html/MENU_CODE/$MENU_CODE'>";
	}
exit;
}

if($_REQUEST['COMMENT_MODE'] == "write"){
	$SQL = "SELECT MAX(SEQ) AS COMMENT_SEQ FROM T_BOARD_COMMENT";
	$SQL .=" WHERE BOARD_SEQ = '$BOARD_SEQ'";
	$SQL .=" AND BOARD_ID = '$BOARD_ID'";
	$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	$COMMENT_SEQ = $row['COMMENT_SEQ']+1; //최신글 번호 구하기
	$proc_save = "INSERT INTO T_BOARD_COMMENT (";
	$proc_save .= "SEQ,BOARD_SEQ,BOARD_ID,USER_ID,USER_NM,COMMENTS,REGDATE";
	$proc_save .= ") VALUES (";
	$proc_save .=" '$COMMENT_SEQ'";
	$proc_save .=" ,'$BOARD_SEQ'";
	$proc_save .=" ,'$BOARD_ID'";
	$proc_save .=" ,'$USER_ID'";
	$proc_save .=" ,'$USER_NM'";
	$proc_save .=" ,'$COMMENTS'";
	$proc_save .=" ,DATE_FORMAT(NOW(), '%Y-%m-%d')";
	$proc_save .= ")";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	$i2 = 0;
	$proc_edit = "UPDATE T_BOARD SET";
	$proc_edit .=" STATE ='$STATE'";
	$proc_edit .=" WHERE SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i2 = $GPLdb5->GPLmysql_affected_rows();
	if($i>0 || $i2>0){
		echo "<script type='text/javascript'>alert('SAVE OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/SEQ/$BOARD_SEQ/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/view'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('SAVE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/SEQ/$BOARD_SEQ/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/view'>";
	}
}
if($_REQUEST['COMMENT_MODE'] == "edit"){
	$proc_edit = "UPDATE T_BOARD_COMMENT SET";
	$proc_edit .=" USER_NM ='$USER_NM'";
	$proc_edit .=" ,USER_ID ='$USER_ID'";
	$proc_edit .=" ,COMMENTS ='$COMMENTS'";
	$proc_edit .=" ,REGDATE =DATE_FORMAT(NOW(), '%Y-%m-%d')";
	$proc_edit .=" WHERE SEQ = '$SEQ'";
	$proc_edit .=" AND BOARD_SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	$i2 = 0;
	$proc_edit = "UPDATE T_BOARD SET";
	$proc_edit .=" STATE ='$STATE'";
	$proc_edit .=" WHERE SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	$i2 = $GPLdb5->GPLmysql_affected_rows();
	if($i>0 || $i2>0){
		echo "<script type='text/javascript'>alert('COMMENT OK.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/SEQ/$BOARD_SEQ'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('COMMENT FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/SEQ/$BOARD_SEQ'>";
	}
}
if($_REQUEST['COMMENT_MODE'] == "delete"){
	$SEQ = $_REQUEST['SEQ'];
	$BOARD_SEQ = $_REQUEST['BOARD_SEQ'];
	$BOARD_ID = $_REQUEST['BOARD_ID'];
	$proc_delete = "DELETE FROM T_BOARD_COMMENT WHERE SEQ = '$SEQ' AND BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID' AND USER_ID ='".$_SESSION['valid_user']."'";
	$i = 0;
	$result = $GPLdb5->GPLexcute_query($proc_delete); //결과값 리턴
	$i = $GPLdb5->GPLmysql_affected_rows();
	if($i>0){
		echo "<script type='text/javascript'>alert(\"DELETE OK.\");</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/SEQ/$BOARD_SEQ/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/view'>";
	}
	else
	{
		echo "<script type='text/javascript'>alert('DELETE FAIL.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/_metro/board/view.html/MENU_CODE/$MENU_CODE/SEQ/$BOARD_SEQ/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/view'>";
	}
	exit;
}
?>