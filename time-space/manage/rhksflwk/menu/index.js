$(document).ready(function () {
			//레이아웃 설정
			myLayout = $('body').layout({ 
				applyDefaultStyles: true,
				west__size:         210,
				 resizable:          false, 
	             closable:           false
			});
			//대메뉴구현
		    $("#nav-menu li").click(function () {
			  $("#nav-menu li").removeClass("on");
			  $(this).addClass("on");
			});
		});