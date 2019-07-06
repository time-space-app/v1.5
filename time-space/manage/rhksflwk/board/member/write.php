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
//게시판 공통변수 항상 페이지 상단에 위치
$GUBN = $_REQUEST['GUBN'];
$SEARCH = $_REQUEST['SEARCH'];
$MODE = $_REQUEST['MODE'];
$LOGIN_ID = $_REQUEST['LOGIN_ID'];
$now_page = $_REQUEST['now_page'];
//===========================
if($MODE == "edit"){ 
	$proc_file = "SELECT";
	$proc_file .= " LOGIN_ID,LOGIN_GUBN,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL,EMAIL_YN,AGREE_YN,HP_NO,HP_YN";
	$proc_file .= " ,PROFILE_TITLE,PROFILE_INFO,PROFILE_EXPERT,VISIT_INFO";
	$proc_file .= " FROM T_MEMBER";
	$proc_file .= " WHERE LOGIN_ID = '$LOGIN_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
	//$ROW = array_reverse($ROW, true);
	$EMAIL=$ROW['USER_EMAIL'];
	$HP=$ROW['HP_NO'];
	$PROFILE_EXPERT=$ROW['PROFILE_EXPERT'];
	$VISIT_INFO=$ROW['VISIT_INFO'];
	$arremail = explode("@",$EMAIL);
	$arrhp = explode("-",$HP);
}
?>
<?php /*자동등록방지코드*/
$se_num1 = mt_rand(1, 9);
$se_num2 = mt_rand(1, 9);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ko">
<meta name="product" content="Metro UI CSS Framework">
<meta name="description" content="Time-Space css framework">
<meta name="author" content="Time-Space">
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<script src="/time-space/ajax/ajax_basic.js"></script>
<script src="/time-space/ajax/ajax_member.js"></script>
<script src="/time-space/ajax/common.js"></script>
<script type="text/javascript">
var myReq = getXMLHTTPRequest();
</script>

<link rel="stylesheet" href="/time-space/reset.css" type="text/css">
<link rel="stylesheet" href="/time-space/board/board.css" type="text/css">
<link href="/time-space/skin/one/design/favicon.ico" rel="shortcut icon" type="image/ico" />
<script type="text/javascript" charset="utf-8" src="/time-space/mobile/js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" charset="utf-8" src="/time-space/js/common.js"></script>
<!--[if lt IE 9]>
 <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if lt IE 7]>
<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
<![endif]-->
<title>Time-Space HTML5</title>

</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Member Manager</h2>
</header>
<span class="br10"></span>

