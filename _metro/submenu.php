<div class="span3">
            <nav class="sidebar light">
            <ul>
                <li class="title"><?php echo $ROW3['MENU_TITLE']?></li>
                <li class="active"><a href="/<?php echo $flugin_url ?>"><i class="icon-home"></i>Home</a></li>
                <?php
		//중메뉴
		$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, M_NAME, M_URL, USE_YN FROM $T_M_MENU";
		$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = '$L_CODE' ORDER BY SUN ASC, M_CODE ASC";
		$result2 = $GPLdb5->GPLexcute_query($SQL);
		if($result2){
			$cnt=0;
			while($row2 = mysqli_fetch_array($result2)) {
			//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
			(str_replace(" ","",$row2['M_URL'])=="")?$dropdown="dropdown-toggle":$dropdown="";
			(STRTOLOWER(SUBSTR($row2['M_URL'],0,7))=="http://")?$TARGET2 = "target='_new' ":$TARGET2 = "";
			if(is_numeric($row2['M_URL']))$row2['M_URL']="/$flugin_url/sub.php/CATEGORY/1/MENU_CODE/".$row2['M_URL'];
			$cnt++;
			(($cnt % 2) == 0)?$stick="stick bg-green":$stick="stick bg-red";
		?>
                <li class="<?php echo $stick?>">
                    <a class="<?php echo $dropdown?>" href="<?php echo $row2['M_URL']?>" <?php echo $TARGET2?>><i class="icon-tree-view"></i><span style="font-size:13px"><?php echo $row2['M_NAME']?></span></a>
	                    <ul class="dropdown-menu" data-role="dropdown">
	                        <?php
				//소메뉴
				$SQL= "SELECT SEQ, SUN, L_CODE, M_CODE, S_CODE, S_NAME, S_URL, USE_YN FROM $T_S_MENU";
				$SQL.= " WHERE USE_YN = 'Y' AND L_CODE = '$L_CODE' AND M_CODE ='$row2[M_CODE]' ORDER BY SUN ASC, S_CODE ASC";
				$result3 = $GPLdb5->GPLexcute_query($SQL);
				if($result3){
					while($row3 = mysqli_fetch_array($result3)) {
					//css드롭다운디자인적용및 HTTP URL 입력시 새창띄우기
					(STRTOLOWER(SUBSTR($row3['S_URL'],0,7))=="http://")?$TARGET3 = "target='_new' ":$TARGET3 = "";
					if(is_numeric($row3['S_URL']))$row3['S_URL']="/$flugin_url/sub.php/CATEGORY/2/MENU_CODE/".$row3['S_URL'];
				?>
	                        <li><a  href="<?php echo $row3['S_URL']?>" <?php echo $TARGET3?>><span style="font-size:13px"><?php echo $row3['S_NAME']?></span></a></li>
				<?php }} //소메뉴끝?>
	                    </ul>
                </li>
                <?php } } //중메뉴끝 ?>
            </ul>
            </nav>
	</div>