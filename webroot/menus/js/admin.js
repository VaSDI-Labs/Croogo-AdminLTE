const Links = {
    documentReady() {
        $(".linkChooser").on("click", function() {
            const link = $(this).data('linkChooser');
            $.ajax({
                url: link,
                dataType: "html",
                success: function(data){
                    $('#link_choosers')
                        .find('.modal-body').html(data).end()
                        .modal('toggle');
                }
            });
        });
    },
    slug() {
        $("#LinkClass").slugify('#LinkTitle');
    },
    reloadParents(event) {
        const query = {menu_id: event.currentTarget.value};
        const url = Croogo.basePath + 'admin/menus/links/index.json';
        $.getJSON(url, query, function (data, text) {
            if (typeof data.linksTree === 'undefined') {
                return;
            }
            const $selectParent = $('#LinkParentId');
            let options = '<option></option>';
            let theParent = null;
            const linkId = $('#LinkId').val();
            $selectParent.empty();
            for (let key in data.linksTree) {
                if (data.linksTree.hasOwnProperty(key)) {
                    const title = data.linksTree[key];
                    for (let i in data.menu.Link) {
                        if (data.menu.Link.hasOwnProperty(i)) {
                            const currentLink = data.menu.Link[i];
                            if (currentLink.id === linkId) {
                                theParent = currentLink.parent_id;
                            }
                        }
                    }
                    options += '<option';
                    if (key === theParent) {
                        options += ' selected="selected"';
                    }
                    options += ' value="' + key + '">' + title + '</option>';
                }
            }
            $selectParent.html(options);
        });
    }
};

$(function() {
	if (Croogo.params.controller === 'links') {
        Links.documentReady();
		if (['admin_add', 'admin_edit'].indexOf(Croogo.params.action) >= 0) {
			Links.slug();
		}
	}

	$('#LinkMenuId').on('change', Links.reloadParents);

	Admin.toggleRowSelection('.checkbox-toggle');
});
