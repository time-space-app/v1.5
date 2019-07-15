<?php
ini_set('log_errors','On');
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL);
class GPLbase {
  //시스템 환경변수
  var $GPLversion;
  var $phpversion;//현재 php버젼
  var $magic_quotes_gpc;
  //세션 쿠키 관련 변수
  var $cookie_domain;//쿠키, 세션 도메인
  var $session_save_path;
  var $session_cache_expire;
  var $session_gc_maxlifetime;
  var $time_del_force_session;
  //기본 환경설정 변수
  var $encoding;//페이지 기본 인코딩
  var $url_default;//설치된 기본url
  var $path_default;//현재File의 기본경로에 대한 상대경로
  var $mode_echo_script_microtime;//스크립트 실행 타임 출력 방법 지정
  //현재 페이지에서 측정된 변수
  var $start_microtime;//스크립트 시작 마이크로 타임
  var $query_string;//넘어온 겟, 포스트 전체를 쿼리스트링으로 세팅
  var $return_url;//처리후 돌아갈 유알엘
  var $db;
  var $db5;
  var $login_member_info;//로그인한 회원의 정보 배열
  function GPLbase($cookie_domain, $url_default, $path_default){

    //기본 함수 라이브러리 인클루드
    include_once GPLDIR_FUNCTION . '/validation.php';
    include_once GPLDIR_FUNCTION . '/string.php';
    //스크립트 시작 시간 측정
    $this->set_start_microtime();
    //시스템 환경 변수 세팅
    $this->GPLversion = 1.001;
    $this->phpversion = (float)@phpversion();
    $this->magic_quotes_gpc = @get_magic_quotes_gpc();
    //시스템 실행환경 체크
    $this->check_phpversion();//php버젼 체크
    $this->check_magic_quotes_gpc();//magic_quotes_gpc을 on인 환경으로 맞춤
    //쿠키, 세션 환경 세팅
    $this->set_session_save_path();
    $this->set_session_cache_expire();
    $this->set_session_gc_maxlifetime();
    $this->set_time_del_force_session();
    //기본 환경 설정
    $this->set_encoding();
    $this->set_cookie_domain($cookie_domain);
    $this->set_url_default($url_default);
    $this->set_path_default($path_default);//상대경로 세팅
    $this->set_mode_echo_script_microtime();
    $this->set_query_string();
    $this->set_return_url();

    //데이타베이스 연결
    include_once GPLDIR_CONFIG . '/db.php';
    include_once GPLDIR_DB . '/GPLmessage.class.php';
    include_once GPLDIR_DB . '/GPLmysqli.class.php';

    $this->db5 = new GPLmysqli($GPLdb_host, $GPLdb_user, $GPLdb_pass, $GPLdb_name);
    unset($GPLdb_host, $GPLdb_user, $GPLdb_pass, $GPLdb_name);
  }

  //스크립트 실행 시작 마이크로타임 세팅
  function set_start_microtime(){
    $this->start_microtime = GPLget_microtime();
  }
  //php버젼 체크하여 4.1미만이면 종료
  function check_phpversion(){
    if ($this->phpversion < 4.1) {
      $this->echo_phpversion();
      echo '<b><br>이 프로그램은 4.1이상의 환경에서만 작동됩니다.</b>';
      exit;
    }
  }
  //php버젼 출력
  function echo_phpversion(){
    echo '<b>현재 이사이트의 php버젼은 ' . $this->phpversion . ' 입니다.</b>';
  }
  //magic_quotes_gpc을 on인 환경으로 맞춤
  function check_magic_quotes_gpc(){
    if (empty($this->magic_quotes_gpc)){

      $_POST = GPLaddslashes_array($_POST);
      $_GET = GPLaddslashes_array($_GET);
      $_COOKIE = GPLaddslashes_array($_COOKIE);
    }
  }
  //세션 저장 경로 설정
  function set_session_save_path($session_save_path=''){
    if (empty($session_save_path) || !is_dir($session_save_path)) {
      $session_save_path = GPLDIR_SESSION;
    }

    if (is_dir($session_save_path)) $this->session_save_path = $session_save_path;
  }
  //세션 라이프타임 설정
  function set_session_cache_expire($session_cache_expire= 86400){
    if (!is_int($session_cache_expire)) $session_cache_expire = 86400;
    $this->session_cache_expire = $session_cache_expire;
  }
  //세션 가베지 콜렉션 타임 설정
  function set_session_gc_maxlifetime($session_gc_maxlifetime= 86400){
    if (!is_int($session_gc_maxlifetime)) $session_gc_maxlifetime = 86400;
    $this->session_gc_maxlifetime = $session_gc_maxlifetime;
  }
  //세션 강제 삭제 타임 설정
  function set_time_del_force_session($time_del_force_session= 0){
    if (!is_int($time_del_force_session)) $time_del_force_session = 0;
    $this->time_del_force_session = $time_del_force_session;
  }
  //페이지의 기본 인코딩 세팅
  function set_encoding($encoding='euckr'){
    if (empty($encoding)) $encoding = 'euckr';
    $this->encoding = $encoding;
  }
  //쿠키나 세션을 공유할 도메인 세팅
  function set_cookie_domain($domain=''){
    if (empty($domain)) $domain = preg_replace("`^www.`i", '', $_SERVER['HTTP_HOST']);

    $this->cookie_domain = $domain;
  }

