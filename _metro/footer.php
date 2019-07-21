<div class="bg-dark">
            <div class="container">
                <div class="grid no-margin">
                    <div class="row no-margin">
                        <div class="span8 padding20 nlp">
                            <img src="/<?php echo $flugin_url ?>/image/small_logo.png" alt="" class="span2 place-left" style="margin-top: 10px"/>
                            <div style="margin-left: 240px;">
                                <h3 class="fg-white">Address</h3>
                                <p class="fg-white">
                                <a href="#" onClick="javascript:alert('330-704  충남 천안시 동남구 문암로 76(안서동 115번지) \n 백석대학교 학생복지동 3층 304호 타임스페이스 (창업보육센터 내)');return false;">  
                                #304, Bi Center, Beakseok University, 76, Munam-ro, Dongnam-gu, Cheonan-si, Chungcheongnam-do, 330-704 Korea</a>
                                <br/>Tel : 010-8175-6075 E-mail : kimilguk@yahoo.co.kr</p>

                            </div>
                        </div>
                        <div class="span3 padding20 nrp">
                            <ul class="unstyled">
                                <li><a class="button danger span3 margin5" href="/LICENSE.html" title="">MIT LICENSE</a></li>
                                <li><a class="button success span3 margin5"  href="/<?php echo $flugin_url ?>/page/privacy.html">PRIVACY</a></li>
                                <li><a class="button info span3 margin5"  href="/<?php echo $flugin_url ?>/board/list.html/MENU_CODE/001001000/BOARD_ID/notice" title="">Notice Post</a></li>
                                <li><a class="button warning span3 margin5"  href="http://blog.daum.net/web_design" target="_new">Technical Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="bg-dark no-margin">
            <div class="container tertiary-text bg-dark fg-white">
                Time-Space &copy; by  <a href="mailto:kimilguk@yahoo.co.kr" class="fg-yellow">Kim ilguk</a>
            </div>
        </footer>
        <div id="back-to-top">Top ▲</div>
</div>
<?php if($BOARD_ID=="notice" || $BOARD_ID=="community" || preg_match('/stay-/',$BOARD_ID)) { ?>
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace( "CONTENT",
		    {
		        height: 300,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images"
		    });
CKEDITOR.config.docType = '<!DOCTYPE html>';
CKEDITOR.config.contentsCss = ['/<?php echo $flugin_url ?>/css/metro-bootstrap.css'];
CKEDITOR.config.bodyClass = 'metro';

</script>
<?php }else{ ?>
<script type="text/javascript" src="/time-space/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
CKEDITOR.replace( "CONTENT",
		    {
		        height: 300,
			toolbar : 'Basic'
		    });
CKEDITOR.config.docType = '<!DOCTYPE html>';
CKEDITOR.config.contentsCss = ['/<?php echo $flugin_url ?>/css/metro-bootstrap.css'];
CKEDITOR.config.bodyClass = 'metro';
</script>
<?php } ?>
</body>
</html>