<?php
class GPLmessage{
	var $target = 'this';
	
	//DB작업 후 메세지 출력 (오브젝트로 리턴값)
	function set_return_message ($message, $url=''){
		if(empty($url))$url=$_SERVER[PHP_SELF];
		if(!empty($message)){
			foreach ($message as $rows){
				echo "<meta http-equiv='Refresh' content='0;url=".$url."?data_message=".urlencode($rows[message])."'>";
			}
		}
	}
	//일반작업 후 메세지 출력 (스트링으로 리턴값)
	function set_normal_message($message, $url=''){
		if(empty($url))$url=$_SERVER[PHP_SELF];
		if(!empty($message)){
			echo "<meta http-equiv='Refresh' content='0;url=".$url."?data_message=".urlencode($message)."'>";
			exit;
		}
	}
	function GPLcommand($msg){
	    $temp = '<script language=javascript>';
	    $temp .= $msg;
	    $temp .= '</script>';
	    echo $temp;
	}
	function GPLerror($mode='', $msg='', $url=''){
		$temp = '';
		switch ($mode){
	      case 'alert' : 
	        $temp = $this->target . '.alert("' . $msg . '");';
	        $this->GPLcommand($temp);
	        break;
	      case 'back' : 
	        if ($msg) $temp = $this->target . '.alert("' . $msg . '");';
	        $temp .= $this->target . '.history.go(-1);';
	        $this->GPLcommand($temp);
	        exit;
	        break;
	      case 'back2' : 
	        if ($msg) $temp = $this->target . '.alert("' . $msg . '");';
	        $temp .= $this->target . '.history.go(-2);';
	        $this->GPLcommand($temp);
	        exit;
	        break;
	      case 'close' : 
	        if ($msg) $temp = $this->target . '.alert("' . $msg . '");';
	        $temp .= $this->target . '.close();';
	        $this->GPLcommand($temp);
	        exit;
	        break;
	      case 'location' : 
	        if (empty($url) && !empty($msg)) $temp = $this->target . '.location.href = "' . $msg . '";';
	        else if (!empty($url) && empty($msg)) $temp = $this->target . '.location.href = "' . $url . '";';
	        else if (!empty($msg) && !empty($url)) {
	          $temp = $this->target . '.alert("' . $msg . '");';
	          $temp .= $this->target . '.location.href = "' . $url . '";';
	        }
	        $this->GPLcommand($temp);
	        exit;
	        break;
	      case 'echo' : 
	        echo $msg;
	        exit;
	        break;
	      default : 
	        echo $msg;
	        break;
	    }
	}
}
?>