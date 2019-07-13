<?PHP header('Content-Type: text/html; charset=UTF-8'); ?>
<?php 
//이부분 뒤에 삽이해주시면 됩니다.
//기본적으로 setup.php에 웹마스터 전자우편, 사이트주소, 사이트 이름이 세팅이
//되어야 가능합니다.
//가입축하메일발송부분///////////////////////////////////////////////////////////////
// 웹마스터 E-mail
$_from = "kimilguk@yahoo.co.kr";

// 사이트 주소
$_homepage = "http://www.test.com";

// 사이트 이름
$_sitename = "테스트";
$to="softline@netsgo.com";
$subject="안녕하세요! $_sitename 입니다";
//comment는 메일발송될 내용입니다. 변수는 member_table에서 가져다 쓰세요.
//드림위버나 나모같은 홈페이지 저작툴로 메일폼을 작성하신 후 소스에서 "를 삭제하시고
//스크립트의 경우는 "를 '로 바꾸어서 불러오시면 됩니다. 또한 이미지나 링크를 절대주소
//로 작성해주세요. http://www........ 이런식으로 하셔야됩니다. //$member_data[user_id]
$comment="<b>TimeSpace</b>회원님, 안녕하세요!
<p align=center >회원등록 통보메일</p>
<table align=center cellspacing=0 width=427 border=1 bordercolordark=white bordercolorlight=black>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   아이디</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   비밀번호</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   이름</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   이메일</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   우편번호</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   주소</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   주민번호</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   전화번호</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   휴대폰번호</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   성별</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
<tr>
<td width=86 height=25 bgcolor=CCCCCC>
<p align=left><span style=font-size:9pt;>   생년월일</span></p>
</td>
<td width=340 height=25>
<p><span style=font-size:9pt;> </span></p>
</td>
</tr>
</table>
";
//메일 헤더를 설정하는 부분입니다.
$lostid_head = "From: $_sitename <$_from>n";
$lostid_head .= "X-Sender: <$_from>n";
$lostid_head .= "X-Mailer: PHPn";
$lostid_head .= "X-Priority: 1n";
$lostid_head .= "Return-Path: <$_from>n";
/* HTML 형식으로 보내시려면 아래 주석을 풀어주세염...^^;;
아래주석을 풀지않으시면 위의 comment가 그대로 텍스트로 발송되겠죠.
*/
$lostid_head .= "Content-Type: text/html; charset=euc-krrn";

//$result=mail($to,$subject,$comment,$lostid_head);
//zb_sendmail을 사용하면 html 발송이 안되는것 같아서 mail 함수를 사용했습니다.
//zb_senmail함수를 사용해서 html 메일이 발송된다면 아래주석을 푸시고 위에 mail 함수에
//주석을 달아주세요.
//$result=zb_sendmail(0, $to, $name, $_from, "", $subject, $comment))
//////////////////////////////////////////////////////////////////////////////////////////////
?>

<?PHP
$connect = mysql_connect('localhost','root','1234');
$isResult = mysql_select_db("NAGOYA", $connect);

//mysql_query("set session character_set_connection=euckr;");
//mysql_query("set session character_set_results=euckr;");
//mysql_query("set session character_set_client=euckr;");

$sql = "show variables like '%character%'";
$result = mysql_query($sql);

while($row = mysqli_fetch_array($result)) {
echo $row[0] . " | " . $row[1] . "<br>n";
}

echo ("<br><br>");

$sql = "show variables like '%collation%'";

$result = mysql_query($sql);

while($row = mysqli_fetch_array($result)) {
echo $row[0] . " | " . $row[1] . "<br>n";
}

?>

<?php
echo "설정확인";
phpinfo();
?>