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
$BOARD_ID = $_REQUEST['BOARD_ID'];
$MODE = $_REQUEST['MODE'];
$BOARD_SEQ = $_REQUEST['SEQ'];
if(!$BOARD_ID) $BOARD_ID = "notice"; //notice, qa, qa, pds, faq
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
		$SQL .= " COUNT(SEQ) AS COUNT";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = '".$BOARD_ID."'";
		$SQL .= " AND (TITLE LIKE '%".$SEARCH."%'";
		$SQL .= " OR CONTENT LIKE '%".$SEARCH."%')";
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
<?php
	//메뉴 변수
	switch ($BOARD_ID) { //notice, qa, qa, pds, faq
		case 'notice'  : $body='1'; $title='NOTICE';break;
		case 'community' : $body='2'; $title='COMMUNITY';break;
		case 'qa'  : $body='3'; $title='Q/A';break;
		case 'faq'  : $body='4'; $title='FAQ';break;
		case 'pds'  : $body='5'; $title='PDS';break;
		default   : $body='1'; $title='NOTICE';break;
	}
?>
﻿<!DOCTYPE html>
<html lang="auto">
<head>
<meta charset="utf-8">
<META HTTP-EQUIV="Content-Language" CONTENT="ja">
<meta name="product" content="Metro UI CSS Framework">
<meta name="description" content="Time-Space css framework">
<meta name="author" content="Time-Space">
<meta name="keywords" content="js, css, metro, framework, windows 8, metro ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="stylesheet" href="/time-space/reset.css" type="text/css">
<link rel="stylesheet" href="/time-space/manage/rhksflwk/board/board.css" type="text/css">
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
	<h2><?php echo $title." Board"?></h2>
</header>
<!--검색영역시작-->
<div id="board_list_search">
	<form method="get" name="form_search" id="form_search" action="">
	<select name="GUBN" id="GUBN" class="type-select">
		<option selected="selected" value="1">ALL</option>
		<option value="2">SUBJECT</option>
		<option value="3">CONTENT</option>
	</select>
	<input type="text" name="SEARCH" id="SEARCH" size=15 class="type-text" value="">
	<input type="hidden" name="BOARD_ID" id="BOARD_ID" size=15 class="type-text" value="<?php echo $BOARD_ID?>">
	<input type=submit value="Search" class="type-submit">
	</form> 
