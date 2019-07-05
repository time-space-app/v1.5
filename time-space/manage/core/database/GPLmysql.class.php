<?php
//mySQL 4버전 이하에서 사용
global $db_host,$db_user,$db_pass,$db_name;
$db_host = $GPLdb_host;
$db_user = $GPLdb_user;
$db_pass = $GPLdb_pass;
$db_name = $GPLdb_name;
class GPLmysqli extends GPLmessage{
	var $db_host,$db_user,$db_pass,$db_name,$db_conn;
	function GPLmysql_connect($db_host='',$db_user='',$db_pass='',$db_name=''){ 
        $argcv = func_get_args();
        call_user_func_array(array(&$this, '__construct'),$argcv);
    	}
	function __construct($db_host='',$db_user='',$db_pass='',$db_name='') {
	global $db_host,$db_user,$db_pass,$db_name;
    	$this->db_host = $db_host;
	$this->db_user = $db_user;
	$this->db_pass = $db_pass;
	$this->db_name = $db_name;
        $this->db_conn = @mysql_connect($this->db_host,$this->db_user,$this->db_pass) or die("데이타 베이스에 접속이 불가능합니다.");
        @mysql_query("set names utf8");//한글깨져서 추가
        @mysql_select_db( $this->db_name, $this->db_conn);
   	}
	var $sql;
	var $result;
	var $db_error_report;

	function GPLdatabase($db_host='', $db_user='', $db_pass='', $db_name='', $db_error_report=false){
		$this->set_database($db_host, $db_user, $db_pass, $db_name);
	}
	function set_database($db_host='', $db_user='', $db_pass='', $db_name='', $db_error_report=false){
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_name = $db_name;
		$this->db_error_report = $db_error_report;
	}

    	/*
	function GPLmysql_connect($db_host=''){
	$this->db_conn = @mysql_connect($this->db_host, $this->db_user, $this->db_pass) or die ('데이타베이스에 접속할 수 없습니다');
	@mysql_query("set names utf8");//한글깨져서 추가
	@mysql_select_db($this->db_name) or die ('해당 데이타베이스를 선택할 수 없습니다');
	}
	*/
	/**
	 * Stored Procedure 호출 함수.
	 */
	function GPLmysql_call($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect();//프로시저는 1번 호출되면  커넥션이 끊어지기 때문에 매번 연결해 준다
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_fetch_assoc();
	}

	function GPLmysql_connect_check(){
		if (empty($this->db_conn)) {
			$this->GPLmysql_connect();
			$this->db_error_report = true;
		}
	}


	function GPLexcute_query($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->sql = $sql;
		$this->result = @mysql_query($sql, $this->db_conn);
		if (empty($this->result)) {
			if ($this->db_error_report === true) {
				echo '<br>(주의)작업오류가 다음위치에서 발생 되었습니다.'. $sql .'; 관리자에게 문의 하세요.<br>';
			}
			if ($mode == 'return') return false;
			else if ($mode == 'force') return true;
			else $this->GPLmysql_error($mode, $msg, $url);
		}
		else return $this->result;
	}

