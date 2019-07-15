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
//Board 공통변수 항상 페이지 상단에 위치
$GUBN = $_REQUEST['GUBN'];
$SEARCH = $_REQUEST['SEARCH'];
$MODE = $_REQUEST['MODE'];
//$LOGIN_ID = $_REQUEST['LOGIN_ID'];
$LOGIN_ID = $_SESSION['valid_user'];
?>
<?php
	//페이징설정 넘버링 시작
	$now_page = $_GET['now_page'];
	//================ pageing 계산 code ======================================
	// 1 - 현재 페이지 설정
	if($now_page == ""){
		$now_page = 1;
	}
	// 2 - 블럭크기 설정
	if($block_size == ""){
		$block_size = 10;
	}
	// 3 - 각 블럭의 start 페이지 값을 설정한다
	if($now_page % $block_size == 0){
		$start_num = abs($now_page - $block_size + 1);    // 현재 페이지가 블럭의 마지막 페이지 일 경우 해당 블럭의 시작 페이지 번호를 정한다
	}else{
		$start_num = floor($now_page/$block_size)*$block_size + 1; // 현재페이지가 블럭의 마지막 페이지가 아닐경우 시작 페이지를 지정한다
	}
	// 4 - 각 블럭의 end 페이지 값을 설정한다
	$end_num = $start_num + $block_size - 1;
	// 5 - 카운터 쿼리호출 (마지막 페이지에서 존재하지 않는 페이지 숫자를 없애주기 위해 토탈레코드 숫자를 구한다 )
		$SQL = "SELECT";
		$SQL .= " COUNT(LOGIN_ID) AS COUNT";
		$SQL .= " FROM T_MEMBER";
		$SQL .= " WHERE";
		$SQL .= " (LOGIN_ID LIKE '%".$SEARCH."%'";
		$SQL .= " OR USER_NM LIKE '%".$SEARCH."%')";
		$result = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
		if($result){
			$total_rec = $result['COUNT'];
		}
	// 6 - 한페이지당 보여줄 레코드 수 설정
	$recnum_per_page = 10;
	// 7 - 불러오기 쿼리문에서 시작레코드 숫자 지정
	if($now_page == 1){
		$st_limit = 0;
	}else{
		$st_limit = $now_page * $recnum_per_page - $recnum_per_page;
	}
	// 8 - 이전 블럭 설정
	$before_block = abs($start - 1);
	// 9 - 다음 블럭 설정
	$next_block = $end_num + 1;
?>
﻿<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ko">
<meta name="product" content="Metro UI CSS Framework">
<meta name="description" content="Time-Space css framework">
<meta name="author" content="Time-Space">
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

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
<script type="text/javascript">
function togle_check(){
    var $togle = $("input:checkbox[name='ALL_CHECK']");
    var $checkbox = $("input:checkbox[name='GET_ID[]']");
    if($togle[0].checked){
	for (x = 0; x < $checkbox.length; x++){
	    $checkbox[x].checked=true;
	}
    }else{
    	for (x = 0; x < $checkbox.length; x++){
	    $checkbox[x].checked=false;
	}
    }
}
function member_del(){
    var $checkbox = $("input:checkbox[name='GET_ID[]']");
    var str = "";
	for (x = 0; x < $checkbox.length; x++){
	    if($checkbox[x].checked) str += $checkbox[x].value + ",";
	}
    if(str==""){
    	alert('선택된 값이 없습니다.');return false;
    }else{
    	//alert(str);//디버그;
    	frm = document.del_frm;
         if (confirm('Are you sure you want to delete?') == true) {
        	frm.MODE.value = "delete_checked"; 
        	frm.SEQS.value = str;
        	frm.submit();
            	return true;
	     } else {
	    	 frm.MODE.value = ""; 
	         return false;
	     }
    }
}
function member_excel(){
    var $checkbox = $("input:checkbox[name='GET_ID[]']");
    var str = "";
	for (x = 0; x < $checkbox.length; x++){
	    if($checkbox[x].checked) str += $checkbox[x].value + ",";
	}
    	//alert(str);//디버그;
    	frm = document.del_frm;
        	frm.MODE.value = "excel_checked"; 
        	frm.SEQS.value = str;
        	frm.submit();
            	return true;
}
</script>
</head>
<body>
<div id="wrap">
<header id="board_list_header">
	<h2>Member Manager</h2>
</header>
<!--검색영역시작-->
<div id="board_list_search">
	<form method="get" name="form_search" id="form_search" action="">
	<select name="GUBN" id="GUBN" class="type-select">
		<option selected="selected" value="1">ALL</option>
		<option value="2">ID</option>
		<option value="3">NAME</option>
	</select>
	<input type="text" name="SEARCH" id="SEARCH" size=15 class="type-text" value="">
	<input type=submit value="Search" class="type-submit">
	</form> 
