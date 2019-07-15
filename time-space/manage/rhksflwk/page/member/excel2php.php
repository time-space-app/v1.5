<?php include_once $_SERVER['DOCUMENT_ROOT']."/time-space/manage/rhksflwk/auth_only.php" //관리자인증 ?>
<?php
session_start();
define('DS', DIRECTORY_SEPARATOR);
define('GPLDIR', $_SERVER['DOCUMENT_ROOT'].DS.'time-space/manage');
include_once GPLDIR . '/core/config/default.php';
include_once GPLDIR_CLASS . '/GPLbase.class.php';
$GPLbase = new GPLmember($GPLcookie_domain, $GPLurl_default, $GPLpath_default);//상속받은 개체 멤버클래스 사용
$GPLdb5 =& $GPLbase->db5;//db 커넥션 오브젝트생성 MYSQL5
?>
<?php
/////////////////////////////File 업로드/////////////////////////////

	$filename = $_FILES['xls']['name'];//File명
	$filesize = $_FILES['xls']['size'];//File크기
	$file_extension = strtolower(array_pop(explode('.', $filename))) ;//확장자추출
	$path = "./temp";
	umask(0); 
	@mkdir($path, 0777); //업로드 임시디렉토리 생성
	
	$uploaddir = "./temp/". $filename;//실제업로드 위치
	//move_uploaded_file($_FILES['xls']['tmp_name'], $uploaddir);//실제 업로드
	copy($_FILES['xls']['tmp_name'], $uploaddir);
