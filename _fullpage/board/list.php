<?php include_once "../header.php"; //전체공통 PHP헤더 ?>
<?php include_once "board_header.php"; //보드공통 PHP헤더 ?>
<style> /* 보드 리스트전용 CSS */
	.listview .list-content { text-align: left; }
	.listview .list-content a { color: white; }
</style>
<div class="header section"><!-- 보드 리스트전용 HTML+PHP -->
	<div class="container">
			<div class="row">
				<!--검색영역시작-->
				<div class="form-inline mx-auto">
					<h1>
						<?php echo $title?>&nbsp;&nbsp;<small class="on-right">
						<?php if($BOARD_ID!="notice" && empty($_SESSION['valid_level']) ) { ?>
						<!--회원만 쓰기 가능하십니다.--><?php } ?></small>
					</h1>
					<form method="get" name="form_search" id="form_search" action="/<?php echo $flugin_url ?>/board/list.php">
						<select name="GUBN" id="GUBN" class="form-control">
							<option selected="selected" value="1">ALL</option>
							<option value="2">subject</option>
							<option value="3">content</option>
						</select>
						<input type="text" name="SEARCH" id="SEARCH" size=15 class="form-control" value="">
						<input type="hidden" name="BOARD_ID" id="BOARD_ID" class="form-control" value="<?php echo $BOARD_ID?>">
						<input type="hidden" name="MENU_CODE" id="MENU_CODE" class="form-control" value="<?php echo $MENU_CODE?>">
						<button type="submit" class="btn btn-default">Search</button>
					</form> 
				</div>
				<!--검색영역끝-->
				<div class="col-md-12">
					<table class="table table-striped table-bordered table-hover table-dark text-center" style="opacity: 0.9;">
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
										$num_rows = $result->num_rows;//echo $num_rows; //디버그
										if($num_rows>0){
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
								<tr><td>
								<div class="listview">
										<div class="list-content">
											<a href="/<?php echo $flugin_url ?>/board/view.php?SEQ=<?php echo $row['SEQ']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=view">
											<span><img src="<?php echo get_image_file_from_html($row[CONTENT],1)?>" style="width:80px;float:left;padding-right:10px;"></span>
											<span class="list-title ribbed-darkPink">[<?php echo cut_str($row[TITLE],88,'...')?>]<?php echo ($COMMENT_CNT>0)?"(".$COMMENT_CNT.")":"";?></span>
											<br><span style="font-size:12px;spadding:5px;"><?php echo cut_str($row[CONTENT],388,'...')?></span>
											</a>
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
										</div>
								</div>
								</td></tr>
									<?php
											$i++;
											}
										}
									?>
								<?php if($i==0){?>
								<tr>
								<td>NONE DATA</td>
								</tr>
								<?php } ?>
						</tbody>
					</table>
			
					<!--paging시작-->
					<div class="pagination">
						<ul class="mx-auto">
						<?php
						//================ pageing 출력 10번~12번 code ======================================
								if($start_num > 1){ 	// 10 - 이전 블럭 링크?>
								<li class="page-item d-inline-block"><a class="page-link" href="/<?php echo $flugin_url ?>/board/list.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $before_block?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID=<?php echo $BOARD_ID?>" onFocus="blur()">
								</a></li>
								<?php } ?>&nbsp;
							<?php
								for($i=$start_num; $i<=$end_num; $i++){	// 11 - 페이지 링크
								if(ceil($total_rec/$recnum_per_page) >= $i){
								if($now_page == $i){ ?>
								<li class="page-item d-inline-block active"><a class="page-link"><?php echo $i?></a>
								</li>
									<?php }else{ ?>
								<li class="page-item d-inline-block"><a class="page-link" href="/<?php echo $flugin_url ?>/board/list.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $i?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>" onFocus="blur()">
								<?php echo $i?>
								</a></li>		  	
							<?php         }
								}
								}  ?>&nbsp;
							<?php
								if($end_num * $recnum_per_page < $total_rec){ 	// 12 - 다음 블럭 링크?>
								<li class="page-item d-inline-block"><a class="page-link" href="/<?php echo $flugin_url ?>/board/list.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $next_block?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>" onFocus="blur()">
								</a><li>
						<?php }
						//====================================================================
						?>
						</ul>
					</div>
					<!--paging끝-->
					<!-- 등록버튼 시작 -->
					<div class="d-none">
						<?php if($_SESSION['valid_user'] != "" && $_SESSION['valid_level'] < 3 ) { ?>
						<a href="/<?php echo $flugin_url ?>/board/write.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/write">
						<span class="btn btn-info float-right">WRITE</span></a>
						<?php } ?>
						<?php if($_SESSION['valid_user'] != "" && $_SESSION['valid_level'] >=3 && ( $BOARD_ID =='community'||$BOARD_ID == 'qa' ) ) { ?>
						<a href="/<?php echo $flugin_url ?>/board/write.php/MENU_CODE/<?php echo $MENU_CODE?>/now_page/<?php echo $now_page?>/GUBN/<?php echo $GUBN?>/SEARCH/<?php echo $SEARCH?>/BOARD_ID/<?php echo $BOARD_ID?>/MODE/write">
						<span class="btn btn-info float-right">WRITE</span></a>
						<?php } ?>
					</div>
					
				</div>
			</div>
	</div>
</div>
<?php include_once "board_footer.php"; //보드공통 PHP푸터 ?>
<?php include_once "../footer.php"; //전체공통 PHP푸터-현재 내용없음 ?>