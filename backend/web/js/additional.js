$(function () {
    $(document).bind('keydown.ctrl_l', function () {
        $.get($('div.lockscreen-container').data('url'), '', function (html) {
            $('div.lockscreen-container').html(html).show();
        });
    });
});