<?php
if (!isset($_SESSION)) session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php
//CMS메뉴시스템 공용변수값
$T_L_MENU = "T_L_MENU";
$T_M_MENU = "T_M_MENU";
$T_S_MENU = "T_S_MENU";
$T_CMS = "T_CMS";
?>
<div class="navigation-bar dark">
    <div class="navigation-bar-content container">
        <a href="/metro/" class="element" style="width:150px;">
        <img src="/metro/image/small_logo.png" alt="" style="width:20px;height:20px;vertical-align:middle"/>타임스페이스</a>
        <span class="element-divider"></span>
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
		if(is_numeric($row['L_URL']))$row['L_URL']="/metro/sub.php/CATEGORY/0/MENU_CODE/".$row['L_URL'];
	?>
	<div class="element">
            <a class="<?php echo $dropdown?> fg-white"  href="<?php echo $row['L_URL']?>" <?php echo $TARGET?>><?php echo $row['L_NAME']?></a>
            <ul class="dropdown-menu inverse" id="components-submenu" data-role="dropdown">
                <?php
		//중메뉴
		$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, M_NAME, M_URL, USE_YN FROM $T_M_MENU";
		$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = $row[L_CODE] ORDER BY SUN ASC, M_CODE ASC";
		$result2 = $GPLdb5->GPLexcute_query($SQL);
		if($result2){
			while($row2 = mysqli_fetch_array($result2)) {
			//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
			(str_replace(" ","",$row2['M_URL'])=="")?$dropdown="dropdown-toggle":$dropdown="";
			(STRTOLOWER(SUBSTR($row2['M_URL'],0,7))=="http://")?$TARGET2 = "target='_new' ":$TARGET2 = "";
			if(is_numeric($row2['M_URL']))$row2['M_URL']="/metro/sub.php/CATEGORY/1/MENU_CODE/".$row2['M_URL'];
		?>
                <li><a class="<?php echo $dropdown?>" href="<?php echo $row2['M_URL']?>" <?php echo $TARGET2?>><span style="font-size:13px"><?php echo $row2['M_NAME']?></span></a>
                    <ul class="dropdown-menu inverse" data-role="dropdown">
                    	<?php
			//소메뉴
			$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, S_CODE, S_NAME, S_URL, USE_YN FROM $T_S_MENU";
			$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = $row[L_CODE] AND M_CODE = $row2[M_CODE] ORDER BY SUN ASC, S_CODE ASC";
			$result3 = $GPLdb5->GPLexcute_query($SQL);
			if($result3){
				while($row3 = mysqli_fetch_array($result3)) {
				//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
				(STRTOLOWER(SUBSTR($row3['S_URL'],0,7))=="http://")?$TARGET3 = "target='_new' ":$TARGET3 = "";
				if(is_numeric($row3['S_URL']))$row3['S_URL']="/metro/sub.php/CATEGORY/2/MENU_CODE/".$row3['S_URL'];
			?>
                        <li><a  href="<?php echo $row3['S_URL']?>" <?php echo $TARGET3?>><span style="font-size:13px"><?php echo $row3['S_NAME']?></span></a></li>
			<?php }} //소메뉴끝?>
                    </ul>
                </li>
                <?php }} //중메뉴끝?>
            </ul>
        </div>
	<?php }} //대메뉴끝?>

	<?php if($_SESSION['valid_user'] != "") { ?>
		<?php if($_SESSION['valid_level'] < 3) { ?>
		<a title="Intranet" href="/time-space/index.php" class="element place-right" target="_new"><span class="icon-rocket"></span>Admin</a>
		<span class="element-divider place-right"></span>
		<?php } ?>
        <a title="LogOut" href="/metro/board/logout.php" class="element place-right"><span class="icon-box-add"></span> LogOut</a>
        <span class="element-divider place-right"></span>
        <a title="Mypage" href="/metro/board/join.html" class="element place-right"><span class="icon-star"></span> Mypage</a>
        <?php }else{ ?>
        <a title="Join" href="/metro/board/join.html" class="element place-right"><span class="icon-share-2"></span> Join</a>
        <span class="element-divider place-right"></span>
        <a title="Login" href="/metro/board/login.html" class="element place-right"><span class="icon-github-6"></span>Login</a>
        <?php } ?>
    </div>
</div>