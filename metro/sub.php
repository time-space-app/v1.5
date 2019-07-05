<?php include "header.php";?>
<?php //입력값 바인딩
//게시판 공통변수 항상 페이지 상단에 위치
//조회카운터+1
	$proc_edit = "UPDATE T_CMS SET";
	$proc_edit .=" READCOUNT = IFNULL(READCOUNT,0) + 1";
	$proc_edit .=" WHERE";
	$proc_edit .=" L_CODE= '$L_CODE'AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$result = $GPLdb5->GPLexcute_query($proc_edit); //결과값 리턴
//============================
//정보 가져오기 쿼리정리
	$proc_file = "SELECT L_CODE,M_CODE,S_CODE,USER_ID,USER_NM,EMAIL,TITLE,CONTENT,REGDATE,READCOUNT";
	$proc_file .= " FROM T_CMS";
	$proc_file .= " WHERE L_CODE='$L_CODE' AND M_CODE='$M_CODE' AND S_CODE='$S_CODE'";
	$ROW = $GPLdb5->GPLquery_fetch_assoc_one($proc_file);
?>
<div class="page" >
	<h1>
	<a href="#" class="history-back"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
	                    <?php echo $ROW3['MENU_TITLE']?><small class="on-right"></small>
	</h1>
	<div class="grid">
	    <div class="row">
	        <?php include "submenu.php";?>
		<div class="span9">
		    <p class="description padding10 bg-grayLighter" id="_general">
	            <span style="font-size:30px;"><i class="icon-accessibility on-left"></i><?php echo $ROW['TITLE']?></span>
	            </p>
	            <div class="description">
	                <p><?php echo str_replace("<br/>", "\r\n",$ROW['CONTENT']);?></p>
	            </div> 
		</div>
	    </div>
	</div>
<?php include "footer.php";?>