<form method="post" name="frm" id="frm" action="write_ok.php" onsubmit="return submitForm('frm');" enctype="multipart/form-data" >
<!-- 테이블 시작 -->
<div class="board_write_table">
     <table summary="" class="write_table" style="text-align:left">
      <caption></caption>
       <colgroup>
        <col style="width:100px;" />
        <col />
       </colgroup>
       <tbody>
		<tr>
		<th>프로필이미지</th>
		<td colspan="5"><img src="/time-space/upload/profile/<?php echo $LOGIN_ID?>.jpg?<?php echo date(YmdHms)?>" width="150px" height="150px">
		<input type="FILE" ID="FILEUPLOAD0" NAME="FILEUPLOAD0" />
		</td>
		</tr>
		<tr>
			<th>약관동의</th> 
			<td>
			<input type="checkbox" name="AGREE_YN" id="AGREE_YN" class="nullChk_chk" title="동의" value="true">동의
			</td>
		</tr>
		<tr>
			<th>로그인구분</th>
			<td>
			<SELECT ID="LOGIN_GUBN" name='LOGIN_GUBN' size='1' style="width:100px">
			        <option value=''>-SELECT-</option>
			        <option value="PE" >응모등록</option>
			        <option value="CO" >공모등록</option>
			</SELECT>
			</td>
		</tr>
		<tr>
			<th>아이디</th>
			<td><div id="board_list_button_table">
			<input type="text" size="30"  name="LOGIN_ID" id="LOGIN_ID" value="" class="nullChk_txt" title="아이디" style="float:left"/>
				<a href="javascript:void(0);" onClick="getUserId(); return false">
                        	<span class="button" style="float:left;height:10px">중복확인</span></a>
                        	<div id="show_id"></div>
                        	</div>
			</td>
		</tr>
		<tr>
			<th width="18%">암호</th>
			<td><input type="password" size="31"  name="LOGIN_PWD" id="LOGIN_PWD" value="" <?php echo ($MODE != "edit")? "class='nullChk_txt'":"";?> title="암호" />
			<input type="hidden" size="30"  name="HIDDEN_PWD" id="HIDDEN_PWD" value="" /></td>
		</tr>
		<tr>
			<th>이름</th>
			<td><input type="text" size="30"  name="USER_NM" id="USER_NM" value="" class="nullChk_txt" title="이름"/></td>
		</tr>
		<tr>
			<th>레벨</th> 
			<td>
			<SELECT ID="USER_LEVEL" name='USER_LEVEL' size='1' style="width:100px" >
			        <option value=''>-SELECT-</option>
			        <option value="1" >admin</option>
			        <option value="2" >staff</option>
			        <option value="9" selected>member</option>
			</SELECT>
			</td>
		</tr>
		<tr>
			<th>휴대전화</th> 
			<td>
			SMS수신동의(필수)
			<input type="checkbox" name="HP_YN" id="HP_YN" class="nullChk_chk" title="SMS수신동의" value="true">
			<SELECT ID="HP0" name='HP0' size='1' style="width:100px" class="nullChk_txt" title="휴대폰첫째자리">
			        <option value=''>-SELECT-</option>
			        <option value="010" <?php echo ($arrhp[0]=="010")?"SELECTED":"";?>>010</option>
			        <option value="011" <?php echo ($arrhp[0]=="011")?"SELECTED":"";?>>011</option>
			        <option value="070" <?php echo ($arrhp[0]=="070")?"SELECTED":"";?>>070</option>
			        <option value="019" <?php echo ($arrhp[0]=="019")?"SELECTED":"";?>>019</option>
			        <option value="017" <?php echo ($arrhp[0]=="017")?"SELECTED":"";?>>017</option>
			        <option value="016" <?php echo ($arrhp[0]=="016")?"SELECTED":"";?>>016</option>
			</SELECT>-
			<input type="text" ID="HP1" NAME="HP1" VALUE="<?php echo $arrhp[1]?>" class="nullChk_txt" title="휴대폰둘째자리"/>-
			<input type="text" ID="HP2" NAME="HP2" VALUE="<?php echo $arrhp[2]?>" class="nullChk_txt" title="휴대폰셋째자리"/>
			</td> 
		</tr>
		<tr>
			<th>이메일</th> 
			<td>
			수신동의(필수)
			<input type="checkbox" name="EMAIL_YN" id="EMAIL_YN" class="nullChk_chk" title="이메일수신동의" value="true">
			<input type="text" ID="EMAIL0" NAME="EMAIL0" VALUE="<?php echo $arremail[0]?>"  class="nullChk_txt" title="이메일첫번째자리"/>@
			<input type="text" ID="EMAIL1" NAME="EMAIL1" VALUE="<?php echo $arremail[1]?>"  class="nullChk_txt" title="이메일두번째자리"/>
			<SELECT ID="DDLEMAIL" name='DDLEMAIL' size='1' style="width:100px" onchange="selectmail()">
			        <option value=''>-SELECT-</option>
			        <option value="naver.com">naver.com</option>
			        <option value="nate.com">nate.com</option>
			        <option value="gmail.com">gmail.com</option>
			        <option value="hanmail.net">hanmail.net</option>
			        <option value="yahoo.co.kr">yahoo.co.kr</option>
			</SELECT>
			</td> 
		</tr>
		<tr>
			<th>로그인허용</th> 
			<td>
			<SELECT ID="USE_YN" name='USE_YN' size='1' style="width:100px">
				<option value="Y" >USE</option>
				<option value="N" >STOP</option>
			</SELECT>
			</td>
		</tr>
		<tr>
			<th>프로필타이틀</th>
			<td><input type="text" size="30"  name="PROFILE_TITLE" id="PROFILE_TITLE" value="" title="프로필타이틀"/></td>
		</tr>
		<tr>
			<th>자기소개</th>
			<td><textarea name="PROFILE_INFO" id="PROFILE_INFO" rows="5"><?php echo str_replace("<br/>", "\r\n",$ROW['PROFILE_INFO']);?> </textarea></td>
		</tr>
		<tr>
			<th>전문분야</th> 
			<td>
			<input type="checkbox" name="PROFILE_EXPERT[]" value="CI/BI" > CI/BI
			<input type="checkbox" name="PROFILE_EXPERT[]" value="인쇄(편집)" > 인쇄(편집)
			<input type="checkbox" name="PROFILE_EXPERT[]" value="애플리케이션" > 애플리케이션
			<input type="checkbox" name="PROFILE_EXPERT[]" value="건축 인테리어" > 건축 인테리어
			<input type="checkbox" name="PROFILE_EXPERT[]" value="캐릭터/애니메이션" > 캐릭터/애니메이션
			<input type="checkbox" name="PROFILE_EXPERT[]" value="일러스트레이션" > 일러스트레이션
			<input type="checkbox" name="PROFILE_EXPERT[]" value="제품" > 제품
			<input type="checkbox" name="PROFILE_EXPERT[]" value="영상/멀티미디어" > 영상/멀티미디어
			</td>
		</tr>
		<tr>
			<th>방문경로</th> 
			<td>
			<input type="checkbox" name="VISIT_INFO[]" value="광고" > 광고
			<input type="checkbox" name="VISIT_INFO[]" value="포털사이트" > 포털사이트
			<input type="checkbox" name="VISIT_INFO[]" value="SNS" > SNS
			<input type="checkbox" name="VISIT_INFO[]" value="추천" > 추천
			<input type="checkbox" name="VISIT_INFO[]" value="디자인관련홈페이지" > 디자인관련홈페이지
			<input type="checkbox" name="VISIT_INFO[]" value="기타" > 가타
			</td>
		</tr>
	</tbody>
	</table>