	function GPLmysql_close(){
		if (!empty($this->db_conn)) if (@mysql_close()) $this->db_conn = '';
	}
	function GPLmysql_error($mode='', $msg='', $url=''){

		if ($mode != 'alert') $this->GPLmysql_close();
		$this->GPLerror($mode, $msg, $url);
	}
	function GPLmysql_query($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->sql = $sql;
		$this->result = @mysql_query($sql, $this->db_conn);
		if (empty($this->result)) {

			if ($this->db_error_report === true) {
				echo $sql . '; <br>' . mysql_errno() . ': '. mysql_error() . '<br>';
			}
			if ($mode == 'return') return false;
			else if ($mode == 'force') return true;
			else $this->GPLmysql_error($mode, $msg, $url);
		}
		else return $this->result;
	}
	function GPLquery_num_rows($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_num_rows();
	}
	function GPLmysql_num_rows(){
		return @mysql_num_rows($this->result);
	}
	function GPLquery_fetch_array($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysqli_fetch_array();
	}
	function GPLmysqli_fetch_array(){

		while ($data = @mysqli_fetch_array($this->result)){
			$fetch_array[] = $data;
		}
		if (empty($fetch_array)) $fetch_array = Array();
		@mysql_free_result($this->result);
		return $fetch_array;
	}
	function GPLquery_fetch_array_all($sql, $mode='', $msg='', $url=''){
		$rows = $this->GPLquery_num_rows($sql, $mode, $msg, $url);
		$fetch_array = $this->GPLmysqli_fetch_array();
		return Array($rows, $fetch_array);
	}
	function GPLquery_fetch_array_one($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysqli_fetch_array_one();
	}
	function GPLmysqli_fetch_array_one(){
		$fetch_array = @mysqli_fetch_array($this->result);
		if (empty($fetch_array)) $fetch_array = Array();
		@mysql_free_result($this->result);
		return $fetch_array;
	}
	function GPLquery_fetch_assoc($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_fetch_assoc();
	}
	function GPLmysql_fetch_assoc(){

		while ($data = @mysql_fetch_assoc($this->result)){
			$fetch_assoc[] = $data;
		}
		if (empty($fetch_assoc)) $fetch_assoc = Array();
		@mysql_free_result($this->result);
		return $fetch_assoc;
	}
	function GPLquery_fetch_assoc_one($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLmysql_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_fetch_assoc_one();
	}
	function GPLmysql_fetch_assoc_one(){
		$fetch_assoc = @mysql_fetch_assoc($this->result);
		if (empty($fetch_assoc)) $fetch_assoc = Array();
		@mysql_free_result($this->result);
		return $fetch_assoc;
	}
	function GPLquery_fetch_assoc_all($sql, $mode='', $msg='', $url=''){
		$rows = $this->GPLquery_num_rows($sql, $mode, $msg, $url);
		$fetch_assoc = $this->GPLmysql_fetch_assoc();
		return Array($rows, $fetch_assoc);
	}
	///* SQL 인젝션 공격에 대한 방어 코드 *///
	function GPLescape_check($sql){
		$this->GPLmysql_connect_check();
		$this->sql = $sql;
		$this->result = @mysql_real_escape_string($sql);
		return $this->result;
		//if (empty($this->result)) {
		//	echo $sql . '; <br>' . mysql_errno() . ': '. mysql_error() . '<br>';
		//}
		//else return $this->result;
	}
	/**
	 * 적용된 행 수를 반환
	 * INSERT, UPDATE, DELETE 질의문만 사용한다.
	 */
	function GPLmysql_affected_rows(){
		$this->GPLmysql_connect_check(); //20120820
		return @mysql_affected_rows($this->db_conn);
	}
	/**
	 * 테이블 존재여부(4.3.7 버전이후로 배제되어 사용안함)
	 * @param unknown_type $table
	 * @return boolean
	 *//*
	function GPLtable_exists($table){
	$this->GPLmysql_connect_check();
	$result = mysql_list_tables($this->db_name);
	if (empty($result)) echo $sql . '; <br>' . mysql_errno() . ': '. mysql_error() . '<br>';
	$find_table = 0;
	while ($temp_table = @mysql_fetch_row($result)) {
	if ($temp_table[0] == $table) {
	$find_table = 1;
	break;
	}
	}
	if ($find_table == 1) return true;
	else return false;
	}*/
	/**
	 * 테이블 목록을 반환(4.3.7 버전이후로 배제되어 사용안함)
	 * @param String $search_str
	 * @param unknown_type $search_pos
	 * @return array
	 *//*
	function GPLget_tables_from_db($search_str='', $search_pos='pre'){
	$this->GPLmysql_connect_check();
	$tables = Array();
	$this->result = mysql_list_tables ($this->db_name);
	$j = 0;
	$rows = $this->GPLmysql_num_rows();
	while ($j < $rows) {
	$table = mysql_tablename ($this->result, $j);
	if (!empty($search_str) && !empty($search_pos) && ($search_pos == 'pre' || $search_pos == 'tail')) {
	if ($search_pos == 'pre'){
	if (!preg_match("`^" . $search_str . "`i", $table)) {

	$j++;
	continue;
	}
	}
	else {
	if (!preg_match("`" . $search_str . "$`i", $table)) {

	$j++;
	continue;
	}
	}
	}
	$tables[] = $table;
	$j++;
	}
	@mysql_free_result($this->result);
	return $tables;
	}*/
}
?>