  //설치된 기본 url 세팅
  function set_url_default($url=''){
    if (empty($url)) $url = 'http://' . $_SERVER['HTTP_HOST'] . '/';

    $this->url_default = preg_replace("`//+$`", '/', $url . '/');
  }
  //현재 실행되는 File의 경로와 기본 경로의 상대경로 세팅
  function set_path_default($path=''){
    if (!empty($path)) {
      $this->path_default = $path;
    }
    else{
      $dir_this = dirname($_SERVER['SCRIPT_FILENAME']);
      if ($dir_this == GPLDIR_DEFAULT){
        $this->path_default = './';
      }
      else {
        $pos = strpos($dir_this, GPLDIR_DEFAULT);
        if ($pos === false) {
          $pos2 = strpos(GPLDIR_DEFAULT, $dir_this);
          if ($pos === false){//겹치지 않는 경로에 있다.
            $temp_str = GPLget_same_sting(GPLDIR_DEFAULT, $dir_this);
            $this->path_default = '../' . preg_replace(array("`[^/]*`", "`/`"), array('', '../'), preg_replace("`^" . $temp_str . "`", '', $dir_this)) . preg_replace("`^" . $temp_str . "`", '', GPLDIR_DEFAULT) . '/';
          }
          else {//현재 경로가 GPLDIR_DEFAULT 상위에 있다.
            $this->path_default = '.' . preg_replace("`^" . $dir_this . "`", '', GPLDIR_DEFAULT) . '/';
          }
        }
        else {//현재 경로가 GPLDIR_DEFAULT 하위에 있다.
          $this->path_default = preg_replace(array("`[^/]*`", "`/`"), array('', '../'), preg_replace("`^" . GPLDIR_DEFAULT . "`", '', $dir_this));
        }
      }
    }
  }
  //스크립트 시간을 어떻게 출력할지를 세팅
  function set_mode_echo_script_microtime($mode_echo_script_microtime=0){
    if (!is_int($mode_echo_script_microtime)) $mode_echo_script_microtime = 0;
    $this->mode_echo_script_microtime = $mode_echo_script_microtime;
  }
  //쿼리 스트링 세팅
  function set_query_string(){
    $this->query_string = '';
    if (is_array($_POST)){
      //2차 이상의 배열은 배제 시킨다.
      foreach($_POST as $key => $val){
        if (is_array($val)) {
          foreach($val as $key2 => $val2){
            if (is_array($val2)) continue;
            $this->query_string .= '&' . $key . '[' . $key2 . ']=' . urlencode(stripslashes($val2));
          }
        }
        else{
          $this->query_string .= '&' . $key . '=' . urlencode(stripslashes($val));
        }
      }
    }
    if (!empty($_SERVER['QUERY_STRING'])) {

      $this->query_string = $_SERVER['QUERY_STRING'] . $this->query_string;
    }
    else{
      if (!empty($this->query_string)) {

        $this->query_string = preg_replace("`^&`", '', $this->query_string);
      }
    }
  }
  //처리후 돌아갈 url세팅
  function set_return_url ($url='', $urlencode=1){
    if (!empty($url)) {
      $this->return_url = $url;
    }
    else if (!empty($_POST['GPLreturn_url'])) {

      $this->return_url = $_POST['GPLreturn_url'];
    }
    else if (!empty($_GET['GPLreturn_url'])) {

      $this->return_url = $_GET['GPLreturn_url'];
    }
    else {

      $this->return_url = $this->path_default;
    }
    //$urlencode 가 1일 경우에만 urlencode
    $this->return_url = ($urlencode == 1) ? get_urlencode_query($this->return_url) : $this->return_url;
  }
  //일반적인 시작
  function start_default(){
    $this->start_session();//세션 세팅 및 시작
  }
  //세션 셋팅 및 시작
  function start_session(){
  	//PHP5.X 이상 버전부터는 session.use_trans_sid 설정을 ini_set으로 바꿀 수 없습니다.
    @@ini_set('session.use_trans_sid', 0);    // PHPSESSID를 자동으로 넘기지 않음
    @@ini_set('url_rewriter.tags', ''); // 링크에 PHPSESSID가 따라다니는것을 무력화함
    //세션 저장디렉토리 지정
    if (!empty($this->session_save_path)) @session_save_path($this->session_save_path);
    @session_cache_limiter('no-cache, must-revalidate');
    if (empty($this->session_cache_expire)) $this->set_session_cache_expire();
    @@ini_set("session.cache_expire", $this->session_cache_expire); // 세션 캐쉬 보관시간 (분)
    if (empty($this->session_gc_maxlifetime)) $this->set_session_gc_maxlifetime();
    @@ini_set("session.gc_maxlifetime", $this->session_gc_maxlifetime); // session data의 gabage collection 존재 기간을 지정 (초)
    @session_set_cookie_params(0, "/");
    /*로컬호스트에서 테스트시 주석 실서버에서는 주석을 해제해 주세요-TimeSpace
    if (!empty($this->cookie_domain)) {
      @@ini_set('session.cookie_domain', '.' . $this->cookie_domain);
    }
    */
    @session_start();
    $this->del_session();
  }
  //지정일 이상된 File은 자동으로 지운다.
  function del_session(){
    if (empty($this->time_del_force_session)) return;
    $d = dir($this->session_save_path);
    while (false !== ($entry = $d->read())) {
      if (!preg_match("`^\.`", $entry)){

        $file = $this->session_save_path . '/' . $entry;
        if (file_exists($file) && (filemtime ($file) < (time() - $this->time_del_force_session))){
          @unlink($file);
        }
      }
    }
    $d->close();
  }
  //일반적인 종료
  function end_default(){
    if (!empty($this->db5)) $this->db5->GPLmysql_close();
    //$this->echo_script_microtime();
  }
  //현재까지의 스크립트 실행시간을 케이스별로 출력한다.
  function echo_script_microtime(){
    if (!empty($this->mode_echo_script_microtime)) {
      switch($this->mode_echo_script_microtime){
        case 1 :
          echo '<br><br>' . $this->get_script_microtime();
          break;
        case 2 :
          echo '<!-- ' . $this->get_script_microtime() . ' //-->';
          break;
      }
    }
  }
  //현재까지의 스크립트 실행 시간 반환
  function get_script_microtime(){
    if (!empty($this->start_microtime)) {
      $end_microtime = GPLget_microtime();
      return GPLget_submicrotime($this->start_microtime, $end_microtime);
    }
    else {
      return '시작시간이 존재하지 않습니다.';
    }
  }
  //GPL버젼 출력
  function echoversion(){
    echo '<b>현재 이사이트의 GPL버젼은 ' . $this->GPLversion . ' 입니다.</b>';
  }
  //헤더 출력
  function put_header($use_history=0){
    Header("P3P: CP='NOI DSP COR IVAa OUR BUS IND UNI COM NAV INT'");//브라우져 보안관련
    header('Content-Type: text/html; charset=' . $this->encoding);
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: no-store, no-cache, must-revalidate'); // HTTP/1.1
    if ($use_history == 1) {// 전송시 히스토리 적용되게
      header('Cache-Control: pre-check=0, post-check=0, max-age=0');
    }
    else {//전송시 히스토리 적용안되게
      header("Cache-Control: post-check=0, pre-check=0", false);
    }
    header('Pragma: no-cache'); // HTTP/1.0
  }
}
//회원 정보와 관련된 클래스
class GPLmember extends GPLbase{
	//로그인 후 세션 설정 (오브젝트로 리턴값)
	function set_return_login($message='', $url=''){
		if(empty($url))$url=$_SERVER[PHP_SELF];
		if(!empty($message)){
			foreach ($message as $rows){
				$this->login_member_info[id] = $rows[login_id];
				$this->login_member_info[nm] = $rows[nm];
				$this->login_member_info[message] = "로그인성공";
				$_SESSION['userID'] = $this->login_member_info[id];
				$_SESSION['userNM'] = $this->login_member_info[nm];
				$_SESSION['login_message'] = $this->login_member_info[message];
			}
		}else{
			$this->login_member_info[message] = "로그인실패. 아이디 또는 암호가 일치하지 않습니다.";
			$_SESSION['login_message'] = $this->login_member_info[message];
		}
		echo "<meta http-equiv='Refresh' content='0;url=".$url."'>";
	}
	function set_return_logout($message='', $url=''){
		if(empty($url))$url=$_SERVER[PHP_SELF];
		unset($_SESSION['userID']);
		unset($_SESSION['userNM']);
		unset($_SESSION['login_message']);
		session_destroy();
		echo "<meta http-equiv='Refresh' content='0;url=".$url."'>";
	}
}
?>
