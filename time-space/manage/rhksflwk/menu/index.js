$(document).ready(function () {
	//레이아웃 설정
	myLayout = $('body').layout({ 
		applyDefaultStyles: true,
		west__size:         150,
		 resizable:          true, 
					 closable:           true
	});
	//대메뉴구현
		$("#nav-menu li").click(function () {
		$("#nav-menu li").removeClass("on");
		$(this).addClass("on");
	});
});