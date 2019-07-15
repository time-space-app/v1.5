<?php include "../header.php";?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="#" class="history-back"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Member<small class="on-right">Login Form</small>
                </h1>
                <div class="accordion" data-role="accordion" data-closeany="true">
                        <div class="accordion-frame">
                            <a class="active heading" href="#">여러분의 방문을 환영합니다.</a>
                            <div class="content">
                                <div class="grid">
                                    <div class="row">
                                        <div class="span3">
                                            <p>신규아이디를 신청하시려면 아래버튼을 이용해 주세요.</p>
                                            <a href="/_metro/board/join.html"><span class="button default">New Id</span></a>
                                        </div>
                                        <div class="span3" style="border:solid 1px blue;padding:0px 10px;margin:0px 10px;">
                                        <?php if($_SESSION['valid_user'] != "") { ?>
                                            <form>
						<h3>WELCOME<br><?php echo $_SESSION['valid_user'];?></h3>
						<a href="/_metro/board/logout.php"><span class="button default info">Log Out</span></a>
						<a href="/_metro/board/join.html"><span class="button default info">Mypage</span></a>
					    </form>
                                         <?php }else{ ?>
					    <form name="form_login" id="form_login" action="" autocomplete="on" method="post">
                                                <fieldset>
                                                    <legend>Login</legend>
                                                    <lable>User ID</lable>
                                                    <div class="input-control text" data-role="input-control">
                                                        <input id="id" name="id" placeholder="User Id" required="required" type="text" placeholder="type text" autofocus>
                                                        <button class="btn-clear" tabindex="-1"></button>
                                                    </div>
                                                    <lable>Password</lable>
                                                    <div class="input-control password" data-role="input-control">
                                                        <input id="pw" name="pw" placeholder="User Password" required="required" type="password" placeholder="type password">
                                                        <button class="btn-reveal" tabindex="-1"></button>
                                                    </div>
                                                    <button type="submit" class="button large info">Login</button>
                                                </fieldset>
                                            </form>
					<?php } ?>
                                        </div>
                                        <div class="span4">
                                        <p>Ajax 아이디 찾기 및 암호 분실신고.</p>
                                            <div class="tab-control" data-role="tab-control">
                                                <ul class="tabs">
                                                    <li class="active"><a href="#_page_1">ID Search</a></li>
                                                    <li><a href="#_page_2">Password Search</a></li>
                                                </ul>

                                                <div class="frames">
                                                    <div class="frame" id="_page_1">
 	                                                    <lable>회원 가입시 등록한 Email 입력</lable>
	                                                    <div class="input-control text" data-role="input-control">
	                                                        <input id="search_email" name="search_email" placeholder="User Email" required="required" type="text" placeholder="type text">
	                                                        <button class="btn-clear" tabindex="-1"></button>
	                                                    </div>
	                                                    <a href="javascript:void(0);" onClick="getUserId(); return false">
	                                                    <span class="button default success">Search</span></a>
	                                                    <div id="show_id"></div>
                                                    </div>
                                                    <div class="frame" id="_page_2">
                                                        <p>관리자 Email( kimilguk@yahoo.co.kr ) 로 암호 분실신고를 해주시면 신규암호를 발급해 드립니다.
                                                        <br/>주의) 회원가입 하실때 입력하신 Email로 발급하여 드립니다.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            </div>
        </div>
<?php include "../footer.php";?>