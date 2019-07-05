</section><!-- e:#contents -->

<footer>
	<p class="row"><!--반응형CSS-클래스만-->
		<small>
			&copy; 311-21  충남 천안시 동남구 대흥로 339 천광빌딩 406호 타임스페이스<br> (구)충청남도 천안시 동남구 신부동 388-14 천광빌딩 406호 타임스페이스		</small>
	</p>
</footer>

<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] < 3) { ?>
<script type="text/javascript">
if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/android/i)))
{
}else{
document.write('<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"><\/script>');
}
</script>
<script type="text/javascript">
CKEDITOR.replace( "CONTENT",
		    {
		        height: 300,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images"
		    });
</script>
<?php } ?>
<?php
//$nowFileName=basename(__FILE__); //현재페이지 파일명 
$nowFileName=basename($_SERVER['PHP_SELF']); //실행되어지는 메인 파일
$nowFileName2= explode(".",$nowFileName);
//echo $nowFileName2[0]; //확장자를 제외한 파일명
if($nowFileName2[0] != "index"){
?>
<script type="text/javascript">
if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/android/i)))
{
$('#contents').css({'margin-top':'60px'});$('header .row').css({'display':'none'});
}
</script>
<?php } ?>
</body>
</html>