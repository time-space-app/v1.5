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
if (isset($_POST['search_email']) && $_POST['search_email']!="")
{
  $search_email = $_POST['search_email'];
  //일반쿼리 사용 (단일출력)
  $search_email = $GPLdb5->GPLescape_check($search_email); //sql 인젝션 방지 사용
  $SQL = "SELECT LOGIN_ID, USER_NM, USER_LEVEL, USER_EMAIL FROM T_MEMBER";
  $SQL .= " WHERE USER_EMAIL = '$search_email'";
  $SQL .= " AND USER_LEVEL > 3";
  //$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
  $row = $GPLdb5->GPLquery_fetch_assoc($SQL);
	  if (count($row) >0 )
	  {
	  	for($line = 0; $line < count($row); $line++){
		  	echo "검색된 아이디는 <strong>".$row[$line]['LOGIN_ID']."</strong> 입니다.";
		  	echo "<br/>";
	  	}
	  	//echo "총 검색된 아이디는 ".count($row)." 건 입니다.";
	  	//echo "검색된 아이디는 <strong>".$row['LOGIN_ID']."</strong> 입니다.";
	  }else{
	  	echo "검색된 값이 없습니다.";
	  }

} else {
	echo "email 입력란에 값이 없습니다.";
}
?>