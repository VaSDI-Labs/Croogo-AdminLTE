const Nodes = {
    documentReady(){},
    slug() {
        $("#NodeSlug").slugify('#NodeTitle');
    },
    confirmProcess() {
        const $el = $(event.currentTarget);
        const action = $($el.data('relatedelement') + ' :selected');
        let confirmMessage = app[$el.data('confirmmessage')];
        const noAction = 'Please select an action';
        if (action.val() === '') {
            confirmMessage = noAction;
        }
        if (confirmMessage === undefined) {
            confirmMessage = 'Are you sure?';
        } else {
            confirmMessage = confirmMessage.replace(/%s/, action.text());
        }
        if (confirmMessage === noAction) {
            alert(confirmMessage);
        } else if(confirm(confirmMessage)) {
            action.get(0).form.submit();
        }
        return false;
    }
};

$(document).ready(function() {
    if (Croogo.params.controller === 'nodes') {
        Nodes.documentReady();
        if (Croogo.params.action === 'admin_add') {
            Nodes.slug();
        }
    }

    Admin.toggleRowSelection('.checkbox-toggle');
});