$(function(){
    if (document.location.host.indexOf('.dev') > -1) {
        $("<script/>").attr('src', '/metro/js/metro/metro-loader.js').appendTo($('head'));
    } else {
        $("<script/>").attr('src', '/metro/js/metro.min.js').appendTo($('head'));
    }
})