const Meta = {
    _spinner: '<i class="' + Admin.spinnerClass() + '"></i>',
    documentReady(){
        Meta.addMeta();
        Meta.removeMeta();
    },
    addMeta(){
        $('a.add-meta').on('click', function (e) {
            const aAddMeta = $(this);
            const spinnerClass = Admin.iconClass('spinner', false);

            aAddMeta.parents('.box').find('#boxOverlay').addClass('overlay').append(Meta._spinner);

            $.get(aAddMeta.attr('href'), function(data) {
                aAddMeta.parent().find('#meta-fields').append(data);
                $('div.meta a.remove-meta').unbind();
                Meta.removeMeta();

               $('.overlay').removeClass('overlay').find('i.' + spinnerClass).remove();
            });
            e.preventDefault();
        });
    },
    removeMeta(){
        $('div.meta a.remove-meta').on('click', function (e) {
            const aRemoveMeta = $(this);
            const spinnerClass = Admin.iconClass('spinner', false);
            if(aRemoveMeta.attr('rel') !== ""){
                if (!confirm('Remove this meta field?')) {
                    return false;
                }
                aRemoveMeta.parents('.box').find('#boxOverlay').addClass('overlay').append(Meta._spinner);
                $.getJSON(aRemoveMeta.attr('href') + '.json', function(data) {
                    if (data.success) {
                        aRemoveMeta.parents('.meta').remove();
                    } else {
                        // error
                    }
                    $('.overlay').removeClass('overlay').find('i.' + spinnerClass).remove();
                });
            } else {
                aRemoveMeta.parents('.meta').remove();
            }
            e.preventDefault();
            return false;
        });
    }
};

$(document).ready(function() {
    Meta.documentReady();
});
