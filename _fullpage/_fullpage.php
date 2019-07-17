<?php include_once "header.php";?><!-- 코어 PHP코드 -->
<!doctype html>
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
	<body>
		<?php include_once "top_menu.php"; //메뉴 PHP코드 ?>
		<div id="fullpage"><!-- 1페이지 스크롤 영역 Start -->
			<div class="header section" data-anchor="header"><!-- 헤더 게시판PHP코드 -->
				<div class="container">
					<div class="slide active">
						<div class="row">
						<?php
							//게시판 공통변수 항상 페이지 상단에 위치
							$GUBN = $_REQUEST['GUBN'];
							$SEARCH = $_REQUEST['SEARCH'];
							$BOARD_ID = $_REQUEST['BOARD_ID'];
							$MODE = $_REQUEST['MODE'];
							$BOARD_SEQ = $_REQUEST['SEQ'];
									if(!$BOARD_ID) $BOARD_ID = "notice"; //notice, qa, repair, pds, faq
									$now_page = $_REQUEST['now_page'];
							?>
							<?php
								//페이징설정 넘버링 시작
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
								$recnum_per_page = 3;
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
							<style>
							.listview .list-content { text-align: left; }
							.listview .list-content a { color: white; }
							</style>
									<div class="mx-auto table text-center">
									<h1>
										<?php echo $title?>&nbsp;&nbsp;<small class="on-right">
										<?php if($BOARD_ID!="notice" && empty($_SESSION['valid_level']) ) { ?>
										<!--회원만 쓰기 가능하십니다.--><?php } ?></small>
									</h1>
									</div>
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
										<div class="col-md-4 float-left">
											<table class="table table-striped table-bordered table-hover table-dark text-center" style="opacity: 0.9;">
											<tbody><tr><td>
												<div class="listview">
													<div class="list-content">
														<a href="board/view.php?SEQ=<?php echo $row['SEQ']?>&now_page=<?php echo $now_page?>&GUBN=<?php echo $GUBN?>&SEARCH=<?php echo $SEARCH?>&BOARD_ID=<?php echo $BOARD_ID?>&MODE=view">
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
											</tbody>
											</table>
										</div>
											<?php
												$i++;
												}
											?>
											<?php }else{ ?>
										<div class="col-md-12 float-left">
											<table class="table table-striped table-bordered table-hover table-dark text-center" style="opacity: 0.9;">
											<tbody><tr><td>
											<div class="listview">
											<div class="list-content text-center">NONE DATA</div>
											</div></td></tr></tbody></table>
										</div>
											<?php } ?>
									
						</div>
					</div>
					<div class="slide">
						<div class="row">
							<div class="d-none d-md-block col-md-3 col-sm-3">
								<img src="/_fullpage/images/lock-icon.jpg" class="cover-image float-right">
							</div>
							<div class="col-md-9 col-sm-9">
								<h3><span class="highlight">O O O O O O O学校</span></h3>
								<p>２１世紀を迎え世界の国際化が急速に進むに従い、日本でも学術、文化、</p>
								<p>経済など様々な分野で日本から世界各国に </p>
								<p>今、次の時代を担う若者たちは世界各国の人々と共に学び、生活し、交流を持つことを願い、 </p>
								<p>適切な指導と環境を渇望しています。</p>
								<p>本校の設立目的はこのような時代的要求に応え、</p>
								<p>日本語教育を通して諸外国との友好と相互理解を進め、</p>
								<p>異文化交流の架け橋となる人材を育成することにあります。 </p>
								<p>そのために日本語教育だけに限らず、教える側の学生たちに対する理解にも気を配り、</p>
								<p>学校と地域住民が留学生と諸外国により深い理解が持てるように学校行事を企画していくつもりです。</p>
								<h4>校長 O O O O</h4>
							</div>
						</div>
					</div>
					<div class="slide">
						<div class="row">
							<div class="d-none d-md-block col-md-3 col-sm-3">
								<img src="/_fullpage/images/lock-icon.jpg" class="cover-image float-right">
							</div>
							<div class="col-md-9 col-sm-9">
								<h3><span class="highlight">O O O O O O O学校</span></h3>
								<p>２１世紀を迎え世界の国際化が急速に進むに従い、日本でも学術、文化、</p>
								<p>経済など様々な分野で日本から世界各国に </p>
								<p>今、次の時代を担う若者たちは世界各国の人々と共に学び、生活し、交流を持つことを願い、 </p>
								<p>適切な指導と環境を渇望しています。</p>
								<p>本校の設立目的はこのような時代的要求に応え、</p>
								<p>日本語教育を通して諸外国との友好と相互理解を進め、</p>
								<p>異文化交流の架け橋となる人材を育成することにあります。 </p>
								<p>そのために日本語教育だけに限らず、教える側の学生たちに対する理解にも気を配り、</p>
								<p>学校と地域住民が留学生と諸外国により深い理解が持てるように学校行事を企画していくつもりです。</p>
								<h4>校長 O O O O</h4>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="section" data-anchor="section1"><!-- 첫 번째 섹션 -->
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<h2>Fastest way to<br><strong>present your design</strong></h2>
							<p>Symu is an easy to use tool for web designers. With the help of our system you can present your projects in a browser for free. It is all very easy!</p>
							<p><strong>Drop your project anywhere</strong><br>Symu will prepare a mockup of your website for you!</p>
						</div>
						<div class="col-md-7">
							<img src="/_fullpage/images/symu-panel-1.png">
						</div>
					</div>
				</div>
			</div>
			<div class="section" data-anchor="section2"><!-- 두 번째 섹션. 흰 배경 -->
				<div class="container">
					<div class="row">
						<div class="col-md-7">
							<img src="/_fullpage/images/symu-panel-2.png">
						</div>
						<div class="col-md-5">
							<h2>The simplest way to<br><strong>get feedback from your clients!</strong></h2>
							<p><strong>You can add a comment anywhere</strong> on a project, this is a fast and easy way to gather input and proposed changes from your client. Click anywhere on a project and leave your thoughts.</p>
							<p><strong>Every added comment becomes a task! </strong> Thanks to this solution you can easily mark the changes you have made.</p>				
						</div>
					</div>
				</div>
			</div>
			<div class="section" data-anchor="section3"><!-- 세 번째 섹션  -->
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<h2>Support for<br><strong>Responsive projects</strong></h2>
							<p>Projects added to Symu are automatically checked whether they are mobile ready.</p>
							<p>The program will divide your files into responsive versions on its own! You have the option to view the projects in either normal or responsive modes!</p>
						</div>
						<div class="col-md-7">
							<img src="/_fullpage/images/home-panel-3.jpg">
						</div>
					</div>
				</div>	
			</div>
			<div class="d-none-kim19 section" data-anchor="section4"><!-- 네 번째 섹션. 흰색 배경. 모바일 이하 크기에서 감춤  -->
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<img src="/_fullpage/images/envelope-icon.jpg" style="float:left">  
							<h2 class="icon-title">Email<br><strong>notifications</strong></h2>
							<p>An email notification will be sent when your client comments or opens a project. You will know when a client recieves the projects and if he has seen it!</p>
						</div>
						<div class="col-md-6">
							<img src="/_fullpage/images/lock-icon.jpg" style="float:left">　　
							<h2 class="icon-title">Project<br><strong>protection</strong></h2>
							<p>Your projects will be perfectly safe, Symu uses SSL encryption and every project added receives a unique link. Additionally you have the option to secure your project with a password.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="d-none-kim19 dark-bg-stat section" data-anchor="section5"><!-- 다섯 번째 섹션. 짙은 배경 -->
				<div class="container">
					<div class="row">
						<div class="col-md-2">
							<div class="align-center">
								<h3>253</h3>
								Todays uploads
							</div>
						</div>
						<div class="col-md-2">
							<div class="align-center">
								<h3>171092</h3>
								Projects uploaded
							</div>
						</div>
						<div class="col-md-4 align-center">
							<a href="#registerModal" role="button" data-toggle="modal" class="btn btn-danger btn-lg">Sign Up <strong>now</strong></a>
						</div>
						<div class="col-md-2">
							<div class="align-center">
								<h3>931523</h3>
								Project views
							</div>
						</div>
						<div class="col-md-2">
							<div class="align-center">
								<h3>100867</h3>
								Comments posted
							</div>
						</div>					
					</div>
				</div>
			</div>
			<footer class="footer section" data-anchor="footer"><!-- 푸터 -->
				The site owner is not responsible for uploaded images. You can only upload images for which you own the copyright.
			</footer>
		</div><!-- 1페이지 스크롤 영역 End -->
		<button id="moveDown" class="btn btn-outline-primary"><i class="arrow down"></i></button><!-- 아래페이지 이동 버튼 -->
		<!-- jQuery 코어 + Bootstrap 코어 -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
		<!-- 외부 플러그인 js  -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/jquery.fullpage.js"></script>
		<script>/* 사용자 지정js - 서브메뉴 클릭유지 스크립트 */
			$(function($){//(function($){ //다른 방법
				$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
				if (!$(this).next().hasClass('show')) {
					$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				var $subMenu = $(this).next(".dropdown-menu");
				$subMenu.toggleClass('show');

				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
					$('.dropdown-submenu .show').removeClass("show");
				});

				return false;
				});
			})//})(jQuery)
		</script>
		<script>/* 사용자 지정js - fullPage 스크립트 */
			//$(document).ready(function() { //기존
			$("#fullpage").fullpage({    //기존
			//	var myFullpage = new fullpage("#fullpage",{ //3.x 버전은 더이상 오픈소스가 아니라서, 2.x로 변경
					anchors: ['header', 'section1', 'section2', 'section3', 'section4', 'section5', 'footer'],
					navigationTooltips: ['header', 'section1', 'section2', 'section3', 'section4', 'section5', 'footer'],
					sectionsColor: ['#0798ec','#f2f2f2','#4bbfc3','#7baabe','whitesmoke','#000','#0d121b'],
					navigation: true,
					//loopBottom: true,
					responsiveWidth: 767, //반응형 가로크기 기준
					afterResponsive: function(isResponsive){ //반응형 일때 사용할 액션
						if(isResponsive) {//기존클래스는 d-none d-md-block -> d-none-kim19 으로 변경.
							$(".d-none-kim19").addClass('d-none');
							$("#moveDown").addClass('d-none');
						}else{
							$(".d-none-kim19").removeClass('d-none');
							$("#moveDown").removeClass('d-none');
						}
					},
					afterLoad: function(section_name, section_num){ // 마지막 페이지 도착 확인, onLeave: //페이지 이동 후 확인
							//alert(section_name);alert(section_num);//디버그
							if(section_name=="footer"){
								$("#moveDown").addClass('d-none');
							}else{
								$("#moveDown").removeClass('d-none');
							}
					},
					/* 3.x 버전 전용
					afterLoad: function(none, object, direction){ // 마지막 페이지 도착 확인, onLeave: //페이지 이동 후 확인
							obj = JSON.stringify(object); alert(obj);alert(direction);//디버그
							if(object["isLast"]){
								$("#moveDown").addClass('d-none');
							}else{
								$("#moveDown").removeClass('d-none');
							}
					},
					*/
					//controlArrows: false
			//	});
			}); //기존
			/* 아래페이지 이동 버튼 */
			$(function(){ //3.x 버전은 더이상 오픈소스가 아니라서, 2.x로 변경
					$('#moveDown').click(function (event) {
							event.preventDefault();
							$.fn.fullpage.moveSectionDown();
					});
			});
			/* $(function(){ //3.x 버전 전용
			$(document).on('click', '#moveDown', function(){
				fullpage_api.moveSectionDown();
			});
			*/
		</script>
		<script> /* 다국어선택 버튼 */
			$('.language').click(function (event) {
				event.preventDefault();
				$(this).toggleClass("active");
			});
			$("body").click(function(e){
				if(e.target.className == "language-current" || ((e.target.className).indexOf("flag") != -1) || e.target.className == "language-name") { 
							//alert("don't hide");  
					}
					else {
						$('.language').removeClass('active');
					}
			});
		</script>
</body>
</html>
<?php include_once "footer.php";?><!-- 코어 PHP코드 -->