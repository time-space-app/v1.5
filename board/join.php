<?php include "../header.php";?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    <a href="#" class="history-back"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Member<small class="on-right">Join Form</small>
                </h1>
		<!--게시판 시작-->
		<section>
		<form method="post" name="frm" id="frm" action="join_ok.php" onsubmit="return submitForm(this)" enctype="multipart/form-data" >
		<!-- 테이블 시작 -->
			<div class="board_write_table">
			     <table summary="" class="table">
			      <caption></caption>
			       <colgroup>
			        <col style="width:100px;" />
			        <col />
			       </colgroup>
			       <tbody>
			        <tr>
			        	<th>이용약관</th>
			        	<td>
<pre>‘타임스페이스’ 는(이하 '회사'는) 고객님의 회원정보를 홈페이지 서비스이용에 사용하게 됩니다.

본 방침은 : 2014 년 06 월 01 일 부터 시행됩니다.


 1. 홈페이지에서 이용하는 개인정보 항목 
 
회사는 홈페이지 서비스 제공을 위해 아래와 같은 개인정보를 이용하고 있습니다.

1) 이용항목

- 아이디, 비밀번호, 회원성명, 이메일, 수신동의</pre>
			        		<label>
						이용약관동의(필수)
						<input type="checkbox" name="AGREE_YN" id="AGREE_YN" <?php echo ($ROW['AGREE_YN']=="on")?"checked=true":"";?>>
						</label>
			        	</td>
			        </tr>
				<tr>
					<th>LOGIN_ID</th>
					<td>
					<div class="input-control text span3 block" data-role="input-control">
					<?php if($_SESSION['valid_user'] != "") { ?>
					<input type="hidden" name="LOGIN_ID" id="LOGIN_ID" value="<?php echo $ROW['LOGIN_ID']?>" />
					<?php echo $ROW['LOGIN_ID']?>
					<?php }else{ ?>
					<input type="text" name="LOGIN_ID" id="LOGIN_ID" value="<?php echo $ROW['LOGIN_ID']?>" />
					<?php } ?>
					</div>
					</td>
				</tr>
				<tr>
					<th width="18%">LOGIN_PWD</th>
					<td>
					<div class="input-control password span3 block" data-role="input-control">
					<input type="password" size="21"  name="LOGIN_PWD" id="LOGIN_PWD" value="" />
					</div>
					<input type="hidden" name="HIDDEN_PWD" id="HIDDEN_PWD" value="<?php echo $ROW['LOGIN_PWD']?>" /></td>
				</tr>
				<tr>
					<th>NAME</th>
					<td>
					<div class="input-control text span3 block" data-role="input-control">
					<input type="text" name="USER_NM" id="USER_NM" value="<?php echo $ROW['USER_NM']?>" />
					</div>
					</td>
				</tr>
				<tr style="display:none">
					<th>LEVEL</th> 
					<td>
					<div class="input-control select span2" data-role="input-control">
					<SELECT ID="USER_LEVEL" name='USER_LEVEL' size='1' style="width:100px">
						<option value="9" <?php echo ($ROW['USER_LEVEL']=="9")?"SELECTED":"";?>>member</option>
						<option value="2" <?php echo ($ROW['USER_LEVEL']=="2")?"SELECTED":"";?>>staff</option>
					        <option value="1" <?php echo ($ROW['USER_LEVEL']=="1")?"SELECTED":"";?>>admin</option>
					</SELECT>
					</div>
					</td>
				</tr>
				<tr>
					<th>E-MAIL</th> 
					<td>
						<label style="float:left">
						수신동의(필수)
						<input type="checkbox" name="EMAIL_YN" id="EMAIL_YN" <?php echo ($ROW['EMAIL_YN']=="on")?"checked=true":"";?>>
						</label>
						<div class="input-control text span2" data-role="input-control">
						<input type="text" ID="EMAIL0" NAME="EMAIL0" VALUE="<?php echo $arremail[0]?>" />
						</div>@
						<div class="input-control text span2" data-role="input-control">
						<input type="text" ID="EMAIL1" NAME="EMAIL1" VALUE="<?php echo $arremail[1]?>" />
						</div>
						<div class="input-control select span3" data-role="input-control">
						<SELECT ID="DDLEMAIL" name='DDLEMAIL' size='1' style="width:90px" onchange="selectmail()">
						        <option value=''>-SELECT-</option>
						        <option value="naver.com">naver.com</option>
						        <option value="nate.com">nate.com</option>
						        <option value="gmail.com">gmail.com</option>
						        <option value="hanmail.net">hanmail.net</option>
						        <option value="yahoo.co.kr">yahoo.co.kr</option>
						</SELECT>
						</div>
					</td> 
				</tr>
				<?php if($_SESSION['valid_user'] == "") { ?>
				<tr>
					<th>Spam방지</th>
					<td><span style="color:#000"><?php echo $se_num1." + ".$se_num2." = "?></span>
					<div class="input-control text span3" data-role="input-control">
					<input type="text" name="SE_NUM" id="SE_NUM" value="" />
					</div>
					<input type="hidden" name="SE_NUM1" id="SE_NUM1" value="<?php echo $se_num1?>" />
					<input type="hidden" name="SE_NUM2" id="SE_NUM2" value="<?php echo $se_num2?>" />(필수)
					</td>
				</tr>
				<?php } ?>
				<tr style="display:none">
					<th>USER_YN</th> 
					<td>
					<div class="input-control select span3" data-role="input-control">
					<SELECT ID="USE_YN" name='USE_YN' size='1'>
					        <option value="Y" <?php echo ($ROW['USE_YN']=="Y")?"SELECTED":"";?>>USE</option>
					        <option value="N" <?php echo ($ROW['USE_YN']=="N")?"SELECTED":"";?>>STOP</option>
					</SELECT>
					</div>
					</td> 
				</tr>
			</tbody>
			</table>
			</div>
			<!-- 등록버튼 시작 -->
			<div id="board_list_button_table" style="text-align:right">
			<button type="reset" class="button large info">RESET</button>
			<button type="submit" class="button large info">COMMIT</button>
			</div>
		</form>
		</section>
		<!--게시판 끝-->
            </div>
        </div>
<?php include "../footer.php";?>