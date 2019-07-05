/* script.js - 스크립트
---------------------------------------------------------------- */
jQuery(function($) { 
	
	//if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/android/i)))
	//{
	//window.scrollTo(0,0);$('header .row').css({'display':'none'});$('#header-bar').css({'position':'fixed','top':'0px'});$('#header-bar').addClass('scrolled');
	//}else{
	// 스크롤 고정 내비게이션 플러그인을 #header-bar에 연결.
	$('#header-bar').scrolledFix();
	//}
	
	// 스마트 폰 환경에서 화면을 가득 채우는 함수 호출.
	if($(window).width() < 767) loadedFullScreen();
	// 스마트 폰 환경에서 전용 메뉴 호출 및 메뉴 숨기기.
	if((navigator.userAgent.match(/iPhone/i))||(navigator.userAgent.match(/iPod/i))||(navigator.userAgent.match(/android/i)))
	{
		$("#phone_menu").on("click",function(){
		if ($(this).attr("class") == "menu_swap") {
			window.scrollTo(0,0);$('header .row').css({'display':'block'});$('#header-bar').css({'position':'relative','top':'-45px'});$('#header-bar').removeClass('scrolled');$('#header-bar ul').remove();
		    } else {
			window.scrollTo(0,0);$('header .row').css({'display':'none'});$('#header-bar').css({'position':'fixed','top':'0px'});$('#header-bar').addClass('scrolled');
		    }
	    	$(this).toggleClass("on");
		});
	}else{
		$("#phone_menu").on("click",function(){
		window.scrollTo(0,0);$('#header-bar').css({'position':'relative','top':'-45px'});$('#header-bar').removeClass('scrolled');$('#header-bar ul').remove();
		});
	}
});

function loadedFullScreen() {
	setTimeout(function() { scrollTo(0,0); }, 100);
};