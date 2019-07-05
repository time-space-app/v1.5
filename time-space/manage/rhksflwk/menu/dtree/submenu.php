<?php include_once $_SERVER['DOCUMENT_ROOT']."/time-space/manage/rhksflwk/auth_only.php" //관리자인증 ?>
<!DOCTYPE html>
<html>
<head>
<meta http - equiv = "p3p" content = 'CP="CAO DSP AND SO " policyref="/w3c/p3p.xml"' >
<meta charset="UTF-8">
	<link rel="StyleSheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
</head>
<body>
<div class="dtree">
	<!-- 
	<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p>
	-->
	<div style="margin:0;padding:0;list-style:none;text-align:center;border-bottom:solid 1px;">
			<div style="float:left;padding-top:5px;">Hi! <?php echo $_SESSION['valid_name']?></div>
			<a href="/time-space/manage/rhksflwk/logout.php" target="_top" style="display:inline-block;" alt="LogOut">
			<img src="/time-space/manage/rhksflwk/menu/logout.jpg" style="float:left;display:inline-block;margin-left:0px;border:0px" title="LogOut" /></a>
	</div><br/>
	<?php if($_SESSION['valid_level'] == '1') { ?>
	<script type="text/javascript">
		<!--
		d = new dTree('d');
		d.add(0,-1,'Management');
		d.add(1,0,'Basic Info','','');
		d.add(2,1,'Member','/time-space/manage/rhksflwk/page/member/list.php','','mainFrame');
		d.add(3,0,'Cms Info','','');
		d.add(4,3,'Cms','/time-space/manage/rhksflwk/page/cms/list.php','','mainFrame');
		d.add(5,0,'Board Info','','');
		d.add(6,5,'Notice','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=notice','','mainFrame');
		d.add(7,5,'Community','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=community','','mainFrame');
		d.add(8,5,'QA','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=qa','','mainFrame');
-		d.add(14,-1,'File-Management','/time-space/index.php','','_top');
		document.write(d);
		//-->
	</script>
	<?php }else {?>
	<script type="text/javascript">
		<!--
		d = new dTree('d');
		d.add(0,-1,'Management');
		d.add(1,0,'Cms Info','','');
		d.add(2,1,'Cms','/time-space/manage/rhksflwk/page/cms/list.php','','mainFrame');
		d.add(3,0,'Board Info','','');
		d.add(4,3,'Notice','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=notice','','mainFrame');
		d.add(5,3,'Community','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=community','','mainFrame');
		d.add(6,3,'QA','/time-space/manage/rhksflwk/board/list.php?BOARD_ID=qa','','mainFrame');
		document.write(d);
		//-->
	</script>
	<?php }?>
</div>
</body>
</html>