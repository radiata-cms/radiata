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
        },

        initLangTabs: function () {
            $('a.lang-tab-a').on('shown.bs.tab', function (e) {
                var activeLang = $(e.target).attr('lang');
                $('a.lang-tab-a[lang=' + activeLang + ']').each(function () {
                    if ($(this) != $(e.target)) {
                        $(this).tab('show');
                    }
                });
            });
        },

        makeSortable: function (selector) {
            $(selector).sortable();
        },

        initErrorsInTabs: function (selector) {
            var form = $(selector);
            form.on('submit', function (e) {
                window.setTimeout(function () {
                    var tabsDivs = form.find('div.tab-content:first').find('div.tab-pane');
                    tabsDivs.each(function () {
                        if ($(this).find('div.has-error').length > 0) {
                            var tabId = $(this).attr('id');
                            $('a[href="#' + tabId + '"]').tab('show');
                        }
                    });
                }, 200);
            });
        },

        updateWysiwygTextArea: function (selector) {
            var form = $(selector);
            form.on('submit', function (e) {
                $('.wysiwygTextArea').each(function () {
                    var id = $(this).attr('id');
                    jQuery("#" + id).redactor('code.sync');
                });
            });
        },

        cleanMultipleFiles: function (selector) {
            var form = $(selector);
            form.on('submit', function (e) {
                $('input[type=file].multiple').each(function () {
                    $(this).remove();
                });
            });
        }
    }

    return obj;
})(jQuery);