<?php
session_start();
?>
<?
	/** 게시판 구분을 위한 번호 */
	$id = $_GET['id'];
	if (!$id) $id = $_POST['id'];
	if (!$id) $id = 1;

	/** 리스트 페이징에 사용되는 페이지 번호 */
	$page = $_GET['page'];
	if (!$page) $page = $_POST['page'];
	if (!$page) $page = 1;

	/** 게시판 제목 배열 */
	$bbs_titles[] = "납품정보";
	$bbs_titles[] = "공지사항";
	$bbs_titles[] = "묻고답하기";
	$bbs_titles[] = "자유게시판";
	$bbs_titles[] = "사진게시판";
	$bbs_titles[] = "동영상게시판";

	/** 게시판 번호를 통하여 제목 배열에서 현재 머물고 있는 게시판 이름 추출 */
	$bbs_title = $bbs_titles[$id-1];

	/** 데이터베이스 연결 객체 */
	$dbcon = null;

	/** 데이터베이스 연결 함수 */
	function db_open() {
		global $dbcon;
		$dbcon = mysql_connect("localhost", "webassets", "mit195884");
		@mysql_query("set names utf8");//한글깨져서 추가
		mysql_select_db("webassets", $dbcon);
	}

	/** 데이터베이스 연결 해제 함수 */
	function db_close() {
		global $dbcon;
		@mysql_query("set names utf8");//한글깨져서 추가
		mysql_close($dbcon);
	}
?>