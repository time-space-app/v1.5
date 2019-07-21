<?php include "../header.php";?>
<?php if($_SESSION['valid_level'] > 3 || $_SESSION['valid_level'] == '') { 
	echo "<script type='text/javascript'>alert(' 스태프 이상 권한만 이용가능 합니다.');</script>";
	echo "<meta http-equiv='Refresh' content='0;url=/$flugin_url/board/login.html'>";
	exit;
}
?>
<div class="page">

<?php
// connection to the database 
$dbhandle = mysql_connect($db_host, $db_user, $db_pass) 
   or die("Unable to connect to MySQL"); 

// select a database to work with 
$selected = mysql_select_db($db_name, $dbhandle) 
   or die("Could not select examples"); 

// return all available tables 
$result_tbl = mysql_query( "SHOW TABLES FROM ".$db_name, $dbhandle ); 

$tables = array(); 
while ($row = mysql_fetch_row($result_tbl)) { 
   $tables[] = $row[0]; 
} 


function table_description($t,$d){ 
     $sql = "SELECT TABLE_COMMENT,TABLE_NAME FROM INFORMATION_SCHEMA.TABLES  
      WHERE TABLE_NAME = '$t'"; 
     $query = mysql_query($sql,$d) or die(mysql_error()); 
     $v = mysql_fetch_row($query); 
     if($v){
     	 //$kim =  iconv('EUC-KR','UTF-8', $v[0]);
         return $v[0]; 
         } 
     return 'Table description not found'; 
     } 
?>
<h1>
<a href="#" class="history-back"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
ERD<small class="on-right">Entity-Relationship Diagram(작업한 테이블 개수= <?php echo count($tables)-4?>개)</small>
</h1>
	<div class="grid">
	    <div class="row">
	        <?php include "../submenu.php";?>
		<div class="span9">
		<STYLE TYPE='text/css'> 
		table.excel{
		  margin: 0 auto; padding: 0; line-height: 21px;
		  border-top: 2px solid #999999;
		  border-bottom: 2px solid #999999;
		  border-collapse: collapse;
		}
		table.excel th, table.excel td{
		  margin: 0; padding: 3px 0; width: 160px; 
		  text-align: center;
		  border-bottom: 1px solid #cccccc;
		}
		table.excel thead th{
		  background-color: #e9e9e9;
		  border-bottom: 1px solid #999999;
		}
		table.excel tfoot th, table.excel tfoot td{
		  border-bottom: none;
		  background-color: #e2e2e2;
		}
		</style>
		<script type="text/javascript" language="javascript">
		  function imgPop(url) {
		   window.open(url,"","width=1024, height=768, scrollbars=1, menubar=no, resizable=1"); 
		  }
		 </script>


		<div class="accordion" data-role="accordion" data-closeany="true">
		
		<div class="accordion-frame">
		<a href="#" class="heading">▶테이블 관계도(클릭하시면 아래 내용이 나타납니다.)</a>
		<div class="content">
		
			<div class="tab-control" data-role="tab-control" style="font-size:16px;line-height:14px;">
			<ul class="tabs">
			<li class="active"><a href="#_page_1" style="font-weight:bold;"><i class="icon-zoom-in on-right"></i>영문 확대이미지</a></li>
			<li><a href="#_page_2" style="font-weight:bold;"><i class="icon-zoom-in on-right"></i>한글 확대이미지</a></li>
			</ul>
			<div class="frames">
				<div class="frame" id="_page_1">
				<a href="javascript:imgPop('/<?php echo $flugin_url ?>/erd/model.jpg');"><img src="/<?php echo $flugin_url ?>/erd/model.jpg" title="개체관계도"></a>
				</div>
				<div class="frame" id="_page_2">
				<a href="javascript:imgPop('/<?php echo $flugin_url ?>/erd/model_ko.jpg');"><img src="/<?php echo $flugin_url ?>/erd/model_ko.jpg" title="개체관계도"></a>
				</div>
			</div>
			</div>

		</div>
		</div>
		
		<div class="accordion-frame">
		<a class="heading" href="#">▶테이블 구조보기(클릭하시면 아래 내용이 나타납니다.)
		실제테이블과 연동 되어있습니다.</a>
		<div class="content" style="color:#000">
		
		<script>
		        function SnagIt(erd){                 
		                frmExcel.action="/<?php echo $flugin_url ?>/erd/erd_down.php";
		                frmExcel.strBuffer.value= erd;
		                //alert(frmExcel.strBuffer.value);//디버그
		                frmExcel.submit();
		        }
		</script>
		<form method=post name=frmExcel>
		<input type=hidden name=strBuffer>
		<button onclick="SnagIt(document.getElementById('excel_down').innerHTML)">Excel_Download</button>
		<div id="excel_down">

		<?php
		foreach ( $tables as $table ) { 
		   if($table=="T_CMS"||preg_match('/_MENU/',$table)){continue;}
		   	else
		   	{
			   $i++;
			   $table_comment = table_description($table,$dbhandle);
			   ?>
			  <table class="excel">
			  <thead>
			    <tr><th colspan="5" style="text-align:left">&nbsp;▦ <?php echo $i?>테이블명: <?php echo $table."[".$table_comment."]"?></th><tr>
			    <tr><th>필드명</th> <th>데이터형</th> <th>고유키</th> <th>Null허용</th> <th>설명</th></tr>
			  </thead>
			 	<tbody>  
			<?php   
			   $result_fld = mysql_query( "SHOW FULL COLUMNS FROM ".$table, $dbhandle ); 
			}
			while( $row1 = mysql_fetch_row($result_fld) ) {  
			      //$comment =  iconv('EUC-KR','UTF-8', $row1[8]);
			      $comment = $row1[8];
			?>
			      <tr>
			      <td><?php echo $row1[0]?></td><td><?php echo $row1[1]?></td><td><?php echo ($row1[4] == "PRI")? "yes" : "" ?></td><td><?php echo $row1[3]?></td><td><?php echo $comment?></td>
			      </tr>
			<?php  } ?>
			</tbody>
		   </table>
		<?
		} 
		// close the connection 
		mysql_close($dbhandle); 
		?>
		</div> 
		</form>
		
		</div></div></div>
</div></div></div>
<?php include "../footer.php";?>