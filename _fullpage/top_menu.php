<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark"><!-- Nav PHP메뉴 -->
	<a class="navbar-brand" href="/" >LOGO</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle Navigation">
		<span class="navbar-toggler-icon"></span>
	</button>	
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
        <?php
        //대메뉴
        $SQL= "SELECT SEQ, SUN, L_CODE, L_NAME, L_URL, USE_YN FROM $T_L_MENU";
        $SQL.= " WHERE USE_YN = 'Y' ORDER BY SUN ASC, L_CODE ASC";
        $result = $GPLdb5->GPLexcute_query($SQL);
        if($result){
            while($row = mysqli_fetch_array($result)) {
            //css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
            (STRTOLOWER(SUBSTR($row['L_URL'],0,7))=="http://")?$TARGET = " target='_new' ":$TARGET = "";
            if($row['L_URL']==$MENU_CODE) $ACTIVE=" active"; else $ACTIVE="";
            if(is_numeric($row['L_URL']))$row['L_URL']="/_fullpage/index.php/CATEGORY/0/MENU_CODE/".$row['L_URL'];
		?>
			<?php
			//중메뉴
			$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, M_NAME, M_URL, USE_YN FROM $T_M_MENU";
			$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = $row[L_CODE] ORDER BY SUN ASC, M_CODE ASC";
			$result2 = $GPLdb5->GPLexcute_query($SQL);
			$num_rows2 = $result2->num_rows;
			if($num_rows2) {
				$dropdown=" dropdown";
				$dropdown_toggle = " dropdown-toggle";
				$dropclass=" id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'";
			}else{
				$dropdown="";
				$dropdown_toggle="";
				$dropclass="";
			}//echo "여기".$dropdown;//디버그
			?>
			<li class="nav-item<?php echo $ACTIVE?><?php echo $dropdown?>">
				<a class="nav-link<?php echo $dropdown_toggle?>" href="<?php echo $row['L_URL']?>"<?php echo $dropclass?><?php echo $TARGET?>><?php echo $row['L_NAME']?></a>
				<?php if($num_rows2) { ?>
					<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
					<?php
					while($row2 = mysqli_fetch_array($result2)) {
					//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
					(str_replace(" ","",$row2['M_URL'])=="")?$dropdown=" dropdown-toggle":$dropdown="";
					(STRTOLOWER(SUBSTR($row2['M_URL'],0,7))=="http://")?$TARGET2 = " target='_new' ":$TARGET2 = "";
					if(is_numeric($row2['M_URL']))$row2['M_URL']="/_fullpage/index.php/CATEGORY/1/MENU_CODE/".$row2['M_URL'];
					?>
						<?php
						//소메뉴
						$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, S_CODE, S_NAME, S_URL, USE_YN FROM $T_S_MENU";
						$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = $row[L_CODE] AND M_CODE = $row2[M_CODE] ORDER BY SUN ASC, S_CODE ASC";
						$result3 = $GPLdb5->GPLexcute_query($SQL);
						$num_rows3 = $result3->num_rows;
						if($num_rows3) {
							$dropdown="dropdown";
							$dropdown_toggle = " dropdown-toggle";
							$dropclass=" id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'";
						}else{
							$dropdown="";
							$dropdown_toggle="";
							$dropclass="";
						}//echo "여기".$num_rows3;//print_r($result3);//
						?>
					<li class="<?php echo $dropdown?>">
						<a class="<?php echo $dropdown_toggle?>" href="<?php echo $row2['M_URL']?>"<?php echo $dropclass?><?php echo $TARGET?>><?php echo $row2['M_NAME']?></a>
						<?php if($num_rows3) { ?>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
							<?php
							while($row3 = mysqli_fetch_array($result3)) {
								//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
								(STRTOLOWER(SUBSTR($row3['S_URL'],0,7))=="http://")?$TARGET3 = "target='_new' ":$TARGET3 = "";
								if(is_numeric($row3['S_URL']))$row3['S_URL']="/_metro/index.php/CATEGORY/2/MENU_CODE/".$row3['S_URL'];
							?>
							<li><a  href="<?php echo $row3['S_URL']?>" <?php echo $TARGET3?>><?php echo $row3['S_NAME']?></a></li>
							<?php } ?>
							</ul>
						<?php } //소메뉴끝?>
					</li>
					<?php } ?>
					</ul>
				<?php }//중메뉴 끝 ?>
			</li>
		<?php }} //대메뉴끝?>
		<!-- 로그인 메뉴 -->
			<?php if($_SESSION['valid_user'] != "") { ?>
				<?php if($_SESSION['valid_level'] < 3) { ?>
				<li class="nav-item">
					<a class="nav-link" title="Intranet" href="/time-space/index.php" target="_new">Admin</a>
				</li>
				<?php } ?>
			<li class="nav-item">
				<a class="nav-link" title="LogOut" href="/time-space/manage/logout.php">LogOut</a>
			</li>
			<?php }else{ ?>
			<li class="nav-item">
				<a class="nav-link" title="Login" href="/time-space/manage/">Login<?php echo $_SESSION['valid_user']; ?></a>
			</li>
			<?php } ?>
			</li>
        <!-- 구글 다국어 플러그인 메뉴 -->
            <li class="nav-item">
					<div id="google_translate_element"></div>
					<script type="text/javascript">
					function googleTranslateElementInit() {
						new google.translate.TranslateElement({pageLanguage: 'ja', includedLanguages: 'en,ko,vi,zh-CN,zh-TW,de,es,fr,la,pt,ru,th', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
					}
					</script>
					<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
					<style>
						.goog-te-gadget {font-family:helvetica,meiryo,gulim,AppleGothic,sans-serif;}
						.goog-te-menu2 {margin-top:5px; border:1px solid #dcdcdc !important;}
						.goog-te-menu2-item div, .goog-te-menu2-item:link div, .goog-te-menu2-item:visited div, .goog-te-menu2-item:active div {color:#000 !important;}
					</style>
            </li>
		</ul>
	</div>	
</nav>
<div class="language active"><!-- 다국어 메뉴 -->
	<div class="language-current">
			<span class="flag flag-ja-JP"></span>
			<div class="language-name">Japanese</div>
	</div>
	<svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="language-triangle">
		<polygon points="0,0 8,0 4, 6">
	</polygon></svg>
	<div class="submenu languages">
			<ul>
				<li><a href="#/en/"><span class="flag flag-en-US"></span><span class="language-name">English</span></a></li>
				<li><a href="#/zh/"><span class="flag flag-zh-CN"></span><span class="language-name">Chinese</span></a></li>
				<li><a href="#/ko/"><span class="flag flag-ko-KR"></span><span class="language-name">Korean</span></a></li>
				<li><a href="#/vi/"><span class="flag flag-vi-VN"></span><span class="language-name">Vietnamese</span></a></li>
			</ul>
	</div>
</div>