<?php 
    @ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "kimilguk@yahoo.co.kr";
    $to = "rladlfrnr@naver.com";
    $subject = "PHP Mail Test script";
    $message = "This is a test to check the PHP Mail functionality";
    $headers = "From:" . $from;
    $result=mail($to,$subject,$message, $headers);
    if($result){
	  echo "mail success";
	  }else  {
	  echo "mail fail";
	 }
?>