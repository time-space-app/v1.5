<div class="bg-dark">
            <div class="container">
                <div class="grid no-margin">
                    <div class="row no-margin">
                        <div class="span8 padding20 nlp">
                            <img src="/_metro/image/small_logo.png" alt="" class="span2 place-left" style="margin-top: 10px"/>
                            <div style="margin-left: 240px;">
                                <h3 class="fg-white">Address</h3>
                                <p class="fg-white">#Ready, Bi Center, Beakseok University, 76, Munam-ro, Dongnam-gu, Cheonan-si, Chungcheongnam-do, 330-704 Korea
                                <br/>Tel : 010-8175-6075 E-mail : kimilguk@yahoo.co.kr</p>

                            </div>
                        </div>
                        <div class="span3 padding20 nrp">
                            <ul class="unstyled">
                                <li><a class="button danger span3 margin5" href="/_metro/board/list.html?BOARD_ID=repair" title="">Work Request</a></li>
                                <li><a class="button success span3 margin5"  href="/wordpress/">WordPress</a></li>
                                <li><a class="button info span3 margin5"  href="/_metro/board/list.html?BOARD_ID=notice" title="">Notice Post</a></li>
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
<?php if($BOARD_ID=="notice" && $_SESSION['valid_level'] < 3) { ?>
<script type="text/javascript">
CKEDITOR.replace( "CONTENT",
		    {
		        height: 400,
				filebrowserImageUploadUrl:"/time-space/ckeditor/upload.php?type=Images"
		    });
</script>
<?php } ?>
</body>
</html>