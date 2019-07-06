<?php
header('Content-Type: text/html; charset=UTF-8');
$todaydate=date('Y-m-d');
$revperson= "rladlfrnr@naver.com";//rladlfrnr@naver.com
$sendperson= $_POST['e_mail'];
$subject= "go-kankoku.net Question";

$name_kanji= $_POST['name_kanji'];//お名前
$name_kana= $_POST['name_kana'];//お名前(フリガナ)
$comment_1= ($_POST['comment_1_0']=="")?"":$_POST['comment_1_0'].",";//お問合せの種類
$comment_1.= ($_POST['comment_1_1']=="")?"":$_POST['comment_1_1'].",";
$comment_1.= ($_POST['comment_1_2']=="")?"":$_POST['comment_1_2'].",";
$comment_1.= ($_POST['comment_1_3']=="")?"":$_POST['comment_1_3'].",";
$comment_1.= $_POST['comment_1_4'];
$comment_2= ($_POST['comment_2_0']=="")?"":$_POST['comment_2_0'].",";//韓国留学の手続き
$comment_2.= ($_POST['comment_2_1']=="")?"":$_POST['comment_2_1'].",";
$comment_2.= $_POST['comment_2_2'];
$comment_3= $_POST['comment_3'];//内容

if(!$revperson){
   echo "<script>
         alert('Please Input Post email-address!');
         history.go(-1);
         </script>";
         }

if(!$sendperson){
   echo "<script>
         alert('Please Input Sender email-address!');
         history.go(-1);
         </script>";
         }

if(!$subject){
   echo "<script>
         alert('Please Input Subject');
         history.go(-1);
         </script>";
         }

/*
$comment1 ="Content-Type: text/html; charset=UTF-8\r\n"; 
*/
$comment1 ="
Date :$todaydate\r\n
FromName : $sendperson\r\n
ToName :$revperson\r\n
Subject :$subject\r\n
お名前 :$name_kanji\r\n
お名前(フリガナ) :$name_kana\r\n
お問合せの種類 :$comment_1\r\n
韓国留学の手続き :$comment_2\r\n
内容 :$comment_3 ";

$comment2=nl2br($comment1);

/*
   $result=mail("$revperson", "$subject", "$comment1" ,"From:$sendperson");
*/
$to = $revperson; 
$fname = $sendperson; 
$mail_from=$sendperson; 
$subject = $subject;
$header ="Content-Type: text/html; charset=UTF-8\r\n"; 
$header .= "From: $fname <$mail_from>\n"; 
$body = $comment2; 
  $result=mail($to, $subject, $body, $header, '-f'.$mail_from); 

   if(!$result){
   echo "<script>
         alert('Sending Error!');
         history.go(-1);
         </script>";
   }else{
   echo "<script>
         alert('Sending OK!');
         //window.close();
         location.href='/';
         </script>";
   }

?>