</div>
<!--검색영역끝-->
<!-- 테이블 시작 -->
<div class="board_list_table">
    <table class="list_table">
        <caption>타임-스페이스 Board 디자인</caption>
        <colgroup>
	   <col width="10%" />
	   <col width="45%" />
	   <?php if($BOARD_ID!="faq"){?>
	   <col width="15%" />
	   <col width="15%" />
	   <?php } ?>
	   <?php if($BOARD_ID=="notice" || $BOARD_ID=="pds"){?>
	   <col width="20%" />
	   <?php } ?>
	   <?php if($BOARD_ID=="qa"){?>
	   <col width="20%" />
	   <?php } ?>
	   <?php if($BOARD_ID!="faq"){?>
	   <col width="10%" />
	   <?php } ?>
	  </colgroup>
        <thead>
            <tr>
                <th>No</th>
                <th>Subject</th>
                <?php if($BOARD_ID!="faq"){?>
                <th>Writer</th>
                <th>UpDate</th>
                <?php } ?>
                <?php if($BOARD_ID=="notice" || $BOARD_ID=="pds"){?>
                <th>File</th>
                <?php } ?>
                <?php if($BOARD_ID=="qa"){?>
		<th>상태</th>
		<?php } ?>
		<?php if($BOARD_ID!="faq"){?>
		<th>hit</th>
		<?php } ?>
            </tr>
        </thead>
        <tbody>
		<?php
		//셀렉트 
		$SQL = "SELECT";
		$SQL .= " SEQ,BOARD_ID,USER_ID,USER_NM,EMAIL,TITLE,CONTENT";
		$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
		$SQL .= " ,READCOUNT,FILECNT,STATE,POPUP,POPUP_W,POPUP_H,TOP_NEWS";
		$SQL .= " FROM T_BOARD";
		$SQL .= " WHERE BOARD_ID = '$BOARD_ID'";
		$SQL .= " AND (TITLE LIKE '%".$SEARCH."%'";
		$SQL .= " OR CONTENT LIKE '%".$SEARCH."%')";
		$SQL .= " ORDER BY IFNULL(TOP_NEWS,'OFF') DESC, SEQ DESC LIMIT $st_limit , $recnum_per_page";
		$result = $GPLdb5->GPLexcute_query($SQL);
		$i=0;
		if($result){
			while($row = mysqli_fetch_array($result)) {
				//댓글셀렉트
				$SQL = "SELECT";
				$SQL .= " COUNT(SEQ) AS COMMENT_CNT";
				$SQL .= " FROM T_BOARD_COMMENT";
				$SQL .= " WHERE BOARD_SEQ = '".$row['SEQ']."'";
				$SQL .= " AND BOARD_ID = '$BOARD_ID'";
				$COMMENT_ROW = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
				$COMMENT_CNT = $COMMENT_ROW['COMMENT_CNT'];
		?>
	<tr>
		<td><?php echo ($row['TOP_NEWS']=="on")?"<b>[TOP_NEWS]</b>":$row['SEQ']//$total_rec+1-?></td> 
		<td>
			<a href="view.php?SEQ=<?php echo $row['SEQ']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=view">
			<?php echo cut_str($row['TITLE'],88,'...')?><?php echo ($COMMENT_CNT>0)?"(".$COMMENT_CNT.")":"";?>
			</a>
		</td>
		<?php if($BOARD_ID!="faq"){?>
			<td><?php echo $row['USER_NM']?></td> 
			<td><?php echo $row['CREATE_DT']?></td>
		<?php }?> 
		<?php if($BOARD_ID=="notice" || $BOARD_ID=="pds"){?>
			<td>
				<?php //첨부File 다운로드로직
				$SQL = "SELECT";
				$SQL .= " SEQ,FILE_NM,FILE_SIZE,DOWN_CNT";
				$SQL .= " ,BOARD_SEQ,BOARD_ID";
				$SQL .= " ,CREATE_DT,CREATE_ID,UPDATE_DT,UPDATE_ID";
				$SQL .= " FROM T_ATTACH_FILE";
				$SQL .= " WHERE BOARD_SEQ = ".$row['SEQ']." AND BOARD_ID = '$BOARD_ID'";
				$SQL .= " ORDER BY SEQ ASC";
				//echo $SQL;//debug 
				$fileresult = $GPLdb5->GPLexcute_query($SQL);
				$i=0;
				if($fileresult){
					while($filerow = mysqli_fetch_array($fileresult)) {	
					if($filerow['FILE_NM']){
					?>
					<a href="/time-space/manage/core/function/download.php?filename=<?php echo $filerow['FILE_NM']?>&target=<?php echo $BOARD_ID?>">[DOWNLOAD]</a>
				<?php 
				}}}?>
			</td>
		<?php } ?>
		<?php if($BOARD_ID=="qa"){?>
			<td><?php echo $row['STATE']?></td>
		<?php } ?> 
		<?php if($BOARD_ID!="faq"){?>
			<td><?php echo $row['READCOUNT']?></td>
		<?php } ?>
	</tr>
		<?php
				$i++;
				}
		  }
		?>
	<?php if($i==0){?>
	<tr>
	<td colspan="10">NONE DATA</td>
	</tr>
	<?php } ?>
        </tbody>
    </table>
</div>
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
	<?php if($_SESSION['valid_user'] != "" && $_SESSION['valid_level'] < 3 ) { ?>
	 <a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=write">
	 <span class="button">WRITE</span></a>
	 <?php } ?>
	 <?php if($_SESSION['valid_user'] != "" && $_SESSION['valid_level'] >= 3 && ( $BOARD_ID =='community'||$BOARD_ID == 'qa' ) ) { ?>
	 <a href="write.php?now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=write">
	 <span class="button">WRITE</span></a>
	 <?php } ?>
</div>

</div>
</body>
</html>