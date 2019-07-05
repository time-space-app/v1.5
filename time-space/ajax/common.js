function roundXL(n, digits) {
  if (digits >= 0) return parseFloat(n.toFixed(digits)); // 소수부 반올림

  digits = Math.pow(10, digits); // 정수부 반올림
  var t = Math.round(n * digits) / digits;

  return parseFloat(t.toFixed(0));
}
function getTimeStamp() {
    var d = new Date();
    var s =
        leadingZeros(d.getFullYear(), 4) + '-' +
        leadingZeros(d.getMonth() + 1, 2) + '-' +
        leadingZeros(d.getDate(), 2);
    return s;
}
function leadingZeros(n, digits) {
    var zero = '';
    n = n.toString();
    if (n.length < digits) {
        for (i = 0; i < digits - n.length; i++)
            zero += '0';
    }
    return zero + n;
}
function date_add(sDate, nDays) {
    var yy = parseInt(sDate.substr(0, 4), 10);
    var mm = parseInt(sDate.substr(5, 2), 10);
    var dd = parseInt(sDate.substr(8), 10);
    d = new Date(yy, mm - 1, dd + nDays);
    yy = d.getFullYear();
    mm = d.getMonth() + 1; mm = (mm < 10) ? '0' + mm : mm;
    dd = d.getDate(); dd = (dd < 10) ? '0' + dd : dd;
    return '' + yy + '-' +  mm  + '-' + dd;
}
function delay(gap){ /* gap is in millisecs */ 
  var then,now; 
  then=new Date().getTime(); 
  now=then; 
  while((now-then)<gap){ 
    now=new Date().getTime();  // 현재시간을 읽어 함수를 불러들인 시간과의 차를 이용하여 처리 
  } 
} 
function del_chk(frm)
 {
	if (confirm('Are you sure you want to delete?') == true) {
	frm.MODE.value = "delete"; 
	frm.submit();
	return true;
	} else {
	frm.MODE.value = ""; 
	return false;
	}
 }
function submitForm(frm)
{
		jQuery.fn.reverse = function() {
		    return this.pushStack(this.get().reverse(), arguments);
		};
		var errorMessage = null;
		var objFocus = null;
		$("#"+frm+" .nullChk_txt").reverse().each(function(){
		      if ($.trim($(this).val()).length == 0){
		  	  errorMessage = $(this).attr('title')+"는(은) 필수입력값입니다.";objFocus=$(this);
		      }
		});
		$("#"+frm+" .nullChk_chk").reverse().each(function(){
		      if ($(this).prop('checked')==false){
		  	  errorMessage = $(this).attr('title')+"는(은) 필수선택값입니다.";objFocus=$(this);
		      }
		});
		$("#"+frm+" .nullChk_rdo").reverse().each(function(){
		      if($(":radio[name='"+$(this).attr('name')+"']:checked").length < 1){
		  	  errorMessage = $(this).attr('title')+"는(은) 필수선택값입니다.";objFocus=$(this);
		      }
		});
	if(errorMessage != null) {
	    objFocus.focus();
	    alert(errorMessage);
	    return false;
	   }
}

