radiata = (function ($) {
    var obj = {

        i18n: i18n,

        createAlert: function (type, text) {
            var html = '';
            html += '<div class="alert alert-' + type + ' alert-dismissible">';
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            html += '<h4><i class="icon fa fa-ban"></i> ' + this.i18n.Alert + '</h4>';
            html += text;
            html += '</div>';
            $('section.content').prepend(html);
        },

        reloadOnSort: function (id) {
            if ($('#' + id).length > 0) {
                $('#' + id).on('sortableSuccess', function () {
                    $('#' + id).fadeOut();
                    $.pjax.reload({container: '#' + id + 'Pjax'});
                    $(document).on('pjax:complete', function () {
                        radiata.reloadOnSort(id);
                    });
                });
            }
        }
    }

    return obj;
})(jQuery);