?>
출력내용이 정확합니까?? 
<a href="excel2php2.php?filename=<?php echo $filename?>&mode=insert">디비에 입력하기</a> /   <a href="excel2php2.php?filename=<?php echo $filename?>&mode=del">취소하고 File을 다시업로드 합니다.</a>
<?php
//$_SESSION[chk_code]="YmdHis";
if($_POST[chk_code] == $_SESSION[chk_code] && $_FILES[xls][tmp_name]){
$chk_code = date("YmdHis");//date("YmdHis");
$_SESSION[chk_code] = $chk_code;
$allow_url_override = 1; // Set to 0 to not allow changed VIA POST or GET
if(!$allow_url_override || !isset($file_to_include))
{
	$file_to_include = $_FILES[xls][tmp_name];
}
if(!$allow_url_override || !isset($max_rows))
{
	$max_rows = 0; //USE 0 for no max
}
if(!$allow_url_override || !isset($max_cols))
{
	$max_cols = 0; //USE 0 for no max
}
if(!$allow_url_override || !isset($debug))
{
	$debug = 0;  //1 for on 0 for off
}
if(!$allow_url_override || !isset($force_nobr))
{
	$force_nobr = ($_POST[force_nobr]) ? 1 : 0;  //Force the info in cells not to wrap unless stated explicitly (newline)
}

if((!$allow_url_override || !isset($force_size)) && $force_nobr)
{
	$force_size = 1;  //
}

require_once $_SERVER['DOCUMENT_ROOT'].'/Excel/reader.php';
$data = new Spreadsheet_Excel_Reader();
$data->setUTFEncoder('mb');
$data->setOutputEncoding('utf-8');
$data->read($file_to_include);
error_reporting(E_ALL ^ E_NOTICE);

echo "
<STYLE>
.table_data
{
	border-style:ridge;
	border-width:1;
}

.table_div_out
{
	position : relative;
	overflow : hidden;
	width:100px;
	height:15px;
	padding : 2px 2px 2px 2px;
}

.table_div_in
{
	position : absolute;
	left : 0px;
	top : 17px;
	visibility:hidden;
	border:1px #DDDDDD solid;
	background-color:yellow;
	padding : 5px 5px 5px 5px;
	z-index : 10000;
}

.tab_base
{
	background:#C5D0DD;
	font-weight:bold;
	border-style:ridge;
	border-width:1;
	cursor:pointer;
}
.table_sub_heading
{
	background:#CCCCCC;
	font-weight:bold;
	border-style:ridge;
	border-width:1;
}
.table_body
{
	background:#F0F0F0;
	font-wieght:normal;
	font-size:12;
	font-family:sans-serif;
	border-style:ridge;
	border-width:1;
	border-spacing: 0px;
	border-collapse: collapse;
}
.tab_loaded
{
	background:#222222;
	color:white;
	font-weight:bold;
	border-style:groove;
	border-width:1;
	cursor:pointer;
}
</STYLE>
";
function make_alpha_from_numbers($number)
{
	$numeric = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if($number<strlen($numeric))
	{
		return $numeric[$number];
	}
	else
	{
		$dev_by = floor($number/strlen($numeric));
		return "" . make_alpha_from_numbers($dev_by-1) . make_alpha_from_numbers($number-($dev_by*strlen($numeric)));
	}
}
echo "<SCRIPT LANGUAGE='JAVASCRIPT'>
var sheet_HTML = Array();\n";
for($sheet=0;$sheet<count($data->sheets);$sheet++)
{
	$table_output[$sheet] .= "<TABLE CLASS='table_body'>
	<TR>
		<TD>&nbsp;</TD>";
	for($i=0;$i<$data->sheets[$sheet]['numCols']&&($i<=$max_cols||$max_cols==0);$i++)
	{
		$table_output[$sheet] .= "<TD CLASS='table_sub_heading' ALIGN=CENTER>" . make_alpha_from_numbers($i) . "</TD>";
	}
	for($row=1;$row<=$data->sheets[$sheet]['numRows']&&($row<=$max_rows||$max_rows==0);$row++)
	{
		$table_output[$sheet] .= "<TR><TD CLASS='table_sub_heading'>" . $row . "</TD>";
		for($col=1;$col<=$data->sheets[$sheet]['numCols']&&($col<=$max_cols||$max_cols==0);$col++)
		{
			/*
			$proc_save= "INSERT INTO T_MEMBER (LOGIN_ID,USER_NM,HP_NO,USER_EMAIL,USE_YN,CREATE_DT,LOGIN_PWD,USER_LEVEL,AGREE_YN,";
			$proc_save.= " HP_YN) values ";
			$proc_save.= "('".$data[0]."','".$data[1]."','".$data[2]."','".$data[3]."','Y',NOW(),sha1('".$data[0]."'),'9','true','true')";
			$result = $GPLdb5->GPLexcute_query($proc_save); //결과값 리턴
			*/
			
			if($data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'] >=1 && $data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'] >=1)
			{
				$this_cell_colspan = " COLSPAN=" . $data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'];
				$this_cell_rowspan = " ROWSPAN=" . $data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'];
				for($i=1;$i<$data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'];$i++)
				{
					$data->sheets[$sheet]['cellsInfo'][$row][$col+$i]['dontprint']=1;
				}
				for($i=1;$i<$data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'];$i++)
				{
					for($j=0;$j<$data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'];$j++)
					{
						$data->sheets[$sheet]['cellsInfo'][$row+$i][$col+$j]['dontprint']=1;
					}
				}
			}
			else if($data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'] >=1)
			{
				$this_cell_colspan = " COLSPAN=" . $data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'];
				$this_cell_rowspan = "";
				for($i=1;$i<$data->sheets[$sheet]['cellsInfo'][$row][$col]['colspan'];$i++)
				{
					$data->sheets[$sheet]['cellsInfo'][$row][$col+$i]['dontprint']=1;
				}
			}
			else if($data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'] >=1)
			{
				$this_cell_colspan = "";
				$this_cell_rowspan = " ROWSPAN=" . $data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'];
				for($i=1;$i<$data->sheets[$sheet]['cellsInfo'][$row][$col]['rowspan'];$i++)
				{
					$data->sheets[$sheet]['cellsInfo'][$row+$i][$col]['dontprint']=1;
				}
			}
			else
			{
				$this_cell_colspan = "";
				$this_cell_rowspan = "";
			}
			if(!($data->sheets[$sheet]['cellsInfo'][$row][$col]['dontprint']))
			{
				$table_output[$sheet] .= "<TD CLASS='table_data' $this_cell_colspan $this_cell_rowspan>";

				if($force_size){
					$table_output[$sheet] .= "<DIV style='position:relative;'><DIV id='div_".$row."_".$col."' CLASS='table_div_in' onmouseOver='show_div(".$row.", ".$col.", 0);' onmouseOut='show_div(".$row.", ".$col.", 1);'>".nl2br(htmlspecialchars($data->sheets[$sheet]['cells'][$row][$col]))."</DIV>";
					$table_output[$sheet] .= "<DIV CLASS='table_div_out' onmouseOver='show_div(".$row.", ".$col.", 0);' onmouseOut='show_div(".$row.", ".$col.", 1);'>";
				}

				if($force_nobr)
				{
					$table_output[$sheet] .= "<NOBR>";
				}
				$table_output[$sheet] .= nl2br(htmlspecialchars($data->sheets[$sheet]['cells'][$row][$col]));
				if($force_nobr)
				{
					$table_output[$sheet] .= "</NOBR>";
				}

				if($force_size){
					$table_output[$sheet] .= "</DIV></DIV>";
				}

				$table_output[$sheet] .= "</TD>";
			}
		}
		$table_output[$sheet] .= "</TR>";
	}
	$table_output[$sheet] .= "</TABLE>";
	$table_output[$sheet] = str_replace("\n","",$table_output[$sheet]);
	$table_output[$sheet] = str_replace("\r","",$table_output[$sheet]);
	$table_output[$sheet] = str_replace("\t"," ",$table_output[$sheet]);
	if($debug)
	{
		$debug_output = print_r($data->sheets[$sheet],true);
		$debug_output = str_replace("\n","\\n",$debug_output);
		$debug_output = str_replace("\r","\\r",$debug_output);
		$table_output[$sheet] .= "<PRE>$debug_output</PRE>";
	}
	echo "sheet_HTML[$sheet] = \"$table_output[$sheet]\";\n";
}
echo "
function change_tabs(sheet)
{
	//alert('sheet_tab_' + sheet);
	for(i=0;i<" , count($data->sheets) , ";i++)
	{
		document.getElementById('sheet_tab_' + i).className = 'tab_base';
	}
	document.getElementById('table_loader_div').innerHTML=sheet_HTML[sheet];
	document.getElementById('sheet_tab_' + sheet).className = 'tab_loaded';

}

function show_div(arg1, arg2, arg3)
{
	var obj = document.getElementById('div_' + arg1 + '_' + arg2);
	if(arg3 == 0){
		obj.style.visibility = 'visible';
	}else{
		obj.style.visibility = 'hidden';
	}
}
</SCRIPT>";
echo "
<TABLE CLASS='table_body' NAME='tab_table'>
<TR>";
for($sheet=0;$sheet<count($data->sheets);$sheet++)
{
	echo "<TD CLASS='tab_base' ID='sheet_tab_$sheet' ALIGN=CENTER
		ONMOUSEDOWN=\"change_tabs($sheet);\">", $data->boundsheets[$sheet]['name'] , "</TD>";
}

echo 
"<TR>";
echo "</TABLE>
<DIV ID=table_loader_div></DIV>
<SCRIPT LANGUAGE='JavaScript'>
change_tabs(0);
</SCRIPT>";
//echo "<IFRAME NAME=table_loader_iframe SRC='about:blank' WIDTH=100 HEIGHT=100></IFRAME>";
/*
echo "<PRE>";
print_r($data);
echo "</PRE>";
*/
?>
<input type="button" value="Excel File 다시 입력" onClick="location.href='excel2php2.php?filename=<?php echo $filename?>&mode=del'">
<?php
@unlink($_FILES[xls][tmp_name]);
}else{
$chk_code = date("YmdHis");//date("YmdHis");
$_SESSION[chk_code] = $chk_code;
?>
<form name="fExcel" method="post" enctype="multipart/form-data">
<input type="hidden" name="chk_code" value="<?php echo $chk_code?>">
셀 고정 보기 : <input type="checkbox" name="force_nobr" value="1"><br>
엑셀File : <input type="file" name="xls"> <input type="submit" value=" 확 인 ">
</form>
<?php
}
?>
</body>
</html>