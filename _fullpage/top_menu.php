<!-- Menu -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
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
            (str_replace(" ","",$row['L_URL'])=="")?$dropdown="dropdown-toggle":$dropdown="";
            (STRTOLOWER(SUBSTR($row['L_URL'],0,7))=="http://")?$TARGET = "target='_new' ":$TARGET = "";
            if($row['L_URL']==$MENU_CODE) $ACTIVE="active"; else $ACTIVE="";
            if(is_numeric($row['L_URL']))$row['L_URL']="/_fullpage/index.php/CATEGORY/0/MENU_CODE/".$row['L_URL'];
        ?>
			<li class="nav-item <?php echo $ACTIVE?>">
				<a class="nav-link" href="<?php echo $row['L_URL']?>" <?php echo $TARGET?>><?php echo $row['L_NAME']?></a>
			</li>
        <?php }} //대메뉴끝?>
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