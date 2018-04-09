$(function () {
    var ulNavigation = $('ul[data-widget="tree"]');
    var activeItemsInNav = $(ulNavigation).find('.active');
    var parentsActiveItems = $(activeItemsInNav).parents('li');

    $.each(parentsActiveItems, function (i, item) {
        $(item).addClass('active').addClass('menu-open');
    });
});