</div>
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<a href="list.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&MODE=list"><span class="button">CANCEL</span></a>	
	<?php if($MODE=="edit"){?>
		<input type="button" value="DELETE" name="DELETE" class="type-btn" onclick="del_chk(this.form);">
	<?php }?>
	<input type="submit" value="COMMIT" name="COMMIT" class="type-btn">
</div>
<div style="display:none">
	<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
	<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
	<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
</div>
</form>
</div>
<!--게시판 끝-->
<?php
if($MODE == "edit"){ 
	//db값 바인딩
	ALL_BIND($ROW);
	CHECKLIST_BIND($ROW['AGREE_YN'],"AGREE_YN");
	CHECKLIST_BIND($ROW['HP_YN'],"HP_YN");
	CHECKLIST_BIND($ROW['EMAIL_YN'],"EMAIL_YN");
	CHECKLIST_BIND($PROFILE_EXPERT,"PROFILE_EXPERT[]");
	CHECKLIST_BIND($VISIT_INFO,"VISIT_INFO[]");
}
?>
<!--
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace( "PROFILE_INFO",
		    {
		        height: 100,
			toolbar : 'Basic'
		    });
		CKEDITOR.config.docType = '<!DOCTYPE html>';
		CKEDITOR.config.contentsCss = ['/_metro/css/metro-bootstrap.css'];
		CKEDITOR.config.bodyClass = 'metro';
</script>
-->
<script type="text/javascript">
/*
	$(document).ready( function() {
		var container, inputs, index;
		container = document.getElementById('frm');
		inputs = container.getElementsByTagName('input');
		for (index = 0; index < inputs.length; ++index) {
		    //alert(inputs[index].name);
		    //var obj_name=inputs[index].name;
		    //alert(obj_name);
		    //$('#'+inputs[index].name).val('obj_name');
		}
		
	});*/
</script>
</body>
</html>