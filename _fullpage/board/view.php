<?php include_once "../header.php"; //전체공통 PHP헤더 ?>
<?php include_once "board_header.php"; //보드공통 PHP헤더 ?>
<?php //보드 뷰전용 PHP코드
	//조회카운터+1
	$proc_edit = "UPDATE T_BOARD SET";
	$proc_edit .=" READCOUNT = IFNULL(READCOUNT,0) + 1";
	$proc_edit .=" WHERE SEQ = '$BOARD_SEQ'";
	$proc_edit .=" AND BOARD_ID = '$BOARD_ID'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
	//정보 가져오기 쿼리정리
	$SQL = "SELECT CONTENT, EMAIL, TITLE, USER_NM, READCOUNT, FILECNT, USER_ID, STATE";
	$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
	$SQL .= " FROM T_BOARD";
	$SQL .= " WHERE SEQ = '$BOARD_SEQ'";
	$SQL .= " AND BOARD_ID = '$BOARD_ID'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
	$EMAIL=$ROW['EMAIL'];
	$arremail = explode("@",$EMAIL);
	//바인딩변수값 정의
	$CONTENT = $ROW['CONTENT'];
	$TITLE = $ROW['TITLE'];
	$NAME = $ROW['USER_NM'];
	$REGDATE =  $ROW['CREATE_DT'];
	$READCOUNT = $ROW['READCOUNT'];
	$FILECNT = $ROW['FILECNT'];
	$USER_ID = $ROW['USER_ID'];
	$STATE = $ROW['STATE'];
	if ($FILECNT > 0)
	{
		$SQL = "SELECT";
		$SQL .= " SEQ,FILE_NM,FILE_SIZE,DOWN_CNT";
		$SQL .= " ,BOARD_SEQ,BOARD_ID";
		$SQL .= " ,CREATE_DT,CREATE_ID,UPDATE_DT,UPDATE_ID";
		$SQL .= " FROM T_ATTACH_FILE";
		$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'";
		$SQL .= " ORDER BY SEQ ASC";
		$fileresult = $GPLdb5->GPLexcute_query($SQL);
	}
?>
<?php //본인이 쓴 글 수정삭제기능
	if($_SESSION['valid_level'] > 3 || $_SESSION['valid_level'] == '') {
	if($_SESSION['valid_user']!=$USER_ID && ($BOARD_ID=="qa"|| $BOARD_ID=="repair") ){ 
		echo "<script type='text/javascript'>alert('It is a secret article.');</script>";
		echo "<meta http-equiv='Refresh' content='0;url=/$flugin_url/board/list.php/MENU_CODE/$MENU_CODE/now_page/$now_page/GUBN/$GUBN/SEARCH/$SEARCH/BOARD_ID/$BOARD_ID/MODE/list'>";
	exit;}
	} ?>
