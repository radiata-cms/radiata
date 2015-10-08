$(document).bind('keydown.ctrl_l', function () {
    $.get($('div.lockscreen-container').data('url'), '', function (html) {
        $('div.lockscreen-container').html(html).fadeIn(300);
    });
});

if ($('#stats-bar-fa-database').length > 0) {
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
}

if ($('.daterange-object').length > 0) {
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
}

if ($('.datetime-object').length > 0) {
    $('.datetime-object').each(function () {
        $(this).daterangepicker({
            timePicker: true,
            singleDatePicker: true,
            timePickerIncrement: 1,
            timePicker12Hour: false,
            "format": i18n.dateTimeFormat,
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
}

radiata.reloadOnSort('LangGridView');

$(function () {
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-' + ADMIN_LTE_SKIN,
        radioClass: 'iradio_square-' + ADMIN_LTE_SKIN,
        increaseArea: '20%' // optional
    });

    $('a.lang-tab-a').on('shown.bs.tab', function (e) {
        var activeLang = $(e.target).attr('lang');
        $('a.lang-tab-a[lang=' + activeLang + ']').each(function () {
            if ($(this) != $(e.target)) {
                $(this).tab('show');
            }
        });
    })
});

if (typeof(jstreeContainers) != 'undefined') {
    for (i in jstreeContainers) {
        var jstreeContainer = jstreeContainers[i];
        if ($('#' + jstreeContainer).length > 0) {
            $('#' + jstreeContainer).jstree({
                'plugins': ["contextmenu", "dnd", "state"],
                'core': {
                    'data': {
                        'url': JS_TREE_DATA_URL,
                        'data': function (node) {
                            return {'nodeId': (node.id == '#' ? '' : node.id)};
                        }
                    },
                    'check_callback': function (operation, node, parent, position) {
                        switch (operation) {
                            case "move_node":
                                if (node.id == '-1' || parent.id == '#') {
                                    return false;
                                }
                                break;
                        }
                        return true;
                    },
                    'state': {"key": "jstree"},
                    'themes': {
                        'name': 'proton',
                        'responsive': true
                    },
                    'multiple': false,
                    'dblclick_toggle': false
                },
                'dnd': {
                    'inside_pos': 'last'
                },
                'contextmenu': {
                    'items': function ($node) {
                        var items = {};
                        items['Create'] = {
                            'label': i18n.CreateChild,
                            'action': function (obj) {
                                var ref = $.jstree.reference(obj.reference),
                                    sel = ref.get_selected();

                                if (!sel.length) {
                                    return false;
                                }

                                var parent = (sel[0] == JST_PREFIX ? '' : '?' + JS_TREE_PARENT_ID_FIELD + '=' + sel[0].replace(JST_PREFIX, ''));
                                document.location.href = JS_TREE_CREATE_URL + parent;
                            }
                        };

                        if ($node.id != JST_PREFIX) {
                            items['Edit'] = {
                                'label': i18n.EditChild,
                                'action': function (obj) {
                                    var ref = $.jstree.reference(obj.reference),
                                        sel = ref.get_selected();

                                    if (!sel.length) {
                                        return false;
                                    }

                                    document.location.href = JS_TREE_EDIT_URL + '/' + sel[0].replace(JST_PREFIX, '');
                                }
                            };

                            items['Delete'] = {
                                'label': i18n.DeleteChild,
                                'action': function (obj) {
                                    var ref = $.jstree.reference(obj.reference),
                                        sel = ref.get_selected();

                                    if (!sel.length) {
                                        return false;
                                    }

                                    if (confirm(i18n.AreYouSure)) {
                                        $.post(JS_TREE_DELETE_URL + '/' + sel[0].replace(JST_PREFIX, ''), {}, function () {
                                            $('#' + jstreeContainer).jstree(true).delete_node([$node]);
                                        });
                                    }
                                }
                            };
                        }

                        return items;
                    }
                }
            }).bind("move_node.jstree", function (e, data) {
                var afterItemId = '0';
                if ($('#' + data.node.id).prev('li').length > 0) {
                    afterItemId = $('#' + data.node.id).prev('li').attr('id');
                }
                $.post(JS_TREE_MOVE_URL, {
                    'nodeId': data.node.id,
                    'parentId': data.parent,
                    'afterItemId': afterItemId
                }, function () {
                    if ($('#mainGridContainer').length > 0) {
                        $.pjax.reload({container: "#mainGridContainer"});
                    }
                });
            });

            $('#' + jstreeContainer).on('dblclick', '.jstree-anchor', function (e) {
                var instance = $.jstree.reference(this),
                    node = instance.get_node(this);

                if (node.id != JST_PREFIX) {
                    document.location.href = JS_TREE_EDIT_URL + '/' + node.id.replace(JST_PREFIX, '');
                }
            });
        }
    }
}

/*
 if ($('.connectedSortable').length > 0) {
 //Make the dashboard widgets sortable Using jquery UI
 $(".connectedSortable").sortable({
 placeholder: "sort-highlight",
 connectWith: ".connectedSortable",
 handle: ".box-header, .nav-tabs",
 forcePlaceholderSize: true,
 zIndex: 999999
 });
 $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");
 }
 */