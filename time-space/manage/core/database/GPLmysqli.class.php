<?php //if ( ! defined('GPLDIR_DEFAULT')) exit('No direct script access allowed');

/**
 * DATABASE 클래스
 * 
 * MySQL 5버전 이상  mysqli 사용한다.
 */

class GPLmysqli extends GPLmessage{
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	private $db_conn;
	private $sql;
	private $result;
	private $db_error_report;

	/**
	 * DATABASE 설정 함수
	 * 생성자에서 DB 정보를 저장하고 연결은 하지 않는다.
	 * 필요할때만 connect() 함수로 연결해서 사용한다.
	 */
	public function __construct($db_host='', $db_user='', $db_pass='', $db_name='', $db_error_report=false){
		$this->set_database($db_host, $db_user, $db_pass, $db_name);
	}
	private function set_database($db_host='', $db_user='', $db_pass='', $db_name='', $db_error_report=false){
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_name = $db_name;
		$this->db_error_report = $db_error_report;
	}
	/**
	 * DataBase 연결 함수
	 * 설정파일을 참조하여 연결하며 기본 인코딩은 UTF-8
	 * @filesource config/db.php
	 */
	public function GPLmysql_connect(){
		$this->db_conn = @mysqli_connect ($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die ('데이타베이스에 접속할 수 없습니다');
		@mysqli_query($this->db_conn, "set names utf8");//euckr
		@mysqli_select_db($this->db_conn, $this->db_name) or die ('해당 데이타베이스를 선택할 수 없습니다');
	}
	/**
	 * DataBase 연결 상태 체크
	 * 연결이 안되있을 경우 재연결
	 */
	private function GPLmysql_connect_check(){
		if (empty($this->db_conn)) {
			$this->GPLmysql_connect();
			$this->db_error_report = true;
		}
	}

	/**
	 * 일반 쿼리 실행용 함수
	 * @param String $sql
	 * @param String $mode
	 * @param String $msg
	 * @param String $url
	 */
	public function GPLexcute_query($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->sql = $sql;
		$this->result = mysqli_query($this->db_conn, $sql);
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
	/**
	 * 프로시저 호출용 함수
	 * @param String $ProcCommand
	 * @return array $recodeSet
	 */
	public function GPLexcute_proc($ProcCommand){
		$recodeSet = array();
		//프로시저 호출 시 multi_query를 사용한다.
		$this->GPLmysql_connect_check();//커넥션 유지여부확인 후 재커넥션처리(20120810추가)
		if (mysqli_multi_query($this->db_conn, $ProcCommand)) {
			do {
				if ($this->result = mysqli_store_result($this->db_conn)) {
					$recodeSet = $this->GPLmysql_fetch_assoc();
				}
			} while (mysqli_next_result($this->db_conn));
		}
		return $recodeSet;
	}
	
	/**
	 * 동적 쿼리문 에서 필드명 출력
	 * @param unknown_type $stmt
	 * @param unknown_type $out
	 */
	public function GPLstmt_bind_assoc (&$stmt, &$out) {
		$this->GPLmysql_connect_check(); //20120820
		$data = @mysqli_stmt_result_metadata($stmt);
		$fields = array();
		$out = array();

		$fields[0] = $stmt;
		$count = 1;

		while($field = @mysqli_fetch_field($data)) {
			$fields[$count] = &$out[$field->name];
			$count++;
		}
		call_user_func_array(@mysqli_stmt_bind_result, $fields);
	}
	
	/**
	 * 동적쿼리문 사용 시(param = ?)
	 * 인젝션 공격에 안전한 쿼리문 작성시 사용된다.
	 * @param String $sql
	 */
	public function GPLprepare($sql){
		$this->GPLmysql_connect_check();
		$this->result = @mysqli_prepare($this->db_conn, $sql);
		if (empty($this->result)) {
			echo $sql . '; <br>' . @mysqli_errno() . ': '. @mysqli_error() . '<br>';
		}
		else return $this->result;
	}

	/**
	 * 쿼리문에 포함된 특수문자에 역슬래쉬 추가
	 * 되도록 이면 단순 쿼리문일때 GPLprepare를 사용
	 * @param String $sql
	 */
	public function GPLescape_check($sql){
		$this->GPLmysql_connect_check();
		$this->sql = $sql;
		$this->result = @mysqli_real_escape_string($this->db_conn, $sql);
		if (!strcasecmp($sql,($this->result))==0) {
			$this->set_normal_message($sql.': 입력값에 보안상 옳지 않은 값이 있습니다.');
		}
		else return $this->result;
	}
	
	/**
	 * 테이블 존재 여부
	 * @param String $table_name
	 */
	public function GPLexist_table($table_name){
		$this->GPLmysql_connect_check(); //20120820
		$command  = 'SELECT count(*) as tbl FROM information_schema.tables ';
		$command .= "WHERE table_schema = '$this->db_name' AND table_name = '$table_name'";
		$this->result = $this->GPLexcute_query($command);
		$exist = $this->GPLmysql_fetch_assoc_one();
	
		if($exist['tbl'] == '1'){
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 테이블의 총 레코드 수를 가져온다.
	 * @param String $table_name
	 */
	public function GPLtable_rows($table_name, $where=''){
		$this->GPLmysql_connect_check();//커넥션 유지여부확인 후 재커넥션처리(20120810추가)
		$command = "SELECT COUNT(*) AS rowcount FROM $table_name ";
		if($where != ''){
			$command .= " WHERE $where";
		}
		$this->result = $this->GPLexcute_query($command);
		$exist = $this->GPLmysql_fetch_assoc_one();
	
		return $exist['rowcount'];
	}
	/**
	 * 적용된 행 수를 반환
	 * INSERT, UPDATE, DELETE 질의문만 사용한다.
	 */
	public function GPLmysql_affected_rows(){
		$this->GPLmysql_connect_check(); //20120820
		return mysqli_affected_rows($this->db_conn);
	}
	
	/**
	 * 질의 결과 리턴 함수들
	 * 단일 행과 멀티 행을 구분해서 사용하지 않으면 오류가 발생할 수 있음 
	 */
	public function GPLquery_fetch_array($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLexcute_query($sql, $mode, $msg, $url);
		return $this->GPLmysqli_fetch_array();
	}
	public function GPLmysqli_fetch_array(){
		$this->GPLmysql_connect_check(); //20120820
		while ($data = @mysqli_fetch_array($this->result, MYSQLI_ASSOC)){
			$fetch_array[] = $data;
		}
		if (empty($fetch_array)) $fetch_array = Array();
		@mysqli_free_result($this->result);
		return $fetch_array;
	}
	public function GPLquery_fetch_array_all($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check(); //20120820
		$rows = $this->GPLquery_num_rows($sql, $mode, $msg, $url);
		$fetch_array = $this->GPLmysqli_fetch_array();
		return Array($rows, $fetch_array);
	}
	public function GPLquery_fetch_array_one($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLexcute_query($sql, $mode, $msg, $url);
		return $this->GPLmysqli_fetch_array_one();
	}
	public function GPLmysqli_fetch_array_one(){
		$this->GPLmysql_connect_check(); //20120820
		$fetch_array = @mysqli_fetch_array($this->result, MYSQLI_ASSOC);
		if (empty($fetch_array)) $fetch_array = Array();
		@mysqli_free_result($this->result);
		return $fetch_array;
	}
	public function GPLquery_fetch_assoc($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLexcute_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_fetch_assoc();
	}
	public function GPLmysql_fetch_assoc(){
		$this->GPLmysql_connect_check(); //20120820
		while ($data = @mysqli_fetch_assoc($this->result)){
			$fetch_assoc[] = $data;
		}
		if (empty($fetch_assoc)) $fetch_assoc = Array();
		@mysqli_free_result($this->result);
		return $fetch_assoc;
	}
	public function GPLquery_fetch_assoc_one($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check();
		$this->GPLexcute_query($sql, $mode, $msg, $url);
		return $this->GPLmysql_fetch_assoc_one();
	}
	public function GPLmysql_fetch_assoc_one(){
		$this->GPLmysql_connect_check(); //20120820
		$fetch_assoc = @mysqli_fetch_assoc($this->result);
		if (empty($fetch_assoc)) $fetch_assoc = Array();
		@mysqli_free_result($this->result);
		return $fetch_assoc;
	}
	public function GPLquery_fetch_assoc_all($sql, $mode='', $msg='', $url=''){
		$this->GPLmysql_connect_check(); //20120820
		$rows = $this->GPLquery_num_rows($sql, $mode, $msg, $url);
		$fetch_assoc = $this->GPLmysql_fetch_assoc();
		return Array($rows, $fetch_assoc);
	}
	
	/**
	 * DataBase 연결 종료 함수
	 * DB작업 종료 후 연결종료를 하여 리소스 낭비를 막는다.
	 */	
	public function GPLmysql_close(){
		if (!empty($this->db_conn)) if (@mysqli_close()) $this->db_conn = '';
	}
	/**
	 * 에러메시지 출력 함수
	 * @param String $mode
	 * @param String $msg
	 * @param String $url
	 */
	public function GPLmysql_error($mode='', $msg='', $url=''){
		// 경고창 출력용
		if ($mode != 'alert') $this->GPLmysql_close();
		$this->GPLerror($mode, $msg, $url);
	}
}
?>