</div>
<!--검색영역끝-->
<!-- 테이블 시작 -->
<div class="board_list_table">
    <table class="list_table">
        <caption>회원관리</caption>
        <colgroup>
	   <col width="5%" />
	   <col width="20%" />
	   <col width="20%" />
	   <col width="5%" />
	   <col width="20%" />
	   <col width="15%" />
	   <col width="15%" />
	   <col width="5%" />
	  </colgroup>
        <thead>
            <tr>
                <th><input type="checkbox" name="ALL_CHECK" onclick="togle_check()" value="true">선택</th>
                <th>ID</th>
                <th>NAME</th>
                <th>LEVEL</th>
                <th>EMAIL</th>
                <th>CREATE_DT</th>
                <th>UPDATE_DT</th>
                <th>USE_YN</th>
            </tr>
        </thead>
        <tbody>

		<?php
		//셀렉트 
		$SQL = "SELECT";
		$SQL .= " LOGIN_ID,LOGIN_PWD,USER_NM,USER_LEVEL,USE_YN,USER_EMAIL";
		$SQL .= " ,DATE_FORMAT(CREATE_DT, '%Y-%m-%d') AS CREATE_DT";
		$SQL .= " ,DATE_FORMAT(UPDATE_DT, '%Y-%m-%d') AS UPDATE_DT";
		$SQL .= " FROM T_MEMBER";
		$SQL .= " WHERE";
		$SQL .= " (LOGIN_ID LIKE '%".$SEARCH."%'";
		$SQL .= " OR USER_NM LIKE '%".$SEARCH."%')";
		$SQL .= " ORDER BY USER_LEVEL ASC,USER_NM ASC LIMIT $st_limit , $recnum_per_page";
		$result = $GPLdb5->GPLexcute_query($SQL);
		$i=0;
		if($result){
			while($row = mysqli_fetch_array($result)) {
		?>
	<tr>
		<td><input type="checkbox" name="GET_ID[]" value="<?php echo $row['LOGIN_ID']?>" ></td>
		<td><?php echo $row['LOGIN_ID']?></td> 
		<td>
			<a href="view.php?LOGIN_ID=<?php echo $row['LOGIN_ID']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&MODE=view">
			<?php echo $row['USER_NM']?>
			</a>
		</td>
		<td><?php echo $row['USER_LEVEL']?></td>
		<td><?php echo $row['USER_EMAIL']?></td>
		<td><?php echo $row['CREATE_DT']?></td>
		<td><?php echo $row['UPDATE_DT']?></td>
		<td><?php echo $row['USE_YN']?></td>
	</tr>
		<?php
				$i++;
				}
		  }
		?>
	<?php if($i==0){?>
	<tr><td colspan="6">NONE DATA</td></tr>
	<?php } ?>
	</tbody>
   </table>
</div>
<!-- 테이블 종료 -->
<!--paging시작-->
<div id="board_list_paging">
	 <?php
	 //================ pageing 출력 10번~12번 code ======================================
		  if($start_num > 1){ 	// 10 - 이전 블럭 링크?>
		  <span>
			 <a href="list.php?now_page=<?php echo $before_block?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>" onFocus="blur()">
			 Prev</a>
		  </span>
		  <?php } ?>&nbsp;
		 <?php
		  for($i=$start_num; $i<=$end_num; $i++){	// 11 - 페이지 링크
			if(ceil($total_rec/$recnum_per_page) >= $i){
			 if($now_page == $i){ ?>
			 <span class="selected_page">
			 <?php echo $i?>
			 </li>
		  <?php    }else{ ?>
		  <span>
			 <a href="list.php?now_page=<?php echo $i?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>" onFocus="blur()"><?php echo $i?></a>
		   </span>
		 <?php            }
			}
		  }  ?>&nbsp;
		 <?php
		  if($end_num * $recnum_per_page < $total_rec){ 	// 12 - 다음 블럭 링크?>
		  <span>
			 <a href="list.php?now_page=<?php echo $next_block?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>" onFocus="blur()">
			 Next</a>
		   </span>
	 <?php  }
	 //====================================================================
	 ?>
</div>
<!--paging끝-->
<!-- 등록버튼 시작 -->
<div id="board_list_button_table">
	<?php if($_SESSION['valid_level'] == 1 ) { ?>
	 <span class="button" onclick="member_excel()">엑셀다운</span>
	 <a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=write">
	 <span class="button">WRITE</span></a>
	 <span class="button" onclick="member_del()">선택삭제</span>
	 <?php } ?>
</div>
<div style="display:none">
	<form method="post" name="del_frm" id="del_frm" action="write_ok.php" >
	<input type="text" value="<?php echo $MODE?>" name="MODE" id="MODE">
	<input type="text" value="<?php echo $LOGIN_ID?>" name="LOGIN_ID" id="LOGIN_ID">
	<input type="text" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
	<input type="text" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
	<input type="text" value="<?php echo $now_page?>" name="now_page" id="now_page">
	<input type="text" value="<?php echo $SEQS?>" name="SEQS" id="SEQS">
	</form>
</div>
<form action="process.php" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td>
			CSV File을 선택해주세요!!
		</td>
	</tr>
	<tr>
		<td>
		<input type="file" name="filename" /><input type="submit" name="저장" value="일괄등록하기" />
		</td>
	</tr>
</table>
</form><br/>
<form action="excel2php.php" method="post" enctype="multipart/form-data">
<table>
	<tr>
		<td>
			엑셀 File을 선택해주세요!!
		</td>
	</tr>
	<tr>
		<td>
		<input type="file" name="xls" /><input type="submit" name="저장" value="일괄등록하기" />
		<input type="hidden" name="chk_code" value="<?php echo date("YmdHis");?>"><?php $_SESSION[chk_code]=date("YmdHis");?>
		</td>
	</tr>
</table>
</form>

</div>
</body>
</html>