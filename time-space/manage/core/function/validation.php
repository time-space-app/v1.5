<?php
//배열값 전체 addslashes, 재귀호출함수
function GPLaddslashes_array($array=Array()){
  if (is_array($array)){
    foreach($array as $key => $value){
      if (is_array($value)){
        $array[$key] = GPLaddslashes_array($value);
      }
      else {
        $array[$key] = addslashes($value);
      }
    }
  }
  return $array;
}
//현재 마이크로타임 측정함수
function GPLget_microtime(){
  return microtime(1);
}
//현재 스크립트 실행 시간 측정함수
function GPLget_submicrotime($start_microtime, $end_microtime){
  
  return (float)(((int)($end_microtime * 10000) - (int)($start_microtime * 10000)) / 10000);
}
//페이지 리다이렉트 함수
function GPLredirect($message='',$url='') {
  header("Content-Type: text/html; charset=UTF-8");
  if(empty($url))$url=$_SERVER[PHP_SELF];
  if (!@headers_sent()) {
  	echo "<script type='text/javascript'>alert('$message');history.back();</script>";//window.location.href='$url'
  	echo "<noscript>";
  	echo "<meta http-equiv='Refresh' content='0;url=".$url."?data_message=".urlencode($message)."'>";
  	echo "</noscript>";
  	exit;
  }
  else {
    echo "<script type='text/javascript'>alert('$message');history.back();</script>";//window.location.href='$url'
    echo "<noscript>";
  	echo "<meta http-equiv='Refresh' content='0;url=".$url."?data_message=".urlencode($message)."'>";
  	echo "</noscript>";
  	exit;
  }
}
//$_POST의  공백 자료 검증을 한다.
function GPLpost_null_check($key='',$url=''){
	$value = $_POST[$key];
	if(!isset($value) || $value == '') GPLredirect($key."값은 반드시 입력 하셔야 합니다.",$url);
	else return $value;
}
//$_GET, $_POST의 모든 값을 합쳐서 키값을 변수명으로 모두 글로벌로 등록한다. 
function GPLset_request_all(){
  $result = array_merge($_GET, $_POST);
  if (is_array($result)){
    foreach($result as $key => $val){
      $$key = $val;
      global $$key;
    }
  }
}
//$_GET, $_POST의 특정 키값을 가져온다. 둘다 존재할경우 $_POST로 덮어씌움
function GPLget_request_value($key,$default = ''){
	
	$result = array_merge($_GET, $_POST);
	$value =  $result[$key];
	if(!isset($value) || $value == '') return $default;
  else return $value;
}
//$_GET의 특정 키값을 가져온다.
function GPLget_get_value($key,$default = ''){
	$value = $_GET[$key];
	if(!isset($value) || $value == '') return $default;
	else return $value;
}
//$_POST의 특정 키값을 가져온다.
function GPLget_post_value($key,$default = ''){
	$value = $_POST[$key];
	if(!isset($value) || $value == '') return $default;
	else return $value;
}
//두문자열을 처음부터 비교하여 처음에서 일치하는 부분까지 반환한다.
function GPLget_same_sting($str1, $str2){
  $return_str = '';
  $len_str1 = strlen($str1);
  $len_str2 = strlen($str2);
  if ($len_str1 < $len_str2) {
    $check_str1 = $str1;
    $check_str2 = $str2;
    $len_check_str1 = $len_str1;
  }
  else {
    $check_str1 = $str2;
    $check_str2 = $str1;
    $len_check_str1 = $len_str2;
  }
  
  for ($i = 0; $i < $len_check_str1; $i++){
    if ($check_str1[$i] !== $check_str2[$i]) break;
    $return_str .= $check_str1[$i];
  }
  return $return_str;
}
//:::문자열::: 이 포함된 문자열을 같은 이름의 변수로 자동 치환
function GPLreplace_auto($str){
  preg_match_all("`:::([^:]+):::`", $str, $replace, PREG_SET_ORDER);
  if (is_array($replace)) {
    foreach($replace as $val){
      if (is_array($val) && !empty($val)) {
        foreach ($val as $val2) {
          global $$val2;
          $str = str_replace(':::' . $val2 . ':::', $$val2, $str);
        }
      }
    }
  }
  return $str;
}
//문자열 체크
function GPLstring_check($str){ 
  $temp = preg_replace("/[\\x00-\\x7e]/", "", $str);
  if (strlen($temp) %2 != 0) {
    
    $temp_len = strlen($str);
    $temp_len--;
    $str = substr ($str, 0, $temp_len);
  }
  return $str;
}
//문자열 컷팅
function GPLcut_string($str, $max, $tail=''){ 
  $max = $max * 2;
  if (strlen($str) <= $max) return $str;
  else {
    $str = substr ($str, 0, $max);
    $temp = preg_replace("/[\\x00-\\x7e]/", "", $str);
    if (strlen($temp) %2 != 0) {
      
      $max--;
      $str = substr ($str, 0, $max);
    }
    if (!empty($tail)) $str .= $tail;
    return $str;
  }
}
//문자열을 체크한다음 문자열 컷팅
function GPLcut_string_check($str, $max, $tail=''){ 
  
  $str = GPLstring_check($str);
  $str = GPLcut_string($str, $max, $tail='');
  return $str;
}
//특수문자 치환, 폼필드에 값을 집어넣을 경우 사용
function GPLhtmlentities($str, $strip=0){
  $pattern = Array("\"", "'", "<", ">");
  $replace = Array("&quot;", "&#039;", "&lt;", "&gt;");
  //단독으로 사용될 경우 $strip == 1일 경우 에만 실행 
  if ($strip == 1) $str = stripslashes($str);
  $str = str_replace($pattern, $replace, $str);
  return str_replace("&amp;", "&", $str);;
}
//출력시 공백이나 탭 치환
function GPLchange_space($str, $strip=0){
  //단독으로 사용될 경우 $strip == 1일 경우 에만 실행 
  if ($strip == 1) $str = stripslashes($str);
  return str_replace(array(" ", "\t"), array("&nbsp;", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"), $str);
}
//한줄 출력
function GPLecho_oneline($str, $mode='text', $strip=0, $max=0, $tail='') {
  if ($strip == 1) $str = stripslashes($str);
  if ($mode != 'html') {
    if ($max > 0) $text = GPLcut_string_check($str, $max, $tail);
    $str = GPLspace_change(GPLhtmlentities($str));
  } 
  else {
    if ($max > 0) $str = GPLcut_string_check($str, $max, $tail);
  }
  return $str;
}
//여러줄 출력
function GPLecho_multiline($str, $mode='text', $strip=0, $max=0, $tail='') {
  if ($strip == 1) $str = stripslashes($str);
  if ($mode != 'html') {
    if ($max > 0) $text = GPLcut_string_check($str, $max, $tail);
    $str = GPLspace_change(GPLhtmlentities($str));
    $str = nl2br(GPLhtmlentities($str));
  } 
  else {
    //처리없음
  }
  return $str;
}
//url의 쿼리부분의 각 밸루값만 urlencode
function get_urlencode_query($url){
}
/*
function get_urlencode_query($url){
  list($url_path, $url_query) = explode('?', $url);
  if (!empty($url_query)) {
    $return = '';
    parse_str($url_query, $temp);
    if (is_array($temp)){
      foreach($temp as $key => $val){
        $return .= '&' . $key . '=' . urlencode($val);
      }
      $return = preg_replace("`^&`", '', $return);
    }
  }
  return (empty($return)) ? $url_path : $url_path . '?' . $return;
}
*/
//암호화 함수
function GPLcrypt($str, $key, $mode=''){ 
  /*사용방법
  암호화 $mode = 1;
  복호화 $mode = 0;
  */
  $temp = '';
  if ($mode != 1) $str = base64_decode($str);
  $cnt = 0; 
  $length = strlen($str);
  $length1 = strlen($key);
  for ($i=0; $i < $length; $i++) { 
    if ($cnt == $length1) $cnt = 0; 
    $temp .= substr($str, $i, 1) ^ substr($key, $cnt, 1); 
    $cnt++; 
  }
  if ($mode == 1) $temp =  base64_encode($temp);
  return $temp;
}
//배열의 값 출력하기
function GPLecho_array($array, $depth=0){
  if (is_array($array)) {
    foreach($array as $key => $val){
      for ($i = 0; $i < $depth; $i++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
      echo "[$key]=><br>";
      if (is_array($val)) {
        
        $j = $depth + 1;
        GPLecho_array($val, $j);
      }
      else{
        for ($i = 0; $i < $depth; $i++) echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -> ' . $val . '<br>';
      }
    }
  }
}

/**
 * 배열안의 값에 대한 인코딩을 변경.
 * @param 배열
 * @return 변환된배열
 */
/*
function conv($array){
	$output = array();
	$param = array(&$this, &$output);

	array_walk($array, 'enc_conv', &$param);

	return $output;
}
function enc_conv($v, $k, $param){
	if(is_array($v)){
		//$v = $param[0]->conv($v);
		$v = conv($v);
	} else if (is_string($v)){
		$v = iconv("utf-8","euc-kr", $v);
	}
	$param[1][$k] = $v;
}*/
?>