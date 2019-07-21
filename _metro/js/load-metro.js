$(function(){
    if (document.location.host.indexOf('.dev') > -1) {
        $("<script/>").attr('src', '/<?php echo $flugin_url ?>/js/metro/metro-loader.js').appendTo($('head'));
    } else {
        $("<script/>").attr('src', '/<?php echo $flugin_url ?>/js/metro.min.js').appendTo($('head'));
    }
})