<?php //게시판 공통변수 항상 페이지 상단에 위치
	$GUBN = $_REQUEST['GUBN'];
	$SEARCH = $_REQUEST['SEARCH'];
	$BOARD_ID = $_REQUEST['BOARD_ID'];
	$MODE = $_REQUEST['MODE'];
	$BOARD_SEQ = $_REQUEST['SEQ'];
	if(!$BOARD_ID) $BOARD_ID = "notice"; //notice, qa, repair, pds, faq
	$now_page = $_REQUEST['now_page'];
?>
<?php //페이징설정 넘버링
	$now_page = $_REQUEST['now_page'];
	//================ pageing 계산 code ======================================
	// 1 - 현재 페이지 설정
	if($now_page == ""){
		$now_page = 1;
	}
	// 2 - 블럭크기 설정
	if($block_size == ""){
		$block_size = 7;
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
	$recnum_per_page = 5;
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
<?php //보드 카테고리 변수
	switch ($BOARD_ID) { //notice, qa, repair, pds, faq
		case 'notice'  : $body='1'; $title='NOTICE';break;
		case 'community' : $body='2'; $title='COMMUNITY';break;
		case 'qa'  : $body='3'; $title='Q/A';break;
		case 'faq'  : $body='4'; $title='FAQ';break;
		case 'pds'  : $body='5'; $title='PDS';break;
		case 'stay-sea'  : $body='6'; $title='대분류1';break;
		case 'stay-mi'  : $body='7'; $title='대분류2';break;
		case 'stay-ho'  : $body='8'; $title='대분류3';break;
		case 'stay-doo'  : $body='9'; $title='대분류4';break;
		default   : $body='1'; $title='NOTICE';break;
	}
?>
<!doctype html> <!-- 보드공통 헤드 HTML -->
<html lang="ja">
<head><!-- 메타태그 작성 -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<!-- 외부 플러그인 CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/jquery.fullpage.css">
	<!-- 사용자가 추가한 CSS -->
	<link rel="stylesheet" href="/_fullpage/css/style.css">
	<title>부트스트랩4.0으로 홈페이지 만들기</title>
</head>
<body><!-- 보드공통 BODY 상단 -->
<!-- Menu -->
<?php include_once "../top_menu.php"; //메뉴 PHP코드 ?>
<div id="fullpage"><!-- 1페이지 스크롤 영역 Start -->