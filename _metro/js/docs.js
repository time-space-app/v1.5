function reinit()
{
    //$('.dropdown-menu').dropdown({effect: 'slide'});
    $.Metro.initDropdowns();
}

$(function(){
    $("[data-load]").each(function(){
        $(this).load($(this).data("load"), function(){
            reinit();
        });
    });

    window.prettyPrint && prettyPrint();

    $(".history-back").on("click", function(e){
        e.preventDefault();
        history.back();
        return false;
    })
})


$(function() {
    if ($('nav > .side-menu').length > 0) {
        var side_menu = $('nav > .side-menu');
        var fixblock_pos = side_menu.position().top;
        $(window).scroll(function(){
            if ($(window).scrollTop() > fixblock_pos){
                side_menu.css({'position': 'fixed', 'top':'65px', 'z-index':'1000'});
            } else {
                side_menu.css({'position': 'static'});
            }
        })
    }

    $(window).scroll(function(){
        if ($(window).scrollTop() > $('header').height()) {
            $("header > .navigation-bar")
                .addClass("fixed-top")
                .addClass(" shadow")
            ;
        } else {
            $("header > .navigation-bar")
                .removeClass("fixed-top")
                .removeClass(" shadow")
            ;
        }
    });
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