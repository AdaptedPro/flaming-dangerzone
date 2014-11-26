$(function() {
    do_resize();
    $(window).resize(function() {
        do_resize();
    });

    function do_resize() {
         var _height = $(window).height() - ( $('.container-fluid').height() + 50);
         $('#ce_frame').height(_height );
    }
});