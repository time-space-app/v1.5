<?php
/**
 * 문자열관련 함수
 */

 /******************************************************************************
// 유니코드 3byte
 ******************************************************************************/
function cut_str($str, $len, $suffix="…")
{
		$str = strip_tags(stripslashes(trim($str)));
		$c = substr(str_pad(decbin(ord($str{$len})),8,'0',STR_PAD_LEFT),0,2);
		if ($c == '10')
			for (;$c != '11' && $c{0} == 1;$c = substr(str_pad(decbin(ord($str{--$len})),8,'0',STR_PAD_LEFT),0,2));
		return substr($str,0,$len) . (strlen($str)-strlen($suffix) >= $len ? $suffix : '');
}

/******************************************************************************
한글을 고려하여 문자열를 Byte기준으로 자른다.
******************************************************************************/
function str_bytecut($string, $length, $suffix="..") {
	$string = strip_tags(stripslashes(trim($string))); //$string의 태그제거 10. 12
	if (strlen($string) <= $length)
		return $string;
	$cpos = $length - 1;
	$count_2B = 0;
	$lastchar = $string[$cpos];
	while (ord($lastchar)>127 && $cpos>=0) {
		$count_2B++;
		$cpos--;
		$lastchar = $string[$cpos];
	}
	if($count_2B % 2) $length--;

	return substr($string, 0, $length).$suffix;
}
/******************************************************************************
 숫자를 한글명으로 바꾼다. ( 예: 1234 -> 일이삼사 )
******************************************************************************/
function NumberToHangul($number){
	$num = array('', '일', '이', '삼', '사', '오', '육', '칠', '팔', '구');
	$unit4 = array('', '만', '억', '조', '경');
	$unit1 = array('', '십', '백', '천');

	$res = array();
	$number = preg_replace('/,/','',$number);
	$split4 = str_explode(strrev((string)$number),4);

	for($i=0;$i<count($split4);$i++){
		$temp = array();
		$split1 = str_explode((string)$split4[$i], 1);
		for($j=0;$j<count($split1);$j++){
			$u = (int)$split1[$j];

			if($u > 0) $temp[] = $num[$u].$unit1[$j];
		}
		if(count($temp) > 0) $res[] = implode('', array_reverse($temp)).$unit4[$i];
	}

	return implode('', array_reverse($res));
}
/******************************************************************************
 배열안의 값에 대한 인코딩을 변경
******************************************************************************/
function conv($array){
	$output = array();
	$param = array(&$this, &$output);
	$obj = new myClass();
	array_walk($array, array($obj,'enc_conv'));
	//array_walk($array, 'enc_conv', &$param);//php5.4 에서 에러나서 위 코드로 수정

	return $output;
}
Class myClass
{
  public function enc_conv($v, $k, $param){
	if(is_array($v)){
		//$v = $param[0]->conv($v);
		$v = conv($v);
	} else if (is_string($v)){
		$v = iconv("utf-8","euc-kr", $v);
	}
	$param[1][$k] = $v;
}
}