<div class="header section"> <!-- 보드 뷰전용 HTML+PHP -->
	<div class="container">
			<div class="row">
			<div class="col-md-12 bg-white" style="color:#343a40;margin-top:50px;">
					<h2>
							<?php echo $title?> <?php echo $TITLE?>
					</h2>
					<h4 style="color:#343a40">Posted by <?php echo $NAME?> on
					<time datetime="2013-06-25"><?php echo $REGDATE?></time>
					<?php if($BOARD_ID=="qa"|| $BOARD_ID=="repair"){?>
							<br>[처리상태]:<?php echo $STATE?>
					<?php } ?> 
					<?php if ($FILECNT > 0){ ?>
						<?php 
							if($fileresult){
								while($filerow = mysql_fetch_array($fileresult)) {	
								?>
								[FILES]: <a href="/time-space/manage/core/function/download.php?filename=<?php echo $filerow['FILE_NM']?>&target=<?php echo $BOARD_ID?>"><?php echo $filerow['FILE_NM']?></a><br/>
							<?php } ?>
							<?php } ?>
					<?php } ?>
					</h4>
					<br>
					<p>
						<?php echo str_replace("<br/>", "\r\n",$CONTENT);?>
					</p>
					<!-- 등록버튼 시작 -->
					<form method="post" name="del_frm" id="del_frm" action="/<?php echo $flugin_url ?>/board/write_ok.php" onsubmit="return del_chk(this)" >
						<input type="hidden" value="<?php echo $MODE?>" name="MODE" id="MODE">
						<input type="hidden" value="<?php echo $BOARD_SEQ?>" name="BOARD_SEQ" id="BOARD_SEQ">
						<input type="hidden" value="<?php echo $BOARD_ID?>" name="BOARD_ID" id="BOARD_ID">
						<input type="hidden" value="<?php echo $FILENUM[0]?>" name="FILENUM0" id="FILENUM0">
						<input type="hidden" value="<?php echo $FILENUM[1]?>" name="FILENUM1" id="FILENUM1">
						<input type="hidden" value="<?php echo $FILE_NM[0]?>" name="FILE_NM0" id="FILE_NM0">
						<input type="hidden" value="<?php echo $FILE_NM[1]?>" name="FILE_NM1" id="FILE_NM1">
						<input type="hidden" value="" name="FILE_DEL0" id="FILE_DEL0">
						<input type="hidden" value="" name="FILE_DEL1" id="FILE_DEL1">
						<input type="hidden" value="<?php echo $SEARCH?>" name="SEARCH" id="SEARCH">
						<input type="hidden" value="<?php echo $GUBN?>" name="GUBN" id="GUBN">
						<input type="hidden" value="<?php echo $now_page?>" name="now_page" id="now_page">
						<input type="hidden" name="MENU_CODE" id="MENU_CODE" size=15 class="type-text" value="<?php echo $MENU_CODE?>">
						<div>
							<a href="/<?php echo $flugin_url ?>/board/list.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/list'">
							<span class="btn btn-info float-right">LIST</span></a>
							<?php if($_SESSION['valid_user']==$USER_ID ||($_SESSION['valid_user'] != "" && $_SESSION['valid_level'] < 3) ){ //본인이 쓴 글 수정삭제기능?>
							<button type="submit" class="btn btn-info float-right d-none" value="DELETE">DELETE</button>
							<a href="/<?php echo $flugin_url ?>/board/write.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/edit/SEQ/<?php echo $BOARD_SEQ?>">
							<span class="btn btn-info float-right d-none">EDIT</span></a>
							<?php }?>
						</div>
					</form>
					<!-- COMMENT START -->
					<?php if($BOARD_ID=="notice" || $BOARD_ID=="pds" || $BOARD_ID=="community" || preg_match('/stay-/',$BOARD_ID)){?>
					<?php }else{ ?>
					<!-- 코멘트 시작 -->
					<h3 id="_default">Comment Form</h3>
					<div id="comment_wrap">
						<div class="board_write_table">
						<?php 
							//코멘트셀렉트 
							$SQL = "SELECT";
							$SQL .= " SEQ,USER_ID,USER_NM,COMMENTS";
							$SQL .= " ,DATE_FORMAT(REGDATE, '%Y-%m-%d') AS CREATE_DT";
							$SQL .= " FROM T_BOARD_COMMENT";
							$SQL .= " WHERE BOARD_SEQ = '$BOARD_SEQ'";
							$SQL .= " AND BOARD_ID = '$BOARD_ID'";
							$SQL .= " ORDER BY SEQ ASC";
							$row = $GPLdb5->GPLquery_fetch_assoc_one($SQL);
							$COMMENT_MODE = ($row)?"edit":"write";
							//$result = $GPLdb5->GPLexcute_query($SQL);
						if($row){
							//if($result){
							//	while($row = mysql_fetch_array($result)) {
							?>
							<table summary="" class="table">
										<caption></caption>
										<colgroup>
												<col width="15%" />
									<col width="55%" />
									<col width="25%" />
										</colgroup>
										<tbody>
								<tr>
								<th><?php echo $row['USER_NM']?></th>
								<th><?php echo $row['COMMENTS']?></th>
								<th><?php echo $row['CREATE_DT']?></th>
								<th><?php //if($_SESSION['valid_user']==$USER_ID && $_SESSION['valid_name']==$NAME){ //본인이 쓴 글 삭제기능?>
								<!-- <a href="write_ok.php?BOARD_SEQ=<?php echo $BOARD_SEQ?>&BOARD_ID=<?php echo $BOARD_ID?>&COMMENT_MODE=delete&SEQ=<?php echo $row['SEQ']?>">
								DEL</a> -->
								<?php //}?>
								</th>
								</tr>
								</tbody>
							</table>
								<?php //}?>
							<?php //}?>
						<?php }?>
						</div>
						<?php if($_SESSION['valid_level'] < 3 && $_SESSION['valid_level'] > 0) { ?>
						<!-- 테이블 시작 -->
							<form method="post" name="frm" id="frm" action="/<?php echo $flugin_url ?>/board/write_ok.php" onsubmit="return submitForm(this)" enctype="multipart/form-data" >
								<table summary="" class="table">
									<caption></caption>
									<colgroup>
											<col width="80%" />
								<col width="20%" />
									</colgroup>
									<tbody>
							<tr>
							<td>
							<div class="input-control text span3 block" data-role="input-control">
							<input type="text" name="USER_NM" id="USER_NM" value="<?php echo ($row['USER_NM']=="")?$_SESSION['valid_name']:$row['USER_NM'];?>" />
							</td>
							
							<td>
							<div class="input-control select" data-role="input-control">
							<SELECT ID="STATE" name='STATE'>
										<option value=''>-STATE-</option>
										<option value="처리중" <?php echo ($STATE=="처리중")?"SELECTED":"";?>>처리중</option>
										<option value="처리완료" <?php echo ($STATE=="처리완료")?"SELECTED":"";?>>처리완료</option>
							</SELECT>
							</div>
							</td>
							</tr>
							<tr>
							<td>
							<div class="input-control textarea" data-role="input-control">
							<textarea name="COMMENTS" id="COMMENTS" rows="3"><?php echo str_replace("<br/>", "\r\n",$row['COMMENTS']);?></textarea>
							</div>
							</td>
							<td>
							<!-- 등록버튼 시작 -->
							<div id="board_list_button_table">
							<button type="submit" class="button default">COMMIT</button>
							<a href="/<?php echo $flugin_url ?>/board/write_ok.php/MENU_CODE/<?php echo $MENU_CODE?>/BOARD_SEQ/<?php echo $BOARD_SEQ?>/BOARD_ID/<?php echo $BOARD_ID?>/COMMENT_MODE/delete/SEQ/<?php echo $row['SEQ']?>">
							<span class="button default">DEL</span></a>
							</div>
							</td>
							</tr>
							</tbody>
							</table>
							<div style="display:none">
							<input type="text" value="<?php echo $COMMENT_MODE?>" name="COMMENT_MODE" id="COMMENT_MODE">
							<input type="text" value="<?php echo $BOARD_SEQ?>" name="BOARD_SEQ" id="BOARD_SEQ">
							<input type="text" value="<?php echo $BOARD_ID?>" name="BOARD_ID" id="BOARD_ID">
							<input type="text" value="<?php echo $row['SEQ']?>" name="SEQ" id="SEQ">
							<input type="text" value="<?php echo $_SESSION['valid_user']?>" name="USER_ID" id="USER_ID">
							<input type="hidden" name="MENU_CODE" id="MENU_CODE" size=15 class="type-text" value="<?php echo $MENU_CODE?>">
							<!--<input type="text" value="<?php echo ($ROW['USER_ID']=="")?$_SESSION['valid_user']:$ROW['USER_ID'];?>" name="USER_ID" id="USER_ID">-->
							</div>
							</form>
							<?php } ?>
						</div>
						<?php }?>
						<!-- COMMENT END -->
						<!-- 이전,다음 게시물 링크시작 -->
						<p>&nbsp;</p>
						<div id="prev_wrap" class="post">
						<h3 id="_default">Preview, Nextview Contents</h3>
						<div class="board_write_table">
								<table class="table">
									<tbody>
									<?php
									//셀렉트 
										$SQL = "SELECT";
										$SQL .= " SEQ,BOARD_ID,TITLE";
										$SQL .= " FROM T_BOARD";
										$SQL .= " WHERE (SEQ = (SELECT MIN(SEQ) FROM T_BOARD WHERE SEQ > '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID')";
										$SQL .= " OR SEQ = (SELECT MAX(SEQ) FROM T_BOARD WHERE SEQ < '$BOARD_SEQ' AND BOARD_ID = '$BOARD_ID'))";
										$SQL .= " AND BOARD_ID = '$BOARD_ID'";
										$SQL .= " ORDER BY TOP_NEWS DESC, SEQ DESC";
										$result = $GPLdb5->GPLexcute_query($SQL);
										$Prevtcnt = $result->num_rows;//echo $num_rows; //디버그
										//$Prevtcnt = mysqli_num_rows($result);
										//echo $BOARD_SEQ."여기".$Prevtcnt;
										if($Prevtcnt>0){
											while($row = mysqli_fetch_array($result)) {
														if ($BOARD_SEQ > $row['SEQ'])
														{
										?>
													<tr><th>Prev</th>
													<td>
													<a href="/<?php echo $flugin_url ?>/board/view.php/MENU_CODE/<?php echo $MENU_CODE?>/SEQ/<?php echo $row['SEQ']?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/view">
														<?php echo $row['TITLE']?>
													</a>
													<?php if($_SESSION['valid_user']!=$row[USER_ID] && ($BOARD_ID=="qa"|| $BOARD_ID=="repair") ){ //본인이 쓴 글 수정삭제기능 ?>
													<img src="/time-space/mobile/img/icon-pass.png">		
													<?php } ?>
													</td></tr>
													<?php if ($Prevtcnt == 1) { ?>
													<tr><th>Next</th>
													<td>None</td></tr>
													<?php } ?>
										<?php } else if ($BOARD_SEQ < $row['SEQ']) {	
										?>			
													<tr><th>Next</th>
													<td>
													<a href="/<?php echo $flugin_url ?>/board/view.php/MENU_CODE/<?php echo $MENU_CODE?>/SEQ/<?php echo $row['SEQ']?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/view">
														<?php echo $row['TITLE']?>
													</a>
													<?php if($_SESSION['valid_user']!=$row[USER_ID] && ($BOARD_ID=="qa"|| $BOARD_ID=="repair")){ //본인이 쓴 글 수정삭제기능 ?>
													<img src="/time-space/mobile/img/icon-pass.png">		
													<?php } ?>
													</td></tr>
													<?php if ($Prevtcnt == 1) { ?>
													<tr><th>Prev</th>
													<td>None</td></tr>
													<?php } ?>
											<?php } ?>
										<?php } ?>
									<?php }else{ ?>
										<tr><th>Prev</th><td>None</td></tr>
										<tr><th>Next</th><td>None</td></tr>
									<?php } ?>
									</tbody>
								</table>
						</div>
				</div>
				<!--코멘트 끝 -->
		</div>
 	</div>
</div>
<?php include_once "board_footer.php"; //보드공통 PHP푸터 ?>
<?php include_once "../footer.php"; //전체공통 PHP푸터-현재 내용없음 ?>