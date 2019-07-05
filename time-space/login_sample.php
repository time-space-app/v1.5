<?php
  session_start();
?>
<table align="center" background="/time-space/testingdata/main.jpg" border="0" cellpadding="1" cellspacing="1" style="width: 1200px; height: 1200px;">
<tbody>
<tr>
<td>
<div style="position:absolute;left:40px;top:80px">
<?php if($_SESSION['login_security'] == 1) { ?>
LOGINED STATUS! <a href="sess_login.php?logout=yes">LOGOUT</a>
<?php }else{ ?>
LOGIN [<a href="/">HOME</a>]
<form action="sess_login.php" method="post" name="login">
ID : <input maxlength="10" name="USERID" size="10" type="text" /> 
PASSWD : <input maxlength="100" name="PASSWD" size="10" type="password" /> 
<input type="submit" value="LOGIN" />
</form>
<?php } ?>
</div>
</td>
</tr>
<tr>
<td style="height: 20px; text-align: center;">
<span style="text-align: center;">Time-Space.biz since 2013-06-07 [<a href="/time-space/index.php" style="text-align: center;">manager</a>] </span></td>
</tr>
</tbody>
</table>