/******************************************************************************
 추가하세요
******************************************************************************/
if (!function_exists('json_encode')) {
    function json_encode($data) {
        switch ($type = gettype($data)) {
            case 'NULL':
                return 'null';
            case 'boolean':
                return ($data ? 'true' : 'false');
            case 'integer':
            case 'double':
            case 'float':
                return $data;
            case 'string':
                return '"' . addslashes($data) . '"';
            case 'object':
                $data = get_object_vars($data);
            case 'array':
                $output_index_count = 0;
                $output_indexed = array();
                $output_associative = array();
                foreach ($data as $key => $value) {
                    $output_indexed[] = json_encode($value);
                    $output_associative[] = json_encode($key) . ':' . json_encode($value);
                    if ($output_index_count !== NULL && $output_index_count++ !== $key) {
                        $output_index_count = NULL;
                    }
                }
                if ($output_index_count !== NULL) {
                    return '[' . implode(',', $output_indexed) . ']';
                } else {
                    return '{' . implode(',', $output_associative) . '}';
                }
            default:
                return ''; // Not supported
        }
    }
}
/******************************************************************************
 html에서 img 추출하기
******************************************************************************/
function get_image_file_from_html($html,$role=null) {
	$pattern = '@<img\s[^>]*src\s*=\s*(["\'])?([^\s>]+?)\1@i';
	$matches = array();
	$cnt = preg_match_all($pattern,$html,$output);
	if(!empty($output[2][0])) {
		if($role==1)
			$retArray = $output[2][0];
		else
			$retArray = $output[2];
	} else {
	$retArray = "/_metro/image/small_logo.png";
	}
	return $retArray;
}
/******************************************************************************
 html에서 모든 OBJECT 바인딩
******************************************************************************/
function ALL_BIND($ROW){
	$OBJ_KEY = array_keys($ROW);
	$keycnt=count($OBJ_KEY);
	for($a=0; $a<$keycnt; $a++){
	$KEY= $OBJ_KEY[$a];
	$VALUE= $ROW[$OBJ_KEY[$a]];
	if ($KEY=="LOGIN_PWD")$KEY="HIDDEN_PWD";
	if ($KEY=="PROFILE_INFO")continue;
	if ($KEY=="CONTENT")continue;
	if ($KEY=="INFO_DESIGN")continue;
	if ($KEY=="INFO_SERVICE")continue;
	if ($KEY=="ORDER_CONTENT")continue;
	ECHO"
	<script type='text/javascript'>
	$(document).ready( function() {
		if($('#$KEY').val()!='true')
		$('#$KEY').val('$VALUE');
	});
	</script>";
	}
}
/******************************************************************************
 html에서 CHECKLIST+단일checkbox 바인딩
******************************************************************************/
function CHECKLIST_BIND($DATA,$OBJ_NAME){
		$arrexpert = explode(",",$DATA);
		$expertcnt=count($arrexpert);
	for($a=0; $a<$expertcnt; $a++){
	ECHO"
	<script type='text/javascript'>
	$(document).ready( function() {
		var obj = document.getElementsByName('$OBJ_NAME');
		for (var i = 0 ; i < obj.length; i++) {
		if (obj[i].value == '$arrexpert[$a]' && '$arrexpert[$a]'!='') obj[i].checked = true;
		}
	});
	</script>";
	}
}
/******************************************************************************
 html에서 단일checkbox 바인딩
******************************************************************************/
function CHECKBOX_BIND($DATA,$OBJ_NAME){
	ECHO"
	<script type='text/javascript'>
	$(document).ready( function() {
		var obj = document.getElementsByName('$OBJ_NAME');
		if (obj[0].value == '$DATA') obj[0].checked = true;
	});
	</script>";
}
/******************************************************************************
 html에서 개별 OBJECT 바인딩
******************************************************************************/
function OBJ_BIND($DATA,$OBJ_NAME){
	ECHO"
	<script type='text/javascript'>
	$(document).ready( function() {
		$('#$OBJ_NAME').val('$DATA');
	});
	</script>";
}
/******************************************************************************
 PHP EMPTY VALUE -> 0
******************************************************************************/
function EMPTY_ZERO($DATA){
	if (empty($DATA))
	{
	  return "0";
	}else{
	  return $DATA;
	}
}
/******************************************************************************
 html에서 모든 OBJECT 바인딩
******************************************************************************/
function ALL_BIND_IE8($ROW){
	$OBJ_KEY = array_keys($ROW);
	$keycnt=count($OBJ_KEY);
	for($a=0; $a<$keycnt; $a++){
	$KEY= $OBJ_KEY[$a];
	$VALUE= $ROW[$OBJ_KEY[$a]];
	if ($KEY=="LOGIN_PWD")$KEY="HIDDEN_PWD";
	if ($KEY=="PROFILE_INFO")continue;
	if ($KEY=="CONTENT")continue;
	if ($KEY=="INFO_DESIGN")continue;
	if ($KEY=="INFO_SERVICE")continue;
	if ($KEY=="ORDER_CONTENT")continue;
	ECHO"
	<script type='text/javascript'>
		if($('#$KEY').val()!='true')
		$('#$KEY').val('$VALUE');
	</script>";
	}
}
/******************************************************************************
 html에서 CHECKLIST+단일checkbox 바인딩
******************************************************************************/
function CHECKLIST_BIND_IE8($DATA,$OBJ_NAME){
		$arrexpert = explode(",",$DATA);
		$expertcnt=count($arrexpert);
	for($a=0; $a<$expertcnt; $a++){
	ECHO"
	<script type='text/javascript'>
		var obj = document.getElementsByName('$OBJ_NAME');
		for (var i = 0 ; i < obj.length; i++) {
		if (obj[i].value == '$arrexpert[$a]' && '$arrexpert[$a]'!='') obj[i].checked = true;
		}
	</script>";
	}
}
/******************************************************************************
 html에서 단일checkbox 바인딩
******************************************************************************/
function CHECKBOX_BIND_IE8($DATA,$OBJ_NAME){
	ECHO"
	<script type='text/javascript'>
		var obj = document.getElementsByName('$OBJ_NAME');
		if (obj[0].value == '$DATA') obj[0].checked = true;
	</script>";
}
/******************************************************************************
 html에서 개별 OBJECT 바인딩
******************************************************************************/
function OBJ_BIND_IE8($DATA,$OBJ_NAME){
	ECHO"
	<script type='text/javascript'>
		$('#$OBJ_NAME').val('$DATA');
	</script>";
}
/**************************************************************************
폴더에서 File명 추출하기
**************************************************************************/
function myallfile($dir, $ext = '')
{
        $file_arr = array();
        if (is_dir($dir))
        {
                if ($dh = opendir($dir))
                {
                        while (($file = readdir($dh)) !== false)
                        {
                                $type = filetype($dir . $file);

                                if($type == 'file')
                                {
                                        if($ext != '')
                                        {
                                                $ext = strtolower($ext);
                                                $temp = explode('.',$file);
                                                if(strtolower($temp[count($temp)-1]) == $ext) $file_arr[] = $file;//$dir.$file;
                                        }
                                        else    $file_arr[] = $file;//$dir.$file;
                                }
                                else if($type == 'dir' && ($file != '.' && $file != '..'))
                                {

                                        $temp = myallfile($file.'/', $ext); //$dir.$file
                                        if(is_array($temp))
                                        {
                                                $file_arr = array_merge($file_arr, $temp);
                                        }
                                }
                        }
                        closedir($dh);
                }
                return $file_arr;
        }
        return 0;
}
/*****************************************************************
이미지 출력 함수
******************************************************************/
function ImageFileExists($path,$filenm)
{
	$upLoad = $_SERVER['DOCUMENT_ROOT']."/time-space/upload/".$path."/".$filenm;
	$exist = file_exists("$upLoad");    //File있는지 검사
	if($exist && $filenm!="")
		$PATH_IMG="/time-space/upload/".$path."/".$filenm.'?'.date(YmdHms);
	 else
	 	$PATH_IMG ="/time-space/upload/none.jpg";
	 return $PATH_IMG;
}
/*****************************************************************
두 날짜 사이 기간
*****************************************************************/
function dateDiff($sStartDate, $sEndDate)
{
    $sStartTime = strtotime($sStartDate);
    $sEndTime = strtotime($sEndDate);

    if($sStartTime > $sEndTime)
        return false;

    $sDiffTime = $sEndTime - $sStartTime;
    $aReturnValue = floor($sDiffTime/60/60/24);
    //$aReturnValue['d'] = floor($sDiffTime/60/60/24);
    //$aReturnValue['d'] = $sDiffTime/60/60/24;
    //$aReturnValue['H'] = sprintf("%02d", ($sDiffTime/60/60)%24);
    //$aReturnValue['i'] = sprintf("%02d", ($sDiffTime/60)%60);

    return $aReturnValue;
}
?>
