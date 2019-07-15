</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<!-- 외부 플러그인 js  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.7/jquery.fullpage.js"></script>
<script>
/* 콘텐츠가 화면 높이 보다 클때는 작동 중지 */
jQuery(document).ready(function($) {
	$(window).resize(function(){
		let $window = $(this);
        let windowHeight = $window.height();
		let documentHeight = $(document).height();
		//alert(documentHeight);alert(windowHeight);디버그
		if(windowHeight>=documentHeight){
			$("#fullpage").fullpage({  });
		}else{
			if ( $('.fp-enabled').length ) {
				$.fn.fullpage.destroy('all');
			}
		}
	}).resize();
});
</script>
<!-- 사용자 지정 js Start -->
<script>
	$(function($){//(function($){ //서브메뉴 클릭유지 스크립트
		$('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
		if (!$(this).next().hasClass('show')) {
			$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
		}
		var $subMenu = $(this).next(".dropdown-menu");
		$subMenu.toggleClass('show');

		$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
			$('.dropdown-submenu .show').removeClass("show");
		});

		return false;
		});
	})//})(jQuery)
</script>
<script>
/* 언어선택 버튼 */
$('.language').click(function (event) {
	event.preventDefault();
	$(this).toggleClass("active");
});
$("body").click(function(e){
	if(e.target.className == "language-current" || ((e.target.className).indexOf("flag") != -1) || e.target.className == "language-name") { 
				//alert("don't hide");  
		}
		else {
			$('.language').removeClass('active');
		}
});
</script>
<!-- 사용자 지정 js End -->
</body>
</html>