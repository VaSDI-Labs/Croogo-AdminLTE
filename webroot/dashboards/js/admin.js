const Dashboard = {
    saveDashboard(e, ui) {
        const dashboard = [],
            serialize = function (column) {
                return function (index) {
                    dashboard.push({
                        'column': column,
                        'order': index,
                        'alias': this.id,
                        'collapsed': $(this).hasClass('collapsed-box') ? 1 : 0
                    });
                }
            };
        let box = null;


        $('#column-0').find('.box').each(serialize(0));
        $('#column-1').find('.box').each(serialize(1));
        $('#column-2').find('.box').each(serialize(2));

        if (ui) {
            box = ui.item;
        } else {
            box = $(this).closest('.box');
        }

        if (!box) {
            return;
        }

        $.post($('#dashboard-url').text(), {dashboard: dashboard});
    },
    sortable(selector, saveDashboard) {
        $(selector).sortable({
            placeholder: 'sort-highlight',
            connectWith: selector,
            handle: '.box-header',
            forcePlaceholderSize: true,
            zIndex: 999999,
            opacity: 0.75,
            tolerance: "pointer",
            update: saveDashboard
        });
        $(selector + ' .box-header').css('cursor', 'move');
    },
    collapsable(saveDashboard) {
        $('body')
            .on('collapsed.boxwidget', '.dashboard-box', saveDashboard)
            .on('expanded.boxwidget', '.dashboard-box', saveDashboard);
    },
    init() {
        const saveDashboard = _.debounce(Dashboard.saveDashboard, 300);
        Dashboard.sortable('.' + Croogo.themeSettings.css['dashboardClass'], saveDashboard);
        Dashboard.collapsable(saveDashboard);
    }
};