var Request = function()
{
    this.getParameter = function( name )
    {
        var rtnval = '';
        var nowAddress = unescape(location.href);
        var parameters = (nowAddress.slice(nowAddress.indexOf('?')+1,nowAddress.length)).split('&');

        for(var i = 0 ; i < parameters.length ; i++)
        {
            var varName = parameters[i].split('=')[0];
            if(varName.toUpperCase() == name.toUpperCase())
            {
                rtnval = parameters[i].split('=')[1];
                break;
            }
        }
        return rtnval;
    }
}
var request = new Request();
//위 코드는 자바스크립트로 URL파라미터 값 구하는 방법
if(request.getParameter('go')!="pc"){ //모바일에서 PC버전 확인가능하도록 if코드 추가
	if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/android/i)))
	{
	//window.location.href='http://time-space.biz/time-space/mobile/';
	location.replace('http://time-space.biz/time-space/mobile/');
	}
}
$(function(){
var disabled= $("a.disabled");
disabled.click(function(event){
var address = $(this).attr('href');
if(event.preventDefault){
        event.preventDefault(); //FF
    } else {
        event.returnValue = false; //IE
    }
alert(address);
});
function getQueryStringObject() {
    var a = window.location.search.substr(1).split('&');
    if (a == "") return {};
    var b = {};
    for (var i = 0; i < a.length; ++i) {
        var p = a[i].split('=', 2);
        if (p.length == 1)
            b[p[0]] = "";
        else
            b[p[0]] = decodeURIComponent(p[1].replace(/\+/g, " "));
    }
    return b;
}
//70% 투명도에 해당하는 Hex값 얻기 (Javasciprt) css에서 사용
//alert(Math.floor(0.7 * 255).toString(16));
//아래코드는 선택된 메뉴 bold처리
if(!window.addEventListener){return;}
if(!document.querySelector){return;}
window.addEventListener("load",function(){
	var url=document.URL;
	var m=document.URL.match(/\/([a-zA-Z0-9\.\-\_]+)[^\/]*$/);
    var fname=m?m[1]:null;
    //<?php echo $_REQUEST['BOARD_ID'] ?> 아래 2개 라인으로 교체
    var qs = getQueryStringObject();
    var board_id=qs.BOARD_ID;
	if(!fname){return};
	fname= fname.replace("view.html", "list.html");
	fname= fname.replace("write.html", "list.html");
	var a=document.querySelector('#page_header>nav>ul>li>a[href$="/'+fname+'?go=pc&BOARD_ID='+board_id+'"]');
	if(!a){return};
	a.removeAttribute("href");
	class_add(a,"show");
},false);
function class_add(element,word){
	if(element.classList){
	element.classList.add(word);
	}else{
	var w=word.replace(/([^a-zA-Z0-9])/,"\\$1","g");
	var re=new Regexp("(^|\\s)"+w+"(\\s|$)");
		if(!re.test(element.className)){
		element.className+=" "+word;
		}
	}
}
});

$(function(){
     $('#back-to-top').hide();   // 스크롤 할때만 나오도록 숨김
     $(window).scroll(function() {
          if($(this).scrollTop() > 6) {
              $('#back-to-top').fadeIn();
          } else {
              $('#back-to-top').fadeOut();
          }
     });
     // 마우스 오버 시 화살표 움직임
     $('#back-to-top').hover(    
     function() {
        $(this).animate({"background-position-y":"30px"},200);
     },
     function() {
        $(this).animate({"background-position-y":"40px"},200);
     });
     //클릭시 페이지 상단으로 이동하도록
     $('#back-to-top').click(function() {
        $('body,html').animate({scrollTop:0}, 500);
        return false;
     });
});