function selectmail() {
	var mail = document.getElementById('DDLEMAIL');
	var txt = document.getElementById('EMAIL1');
	if (mail == "") {
	txt.focus();
	txt.value = "";
	} else {
	txt.value= mail.value;
	}
}
function imgPop(url) {
   window.open(url,"","width=800, height=600, scrollbars=1, menubar=no, resizable=1"); 
}
if (typeof(CALENDAR_JS) == 'undefined') // 한번만 실행
{
//달력 레이어 시작
	var CALENDAR_JS = true;
	var Cal_Today = new Date();
	var Cal_Year = Cur_Year = parseInt(Cal_Today.getFullYear());
	var Cal_Month = Cur_Month = parseInt(Cal_Today.getMonth()) + 1;
	var Cal_Date = Cur_Date = parseInt(Cal_Today.getDate());
	var Fld_Obj;
/* 달력 환경설정 */
	function Calendar_Config(type){
		//날짜 셀의 크기지정 가로, 세로
		var cell = new Array(25, 21);
		//요일타이틀 색깔지정 혹은 이미지 대체 (일, 월, 화, 수, 목, 금, 토) 순으로
		var yoil = new Array("<img src='/time-space/image/cal_0.jpg'>","<img src='/time-space/image/cal_1.jpg'>","<img src='/time-space/image/cal_2.jpg'>","<img src='/time-space/image/cal_3.jpg'>","<img src='/time-space/image/cal_4.jpg'>","<img src='/time-space/image/cal_5.jpg'>","<img src='/time-space/image/cal_6.jpg'>");
		//날짜 색깔지정 (일, 월, 화, 수, 목, 금, 토) 순으로
		var yoil_color = new Array("#CC0000", "#000000", "#000000", "#000000", "#000000", "#000000", "#0000CC");
		//오늘 날짜 색깔 및 배경지정 (스타일태그시작, 종료,스타일(배경등))
		var today = new Array("<b style='color:#006600'>", "</b>", "background: url('/time-space/image/mini3.gif') no-repeat; background-position:2 0;");
		//마우스 오버 색깔
		var over = '#E1E1E1';
		//달력 이동 버튼들
		var move = new Array("<img src='/time-space/image/month_prev.gif' border=0><img src='/time-space/image/month_prev.gif' border=0>", "<img src='/time-space/image/month_prev.gif' border=0>", "<img src='/time-space/image/month_next.gif' border=0>", "<img src='/time-space/image/month_next.gif' border=0><img src='/time-space/image/month_next.gif' border=0>");
		//분리문자 2009-01-01
		var sp = "-";
		return eval(type);
	}
/* 달력 초기화 및 삭제 */
	function Calendar_Reset(){
		Fld_Obj = null;
		Cal_Year = parseInt(Cal_Today.getFullYear());
		Cal_Month = parseInt(Cal_Today.getMonth()) + 1;
		Cal_Date = parseInt(Cal_Today.getDate());
		var Cal_Div = document.getElementById('Calendar_Div');
		Cal_Div.parentNode.removeChild(Cal_Div);
	}
/* 달력 초기세팅 및 출력 */
	function Calendar_Create(id, move){
		if(id){
			Fld_Obj = document.getElementById(id);
		}
		if((Fld_Obj.value && Fld_Obj.value != ('0000' + Calendar_Config('sp') + '00' + Calendar_Config('sp') + '00')) && !move){
			var tmp = Fld_Obj.value.split(Calendar_Config('sp'));
			Cal_Year = parseInt(tmp[0]);
			Cal_Month = parseInt(tmp[1]);
		} else if(!move){
			Cal_Year = parseInt(Cal_Today.getFullYear());
			Cal_Month = parseInt(Cal_Today.getMonth())+1;
		}
		Cal_Date = 1;
		Cal_Time = new Date(Cal_Year, Cal_Month, 1);
		Start_Date = new Date(Cal_Year, Cal_Month-1, 1).getDay();
		Last_Date = Calendar_LastDate(Cal_Year, Cal_Month);

		Calendar_Display(Start_Date, Last_Date);
	}
/* 인풋박스의 위치값 */
	function Calendar_Get_XY(fld){
		Fld_Element = new Object();
		var obj = fld.getBoundingClientRect();
		Fld_Element.left = obj.left + (document.documentElement.scrollLeft || document.body.scrollLeft);
		Fld_Element.top = obj.top + (document.documentElement.scrollTop || document.body.scrollTop);
		Fld_Element.height = obj.bottom - obj.top;
		var XY = new Array(Fld_Element.left, Fld_Element.top, Fld_Element.height);
		return XY;
	}
/* 달력 마지막 일자 계산 */
	function Calendar_LastDate(year, month){
		var dateCount = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

		if( (year%400 == 0) || ((year%4 == 0) && (year % 100 != 0)) ) {
			dateCount[1] = 29;
		}
		return dateCount[Number(month)-1];
	}
/* 년 +, - 이동 */
	function Calendar_Move_Year(num){
		Cal_Year += num;
		Calendar_Create("", true);
	}
/* 월 +, - 이동 */
	function Calendar_Move_Month(num){
		Cal_Month += num;
		if(Cal_Month < 1) { Cal_Year--; Cal_Month = 12; }
		if(Cal_Month > 12) { Cal_Year++; Cal_Month = 1; }
		Calendar_Create("", true);
	}
/* 년월 동시 이동 */
	function Calendar_Move_All(year, month){
		Cal_Year = year;
		Cal_Month = month;
		Calendar_Create("", true);
	}
/* 달력 실제 출력부 */
	function Calendar_Display(sd, ld){
		if(!document.getElementById('Calendar_Div')){
			if(document.layers){ 
				document.layers['Calendar_Div'] = new Layer(1);
			} else if (document.all){ //익스플로러
				document.body.insertAdjacentHTML("BeforeEnd","<DIV ID='Calendar_Div'></DIV>");
			} else { 
				Make_Div = document.createElement('div');
				Make_Div.setAttribute("id", "Calendar_Div");
				document.body.appendChild(Make_Div);
			}
		}

		var Cal_Div = document.getElementById('Calendar_Div');
		var XY = Calendar_Get_XY(Fld_Obj); //위치값 계산
		//환경설정 값 읽어옴
		var disp_date = 1; //날짜출력
		var disp_yoil = 0; //요일출력
		var yoil = Calendar_Config('yoil'); //요일타이틀
		var yoil_color = Calendar_Config('yoil_color'); //요일별 날짜색상
		var today_style = Calendar_Config('today'); //오늘표기
		var button = Calendar_Config('move'); //버튼
		var size = Calendar_Config('cell'); //셀크기
		var div_width = size[0] * 7 + 10; //레이어 크기계산

		with(Cal_Div.style){
			position = 'absolute';
			width =  div_width +'px';
			backgroundColor = '#e1e1e1';
			left = XY[0] - 2;
			top = XY[1] + XY[2] - 2;
			padding = '5px';
			display = 'block';
		}

		var In_HTML = "";
		var disp_y = Cal_Year + "년";
		var disp_m = Cal_Month < 10 ? "0"+Cal_Month+"월" : Cal_Month+"월";
		In_HTML += "<table border=0 width=100% cellpadding=0 cellspacing=0 bgcolor='#FFFFFF'>\n"
				+  "<tr align=center height=30><td colspan=7>"
				+  "<a href='javascript:Calendar_Move_Year(-1);'>" + button[0] + "</a> "
				+  "<a href='javascript:Calendar_Move_Month(-1);'>" + button[1] + "</a>"
				+  "&nbsp;&nbsp;&nbsp;<b>" + disp_y + " " + disp_m + "</b>&nbsp;&nbsp;&nbsp;"
				+  "<a href='javascript:Calendar_Move_Month(1);'>" + button[2] + "</a> "
				+  "<a href='javascript:Calendar_Move_Year(1);'>" + button[3] + "</a></td></tr>\n"
				+  "<tr><td colspan='7' bgcolor='e1e1e1'></td></tr>"
				+  "<tr align=center height=22>";
		//요일출력
		for(var i=0; i<yoil.length; i++){
			In_HTML += "<td>" + yoil[i] + "</td>";
		}
		In_HTML += "</tr>\n"
				+  "<tr><td colspan='7' bgcolor='e1e1e1'></td></tr>";
		//날짜출력
		for(var i=0; i<ld+sd; i++){
			if(disp_yoil > 6) disp_yoil = 0;

			if(i == 0) In_HTML += "\n<tr height="+size[1]+">";
			if(i>0 && i%7 == 0){
				if(i%7 == 0) In_HTML += "\n</tr>\n<tr height="+size[1]+">\n";
			}
			if(i < sd) {
				In_HTML += "<td>&nbsp;</td>";
			} else if(Cal_Year == Cur_Year && Cal_Month == Cur_Month && disp_date == Cur_Date){
				In_HTML += "<td align=center style=\"cursor:pointer;";
				if(today_style[2]) In_HTML += " " + today_style[2];
				In_HTML += "\" onclick='Calendar_SetValue(" + disp_date + ");'>" + today_style[0] + disp_date + today_style[1] + "</td>";
				disp_date++;
			} else {
				In_HTML += "<td align=center style=\"cursor:pointer;\" onclick='Calendar_SetValue(" + disp_date + ");' onmouseover=\"Calendar_ChangeBG(this, 'set');\" onmouseout=\"Calendar_ChangeBG(this, 'unset');\"><font color='" + yoil_color[disp_yoil] + "'>" + disp_date + "</font></td>";
				disp_date++;
			}
			disp_yoil++;
		}
		//빈칸 메꾸기
		if(disp_yoil < 7){
			for(var i=disp_yoil; i<7; i++){
				In_HTML += "<td>&nbsp;</td>";
			}
		}
		In_HTML += "\n</tr>"
				+  "<tr><td colspan='7' bgcolor='e1e1e1'></td></tr>"
				+  "<tr><td colspan=7 align=right style='padding:3 3;'><a href='javascript:Calendar_Move_All(" + Cur_Year + ", " + Cur_Month + ");'>[오늘]</a> <a href='javascript:Calendar_Reset();'>[닫기]</a></td></tr></table>";

		Cal_Div.innerHTML = In_HTML;
	}
/* 날짜클릭으로 인풋박스에 값 넣기 */
	function Calendar_SetValue(date){
		var sp = Calendar_Config('sp');
		Fld_Obj.value = Cal_Year + sp + (Cal_Month < 10 ? '0'+Cal_Month : Cal_Month) + sp + (date < 10 ? '0'+date : date);
		Calendar_Reset();
	}
/* [오늘] 을 클릭했을시 달력이 사라지면서 오늘날짜를 바로 넣기 */
	function Calendar_SetToday(){
		Cal_Year = Cur_Year;
		Cal_Month = Cur_Month;
		Calendar_SetValue(Cur_Date);
	}
/* 날짜에 마우스 오버시 배경색 변경 */
	function Calendar_ChangeBG(obj, type){
		if(type == 'set'){
			obj.style.backgroundColor = Calendar_Config('over');
		} else {
			obj.style.backgroundColor = '';
		}
	}
}
//달력 레이어 끝
/* 롤오버레이어액션 마우스 위치값 */
function Target_Get_XY(F_id){
	ld_Element = new Object();
	var obj_id  = document.getElementById(F_id);
	var obj = obj_id.getBoundingClientRect();
	ld_Element.left = obj.left + (document.documentElement.scrollLeft || document.body.scrollLeft);
	ld_Element.top = obj.top + (document.documentElement.scrollTop || document.body.scrollTop);
	ld_Element.height = obj.bottom - obj.top;
	var XY = new Array(ld_Element.left, ld_Element.top, ld_Element.height);
	return XY;
}
/* 롤오버레이어 실제 출력부 */
function Layer_Display(data_src, obj_id){
	if(!document.getElementById('View_Div')){
		if(document.layers){ 
			document.layers['View_Div'] = new Layer(1);
		} else if (document.all){ //익스플로러
			document.body.insertAdjacentHTML("BeforeEnd","<DIV ID='View_Div'></DIV>");
		} else { 
			var Make_Div = document.createElement('div');
			Make_Div.setAttribute("id", "View_Div");
			document.body.appendChild(Make_Div);
		}
	}
	var V_Div = document.getElementById('View_Div');
	var XY = Target_Get_XY(obj_id); //위치값 계산
	var div_width = '300px' //레이어 크기계산
	var offset = $('#'+obj_id).offset();
	$('#View_Div').css("top",(offset.top)-20);
	$('#View_Div').css("left",(offset.left));

	with(V_Div.style){
		position = 'absolute';
		width =  div_width;
		backgroundColor = '#fff';
		left = XY[0] + 2;
		top = XY[1] - XY[2] - 2;
		padding = '5px';
		display = 'block';
		border='1px solid blue';
	}
	var In_HTML = data_src;
	V_Div.innerHTML = In_HTML;
}
/* 롤오버레이어 숨기기 */
function Layer_Hide(){
	$('#View_Div').remove();
}
document.write("<link rel='stylesheet' href='http://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css' type='text/css' media='all'>");
document.write("<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js' type='text/javascript'><\/script>");
document.write("<script src='http://code.jquery.com/ui/1.8.18/jquery-ui.min.js' type='text/javascript'><\/script>");
$(document).ready( function() {
	function checkEnter(e){
	 e = e || event;
	 var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
	 return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
	}
	document.querySelector('form').onkeypress = checkEnter;
});