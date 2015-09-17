$(document).bind('keydown.ctrl_l', function () {
    $.get($('div.lockscreen-container').data('url'), '', function (html) {
        $('div.lockscreen-container').html(html).fadeIn(300);
    });
});

$('#stats-bar-fa-database').click(function (event) {
    event.preventDefault();
    $.getJSON($('#stats-bar-fa-database').attr('href'), function (data) {
        if (typeof(data.success) != 'undefined') {
            $('#stats-bar-fa-database').parent().parent().remove();
            radiata.createAlert('success', data.success);
        } else if (typeof(data.error) != 'undefined') {
            radiata.createAlert('danger', data.error);
        }
    });
});

$('.daterange-object').each(function () {
    $(this).daterangepicker({
        "maxDate": new Date(),
        "format": i18n.dateFormat,
        "locale": {
            "separator": " - ",
            "applyLabel": radiata.i18n.Apply,
            "cancelLabel": radiata.i18n.Cancel,
            "fromLabel": radiata.i18n.From,
            "toLabel": radiata.i18n.To,
            "customRangeLabel": radiata.i18n.Custom,
            "daysOfWeek": [
                radiata.i18n.Su,
                radiata.i18n.Mo,
                radiata.i18n.Tu,
                radiata.i18n.We,
                radiata.i18n.Th,
                radiata.i18n.Fr,
                radiata.i18n.Sa
            ],
            "monthNames": [
                radiata.i18n.January,
                radiata.i18n.February,
                radiata.i18n.March,
                radiata.i18n.April,
                radiata.i18n.May,
                radiata.i18n.June,
                radiata.i18n.July,
                radiata.i18n.August,
                radiata.i18n.September,
                radiata.i18n.October,
                radiata.i18n.November,
                radiata.i18n.December
            ],
            "firstDay": 1
        }
    });
});
