$(document).bind('keydown.ctrl_l', function () {
    $.get($('div.lockscreen-container').data('url'), '', function (html) {
        $('div.lockscreen-container').html(html).fadeIn(300);
    });
});

$('.daterange-object').each(function () {
    $(this).daterangepicker({
        "maxDate": new Date(),
        "format": i18n.dateFormat,
        "locale": {
            "separator": " - ",
            "applyLabel": i18n.Apply,
            "cancelLabel": i18n.Cancel,
            "fromLabel": i18n.From,
            "toLabel": i18n.To,
            "customRangeLabel": i18n.Custom,
            "daysOfWeek": [
                i18n.Su,
                i18n.Mo,
                i18n.Tu,
                i18n.We,
                i18n.Th,
                i18n.Fr,
                i18n.Sa
            ],
            "monthNames": [
                i18n.January,
                i18n.February,
                i18n.March,
                i18n.April,
                i18n.May,
                i18n.June,
                i18n.July,
                i18n.August,
                i18n.September,
                i18n.October,
                i18n.November,
                i18n.December
            ],
            "firstDay": 1
        }
    });
});
